<?php

abstract class Controller
{

	private $view, $inner_view = null, $page_title = null;
	private $validation_errors = array();

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

	public function setView($view)
	{
		$this->view = $view;
	}

	public function setPageTitle($page_title)
	{
		$this->page_title = $page_title;
	}

	public function setInnerView($inner_view)
	{
		$this->inner_view = $inner_view;
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
