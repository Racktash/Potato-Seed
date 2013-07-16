<?php

abstract class Controller
{

	protected $view, $inner_view = null, $page_title = null;
	protected $validation_errors = array();

	public function getView()
	{
		return $this->view;
	}

	public function getPageTitle()
	{
		return $this->page_title;
	}

	public function getInnerView()
	{
		return $this->inner_view;
	}

	public function getValidationErrors()
	{
		return $this->validation_errors;
	}

	abstract public function execute();

	public function addValidationError($validation_error)
	{
		$this->validation_errors[] = $validation_error;	
	}

}

?>
