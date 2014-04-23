<?php
namespace Sirius\Forms;

use Sirius\Filtration\Filtrator;
use Sirius\Filtration\FiltratorInterface;
use Sirius\Forms\Element\AbstractElement;
use Sirius\Forms\Element\Factory as ElementFactory;
use Sirius\Forms\Element\Traits\HasChildrenTrait as ElementContainerTrait;
use Sirius\Forms\Util\Arr;
use Sirius\Upload\Handler;
use Sirius\Upload\HandlerAggregate;
use Sirius\Validation\Validator;
use Sirius\Validation\ValidatorInterface;

class Form extends Specs
{
    use ElementContainerTrait;

    /**
     * Uploaded files will have their names prefixed with this value
     * A form element of type "file" with the name "picture" will upload
     * the file into $_FILES['__upload_picture'].
     *
     * This is done to prevent collisions with hidden fields that
     * might hold values from AJAX uploads.
     */
    const UPLOAD_PREFIX = '__upload_';

    /**
     * @var boolean
     */
    protected $isInitialized = false;

    /**
     * @var boolean
     */
    protected $isPrepared = false;

    /**
     * Factory form creating form elements from specs
     *
     * @var ElementFactory
     */
    protected $elementFactory;

    /**
     * Data validation object
     *
     * @var \Sirius\Validation\Validator
     */
    protected $validator;

    /**
     * Data filtrator object
     *
     * @var \Sirius\Filtration\Filtrator
     */
    protected $filtrator;

    /**
     * The upload handlers that are registered withing this form
     *
     * @var HandlerAggregate
     */
    protected $uploadHandlers = array();

    function __construct(
        ElementFactory $elementFactory = null,
        ValidatorInterface $validator = null,
        FiltratorInterface $filtrator = null
    ) {
        if (!$elementFactory) {
            $elementFactory = new ElementFactory();
        }
        $this->elementFactory = $elementFactory;

        if (!$validator) {
            $validator = new Validator();
        }
        $this->validator = $validator;

        if (!$filtrator) {
            $filtrator = new Filtrator();
        }
        $this->filtrator = $filtrator;
    }

    /**
     * Initialize the form
     * This is the place to put your form's definition (properties, elements)
     *
     * @return \Sirius\Forms\Form
     */
    function init()
    {
        if ($this->isInitialized) {
            return $this;
        }
        $this->isInitialized = true;
        return $this;
    }

    /**
     * Returns whether the form was initialized or not
     *
     * @return boolean
     */
    function isInitialized()
    {
        return $this->isInitialized;
    }

    /**
     * Return the element factory
     *
     * @return ElementFactory
     */
    function getElementFactory()
    {
        return $this->elementFactory;
    }

    /**
     * Prepare the form's validator, filtrator and upload handlers objects
     *
     * @param bool $force force the execution of the preparation code even if already prepared
     * @throws \LogicException
     * @return \Sirius\Forms\Form
     */
    function prepare($force = false)
    {
        if ($this->isPrepared && !$force) {
            return $this;
        }
        $this->init();
        if (!$this->isInitialized()) {
            throw new \LogicException('Form was not properly initialized');
        }

        // remove validation rules
        $validator = $this->getValidator();
        $validationRules = $validator->getRules();
        if (is_array($validationRules)) {
            foreach (array_keys($validationRules) as $selector) {
                $validator->remove($selector);
            }
        }

        // remove filtration rules
        $filtrator = $this->getFiltrator();
        $filters = $filtrator->getFilters();
        if (is_array($filters)) {
            foreach (array_keys($filters) as $selector) {
                $filtrator->remove($selector);
            }
        }

        // reset upload handler
        $this->uploadHandlers = null;

        foreach ($this->getChildren() as $element) {
            if (method_exists($element, 'prepareForm')) {
                $element->prepareForm($this);
            }
        }
        $this->isPrepared = true;
        return $this;
    }

    /**
     * Return whether the form is prepared or not
     *
     * @return boolean
     */
    function isPrepared()
    {
        return $this->isPrepared;
    }


    /**
     * Returns the form's validator object
     *
     * @return \Sirius\Validation\Validator
     */
    function getValidator()
    {
        return $this->validator;
    }

    /**
     * Returns the form's filtrator object
     *
     * @return \Sirius\Filtration\Filtrator
     */
    function getFiltrator()
    {
        return $this->filtrator;
    }

    /**
     * Retrieves the upload handlers aggregate object
     *
     * @return HandlerAggregate
     */
    function getUploadHandlers()
    {
        if (!$this->uploadHandlers) {
            $this->uploadHandlers = new HandlerAggregate;
        }
        return $this->uploadHandlers;
    }

    /**
     * Sets a upload handler to be executed on files with a specific selector
     * @example
     *      $form->setUploadHandler('pictures[*]', $pictureHandler);
     *
     * @param $selector
     * @param Handler $handler
     * @return $this
     */
    function setUploadHandler($selector, Handler $handler) {
        $this->getUploadHandlers()->addHandler($selector, $handler);
        return $this;
    }

    /**
     * Populates a form with values. If you have uploads you must merge data from POST and FILES.
     *
     * @param array $data
     * @throws \LogicException
     */
    function populate($data = array())
    {
        $this->prepare();
        if (!$this->isPrepared()) {
            throw new \LogicException('Form is not prepared and cannot receive data');
        }

        // set raw data and data
        $this->rawData = $data;
        $this->data = $this->getFiltrator()->filter($this->rawData);
        $uploadErrors = $this->processUploads();

        // validate form values
        $validator = $this->getValidator();
        $validator->validate($this->data);

        // add upload error messages to the validator
        foreach ($uploadErrors as $key => $messages) {
            foreach ($messages as $message) {
                $validator->addMessage($key, $message);
            }
        }
    }

    /**
     * Processes the uploaded files:
     * 1. Validates the files
     * 2. Confirms valid files
     * 3. Returns validation errors
     *
     * @return array
     */
    protected function processUploads() {
        $result = $this->uploadHandlers->process($this->data);
        $errors = array();
        foreach ($result as $path => $file) {
            // remember!; $_FILES keys are prefixed with '__upload_'
            $key = substring($path, strlen(self::UPLOAD_PREFIX));
            /* @var $file \Sirius\Upload\Result\File */
            if ($file->isValid()) {
                $file->confirm();
                Arr::setByPath($key, $file->name);
            } else {
                $errors[$key] = $file->getMessages();
            }
        }
        return $errors;
    }


    /**
     * Returns whether the form's data is valid.
     * The validation was executed on populate()
     *
     * @return bool
     */
    function isValid()
    {
        return count($this->getValidator()->getMessages()) === 0;
    }
}
