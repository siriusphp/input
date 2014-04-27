<?php
include_once('../autoload.php');
include_once('../vendor/siriusphp/filtration/autoload.php');
include_once('../vendor/siriusphp/validation/autoload.php');
include_once('../vendor/siriusphp/upload/autoload.php');

use Sirius\Forms\Element;
use Sirius\Forms\Form;
use Sirius\Forms\Renderer;

$form = new Form();
$formRenderer = new Renderer();

$form->add(
    'name',
    array(
        Element::ELEMENT_TYPE => 'text',
        Element::LABEL => 'Your name',
        Element::FILTERS => array(
            'stringtrim',
        ),
        Element::VALIDATION_RULES => array(
            'required'
        )
    )
);
$form->add(
    'email',
    array(
        Element::ELEMENT_TYPE => 'text',
        Element::LABEL => 'Your email',
        Element::FILTERS => array(
            'stringtrim',
        ),
        Element::VALIDATION_RULES => array(
            'required',
            'email'
        )
    )
);
$form->add(
    'department',
    array(
        Element::ELEMENT_TYPE => 'select',
        Element::LABEL => 'Department',
        Element::VALIDATION_RULES => array(
            'required',
        ),
        Element::OPTIONS => array(
            'marketing' => 'Marketing',
            'accounting' => 'Accounting',
            'unknown' => 'Don\'t know for sure',
        ),
        Element::HINT => 'Select the department where you want to sent your inquiry'
    )
);
$form->add(
    'content',
    array(
        Element::ELEMENT_TYPE => 'textarea',
        Element::LABEL => 'Your request',
        Element::FILTERS => array(
            'stringtrim',
        ),
        Element::VALIDATION_RULES => array(
            'required'
        )
    )
);
$form->add(
    'submit',
    array(
        Element::ELEMENT_TYPE => 'submit',
        Element::LABEL => 'Send inquiry'
    )
);

print_r($form->getChildren());
//echo $formRenderer->render($form);
