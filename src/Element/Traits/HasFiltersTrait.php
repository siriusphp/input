<?php

namespace Sirius\Forms\Element\Traits;

use Sirius\Forms\Element\Input;
use Sirius\Forms\Form;

trait HasFiltersTrait {

    function getFilters() {
        return isset($this[Input::FILTERS]) ? $this[Input::FILTERS] : array();
    }

    function setFilters($filters = array()) {
        $this[Input::FILTERS] = $filters;
        return $this;
    }

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
