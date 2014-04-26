<?php
namespace Sirius\Forms\Element;

use Sirius\Forms\Element\Traits\HasContainerTrait;
use Sirius\Forms\Element\Traits\HasFiltersTrait;
use Sirius\Forms\Element\Traits\HasLabelTrait;
use Sirius\Forms\Element;
use Sirius\Forms\Element\Traits\HasValidationRulesTrait;
use Sirius\Forms\Element\Traits\HasHintTrait;

class Input extends Element
{
    use HasFiltersTrait;
    use HasValidationRulesTrait;
    use HasLabelTrait;
    use HasHintTrait;
    use HasContainerTrait;

    /**
     * Name of the field (identifier of the element in the form's child list)
     *
     * @var string
     */
    protected $name;

    protected $value;

    /**
     *
     * @param string $name
     *            Name of the form element that will make it identifiable
     * @param array $specs
     *            Specification for the element (attributes, parents, etc)
     */
    function __construct($name, $specs = array())
    {
        $specs = array_merge($this->getDefaultSpecs(), $specs);
        parent::__construct($name, $specs);
    }

    /**
     * Returns the default element specifications
     * To be used for easily extending objects
     *
     * @return array
     */
    protected function getDefaultSpecs()
    {
        return array(
            static::WIDGET => 'text',
            static::ATTRIBUTES => array(
                'type' => 'text'
            )
        );
    }

    function getValue()
    {
        return $this->value;
    }

    function setValue($value)
    {
        $this->value = $value;
        return $this;
    }

}
