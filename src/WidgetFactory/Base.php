<?php
namespace Sirius\Forms\WidgetFactory;

use Sirius\Forms\Element\AbstractElement;
use Sirius\Forms\Form;
use Sirius\Forms\Util\PriorityList;

class Base implements FactoryInterface
{

    /**
     *
     * @var PriorityList
     */
    protected $workers;

    function __construct()
    {
        $this->workers = new PriorityList();
    }

    /**
     * Adds a worker on the list of workers that will process tasks
     *
     * @param WorkerInterface $worker
     * @param integer $priority
     * @return self
     */
    function addWorker(WorkerInterface $worker, $priority = 0)
    {
        $this->workers->add($worker, $priority);
        return $this;
    }

    /*
     * (non-PHPdoc) @see \Sirius\Forms\WidgetFactory\FactoryInterface::createWidget()
     */
    function createWidget(Form $form, AbstractElement $element = null)
    {
        $task = $this->createTask($form, $element);
        foreach ($this->workers as $worker) {
            /* @var $worker \Sirius\Forms\WidgetFactory\WorkerInterface */
            $worker->processTask($task);
        }
        return $task->getResult();
    }

    /**
     * Composes a task that is be passed to workers for processing
     *
     * @param Form $form
     * @param AbstractElement $element
     * @return \Sirius\Forms\WidgetFactory\Task
     */
    protected function createTask(Form $form, AbstractElement $element = null)
    {
        return new Task($this, $form, $element);
    }
}
