<?php

namespace Sirius\Input\Element\Button;

use Sirius\Input\Element;

class ResetTest extends \PHPUnit_Framework_TestCase
{

    function testDefaults()
    {
        $input = new Reset('reset');

        $this->assertEquals('button', $input[Element::WIDGET]);
        $this->assertEquals('reset', $input[Element::ATTRIBUTES]['type']);
    }

}
