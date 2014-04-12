<?php
namespace Sirius\Forms\Element;

use Mockery as m;

class InputTest extends \PHPUnit_Framework_TestCase
{

    function setUp()
    {
        $this->validator = m::mock('\Sirius\Validation\Validator');
        $this->filtrator = m::mock('\Sirius\Filtration\Filtrator');
        $this->form = new \Sirius\Forms\Form(null, $this->validator, $this->filtrator);
    }

    function tearDown()
    {
        m::close();
    }

    function testPrepareFormValidation()
    {
        $this->form->add(
            'email',
            array(
                Input::ELEMENT_TYPE => 'text',
                Input::LABEL => 'Email',
                Input::FILTERS => array(
                    'stringtrim',
                    array(
                        'truncate',
                        'limit=100'
                    )
                ),
                Input::VALIDATION_RULES => array(
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

        $email = $this->form->get('email');
        foreach ($email->getValidationRules() as $rule) {
            if (!is_array($rule)) {
                $rule = array(
                    $rule
                );
            }
            $this->validator->shouldReceive('add')
                ->with('email', $rule[0], @$rule[1], @$rule[2], $email->getLabel())
                ->andReturn($this->validator);
        }

        foreach ($email->getFilters() as $filter) {
            if (!is_array($filter)) {
                $filter = array($filter);
            }
            $this->filtrator->shouldReceive('add')
                ->with('email', $filter[0], @$filter[1], @$filter[2], @$filter[3])
                ->andReturn($this->filtrator);
        }

        $this->form->prepare();
    }
}
