<?php
namespace Sirius\Forms\WidgetFactory;

use Sirius\Forms\WidgetFactory\FactoryInterface;
use Sirius\Forms\WidgetFactory\Task;

class Base implements FactoryInterface
{

    /**
     *
     * @var \Sirius\Forms\Util\PriorityList
     */
    protected $workers;

    function __construct()
    {
        $this->workers = new \Sirius\Forms\Util\PriorityList();
    }

    /**
     * Adds a worker on the list of workers that will process tasks
     *
     * @param WorkerInterface $worker            
     * @param number $priority            
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
    function createWidget(\Sirius\Forms\Form $form,\Sirius\Forms\Element\Specs $element = null)
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
     * @param \Sirius\Forms\Form $form            
     * @param \Sirius\Forms\Element\Specs $element            
     * @return \Sirius\Forms\WidgetFactory\Task
     */
    protected function createTask(\Sirius\Forms\Form $form, \Sirius\Forms\Element\Specs $element = null)
    {
        return new Task($this, $form, $element);
    }
}