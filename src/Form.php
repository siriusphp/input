<?php
namespace Sirius\Forms;

use Sirius\Filtration\Filtrator;
use Sirius\Filtration\FiltratorInterface;
use Sirius\Forms\Element\Traits\HasChildrenTrait as ElementContainerTrait;
use Sirius\Forms\Element\Factory as ElementFactory;
use Sirius\Forms\Element\AbstractElement;
use Sirius\Validation\Validator;
use Sirius\Validation\ValidatorInterface;

class Form extends Element
{
    use ElementContainerTrait;

    /**
     *
     * @var boolean
     */
    protected $isInitialized = false;

    /**
     *
     * @var boolean
     */
    protected $isPrepared = false;

    /**
     *
     * @var ElementFactory
     */
    protected $elementFactory;

    /**
     *
     * @var Sirius\Validation\Validator
     */
    protected $validator;

    /**
     *
     * @var Sirius\Filtration\Filtrator
     */
    protected $filtrator;

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
     * @throws \LogicException
     * @return \Sirius\Forms\Form
     */
    function prepare()
    {
        if ($this->isPrepared) {
            return $this;
        }
        $this->init();
        if (!$this->isInitialized()) {
            throw new \LogicException('Form was not properly initialized');
        }
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
     * @return \Sirius\Forms\Sirius\Validation\Validator
     */
    function getValidator()
    {
        return $this->validator;
    }

    /**
     * Returns the form's filtrator object
     *
     * @return \Sirius\Forms\Sirius\Filtration\Filtrator
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
