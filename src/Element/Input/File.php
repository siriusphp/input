<?php
namespace Sirius\Forms\Element\Input;

use Sirius\Forms\Element\Input as BaseInput;
use Sirius\Forms\Form;

/**
 * File form element
 * @package Sirius\Forms\Element\Input
 */
class File extends BaseInput
{

    /**
     * @non
     * @return array
     */
    protected function getDefaultSpecs()
    {
        return array(
            BaseInput::WIDGET => 'file'
        );
    }

    /**
     * Attaches the upload handlers to the form
     *
     * @param Form $form
     */
    protected function prepareFormUploadHandling(Form $form)
    {

    }

}
