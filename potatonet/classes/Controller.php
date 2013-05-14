<?php

abstract class Controller
{

	protected $model, $view, $inner_view = null, $page, $page_title = null;
	protected $validation_errors = array();

	public function getModel()
	{
		return $this->model;
	}

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

	public function getPage()
	{
		return $this->page;
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
