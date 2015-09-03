<?php
namespace Sirius\Input\Element;

use Sirius\Input\Specs;
use Mockery as m;

class CollectionTest extends \PHPUnit_Framework_TestCase
{

    function setUp()
    {
        $this->validator = m::mock('\Sirius\Validation\Validator');
        $this->filtrator = m::mock('\Sirius\Filtration\Filtrator');
        $this->form = new \Sirius\Input\InputFilter(null, $this->validator, $this->filtrator);

        $this->form->addElement('invoice_lines', array(Specs::TYPE => 'collection'));
        $this->input = $this->form->getElement('invoice_lines');
}

    function testAddingElements()
    {
        $this->input->addElement(
            'quantity',
            array(
                'position' => 2
            )
        );
        $this->input->addElement(
            'product',
            array(
                'position' => 1
            )
        );
        $this->input->addElement(
            'price',
            array(
                'position' => 2
            )
        );

        $children = $this->input->getElements();
        $elementNames = array_keys($children);

        // test the element are in the correct order
        $this->assertEquals('invoice_lines[*][product]', $elementNames[0]);
        $this->assertEquals('invoice_lines[*][quantity]', $elementNames[1]);
        $this->assertEquals('invoice_lines[*][price]', $elementNames[2]);
    }

    function testRemovingElements()
    {
        $this->assertFalse($this->input->hasElement('product'));
        $this->input->addElement(
            'product',
            array(
                'position' => 2
            )
        );
        $this->assertTrue($this->input->hasElement('product'));

        $this->input->removeElement('product');

        $this->assertEquals(0, count($this->input->getElements()));
    }

    function testDeepElement()
    {
        $this->input->addElement('discount[percentage]', array());
        $this->assertEquals(
            'invoice_lines[*][discount][percentage]',
            $this->input->getElement('discount[percentage]')
                ->getName()
        );
    }

    function testPrepareForm()
    {
        $this->form->addElement($this->input);
        $this->input->addElement(
            'product',
            array(
                Fieldset::VALIDATION_RULES => array(
                    'required',
                )
            )
        );

        $this->validator->shouldReceive('getRules');
        $this->validator->shouldReceive('remove');
        $this->validator->shouldReceive('add')
            ->with('invoice_lines[*][product]', 'required', null, null, null)
            ->andReturn($this->validator);

        $this->filtrator->shouldReceive('getFilters');
        $this->filtrator->shouldReceive('remove');

        $this->form->prepare();
    }
}
