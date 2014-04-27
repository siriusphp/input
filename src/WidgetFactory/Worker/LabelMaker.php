<?php
namespace Sirius\Forms\WidgetFactory\Worker;

use Sirius\Forms\Element\Fieldset;
use Sirius\Forms\Html\Label;
use Sirius\Forms\Html\ExtendedTag;
use Sirius\Forms\Widget\Traits\HasLabelTrait;
use Sirius\Forms\WidgetFactory\Task;
use Sirius\Forms\WidgetFactory\WorkerInterface;

/**
 * This worker attaches a label HTML tag to the widget
 */
class LabelMaker implements WorkerInterface
{

    function processTask(Task $task)
    {
        if (!$this->canHandleTask($task)) {
            return;
        }
        /* @var $element \Sirius\Forms\Element */
        $element = $task->getElement();
        if (!$element->getLabel()) {
            return;
        }
        $label = new Label();
        // for fieldsets we need a LEGEND attribute
        if ($element instanceof Fieldset) {
            $label = ExtendedTag::create(array(), 'legend', false);
        }
        $label->setAttributes($element->getLabelAttributes());
        $label->setText($element->getLabel());
        $task->getResult()->setLabel($label);
    }

    protected function canHandleTask(Task $task)
    {
        return is_object($task->getResult()) && method_exists($task->getResult(), 'setLabel');
    }
}
