<?php
namespace Sirius\Forms;

use Mockery as m;

class FormTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Form
     */
    protected $form;

    function setUp()
    {
        $this->form = new Form();
    }


    function testRemoveElements()
    {
        $this->assertFalse($this->form->has('email'));

        $this->form->add('email', array(Element::ELEMENT_TYPE => 'text'));

        $this->assertTrue($this->form->has('email'));

        $this->form->remove('email');
        $this->assertFalse($this->form->has('email'));

    }

    function testPrepare()
    {
        $this->form->add(
            'email',
            array(
                Element::ELEMENT_TYPE     => 'text',
                Element::VALIDATION_RULES => array('required', 'email')
            )
        );
        $this->form->add(
            'picture',
            array(
                Element::ELEMENT_TYPE => 'file',
                Element::UPLOAD_CONTAINER => '/var/www',
                Element::UPLOAD_RULES => array('image')
            )
        );
        $this->form->prepare();

        $validator = $this->form->getValidator();
        $validationRules = $validator->getRules();
        $this->assertTrue(array_key_exists('email', $validationRules));

        $uploadHandlers = $this->form->getUploadHandlers();
        $handlers = $uploadHandlers->getIterator();
        $this->assertTrue(array_key_exists(Form::UPLOAD_PREFIX . 'picture', $handlers));
    }

}
