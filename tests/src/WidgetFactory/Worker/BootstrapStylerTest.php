<?php
/**
 * Created by PhpStorm.
 * User: Florin
 * Date: 4/27/2014
 * Time: 9:28 AM
 */

namespace Sirius\Forms\WidgetFactory\Worker;


use Sirius\Forms\Element\Input\Text;
use Sirius\Forms\Form;
use Sirius\Forms\Widget\Input;
use Sirius\Forms\WidgetFactory\Task;
use Sirius\FormsTest\Html\Div;

class BootstrapStylerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Form
     */
    protected $form;
    /**
     * @var FormMaker
     */
    protected $worker;

    /**
     * @var \Sirius\Forms\WidgetFactory\Base
     */
    protected $widgetFactory;
    /**
     * @var \Sirius\Forms\Widget\Form
     */
    protected $formWidget;

    /**
     * @var \Sirius\Forms\Widget\Input
     */
    protected $inputWidget;

    function setUp()
    {
        $this->form = new Form();

        $this->widgetFactory = \Mockery::mock('\Sirius\Forms\WidgetFactory\Base');

        $this->worker = new BootstrapStyler();
        $this->formWidget = new \Sirius\Forms\Widget\Form();
        $this->inputWidget = new Input();
    }

    function testFormGetsBootstrapClass()
    {
        $task = new Task($this->widgetFactory, $this->form);
        $task->setResult($this->formWidget);

        // the form doesn't have a Bootstrap class
        $this->assertFalse($this->formWidget->hasClass(BootstrapStyler::INLINE_FORM_CLASS));
        $this->assertFalse($this->formWidget->hasClass(BootstrapStyler::HORIZONTAL_FORM_CLASS));
        $this->worker->processTask($task);
        // gets one from the worker
        $this->assertTrue($this->formWidget->hasClass(BootstrapStyler::HORIZONTAL_FORM_CLASS));
    }

    function testFormRemainsUnchangedIfItHasABootstrapClass()
    {
        $task = new Task($this->widgetFactory, $this->form);
        $task->setResult($this->formWidget);
        $this->formWidget->addClass('form-inline');

        // the form has a Bootstrap class
        $this->assertTrue($this->formWidget->hasClass(BootstrapStyler::INLINE_FORM_CLASS));
        $this->assertFalse($this->formWidget->hasClass(BootstrapStyler::HORIZONTAL_FORM_CLASS));
        $this->worker->processTask($task);
        // the default Bootstrap class is not set by the worker
        $this->assertFalse($this->formWidget->hasClass(BootstrapStyler::HORIZONTAL_FORM_CLASS));
    }

    function testBootstrapClassesAreSetToInputWidgetParts()
    {
        $task = new Task($this->widgetFactory, $this->form, new Text('email'));
        // add parts to the input widget
        $this->inputWidget->setError(new Div());
        $this->inputWidget->setHint(new Div());
        $task->setResult($this->inputWidget);

        // Bootstrap classes do not exist
        $this->assertFalse($this->inputWidget->hasClass(BootstrapStyler::CONTAINER_CLASS));
        $this->assertFalse($this->inputWidget->getError()->hasClass(BootstrapStyler::ERROR_CLASS));
        $this->assertFalse($this->inputWidget->getHint()->hasClass(BootstrapStyler::HINT_CLASS));

        $this->worker->processTask($task);

        // Boostrap classes were set
        $this->assertTrue($this->inputWidget->hasClass(BootstrapStyler::CONTAINER_CLASS));
        $this->assertTrue($this->inputWidget->getError()->hasClass(BootstrapStyler::ERROR_CLASS));
        $this->assertTrue($this->inputWidget->getHint()->hasClass(BootstrapStyler::HINT_CLASS));

    }

}
