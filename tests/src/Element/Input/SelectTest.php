<?php
namespace Sirius\Input\Element\Input;

use Sirius\Input\Element\Input;
use Mockery as m;

class SelectTest extends \PHPUnit_Framework_TestCase
{

    /**
     *
     * @var \Sirius\Filtration\Filtrator
     */
    protected $filtrator;

    /**
     *
     * @var \Sirius\Input\InputFilter
     */
    protected $form;

    /**
     *
     * @var Select
     */
    protected $input;

    function setUp()
    {
        $this->filtrator = m::mock('\Sirius\Filtration\Filtrator');
        $this->form = new \Sirius\Input\InputFilter(null, null, $this->filtrator);
        $this->input = new Select('select');
        $this->input->setOptions(array(
            'a' => 'A',
            'b' => 'B'
        ));
    }

    function tearDown()
    {
        m::close();
    }

    function testDefaults()
    {
        $this->assertEquals('select', $this->input[Input::WIDGET]);
    }

    function testFirstOption()
    {
    	$this->input->setFirstOption('select from list...');
    	$this->assertEquals('select from list...', $this->input->getFirstOption());
    }

    function testPrepareFormFiltration()
    {
        $this->filtrator->shouldReceive('getFilters');
        $this->filtrator->shouldReceive('add')->with('select', 'callback', array(
            'callback' => array(
                $this->input,
                'filterValue'
            )
        ));
        $this->form->addElement($this->input);
        $this->form->prepare();
    }

    function testFilterValue()
    {
        $this->assertEquals('a', $this->input->filterValue('a'));
        $this->assertEquals(null, $this->input->filterValue('c'));
    }
}
