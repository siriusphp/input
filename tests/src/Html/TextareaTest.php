<?php
namespace Sirius\FormsTest\Renderer\Widget;

use Sirius\Forms\Html\Textarea;

class TextareaTest extends \PHPUnit_Framework_TestCase
{

    function setUp()
    {
        $this->input = new Textarea(
            array(
                'name' => 'comment',
                'value' => 'Sirius Forms rocks!',
                'attrs' => array(
                    'cols' => '30'
                )
            )
        );
    }

    function testRender()
    {
        $this->assertEquals('<textarea cols="30" name="comment">Sirius Forms rocks!</textarea>', (string)$this->input);
    }
}
