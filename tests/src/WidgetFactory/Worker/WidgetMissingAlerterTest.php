<?php

namespace Sirius\Forms\WidgetFactory\Worker;


use Sirius\Forms\Form;
use Sirius\Forms\WidgetFactory\Base;
use Sirius\Forms\WidgetFactory\Task;

class WidgetMissingAlerterTest extends \PHPUnit_Framework_TestCase
{
    function testExceptionThrownIfTaskDoesNotHaveAResult() {
        $task = new Task(new Base(), new Form());
        $this->setExpectedException('\RuntimeException');
        $worker = new WidgetMissingAlerter();
        $worker->processTask($task);
    }
}
