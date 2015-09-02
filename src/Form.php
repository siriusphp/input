<?php
namespace Sirius\Input;

use Sirius\Filtration\Filtrator;
use Sirius\Filtration\FiltratorInterface;
use Sirius\Input\Element\AbstractElement;
use Sirius\Input\Element\Factory as ElementFactory;
use Sirius\Input\Traits\HasChildrenTrait;
use Sirius\Input\Traits\HasAttributesTrait;
use Sirius\Input\Traits\HasFiltersTrait;
use Sirius\Input\Util\Arr;
use Sirius\Upload\Handler as UploadHandler;
use Sirius\Upload\HandlerAggregate as UploadHandlerAggregate;
use Sirius\Validation\Validator;
use Sirius\Validation\ValidatorInterface;

class Form extends Specs
{
    use HasChildrenTrait;
    use HasAttributesTrait;
    use HasFiltersTrait;

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

    protected $rawValues = array();

    protected $values = array();

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
        $this->setAttribute('method', 'post');
    }

    /**
     * Initialize the form
     * This is the place to put your form's definition (properties, elements)
     *
     * @return \Sirius\Input\Form
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
     * @return \Sirius\Input\Form
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

        foreach ($this->getElements() as $element) {
            if (method_exists($element, 'prepareForm')) {
                $element->prepareForm($this);
            }
        }
        $this->prepareFiltration();
        $this->isPrepared = true;
        return $this;
    }
    
    protected function prepareFiltration()
    {
        $filters = $this->getFilters();
        if (!$filters || !is_array($filters)) {
            return;
        }
        $filtrator = $this->getFiltrator();
        foreach ($filters as $filter) {
            $params = is_array($filter) ? $filter : array($filter);
            if (isset($params[0])) {
                $filtrator->add(Filtrator::SELECTOR_ROOT, $params[0], @$params[1], @$params[2], @$params[3]);
            }
        }
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
     * @return UploadHandlerAggregate
     */
    function getUploadHandlers()
    {
        if (!$this->uploadHandlers) {
            $this->uploadHandlers = new UploadHandlerAggregate;
        }
        return $this->uploadHandlers;
    }

    /**
     * Sets a upload handler to be executed on files with a specific selector
     * @example
     *      $form->setUploadHandler('resume', $resumeHandler);
     *      $form->setUploadHandler('pictures[*]', $pictureHandler);
     *
     * @param $selector
     * @param UploadHandler $handler
     * @return $this
     */
    function setUploadHandler($selector, UploadHandler $handler) {
        $this->getUploadHandlers()->addHandler($selector, $handler);
        return $this;
    }

    /**
     * Populates a form with values. If you have uploads you must merge data from POST and FILES.
     *
     * @param array $values
     * @throws \LogicException
     */
    function populate($values = array())
    {
        $this->prepare();
        if (!$this->isPrepared()) {
            throw new \LogicException('Form was not prepared and cannot receive data');
        }

        // set raw values
        $this->rawValues = $values;
        $this->values = $values;
    }

    /**
     * Processes the uploaded files:
     * 1. Validates the files
     * 2. Confirms valid files
     * 3. Add the upload errors to the validation errors
     */
    protected function processUploads() {
        $result = $this->getUploadHandlers()->process($this->values);
        $errors = array();
        foreach ($result as $path => $file) {
            // remember!; $_FILES keys are prefixed with a value
            $key = substr($path, strlen(self::UPLOAD_PREFIX));
            /* @var $file \Sirius\Upload\Result\File */
            if ($file->isValid()) {
                $file->confirm();
                $this->values = Arr::setBySelector($this->values, $key, $file->name);
            } else {
                $errors[$key] = $file->getMessages();
            }
        }
        // add upload error messages to the validator
        $validator = $this->getValidator();
        foreach ($errors as $key => $messages) {
            foreach ($messages as $message) {
                $validator->addMessage($key, $message);
            }
        }
    }


    /**
     * Returns whether the form's data is valid.
     * If filters the data, process the uploads and performs the validation
     *
     * @param bool $skipDataProcessing skip filtration and upload handling
     * @return bool
     */
    function isValid($skipDataProcessing = false)
    {
        if (!$skipDataProcessing) {
            $this->values = $this->getFiltrator()->filter($this->rawValues);
        }

        // validate form values
        $validator = $this->getValidator();
        $validator->validate($this->values);

        if (!$skipDataProcessing) {
            $this->processUploads();
        }
        return count($this->getValidator()->getMessages()) === 0;
    }

    function getErrors() {
        return $this->getValidator()->getMessages();
    }

    function getValues() {
        return empty($this->values) ? $this->rawValues : array();
    }
    
    function getValue($name) {
        return empty($this->values) ? $this->getRawValue($name) : Arr::getByPath($this->values, $name);
    }

    function getRawValue($name) {
        return Arr::getByPath($this->rawValues, $name);
    }
    
    
}
