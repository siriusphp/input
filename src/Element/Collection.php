<?php
namespace Sirius\Input\Element;

use Sirius\Input\Traits\HasChildrenTrait;
use Sirius\Input\Traits\HasLabelTrait;
use Sirius\Input\Traits\HasHintTrait;
use Sirius\Input\Traits\HasFiltersTrait;
use Sirius\Input\Traits\HasValidationRulesTrait;
use Sirius\Input\Element\Factory as ElementFactory;
use Sirius\Input\Element\FactoryAwareInterface as ElementFactoryAwareInterface;
use Sirius\Input\InputFilter;
use Sirius\Input\Specs;

class Collection extends Input implements ElementFactoryAwareInterface
{
    use HasChildrenTrait;
    use HasLabelTrait;
    use HasHintTrait;
    use HasFiltersTrait;
    use HasValidationRulesTrait;

    /**
     *
     * @var ElementFactory
     */
    protected $elementFactory;

    protected function getDefaultSpecs()
    {
        return array(
            Specs::WIDGET => 'fieldset'
        );
    }

    /**
     * Generate the namespaced field name of an element inside the fielset
     *
     * @param string $name
     *
     * @return string
     */
    protected function getFullChildName($name)
    {
        $firstOpenBracket = strpos($name, '[');
        // the name is already at least 2 levels deep like street[name]
        if ($firstOpenBracket !== false) {
            $name = substr($name, 0, $firstOpenBracket) . '][' . substr($name, $firstOpenBracket + 1, - 1);
        }

        return $this->getName() . '[*][' . $name . ']';
    }

    public function setElementFactory(ElementFactory $elementFactory)
    {
        $this->elementFactory = $elementFactory;
        $this->createChildren();

        return $this;
    }

    public function prepareInputFilter(InputFilter $inputFilter)
    {
        parent::prepareInputFilter($inputFilter);
        $this->cleanUpMissingGroups();
        foreach ($this->getElements() as $element) {
            $element->prepareInputFilter($inputFilter);
        }
    }
}
