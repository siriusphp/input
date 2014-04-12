<?php

namespace Sirius\Forms\WidgetFactory;

interface WorkerInterface
{

    /**
     * Process a widget factory task
     *
     * @param Task $task
     */
    function processTask(Task $task);
}
