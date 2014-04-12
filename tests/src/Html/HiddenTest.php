<?php
namespace Sirius\FormsTest\Renderer\Widget;

use Sirius\Forms\Html\Hidden;

class HiddenTest extends \PHPUnit_Framework_TestCase
{

    function setUp()
    {
        $this->input = new Hidden(
            array(
                'name' => 'token'
            )
        );
    }

    function testRender()
    {
        $this->assertEquals('<input name="token" type="hidden">', (string)$this->input);
    }
}
