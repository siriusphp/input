<?php
namespace Sirius\Input\Element\Input;

use Sirius\Input\Element\Input as BaseInput;
use Sirius\Input\Traits\HasUploadTrait;
use Sirius\Input\InputFilter;
use Sirius\Upload\Handler;

/**
 * File element
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
     * Attaches the upload handlers to the input object
     *
     * @param InputFilter $inputFilter
     */
    protected function prepareUploadHandlers(InputFilter $inputFilter)
    {
        $uploadValidator = new \Sirius\Validation\ValueValidator(
            $inputFilter->getValidator()->getRuleFactory(),
            $inputFilter->getValidator()->getErroMessagePrototype(),
            $this->getLabel()
        );

        // create the upload handler
        $uploadHandler = new Handler(
            $this->getUploadContainer(),
            $this->getUploadOptions(),
            $uploadValidator
        );
        if (is_array($this->getUploadRules())) {
            foreach ($this->getUploadRules() as $rule) {
                if ( ! is_array($rule)) {
                    $rule = array( $rule );
                }
                $name    = $rule[0];
                $options = isset($rule[1]) ? $rule[1] : null;
                $message = isset($rule[2]) ? $rule[2] : null;
                $label   = $this->getLabel();
                $uploadHandler->addRule($name, $options, $message, $label);
            }
        }
        $inputFilter->setUploadHandler($inputFilter->getUploadPrefix() . $this->getName(), $uploadHandler);
    }

}
