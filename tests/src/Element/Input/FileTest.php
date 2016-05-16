<?php

namespace Sirius\Input\Element\Input;

use Sirius\Input\Element\Input;
use Sirius\Upload\Handler;
use Mockery as m;
use Sirius\Input\Specs;

class FileTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var \Sirius\Input\InputFilter
     */
    protected $form;

    /**
     * @var File
     */
    protected $input;

    function setUp()
    {
        $this->form  = m::mock('\Sirius\Input\InputFilter');
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
        $this->assertEquals('file', $this->input[Specs::WIDGET]);
    }


    function testPrepareFormUploadHandling()
    {
        $this->form->shouldReceive('add');
        $this->form->shouldReceive('prepare');
        $this->form->shouldReceive('setUploadHandler');
        $this->form->add('picture', $this->input);
        $this->form->prepare();
    }

}
