<?php
namespace Sirius\FormsTest\Renderer\Widget;

use Sirius\Forms\Html\Radio;

class RadioTest extends \PHPUnit_Framework_TestCase
{

    function setUp()
    {
        $this->input = new Radio(array(
            'name' => 'gender',
            'attrs' => array(
                'value' => 'male'
            ),
            'value' => 'male'
        ));
    }

    function testRender()
    {
        $this->assertEquals('<input checked="checked" name="gender" type="radio" value="male">', (string) $this->input);
    }
}