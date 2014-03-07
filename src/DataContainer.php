<?php
namespace Sirius\Forms;

class DataContainer
{

    protected $data = array();

    protected $transformers = array();

    function get($name)
    {}

    function set($name, $value)
    {}

    function clear()
    {}

    function addTransformation($callback, $params = array())
    {}
}