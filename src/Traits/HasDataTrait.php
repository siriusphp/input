<?php
namespace Sirius\Forms\Traits;

use Sirius\Forms\Specs;
use Sirius\Forms\DataContainer;

trait HasDataTrait
{

    protected function ensureData()
    {
        if (!isset($this[Specs::DATA])) {
            $this[Specs::DATA] = new DataContainer();
        }
    }
    
    /**
     * Retrieve an attribute from the label
     *
     * @param string $attr
     * @return mixed
     */
    function getData($key = null)
    {
        $this->ensureData();
        if ($key === null) {
            return $this[Specs::DATA]->getAll();
        }
        return $this[Specs::DATA]->get($key);
    }
    
    /**
     * Set/Unset a label attribute
     *
     * @param string $attr
     * @param mixed|null $value
     * @return self
     */
    function setData($keyOrArray, $value = null)
    {
        $this->ensureData();
        $this[Specs::DATA]->set($keyOrArray, $value);
        return $this;
    }
    
}