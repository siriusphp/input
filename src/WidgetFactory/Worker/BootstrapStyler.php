<?php

namespace Sirius\Forms\WidgetFactory\Worker;

use Sirius\Forms\Widget\Form;
use Sirius\Forms\Widget\Input;
use Sirius\Forms\Widget\Traits\HasChildrenTrait;
use Sirius\Forms\WidgetFactory\Task;
use Sirius\Forms\WidgetFactory\WorkerInterface;

class BootstrapStyler implements WorkerInterface {

    /**
     * Process a widget factory task
     *
     * @param Task $task
     */
    function processTask(Task $task)
    {
        $currentResult = $task->getResult();
        if ($currentResult instanceof Form) {
            $this->applyFormStyles($currentResult);
        } else if ($currentResult instanceof Input) {
            $this->applyInputStyles($currentResult);
        }
    }

    protected function applyFormStyles(Form $form) {
        if (!$form->hasClass('form-inline') && !$form->hasClass('form-horizontal')) {
            $form->addClass('form-horizontal');
        }
    }

    protected function applyInputStyles(Input $widget) {
        $widget->addClass('form-group');
        $widget->getHint()->addClass('help-block');
        $widget->getError()->addClass('bg-danger');
    }

}
