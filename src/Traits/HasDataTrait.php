<?php
namespace Sirius\Input\Traits;

use Sirius\Input\Specs;
use Sirius\Input\DataContainer;

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
     * @param string $key
     *
     * @return mixed
     */
    public function getData($key = null)
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
     * @param string $keyOrArray
     * @param mixed|null $value
     *
     * @return self
     */
    public function setData($keyOrArray, $value = null)
    {
        $this->ensureData();
        $this[Specs::DATA]->set($keyOrArray, $value);

        return $this;
    }

}