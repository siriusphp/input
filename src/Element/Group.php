<?php
namespace Sirius\Forms\Element;

/**
 * A group is a container for other elements.
 * It doesn't occupy a namespace like a fieldset does and elements can be moved out of a group.
 *
 * This is usefull if you organize your form into sections that may be displayed as tabs.
 * The elements will be attached to the form but they will have a group assigned as 'group'
 */
class Group extends Input
{

    protected function getDefaultSpecs()
    {
        return array(
            Input::WIDGET => 'group'
        );
    }
}
