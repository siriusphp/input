<?php
namespace Sirius\Forms\WidgetFactory\Worker;

use Sirius\Forms\Element\Fieldset;
use Sirius\Forms\Element;
use Sirius\Forms\Html\Label;
use Sirius\Forms\Html\ExtendedTag;
use Sirius\Forms\Specs;
use Sirius\Forms\Widget\Traits\HasLabelTrait;
use Sirius\Forms\WidgetFactory\Task;
use Sirius\Forms\WidgetFactory\WorkerInterface;

class WidgetMaker implements WorkerInterface
{

    function processTask(Task $task)
    {
        if (!$this->canHandleTask($task)) {
            return;
        }
        /* @var $element \Sirius\Forms\Element */
        $element = $task->getElement();
        $task->setResult($this->createWidget($element));
    }

    protected function canHandleTask(Task $task)
    {
        return !is_object($task->getResult());
    }

    function createWidget(Specs $element) {
        switch ($element[Element::WIDGET]) {
            case 'textarea':
                break;
            case 'input':
            case 'text':
            default:
                break;
        }
    }
}
