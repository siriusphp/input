<?php

namespace Sirius\Input\Element\Input;

use Sirius\Input\Element\Input;

class CheckboxTest extends \PHPUnit_Framework_TestCase
{

    function testDefaults()
    {
        $input = new Checkbox('agree');

        $this->assertEquals('checkbox', $input[Input::WIDGET]);
    }

    function testValues()
    {
        $input = new Checkbox('agree');

        $input->setUncheckedValue('no');
        $this->assertEquals('no', $input->getUncheckedValue());

        $input->setCheckedValue('yes');
        $this->assertEquals('yes', $input->getCheckedValue());
    }

}
