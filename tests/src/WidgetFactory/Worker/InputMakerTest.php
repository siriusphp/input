<?php
/**
 * Created by PhpStorm.
 * User: Florin
 * Date: 4/26/2014
 * Time: 12:40 PM
 */

namespace Sirius\Forms\WidgetFactory\Worker;


use Sirius\Forms\Element\Input\File;
use Sirius\Forms\Element;
use Sirius\Forms\Element\Input\MultiSelect;
use Sirius\Forms\Element\Input\Select;
use Sirius\Forms\Element\Input\Text;
use Sirius\Forms\Element\Input\Textarea;
use Sirius\Forms\Form;
use Sirius\Forms\WidgetFactory\Task;

class InputMakerTest extends \PHPUnit_Framework_TestCase
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

    function setUp()
    {
        $this->form = new Form;
        $this->form->setAttributes(
            array(
                'method' => 'post',
                'action' => 'url'
            )
        );
        $this->form->setData('key', 'value');

        $this->widgetFactory = \Mockery::mock('\Sirius\Forms\WidgetFactory\Base');

        $this->worker = new InputMaker();
    }


    function testTextareaCreation()
    {
        $element = new Textarea('comment');
        $element->addClass('full-width');
        $value = 'Cool website, spam comment';

        $this->form->populate(
            array(
                'comment' => $value
            )
        );

        $task = new Task($this->widgetFactory, $this->form, $element);
        $this->worker->processTask($task);
        /* @var $widget \Sirius\Forms\Widget\Input */
        $widget = $task->getResult();

        $this->assertEquals($widget->getInput()->getAttribute('class'), $element->getAttribute('class'));
        $this->assertEquals($value, $widget->getValue());
        $this->assertEquals($value, $widget->getRawValue());
    }

    function testTextCreation()
    {
        $element = new Text('email');
        $element->addClass('full-width');
        $value = 'me@domain.com';

        $this->form->populate(
            array(
                'email' => $value
            )
        );

        $task = new Task($this->widgetFactory, $this->form, $element);
        $this->worker->processTask($task);
        /* @var $widget \Sirius\Forms\Widget\Input */
        $widget = $task->getResult();

        $this->assertEquals($widget->getInput()->getAttribute('class'), $element->getAttribute('class'));
        $this->assertEquals($value, $widget->getValue());
        $this->assertEquals($value, $widget->getRawValue());
        $this->assertEquals($element->getName(), $widget->getInput()->getAttribute('name'));
    }

    function testPasswordCreation()
    {
        $element = new Text('password');
        $element[Element::WIDGET] = 'password';
        $element->addClass('full-width');
        $value = '123456';

        $this->form->populate(
            array(
                'password' => $value
            )
        );

        $task = new Task($this->widgetFactory, $this->form, $element);
        $this->worker->processTask($task);
        /* @var $widget \Sirius\Forms\Widget\Input */
        $widget = $task->getResult();

        $this->assertEquals($widget->getInput()->getAttribute('class'), $element->getAttribute('class'));
        $this->assertEquals($value, $widget->getValue());
        $this->assertEquals($value, $widget->getRawValue());
    }

    function testFileCreation()
    {
        $element = new File('picture');
        $value = 'shot.png';

        $this->form->populate(
            array(
                'picture' => $value
            )
        );

        $task = new Task($this->widgetFactory, $this->form, $element);
        $this->worker->processTask($task);
        /* @var $widget \Sirius\Forms\Widget\Input */
        $widget = $task->getResult();

        $this->assertEquals($widget->getInput()->getAttribute('class'), $element->getAttribute('class'));
        $this->assertEquals($value, $widget->getValue());
        $this->assertEquals($value, $widget->getRawValue());
    }

    function testSelectCreation()
    {
        $element = new Select('country');
        $element->addClass('full-width');
        $element->setOptions(
            array(
                'Ro' => 'Romania',
                'USA' => 'United States of America'
            )
        );
        $element->setFirstOption('select your country...');
        $value = 'Romania';

        $this->form->populate(
            array(
                'country' => $value
            )
        );

        $task = new Task($this->widgetFactory, $this->form, $element);
        $this->worker->processTask($task);
        /* @var $widget \Sirius\Forms\Widget\Input */
        $widget = $task->getResult();

        $this->assertEquals($widget->getInput()->getAttribute('class'), $element->getAttribute('class'));
        $this->assertEquals($widget->getInput()->getData('first_option'), $element->getFirstOption());
        $this->assertEquals($widget->getInput()->getData('options'), $element->getOptions());
        $this->assertEquals($value, $widget->getValue());
        $this->assertEquals($value, $widget->getRawValue());
    }


    function testMultiSelectCreation()
    {
        $element = new MultiSelect('preferences');
        $element->setOptions(
            array(
                'icecream' => 'Icecream',
                'cookies' => 'Cookies'
            )
        );
        $value = array('icecream');

        $this->form->populate(
            array(
                'preferences' => $value
            )
        );

        $task = new Task($this->widgetFactory, $this->form, $element);
        $this->worker->processTask($task);
        /* @var $widget \Sirius\Forms\Widget\Input */
        $widget = $task->getResult();

        $this->assertEquals($widget->getInput()->getAttribute('class'), $element->getAttribute('class'));
        $this->assertEquals($widget->getInput()->getData('options'), $element->getOptions());
        $this->assertEquals($value, $widget->getValue());
        $this->assertEquals($value, $widget->getRawValue());
    }

    function testUnknownWidgetNotCreated()
    {
        $element = new Text('unknown_widget_type');
        $element[Element::WIDGET] = 'unknown_widget';

        $task = new Task($this->widgetFactory, $this->form, $element);
        $this->worker->processTask($task);
        $widget = $task->getResult();

        $this->assertNull($widget);
    }

    function testWidgetNotCreatedIfTheTaskHasAlreadyAResult()
    {
        $element = new Text('email');
        $element->addClass('full-width');
        $value = 'me@domain.com';

        $this->form->populate(
            array(
                'email' => $value
            )
        );

        $task = new Task($this->widgetFactory, $this->form, $element);
        $firstWidget = new \Sirius\Forms\Html\Textarea();
        $task->setResult($firstWidget);
        $this->worker->processTask($task);
        $widget = $task->getResult();

        $this->assertEquals($firstWidget, $widget);
    }

}
