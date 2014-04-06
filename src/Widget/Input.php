<?php
namespace Sirius\Renderer\Widget;

use Sirius\Forms\Html\ExtendedTag;

class Input extends ExtendedTag
{
    use \Sirius\Forms\Widget\Traits\HasLabelTrait;
    use \Sirius\Forms\Widget\Traits\HasHintTrait;
    use \Sirius\Forms\Widget\Traits\HasErrorTrait;
    use \Sirius\Forms\Widget\Traits\HasInputTrait;

    function render()
    {
        $error = $this->getError() && $this->getError()->text() ? $this->getError() : '';
        $label = $this->getLabel() && $this->getLabel()->text() ? $this->getLabel() : '';
        $hint = $this->getHint() && $this->getHint()->text() ? $this->getHint() : '';
        $input = $this->getInput();
        $this->text("{$error}{$label}{$input}{$hint}");
        return parent::render();
    }
}