<?php

namespace Sirius\Input\Element;

use Sirius\Input\Element\Input;

class GroupTest extends \PHPUnit_Framework_TestCase
{

    function testDefaults()
    {
        $input = new Group('left_column');

        $this->assertEquals('group', $input[Input::WIDGET]);
    }

}
