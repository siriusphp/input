<?php
namespace Sirius\Forms\WidgetFactory\Worker;

use Sirius\Forms\Html\Div;
use Sirius\Forms\Widget\Traits\HasErrorTrait;
use Sirius\Forms\WidgetFactory\Task;
use Sirius\Forms\WidgetFactory\WorkerInterface;

/**
 * This worker attaches an HTML error tag to the element
 */
class ErrorMaker implements WorkerInterface
{

    function processTask(Task $task)
    {
        if (!$this->canHandleTask($task)) {
            return;
        }
        /* @var $element \Sirius\Forms\Element */
        $element = $task->getElement();
        $errorMessages = $task->getForm()->getValidator()->getMessages($element->getName());
        if (!$errorMessages) {
            return;
        }
        $error = new Div();
        $error->addClass('form-error');
        $error->setText(implode('<br>', $errorMessages));
        $task->getResult()->setError($error);
    }

    protected function canHandleTask(Task $task)
    {
        return is_object($task->getResult()) && $task->getResult() instanceof HasErrorTrait;
    }
}
