<?php
namespace Sirius\Forms\WidgetFactory\Worker;


use Sirius\Forms\Element\Input\Text;
use Sirius\Forms\Form;
use Sirius\Forms\Widget\Input;
use Sirius\Forms\WidgetFactory\Task;

class ErrorMakerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Form
     */
    protected $form;
    /**
     * @var ErrorMaker
     */
    protected $worker;

    /**
     * @var \Sirius\Forms\WidgetFactory\Base
     */
    protected $widgetFactory;

    function setUp()
    {
        $this->form = new Form();
        $this->form->setAttributes(
            array(
                'method' => 'post',
                'action' => 'url'
            )
        );
        $this->form->setData('key', 'value');

        $this->widgetFactory = \Mockery::mock('\Sirius\Forms\WidgetFactory\Base');

        $this->worker = new ErrorMaker();
    }

    function testErrorElementAttached()
    {
        $widget = new Input();
        $task = new Task($this->widgetFactory, $this->form, new Text('email'));
        $task->setResult($widget);
        $this->form->getValidator()->addMessage('email', 'Email is not valid');

        $this->assertNull($widget->getError());
        $this->worker->processTask($task);
        $this->assertEquals('Email is not valid', $widget->getError()->getText());
    }

    function testErrorElementNotAttachedWhenThereIsNoError()
    {
        $widget = new Input();
        $task = new Task($this->widgetFactory, $this->form, new Text('email'));
        $task->setResult($widget);

        $this->worker->processTask($task);
        $this->assertNull($widget->getError());
    }

}
