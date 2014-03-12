<?php

namespace Sirius\Forms;

class FormBuilder {
	protected $elementFactory;
	protected $validatorFactory;
	protected $filtratorFactory;
	
	function __construct(
		ElementFactory $elementFactory = null,
		ValidatorFactory $validatorFactory = null,
		FiltratorFactory $filtratorFactory = null
	) {
		
	}
	
	function build($formClass) {
		
	}
}