<?php

namespace Sirius\Input\Element;

use Sirius\Input\Element;
use Sirius\Input\Specs;

class ButtonTest extends \PHPUnit_Framework_TestCase
{

    function testDefaults()
    {
        $button = new Button('submit');

        $this->assertEquals('button', $button[Specs::WIDGET]);
    }


    function testLabel()
    {
        $button = new Button('submit');

        $this->assertNull($button->getLabel());
        $button->setLabel('Submit');
        $this->assertEquals('Submit', $button->getLabel());
    }
}
