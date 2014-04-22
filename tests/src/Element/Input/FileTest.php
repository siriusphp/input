<?php

namespace Sirius\Forms\Element\Input;

use Sirius\Forms\Element\Input;
use Sirius\Upload\Handler;
use Mockery as m;

class FileTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var \Sirius\Forms\Form
     */
    protected $form;

    /**
     * @var File
     */
    protected $input;

    function setUp()
    {
        $this->form = m::mock('\Sirius\Forms\Form');
        $this->input = new File('picture');
        $this->input->setUploadContainer('/var/www');
        $this->input->setUploadOptions(array(
            Handler::OPTION_AUTOCONFIRM => true
        ));
        $this->input->setUploadRules(array(
            'image'
        ));
    }

    function tearDown()
    {
        m::close();
    }

    function testDefaults()
    {
        $this->assertEquals('file', $this->input[Input::WIDGET]);
    }


    function testPrepareFormUploadHandling() {
        $this->form->shouldReceive('add');
        $this->form->shouldReceive('prepare');
        $this->form->shouldReceive('setUploadHandler');
        $this->form->add('picture', $this->input);
        $this->form->prepare();
    }

}
