<?php
namespace Sirius\Input\Element\Input;

use Sirius\Input\Element\Input as BaseInput;
use Sirius\Input\Traits\HasUploadTrait;
use Sirius\Input\Form;
use Sirius\Upload\Handler;

/**
 * File form element
 *
 * @package Sirius\Input\Element\Input
 */
class File extends BaseInput
{

    use HasUploadTrait;

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
        // create the upload handler
        $uploadHandler = new Handler(
            $this->getUploadContainer(),
            $form->getValidator()->getErroMessagePrototype(),
            $this->getUploadOptions()
        );
        if (is_array($this->getUploadRules())) {
            foreach ($this->getUploadRules() as $rule) {
                if (!is_array($rule)) {
                    $rule = array($rule);
                }
                $name = $rule[0];
                $options = isset($rule[1]) ? $rule[1] : null;
                $message = isset($rule[2]) ? $rule[2] : null;
                $label = $this->getLabel();
                $uploadHandler->addRule($name, $options, $message, $label);
            }
        }
        $form->setUploadHandler(Form::UPLOAD_PREFIX . $this->getName(), $uploadHandler);
    }

}
