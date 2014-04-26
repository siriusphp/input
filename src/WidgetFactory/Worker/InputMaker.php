<?php
namespace Sirius\Forms\WidgetFactory\Worker;

use Sirius\Forms\Element;
use Sirius\Forms\Element\Traits\HasContainerTrait;
use Sirius\Forms\Form;
use Sirius\Forms\Html\File;
use Sirius\Forms\Html\MultiSelect;
use Sirius\Forms\Html\Password;
use Sirius\Forms\Html\Select;
use Sirius\Forms\Html\Text;
use Sirius\Forms\Html\Textarea;
use Sirius\Forms\Widget\Input;
use Sirius\Forms\Widget\Traits\HasInputTrait;
use Sirius\Forms\Widget\Traits\HasLabelTrait;
use Sirius\Forms\WidgetFactory\Task;
use Sirius\Forms\WidgetFactory\WorkerInterface;

class InputMaker implements WorkerInterface
{

    function processTask(Task $task)
    {
        if (!$this->canHandleTask($task)) {
            return;
        }
        /* @var $element \Sirius\Forms\Element */
        $element = $task->getElement();
        $form = $task->getForm();
        $widget = $this->createWidget($element, $form);
        if ($widget) {
            $task->setResult($widget);
        }
    }

    protected function canHandleTask(Task $task)
    {
        return !is_object($task->getResult()) && $task->getElement();
    }

    function createWidget(Element $element, Form $form) {
        // by default we have an input-type widget without an input
        // the input will be created later
        $widget = new Input();
        $input = null;
        switch ($element[Element::WIDGET]) {
            case 'textarea':
                $input = $this->createTextarea($element);
                break;
            case 'select':
                $input = $this->createSelect($element);
                break;
            case 'multiselect':
                $input = $this->createMultiSelect($element);
                break;
            case 'file':
                $input = $this->createFile($element);
                break;
            case 'password':
                $input = $this->createPassword($element);
                break;
            case 'input':
            case 'text':
            case null:
                $input = $this->createText($element);
                break;
        }
        if (!$input) {
            return null;
        }
        $widget->setInput($input);
        if ($element instanceof HasContainerTrait) {
            $widget->setAttributes($element->getContainerAttributes());
        }
        $widget->setValue($form->getValue($element->getName()));
        $widget->setRawValue($form->getRawValue($element->getName()));
        return $widget;
    }

    protected function createTextarea(Element $element) {
        $input = new Textarea();
        $input->setAttributes($element->getAttributes());
        return $input;
    }

    protected function createText(Element $element) {
        $input = new Text();
        $input->setAttributes($element->getAttributes());
        return $input;
    }

    protected function createPassword(Element $element) {
        $input = new Password();
        $input->setAttributes($element->getAttributes());
        return $input;
    }

    protected function createSelect(Element $element) {
        $input = new Select();
        $input->setAttributes($element->getAttributes());
        $input->setData('options', $element->getOptions());
        $input->setData('first_option', $element->getFirstOption());
        return $input;
    }

    protected function createMultiSelect(Element $element) {
        $input = new MultiSelect();
        $input->setAttributes($element->getAttributes());
        $input->setData('options', $element->getOptions());
        $input->setData('first_option', $element->getFirstOption());
        return $input;
    }

    protected function createFile(Element $element) {
        $input = new File();
        $input->setAttributes($element->getAttributes());
        return $input;
    }

}
