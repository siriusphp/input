<?php
namespace Sirius\Input\Element;

use Sirius\Input\Traits\HasFiltersTrait;
use Sirius\Input\Traits\HasLabelTrait;
use Sirius\Input\Element;
use Sirius\Input\Traits\HasValidationRulesTrait;
use Sirius\Input\Traits\HasHintTrait;
use Sirius\Input\Traits\HasAttributesTrait;

class Input extends Element
{
    use HasFiltersTrait;
    use HasValidationRulesTrait;
    use HasLabelTrait;
    use HasHintTrait;
    use HasAttributesTrait;

    /**
     * Name of the field (identifier of the element in the child list)
     *
     * @var string
     */
    protected $name;

    protected $value;

    /**
     *
     * @param string $name
     *            Name of the input element that will make it identifiable
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
}
