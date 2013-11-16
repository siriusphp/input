<?php
namespace Sirius\FormsTest\Renderer\Widget;

use Sirius\Forms\Html\Label;

class LabelTest extends \PHPUnit_Framework_TestCase
{

    function setUp()
    {
        $this->input = new Label(array(
            'attrs' => array(
                'for' => 'email'
            ),
            'text' => 'Email'
        ));
    }

    function testRender()
    {
        $this->assertEquals('<label for="email">Email</label>', (string) $this->input);
    }
}