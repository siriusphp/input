<?php
namespace Sirius\Forms\WidgetFactory\Worker;

use Sirius\Forms\Html\Div;
use Sirius\Forms\Widget\Traits\HasLabelTrait;
use Sirius\Forms\WidgetFactory\Task;

/**
 * This worker attaches a hint HTML tag to the form element
 */
class Hint
{

    function processTask(Task $task)
    {
        if (!$this->canHandleTask($task)) {
            return;
        }
        $element = $task->getElement();
        if (!$element->getHint()) {
            return;
        }
        $hint = new Div($element->getHintAttributes());
        $hint->addClass('help-block');
        $hint->setText($element->getHint());
        $taks->getResult()->setHint($hint);
    }

    protected function canHandleTask(Task $task)
    {
        return is_object($taks->getResult()) && $task->getResult() instanceof HasHintTrait;
    }
}
