<?php
namespace Sirius\Input;

use Mockery as m;

class FormTest extends \PHPUnit_Framework_TestCase
{

    /**
     *
     * @var InputFilter
     */
    protected $form;

    function setUp()
    {
        $this->form = new InputFilter();
    }

    function testExceptionThrownOnInvalidElements()
    {
    	$this->setExpectedException('RuntimeException');
    	$this->form->addElement(new \stdClass());
    }

    function testRemoveElements()
    {
        $this->assertFalse($this->form->hasElement('email'));
        
        $this->form->addElement('email', array(
            Element::TYPE => 'text'
        ));
        
        $this->assertTrue($this->form->hasElement('email'));
        
        $this->form->removeElement('email');
        $this->assertFalse($this->form->hasElement('email'));
    }

    function testPrepare()
    {
        $this->form->addElement('email', array(
            Element::TYPE => 'text',
            Element::VALIDATION_RULES => array(
                'required',
                'email'
            )
        ));
        $this->form->addElement('picture', array(
            Element::TYPE => 'file',
            Element::UPLOAD_CONTAINER => __DIR__,
            Element::UPLOAD_RULES => array(
                'image'
            )
        ));
        $this->form->prepare();
        
        $validator = $this->form->getValidator();
        $validationRules = $validator->getRules();
        $this->assertTrue(array_key_exists('email', $validationRules));
        
        $uploadHandlers = $this->form->getUploadHandlers();
        $handlers = $uploadHandlers->getIterator();
        $this->assertTrue(array_key_exists($this->form->getUploadPrefix() . 'picture', $handlers));
    }

    function testPopulate()
    {
        /**
         * email field should be filtered (trim whitespace)
         * and validated against the rules
         */
        $emailValue = '   ';
        $this->form->addElement('email', array(
            Element::TYPE => 'text',
            Element::VALIDATION_RULES => array(
                'required',
                'email'
            ),
            Element::FILTERS => array(
                'stringtrim',
                'nullify'
            )
        ));
        $this->form->populate(array(
            'email' => $emailValue
        ));
        $this->form->isValid();
        
        $this->assertEquals($emailValue, $this->form->getRawValue('email'));
        $this->assertEquals('', $this->form->getValue('email'));
        $this->assertFalse($this->form->isValid());
        $this->assertEquals('This field is required', (string) $this->form->getValidator()
            ->getMessages('email')[0]);
    }

    function testSuccessfulUpload()
    {
        /**
         * The `picture` file element will upload the file as `__upload_picture` and, if the upload is successful
         * the result will populate the `picture` value of the field
         */
        $uploadedFile = array(
            'name' => 'pic.png',
            'tmp_name' => '/tmp/php1234.tmp'
        );
        
        // the result of the upload
        $file = $uploadedFile;
        $file['original_name'] = $file['name'];
        $file['name'] = '1234_pic.png'; // the file will be uploaded with a prefix
        
        $mockedUploadContainer = m::mock('\Sirius\Upload\Container\Local');
        $mockedUploadContainer->shouldReceive('isWritable')->andReturn(true);
        $mockedUploadContainer->shouldReceive('delete')->andReturn(true);
        
        $mockedUploadHandler = m::mock('\Sirius\Upload\Handler');
        $mockedUploadHandler->shouldReceive('process')->andReturn(new \Sirius\Upload\Result\File($file, $mockedUploadContainer));
        
        // first we need to prepare the form, then add the handler
        // otherwise the handlers will be cleared
        $this->form->prepare();
        $this->form->getUploadHandlers()->addHandler($this->form->getUploadPrefix() . 'picture', $mockedUploadHandler);
        
        $this->form->populate(array(
            $this->form->getUploadPrefix() . 'picture' => $uploadedFile
        ));
        $this->form->isValid();
        
        $this->assertEquals($file['name'], $this->form->getValue('picture'));
    }

    function testFailedUpload()
    {
        /**
         * The `picture` file element will upload the file as `__upload_picture` and, if the upload is successful
         * the result will populate the `picture` value of the field
         */
        $uploadedFile = array(
            'name' => 'pic.png', // PNGs are not allowed
            'tmp_name' => '/tmp/php1234.tmp'
        );

        // the result of the upload; it has error messages
        $file = $uploadedFile;
        $file['original_name'] = $file['name'];
        $file['messages'] = array('Invalid file');

        $mockedUploadContainer = m::mock('\Sirius\Upload\Container\Local');
        $mockedUploadContainer->shouldReceive('isWritable')->andReturn(true);
        $mockedUploadContainer->shouldReceive('delete')->andReturn(true);

        /* @var $mockedUploadHandler \Sirius\Upload\Handler */
        $mockedUploadHandler = m::mock('\Sirius\Upload\Handler');
        $mockedUploadHandler->shouldReceive('process')->andReturn(new \Sirius\Upload\Result\File($file, $mockedUploadContainer));

        // first we need to prepare the form, then add the handler
        // otherwise the handlers will be cleared
        $this->form->prepare();
        $this->form->getUploadHandlers()->addHandler($this->form->getUploadPrefix() . 'picture', $mockedUploadHandler);

        $this->form->populate(array(
            $this->form->getUploadPrefix() . 'picture' => $uploadedFile
        ));
        $this->form->isValid();

        $this->assertEquals(null, $this->form->getValue('picture'));
        $errors = $this->form->getErrors();
        $this->assertNotEquals(null, $errors['picture']);
    }

    function testGetChildrenOrder()
    {
        $this->form->addElement('email', array(
            Element::TYPE => 'text',
            Element::POSITION => 8
        ));
        $this->form->addElement('email_confirmation', array(
            Element::TYPE => 'text',
            Element::POSITION => 8
        ));
        $this->form->addElement('name', array(
            Element::TYPE => 'text'
        ));
        
        $children = array_keys($this->form->getElements());
        $this->assertSame('name', $children[0]);
        $this->assertSame('email', $children[1]);
        $this->assertSame('email_confirmation', $children[2]);
    }

    function testFormFilter() {
        $this->form->addElement('email', array(
            Element::TYPE => 'text',
            Element::POSITION => 8
        ));
        $this->form->addElement('email_confirmation', array(
            Element::TYPE => 'text',
            Element::POSITION => 8
        ));
        // the filter will be set at
        $this->form->setFilters(array(
            array('stringtrim', array(), true, false)
        ));

        $rawValues = array(
            'email' => '  abc',
            'email_confirmation' => 'abc   '
        );
        $this->form->populate($rawValues);

        $this->form->isValid();

        $values = $this->form->getValues();
        $this->assertEquals($rawValues, $this->form->getRawValues());
        $this->assertEquals(array(
            'email' => 'abc',
            'email_confirmation' => 'abc'
        ), $values);



    }

    function testUnsetMissingElementGroups() {
        $this->form->addElement('email', array(
            Element::TYPE => 'text',
            Element::POSITION => 8,
            Element::GROUP => 'missing'
        ));
        $this->form->addElement('email_confirmation', array(
            Element::TYPE => 'text',
            Element::POSITION => 8,
            Element::GROUP => 'missing'
        ));

        $this->form->prepare();

        $elements = $this->form->getElements();

        $this->assertEquals(null, $elements['email']->getGroup());
        $this->assertEquals(null, $elements['email_confirmation']->getGroup());
    }
}
