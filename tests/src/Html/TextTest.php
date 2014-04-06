<?php
namespace Sirius\FormsTest\Renderer\Widget;

use Sirius\Forms\Html\Text;

class TextTest extends \PHPUnit_Framework_TestCase
{

    function setUp()
    {
        $this->input = new Text(array(
            'name' => 'username',
            'value' => 'siriusforms',
            'attrs' => array(
                'disabled' => true,
                'class' => 'not-valid'
            )
        ));
    }

    function testFactoryMethod()
    {
        $input = Text::create();
        $this->assertTrue($input instanceof Text);
    }

    function testFactoryOfCustomElement()
    {
        $input = Text::create(array(), 'em', false);
        $this->assertEquals('<em></em>', (string) $input);
    }

    function testAttributes()
    {
        $this->assertEquals('siriusforms', $this->input->getValue());
        $this->assertEquals('username', $this->input->getAttribute('name'));
        $this->assertTrue($this->input->hasClass('not-valid'));
    }

    function testRender()
    {
        $this->assertEquals('<input class="not-valid" disabled name="username" value="siriusforms">', (string) $this->input);
    }
}