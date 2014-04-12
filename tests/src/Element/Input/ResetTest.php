<?php

namespace Sirius\Forms\Element\Input;

use Sirius\Forms\Element\Input;

class ResetTest extends \PHPUnit_Framework_TestCase
{

    function testDefaults()
    {
        $input = new Reset('reset');

        $this->assertEquals('button', $input[Input::WIDGET]);
        $this->assertEquals('reset', $input[Input::ATTRIBUTES]['type']);
    }

}
