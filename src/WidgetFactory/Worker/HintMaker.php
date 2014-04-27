<?php
namespace Sirius\Forms\WidgetFactory\Worker;

use Sirius\Forms\Html\Div;
use Sirius\Forms\Widget\Traits\HasHintTrait;
use Sirius\Forms\WidgetFactory\Task;
use Sirius\Forms\WidgetFactory\WorkerInterface;

/**
 * This worker attaches a hint HTML tag to the form element
 */
class HintMaker implements WorkerInterface
{

    function processTask(Task $task)
    {
        if (!$this->canHandleTask($task)) {
            return;
        }
        /* @var $element \Sirius\Forms\Element */
        $element = $task->getElement();
        if (!$element || !$element->getHint()) {
            return;
        }
        $hint = new Div();
        $hint->setAttributes($element->getHintAttributes());
        $hint->setText($element->getHint());
        $task->getResult()->setHint($hint);
    }

    protected function canHandleTask(Task $task)
    {
        return is_object($task->getResult()) && method_exists($task->getResult(), 'setHint');
    }
}
