<?php
namespace Sirius\Forms\Element\Input;

use Sirius\Forms\Element\Input as BaseInput;
use Sirius\Forms\Element\Traits\HasUploadTrait;
use Sirius\Forms\Form;
use Sirius\Upload\Handler;

/**
 * File form element
 *
 * @package Sirius\Forms\Element\Input
 */
class File extends BaseInput
{
    public static $inputPrefix = '__upload_';

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
        // create the upload hanlder
        $uploadHandler = new Handler(
            $this->getUploadContainer(),
            $form->getValidator()->getErroMessagePrototype(),
            $this->getUploadOptions()
        );
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
        $form->setUploadHanlder(static::$inputPrefix . $this->getName(), $uploadHandler);
    }

}
