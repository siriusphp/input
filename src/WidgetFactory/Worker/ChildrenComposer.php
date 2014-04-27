<?php
namespace Sirius\Forms\WidgetFactory\Worker;


use Sirius\Forms\Element\Group;
use Sirius\Forms\WidgetFactory\Task;
use Sirius\Forms\WidgetFactory\WorkerInterface;

class ChildrenComposer implements WorkerInterface
{

    /**
     * Process a widget factory task
     *
     * @param Task $task
     */
    function processTask(Task $task)
    {
        $form = $task->getForm();
        $element = $task->getElement();
        $result = $task->getResult();

        // the element that contains the children
        $source = $element ?: $form;
        $sourceHasChildren = $source && method_exists($source, 'getChildren');
        if (!$source || !$sourceHasChildren || !method_exists($result, 'setChildren')) {
            return;
        }

        $children = $source->getChildren();
        // get the group children first
        $groupChildren = array();
        foreach ($children as $name => $child) {
            if ($child instanceof Group) {
                $groupChildren[$name] = array();
            }
        }

        // create the direct children
        $childrenWidgets = array();
        foreach ($children as $name => $child) {
            $childWidget = $task->getWidgetFactory()->createWidget($form, $child);
            // if the child belongs to a group which exists, add the widget to the group's children
            if ($child->getGroup() && isset($groupChildren[$child->getGroup()])) {
                $groupChildren[$child->getGroup()][$name] = $childWidget;
            // otherwise added to the final children widgets list
            } else {
                $childrenWidgets[$name] = $childWidget;
            }
        }

        // add the groups' children to their group element
        foreach ($groupChildren as $name => $children) {
            /* @var $groupWidget \Sirius\Forms\Widget\Group */
            $groupWidget = $childrenWidgets[$name];
            $groupWidget->setChildren($children);
        }

        // add the children to the target
        $result->setChildren($childrenWidgets);
    }

}
