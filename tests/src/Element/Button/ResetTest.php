<?php

namespace Sirius\Input\Element\Button;

use Sirius\Input\Element;
use Sirius\Input\Specs;

class ResetTest extends \PHPUnit_Framework_TestCase
{

    public function testDefaults()
    {
        $input = new Reset('reset');

        $this->assertEquals('button', $input[Specs::WIDGET]);
        $this->assertEquals('reset', $input[Specs::ATTRIBUTES]['type']);
    }

}
