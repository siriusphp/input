<?php
namespace Sirius\Forms;

use Mockery as m;

class FormTest extends \PHPUnit_Framework_TestCase
{

    function setUp()
    {
        $this->form = new \Sirius\Forms\Form();
    }


    function testRemoveElements()
    {
        $this->assertFalse($this->form->has('email'));

        $this->form->add('email', array(Element\Input::ELEMENT_TYPE => 'text'));

        $this->assertTrue($this->form->has('email'));

        $this->form->remove('email');
        $this->assertFalse($this->form->has('email'));

    }

}
