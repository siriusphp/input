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
        $form = $task->getForm();
        if (!$element) {
            $task->setResult($this->createForm($form));
        } else {
            $task->setResult($this->createElement($element));
        }
    }

    protected function canHandleTask(Task $task)
    {
        return !is_object($task->getResult());
    }

    function createForm(Specs $element) {

    }

    function createElement(Specs $element) {
        switch ($element[Element::WIDGET]) {
            case 'textarea':
                return $this->createTextarea($element);
                break;
            case 'checkbox':
                return $this->createCheckbox($element);
                break;
            case 'select':
                return $this->createSelect($element);
                break;
            case 'multiselect':
                return $this->createMultiSelect($element);
                break;
            case 'checkboxset':
                return $this->createCheckboxSet($element);
                break;
            case 'radioset':
                return $this->createRadioSet($element);
                break;
            case 'file':
                return $this->createFile($element);
                break;
            case 'input':
            case 'text':
            default:
                return $this->createText($element);
                break;
        }
    }

    protected function createTextarea(Specs $element) {
        //
    }
}
