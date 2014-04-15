<?php
namespace Sirius\Forms;

use Sirius\Filtration\Filtrator;
use Sirius\Filtration\FiltratorInterface;
use Sirius\Forms\Element\AbstractElement;
use Sirius\Forms\Element\Factory as ElementFactory;
use Sirius\Forms\Element\Traits\HasChildrenTrait as ElementContainerTrait;
use Sirius\Validation\Validator;
use Sirius\Validation\ValidatorInterface;

class Form extends Specs
{
    use ElementContainerTrait;

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
     * @var array
     */
    protected $uploadHanlders = array();

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
        foreach (array_keys($validator->getRules()) as $selector) {
            $validator->remove($selector);
        }

        // remove filtration rules
        $filtrator = $this->getFiltrator();
        foreach (array_keys($filtrator->getAll()) as $selector) {
            $filtrator->remove($selector);
        }

        // remove upload hanlder
        $this->uploadHanlders = array();

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

    function getUploadHandlers()
    {
        return $this->uploadHandlers;
    }

    function setData($values = array(), $files = array())
    {
        $this->prepare();
        if (!$this->isPrepared()) {
            throw new \LogicException('Form is not prepared and cannot receive data');
        }
    }

    function isValid()
    {
        return count($this->getValidator()->getMessages()) === 0;
    }
}
