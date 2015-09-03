<?php

namespace Sirius\Input\Element\Input;

use Sirius\Input\Element\Input;

class TextareaTest extends \PHPUnit_Framework_TestCase
{

    function testDefaults()
    {
        $input = new Textarea('comment');

        $this->assertEquals('textarea', $input[Input::WIDGET]);
        $this->assertEquals(5, $input[Input::ATTRIBUTES]['rows']);
        $this->assertEquals(100, $input[Input::ATTRIBUTES]['cols']);
    }

}
