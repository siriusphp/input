<?php

namespace Sirius\Input\Traits;

use Sirius\Input\Specs;
use Sirius\Input\InputFilter;

trait HasFiltersTrait {

    /**
     * Get data filters for the element
     *
     * @return array
     */
    function getFilters() {
        return isset($this[Specs::FILTERS]) ? $this[Specs::FILTERS] : array();
    }

    /**
     * Sets data filter for the element
     *
     * @param array $filters
     *
     * @return $this
     */
    function setFilters($filters = array()) {
        $this[Specs::FILTERS] = $filters;
        return $this;
    }

    /**
     * Attached the element's data filters to the filtrator object
     *
     * @param InputFilter $input
     *
     * @throws \InvalidArgumentException
     */
    protected function prepareFiltrator(InputFilter $input)
    {
        $filters = $this->getFilters();
        if (!$filters || !is_array($filters)) {
            return;
        }
        $filtrator = $input->getFiltrator();
        foreach ($filters as $filter) {
            $params = is_array($filter) ? $filter : array($filter);
            if (isset($params[0])) {
                $filtrator->add($this->getName(), $params[0], @$params[1], @$params[2], @$params[3]);
            }
        }
    }

}
