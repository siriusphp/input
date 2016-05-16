<?php

namespace Sirius\Input\Element\Button;

use Sirius\Input\Specs;

class SubmitTest extends \PHPUnit_Framework_TestCase
{

    public function testDefaults()
    {
        $input = new Submit('submit');

        $this->assertEquals('button', $input[Specs::WIDGET]);
        $this->assertEquals('submit', $input[Specs::ATTRIBUTES]['type']);
    }

}
