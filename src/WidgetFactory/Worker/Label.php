<?php
namespace Sirius\Forms\WidgetFactory\Worker;

use Sirius\Forms\Widget\Traits\HasLabelTrait;
use Sirius\Forms\WidgetFactory\Task;

/**
 * This worker attaches a label HTML tag to the widget
 */
class Label
{

    function processTask(Task $task)
    {
        if (!$this->canHandleTask($task)) {
            return;
        }
        $element = $task->getElement();
        if (!$element->getLabel()) {
            return;
        }
        $label = new \Sirius\Forms\Html\Label($element->getLabelAttributes());
        $label->setText($element->getLabel());
        $taks->getResult()->setLabel($label);
    }

    protected function canHandleTask(Task $task)
    {
        return is_object($taks->getResult()) && $task->getResult() instanceof HasLabelTrait;
    }
}
