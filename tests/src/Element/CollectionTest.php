<?php
namespace Sirius\Forms\Element;

use Mockery as m;

class CollectionTest extends \PHPUnit_Framework_TestCase
{

    function setUp()
    {
        $this->validator = m::mock('\Sirius\Validation\Validator');
        $this->filtrator = m::mock('\Sirius\Filtration\Filtrator');
        $this->form = new \Sirius\Forms\Form(null, $this->validator, $this->filtrator);

        $this->input = new Collection('invoice_lines');
        $this->input->setElementFactory($this->form->getElementFactory());
    }

    function testAddingElements()
    {
        $this->input->add(
            'quantity',
            array(
                'position' => 2
            )
        );
        $this->input->add(
            'product',
            array(
                'position' => 1
            )
        );
        $this->input->add(
            'price',
            array(
                'position' => 2
            )
        );

        $children = $this->input->getChildren();
        $elementNames = array_keys($children);

        // test the element are in the correct order
        $this->assertEquals('invoice_lines[*][product]', $elementNames[0]);
        $this->assertEquals('invoice_lines[*][quantity]', $elementNames[1]);
        $this->assertEquals('invoice_lines[*][price]', $elementNames[2]);
    }

    function testRemovingElements()
    {
        $this->assertFalse($this->input->has('product'));
        $this->input->add(
            'product',
            array(
                'position' => 2
            )
        );
        $this->assertTrue($this->input->has('product'));

        $this->input->remove('product');

        $this->assertEquals(0, count($this->input->getChildren()));
    }

    function testDeepElement()
    {
        $this->input->add('discount[percentage]', array());
        $this->assertEquals(
            'invoice_lines[*][discount][percentage]',
            $this->input->get('discount[percentage]')
                ->getName()
        );
    }

    function testPrepareForm()
    {
        $this->form->add('invoice_lines', $this->input);
        $this->input->add(
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
