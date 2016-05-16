<?php

namespace Sirius\Input\Element\Input;

use Sirius\Input\Element\Input;
use Sirius\Input\Specs;

class TextareaTest extends \PHPUnit_Framework_TestCase
{

    function testDefaults()
    {
        $input = new Textarea('comment');

        $this->assertEquals('textarea', $input[Specs::WIDGET]);
        $this->assertEquals(5, $input[Specs::ATTRIBUTES]['rows']);
        $this->assertEquals(100, $input[Specs::ATTRIBUTES]['cols']);
    }

}
