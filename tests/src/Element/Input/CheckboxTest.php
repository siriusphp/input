<?php

namespace Sirius\Input\Element\Input;

use Sirius\Input\Element\Input;
use Sirius\Input\Specs;

class CheckboxTest extends \PHPUnit_Framework_TestCase
{

    function testDefaults()
    {
        $input = new Checkbox('agree');

        $this->assertEquals('checkbox', $input[Specs::WIDGET]);
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
