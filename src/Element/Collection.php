<?php
namespace Sirius\Forms\Element;

use Sirius\Forms\Element\Traits\HasChildrenTrait;
use Sirius\Forms\Element\Traits\HasLabelTrait;
use Sirius\Forms\Element\Traits\HasHintTrait;
use Sirius\Forms\Element\Traits\HasFiltersTrait;
use Sirius\Forms\Element\Traits\HasValidationRulesTrait;
use Sirius\Forms\Element\Factory as ElementFactory;
use Sirius\Forms\Element\FactoryAwareInterface as ElementFactoryAwareInterface;
use Sirius\Forms\Form;

class Collection extends Input implements ElementFactoryAwareInterface
{
    use HasChildrenTrait;
    use HasLabelTrait;
    use HasHintTrait;
    use HasFiltersTrait;
    use HasValidationRulesTrait;

    /**
     *
     * @var \Sirius\Form\ElementFactory
     */
    protected $elementFactory;

    protected function getDefaultSpecs()
    {
        return $defaultSpecs = array(
            Input::WIDGET => 'fieldset'
        );
    }

    /**
     * Generate the namespaced field name of an element inside the fielset
     *
     * @param string $name
     * @return string
     */
    protected function getFullChildName($name)
    {
        $firstOpenBracket = strpos($name, '[');
        // the name is already at least 2 levels deep like street[name]
        if ($firstOpenBracket !== false) {
            $name = substr($name, 0, $firstOpenBracket) . '][' . substr($name, $firstOpenBracket + 1, -1);
        }
        return $this->getName() . '[*][' . $name . ']';
    }

    function setElementFactory(ElementFactory $elementFactory)
    {
        $this->elementFactory = $elementFactory;
        return $this;
    }

    function prepareForm(Form $form)
    {
        parent::prepareForm($form);
        foreach ($this->getChildren() as $element) {
            $element->prepareForm($form);
        }
    }
}
