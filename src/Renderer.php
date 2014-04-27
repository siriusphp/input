<?php
namespace Sirius\Forms;

use Sirius\Forms\Decorator\DecoratorInterface;
use Sirius\Forms\Form;
use Sirius\Forms\Html\ExtendedTag;
use Sirius\Forms\WidgetFactory\Base as BaseFactory;
use Sirius\Forms\WidgetFactory\Worker\BootstrapStyler;
use Sirius\Forms\WidgetFactory\Worker\ChildrenComposer;
use Sirius\Forms\WidgetFactory\Worker\ErrorMaker;
use Sirius\Forms\WidgetFactory\Worker\FormMaker;
use Sirius\Forms\WidgetFactory\Worker\HintMaker;
use Sirius\Forms\WidgetFactory\Worker\IdAttributeAttacher;
use Sirius\Forms\WidgetFactory\Worker\InputMaker;
use Sirius\Forms\WidgetFactory\Worker\LabelMaker;
use Sirius\Forms\WidgetFactory\Worker\WidgetMaker;
use Sirius\Forms\WidgetFactory\Worker\WidgetMissingAlerter;

class Renderer
{

    /**
     *
     * @var \Sirius\Forms\WidgetFactory\FactoryInterface
     */
    protected $widgetFactory;

    /**
     *
     * @var \Sirius\Forms\Util\PriorityList
     */
    protected $decoratorsList;

    function __construct(BaseFactory $widgetFactory = null)
    {
        if (!$widgetFactory) {
            $widgetFactory = new BaseFactory();
        }
        $this->widgetFactory = $widgetFactory;
        $this->init();
    }

    function init() {
        $this->widgetFactory->addWorker(new FormMaker(), PHP_INT_MAX - 1000);
        $this->widgetFactory->addWorker(new InputMaker(), PHP_INT_MAX - 1500);
        $this->widgetFactory->addWorker(new LabelMaker(), PHP_INT_MAX - 2000);
        $this->widgetFactory->addWorker(new ErrorMaker(), PHP_INT_MAX - 3000);
        $this->widgetFactory->addWorker(new HintMaker(), PHP_INT_MAX - 4000);
        $this->widgetFactory->addWorker(new ChildrenComposer(), PHP_INT_MAX - 5000);
        $this->widgetFactory->addWorker(new BootstrapStyler());
        $this->widgetFactory->addWorker(new IdAttributeAttacher());
        $this->widgetFactory->addWorker(new WidgetMissingAlerter(), -PHP_INT_MAX + 1000); // close to the bottom
    }

    /**
     *
     * @param Form $form
     * @return Ambigous <\Sirius\Forms\WidgetFactory\false, \Sirius\Form\Renderer\Widget\WidgetInterface>
     */
    function render(Form $form)
    {
        return $this->getFormWidget($form);
    }

    /**
     * Returns the widget associated with the form
     *
     * @param Form $form
     * @return NULL|\Sirius\Forms\Html\ExtendedTag
     */
    function getFormWidget(Form $form)
    {
        $widget = $this->widgetFactory->createWidget($form);
        return $widget;
    }

    /**
     * Returns the widget associated with an element from the form
     *
     * @param Form $form
     * @param string $elementName
     * @throws \RuntimeException
     * @return NULL|\Sirius\Forms\Html\ExtendedTag
     */
    function getElementWidget(Form $form, $elementName)
    {
        $element = $form->get($elementName);
        if (!$element) {
            throw new \RuntimeException(sprintf('Input "%s" is not registered to this form'));
        }
        $widget = $this->widgetFactory->createWidget($form, $element);
        return $widget;
    }
}
