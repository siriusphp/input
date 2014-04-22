<?php

namespace Sirius\Forms\Element\Traits;

use Sirius\Forms\Element\Input;
use Sirius\Forms\Form;

trait HasFiltersTrait {

    /**
     * Get data filters for the element
     *
     * @return array
     */
    function getFilters() {
        return isset($this[Input::FILTERS]) ? $this[Input::FILTERS] : array();
    }

    /**
     * Sets data filter for the element
     *
     * @param array $filters
     *
     * @return $this
     */
    function setFilters($filters = array()) {
        $this[Input::FILTERS] = $filters;
        return $this;
    }

    /**
     * Attached the element's data filters to the form's filtrator object
     *
     * @param Form $form
     *
     * @throws \InvalidArgumentException
     */
    protected function prepareFormFiltration(Form $form)
    {
        $filters = $this->getFilters();
        if (!$filters || !is_array($filters)) {
            return;
        }
        $filtrator = $form->getFiltrator();
        foreach ($filters as $filter) {
            $params = is_array($filter) ? $filter : array($filter);
            if (isset($params[0])) {
                $filtrator->add($this->getName(), $params[0], @$params[1], @$params[2], @$params[3]);
            }
        }
    }

}
