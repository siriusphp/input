<?php
namespace Sirius\Input\Element;

use Mockery as m;
use Sirius\Input\InputFilter;
use Sirius\Input\Specs;

class InputTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var InputFilter
     */
    protected $element;

    function setUp()
    {
        $this->validator = m::mock('\Sirius\Validation\Validator');
        $this->filtrator = m::mock('\Sirius\Filtration\Filtrator');
        $this->form      = new InputFilter(null, $this->validator, $this->filtrator);
        $this->element   = new Input('username');
    }

    function tearDown()
    {
        m::close();
    }

    function testLabel()
    {
        $this->element->setLabel('Username');
        $this->assertEquals('Username', $this->element['label']);
        $this->assertEquals('Username', $this->element->getLabel());
    }

    function testLabelAttributes()
    {
        // setting single attribute
        $this->element->setLabelAttribute('class', 'required');
        $this->assertEquals('required', $this->element->getLabelAttribute('class'));

        // remove attriubte
        $this->element->setLabelAttribute('class');
        $this->assertNull($this->element->getLabelAttribute('class'));

        // set multiple attributes
        $attrs = array(
            'data-attribute-a' => 'a'
        );
        $this->element->setLabelAttributes($attrs);
        $this->assertEquals($attrs, $this->element->getLabelAttributes());
    }

    function testLabelCssClassHandling()
    {
        // add CSS class
        $this->assertNull($this->element->getLabelAttribute('class'));
        $this->element->removeLabelClass('missing');
        $this->assertNull($this->element->getLabelAttribute('class'));

        $this->element->addLabelClass('required');
        $this->assertTrue($this->element->hasLabelClass('required'));
        $this->element->removeLabelClass('required');
        $this->assertEmpty($this->element->getLabelAttribute('class'));

        $this->element->toggleLabelClass('required');
        $this->assertTrue($this->element->hasLabelClass('required'));
    }

    function testHint()
    {
        $this->element->setHint('Your website nickname');
        $this->assertEquals('Your website nickname', $this->element['hint']);
        $this->assertEquals('Your website nickname', $this->element->getHint());
    }

    function testHintAttributes()
    {
        // setting single attribute
        $this->element->setHintAttribute('class', 'form-tip');
        $this->assertEquals('form-tip', $this->element->getHintAttribute('class'));

        // remove attriubte
        $this->element->setHintAttribute('class');
        $this->assertNull($this->element->getHintAttribute('class'));

        // set multiple attributes
        $attrs = array(
            'data-attribute-a' => 'a'
        );
        $this->element->setHintAttributes($attrs);
        $this->assertEquals($attrs, $this->element->getHintAttributes());
    }

    function testHintCssClassHandling()
    {
        // add CSS class
        $this->assertNull($this->element->getHintAttribute('class'));
        $this->element->addHintClass('form-tip');
        $this->assertTrue($this->element->hasHintClass('form-tip'));
        $this->element->removeHintClass('form-tip');
        $this->assertFalse($this->element->hasHintClass('form-tip'));
        $this->element->toggleHintClass('form-tip');
        $this->assertTrue($this->element->hasHintClass('form-tip'));
    }

    function testPrepareFormValidation()
    {
        $this->form->addElement(
            'email',
            array(
                Specs::TYPE             => 'text',
                Specs::LABEL            => 'Email',
                Specs::FILTERS          => array(
                    'stringtrim',
                    array(
                        'truncate',
                        'limit=100'
                    )
                ),
                Specs::VALIDATION_RULES => array(
                    'required',
                    'email',
                    array(
                        'maxlength',
                        'max=100',
                        'This field should be less than 100 characters long'
                    )
                )
            )
        );

        $email = $this->form->getElement('email');
        foreach ($email->getValidationRules() as $rule) {
            if ( ! is_array($rule)) {
                $rule = array(
                    $rule
                );
            }
            $this->validator->shouldReceive('add')
                            ->with('email', $rule[0], @$rule[1], @$rule[2], $email->getLabel())
                            ->andReturn($this->validator);
        }

        foreach ($email->getFilters() as $filter) {
            if ( ! is_array($filter)) {
                $filter = array( $filter );
            }
            $this->filtrator->shouldReceive('add')
                            ->with('email', $filter[0], @$filter[1], @$filter[2], @$filter[3])
                            ->andReturn($this->filtrator);
        }

        $this->validator->shouldReceive('getRules');
        $this->validator->shouldReceive('remove');

        $this->filtrator->shouldReceive('getFilters');
        $this->filtrator->shouldReceive('remove');

        $this->form->prepare();
    }
}
