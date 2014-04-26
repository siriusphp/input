<?php
namespace Sirius\Forms\WidgetFactory\Worker;


use Sirius\Forms\WidgetFactory\Task;
use Sirius\Forms\WidgetFactory\WorkerInterface;

class WidgetMissingAlerter implements WorkerInterface{

    /**
     * Process a widget factory task
     * It will throw an exception if there is no result on the task so it should be put at the bottom of the
     * worker's chain
     *
     * @param Task $task
     * @throws \RuntimeException
     */
    function processTask(Task $task)
    {
        if (!$task->getResult()) {
            throw new \RuntimeException('The widget factory has not produced anything for the task it received');
        }
    }

}
