<?php
namespace Sirius\Forms\Util;

use Sirius\Forms\Util\PriorityList;

class PriorityListTest extends \PHPUnit_Framework_TestCase
{

    function setUp()
    {
        $this->list = new PriorityList();
    }
    
    function testAddItems() {
        $this->list->add('item_2'); // priority 0
        $this->list->add('item_3'); // priority 0
        $this->list->add('item_1', 100);
        
        $items = $this->list->getIterator();
        $this->assertEquals('item_1', $items[0]);
        $this->assertEquals('item_2', $items[1]);
        $this->assertEquals('item_3', $items[2]);
    }
}