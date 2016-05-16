<?php
namespace Sirius\Input\Element;

use Sirius\Input\Specs;

/**
 * A group is a container for other elements.
 * It doesn't occupy a namespace like a fieldset does and elements can be moved out of a group.
 *
 * This is usefull if you organize your input into sections that may be displayed as tabs.
 * The elements will be attached to the input but they will have a group assigned as 'group'
 */
class Group extends Input
{

    protected function getDefaultSpecs()
    {
        return array(
            Specs::WIDGET => 'group'
        );
    }
}
