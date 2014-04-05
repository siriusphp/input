<?php
namespace Sirius\Forms;

use Sirius\Forms\Element\Specs;
use Sirius\Forms\Element\ContainerTrait as ElementContainerTrait;
use Sirius\Forms\Element\Factory as ElementFactory;
use Sirius\Validation\ValidatorInterface;
use Sirius\Filtration\FiltratorInterface;

class Form extends Specs
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

    function __construct(ElementFactory $elementFactory = null, ValidatorInterface $validator = null, FiltratorInterface $filtrator = null)
    {
        if (! $elementFactory) {
            $elementFactory = new ElementFactory();
        }
        $this->elementFactory = $elementFactory;
        
        if (! $validator) {
            $validator = new \Sirius\Validation\Validator();
        }
        $this->validator = $validator;
        
        if (! $filtrator) {
            $filtrator = new \Sirius\Filtration\Filtrator();
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
     * Add an element to the form
     *
     * @param string $name            
     * @param \Sirius\Forms\Element|array $specsOrElement            
     * @throws \RuntimeException
     * @return \Sirius\Forms\Form
     */
    function add($name, $specsOrElement)
    {
        if ($this->isPrepared()) {
            throw new \LogicException('You cannot add elements after the form has been prepared');
        }
        $element = $specsOrElement;
        if (is_array($specsOrElement)) {
            $element = $this->getElementFactory()->createFromSpecs($name, $specsOrElement);
            $element->setForm($this);
        }
        return $this->addToElementContainer($name, $element);
    }

    /**
     * Retrieve an element by name
     *
     * @param string $name            
     * @return \Sirius\Forms\Element
     */
    function get($name)
    {
        return $this->getFromElementContainer($name);
    }

    /**
     * Removes an element from the form
     *
     * @param string $name            
     * @throws \RuntimeException
     * @return \Sirius\Forms\Form
     */
    function remove($name)
    {
        if ($this->isPrepared()) {
            throw new \LogicException('You cannot remove elements after the form has been prepared');
        }
        return $this->removeFromElementContainer($name);
    }

    /**
     * Returns whether an element exist in the form
     * 
     * @param string $name
     * @return boolean
     */
    function has($name)
    {
    	return false !== $this->get($name);
    }

    /**
     * Prepare the form's validator, filtrator and upload handlers objects
     *
     * @throws \RuntimeException
     * @return \Sirius\Forms\Form
     */
    function prepare()
    {
        if ($this->isPrepared) {
            return $this;
        }
        $this->init();
        if (! $this->isInitialized()) {
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
        if (! $this->isPrepared()) {
            throw new \LogicException('Form is not prepared and cannot receive data');
        }
    }

    function isValid()
    {
        return count($this->getValidator()->getMessages()) === 0;
    }
}