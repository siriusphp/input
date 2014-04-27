<?php
namespace Sirius\Forms\WidgetFactory\Worker;


use Sirius\Forms\Element\Input;
use Sirius\Forms\Form;
use Sirius\Forms\Html\Text;
use Sirius\Forms\WidgetFactory\Base;
use Sirius\Forms\WidgetFactory\Task;

class LabelMakerTest  extends \PHPUnit_Framework_TestCase
{

    /**
     * @var LabelMaker
     */
    protected $maker;

    /**
     * @var \Sirius\Forms\Widget\Input
     */
    protected $widget;

    /**
     * @var \Sirius\Forms\Element\Input
     */
    protected $element;

    function setUp() {
        $this->maker = new LabelMaker();
        $this->element = new Input('email', array(
            'label' => 'Your email',
            'label_attributes' => array('class' => 'required', 'for' => 'email')
        ));
        $this->widget = new \Sirius\Forms\Widget\Input();
        $this->widget->setInput(new Text());
    }

    function testLabelIsAttachedToTaskResult() {
        $task = new Task(new Base(), new Form(), $this->element);
        $task->setResult($this->widget);
        $this->maker->processTask($task);

        $label = $this->widget->getLabel();
        $this->assertEquals($this->element->getLabel(), $label->getText());
        $this->assertEquals($this->element->getLabelAttribute('class'), $label->getAttribute('class'));
        $this->assertEquals($this->element->getLabelAttribute('for'), $label->getAttribute('for'));
    }

}
