<?php
namespace Sirius\Input\Element;

use Mockery as m;

class FieldsetTest extends \PHPUnit_Framework_TestCase
{

    function setUp()
    {
        $this->validator = m::mock('\Sirius\Validation\Validator');
        $this->filtrator = m::mock('\Sirius\Filtration\Filtrator');
        $this->form = new \Sirius\Input\InputFilter(null, $this->validator, $this->filtrator);

        $this->input = new Fieldset('address');
        $this->input->setElementFactory($this->form->getElementFactory());
    }

    function tearDown()
    {
        m::close();
    }

    function testAddingElements()
    {
        $this->input->addElement(
            'city',
            array(
                'position' => 2
            )
        );
        $this->input->addElement(
            'street',
            array(
                'position' => 1
            )
        );
        $this->input->addElement(
            'state',
            array(
                'position' => 2
            )
        );

        $children = $this->input->getElements();
        $elementNames = array_keys($children);

        // test the element are in the correct order
        $this->assertEquals('address[street]', $elementNames[0]);
        $this->assertEquals('address[city]', $elementNames[1]);
        $this->assertEquals('address[state]', $elementNames[2]);
    }

    function testRemovingElements()
    {
        $this->assertFalse($this->input->hasElement('city'));
        $this->input->addElement(
            'city',
            array(
                'position' => 2
            )
        );
        $this->assertTrue($this->input->hasElement('city'));

        $this->input->removeElement('city');

        $this->assertEquals(0, count($this->input->getElements()));
    }

    function testDeepElement()
    {
        $this->input->addElement('country[code]', array());
        $this->assertEquals(
            'address[country][code]',
            $this->input->getElement('country[code]')
                ->getName()
        );
    }

    function testPrepareForm()
    {
        $this->form->addElement($this->input);
        $this->input->addElement(
            'city',
            array(
                Fieldset::VALIDATION_RULES => array(
                    'required',
                )
            )
        );

        $this->validator->shouldReceive('getRules');
        $this->validator->shouldReceive('remove');
        $this->validator->shouldReceive('add')
            ->with('address[city]', 'required', null, null, null)
            ->andReturn($this->validator);

        $this->filtrator->shouldReceive('getFilters');
        $this->filtrator->shouldReceive('remove');

        $this->form->prepare();
    }
}
