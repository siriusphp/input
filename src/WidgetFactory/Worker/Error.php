<?php
namespace Sirius\Forms\WidgetFactory\Worker;

use Sirius\Forms\Html\Div;
use Sirius\Forms\Widget\Traits\HasLabelTrait;
use Sirius\Forms\WidgetFactory\Task;

/**
 * This worker attaches an HTML error tag to the element
 */
class Error
{

    function processTask(Task $task)
    {
        if (!$this->canHandleTask($task)) {
            return;
        }
        $element = $task->getElement();
        $errorMessages = $task->getForm()->getValidator()->getMessage($element->getName());
        if (!$errorMessages) {
            return;
        }
        $error = new Div();
        $error->setText($errorMessages);
        $taks->getResult()->setError($error);
    }

    protected function canHandleTask(Task $task)
    {
        return is_object($taks->getResult()) && $task->getResult() instanceof HasErrorTrait;
    }
}
