<?php
namespace Sirius\Input\Element;

use Mockery as m;
use Sirius\Input\InputFilter;
use Sirius\Input\Specs;

class FieldsetTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var InputFilter
     */
    protected $inputFilter;

    /**
     * @var Fieldset
     */
    protected $input;

    function setUp()
    {
        $this->validator   = m::mock('\Sirius\Validation\Validator');
        $this->filtrator   = m::mock('\Sirius\Filtration\Filtrator');
        $this->inputFilter = new \Sirius\Input\InputFilter(null, $this->validator, $this->filtrator);

        $this->input = new Fieldset('address');
        $this->input->setElementFactory($this->inputFilter->getElementFactory());
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

        $children     = $this->input->getElements();
        $elementNames = array_keys($children);

        // test the element are in the correct order
        $this->assertEquals('street', $elementNames[0]);
        $this->assertEquals('city', $elementNames[1]);
        $this->assertEquals('state', $elementNames[2]);
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
        $this->inputFilter->addElement($this->input);
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

        $this->inputFilter->prepare();
    }

    function testChildrenAddedFromSpecs()
    {
        $this->inputFilter->addElement('address', [
            Specs::TYPE     => 'fieldset',
            Specs::CHILDREN => [
                'street' => [
                    Specs::TYPE => 'text',
                ],
                'city'   => [
                    Specs::TYPE => 'text',
                ],
                'zip'    => [
                    Specs::TYPE => 'text',
                ]
            ]
        ]);

        $this->assertEquals(3, count($this->inputFilter->getElement('address')->getElements()));
    }
}
