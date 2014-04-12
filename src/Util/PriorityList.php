<?php

namespace Sirius\Forms\Util;

/**
 * Class to manage an auto-sorted array
 * Each time an element is added to the list the array is sorted
 * based on priority (first) and adding order(second)
 *
 * It implements the IteratorAggregate interface so you iterate
 * over items added in the list
 */
class PriorityList implements \IteratorAggregate
{
    /**
     * @var int
     */
    protected $index = PHP_INT_MAX;
    /**
     * @var array
     */
    protected $list = array();

    /**
     * Add an item to the list
     *
     * @param mixed $item
     * @param integer $priority
     */
    function add($item, $priority = 0)
    {
        $this->index--;
        $entry = array(
            'item' => $item,
            'priority' => $priority,
            'index' => $this->index
        );
        $this->list[] = $entry;
        usort($this->list, array($this, 'compareEntries'));
    }

    /**
     * The function used for comparing 2 entries in the list
     *
     * @param array $e1
     * @param array $e2
     * @return number
     */
    protected function compareEntries($e1, $e2)
    {
        // first check the user provided priority
        if ($e1['priority'] > $e2['priority']) {
            return -1;
        } elseif ($e1['priority'] < $e2['priority']) {
            return 1;
        }
        // then check the automaticly assigned index
        if ($e1['index'] > $e2['index']) {
            return -1;
        } elseif ($e1['index'] < $e2['index']) {
            return 1;
        }
        return 0;
    }

    /* (non-PHPdoc)
     * @see IteratorAggregate::getIterator()
     */
    /**
     * @return array
     */
    function getIterator()
    {
        $items = array();
        foreach ($this->list as $entry) {
            $items[] = $entry['item'];
        }
        return $items;
    }
}
