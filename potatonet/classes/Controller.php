<?php

abstract class Controller
{

    protected $model, $view, $inner_view=null, $page, $page_title=null;
    
    protected $validation_errors = array();

    public function returnModel()
    {
        return $this->model;
    }

    public function returnView()
    {
        return $this->view;
    }
    
    public function returnPageTitle()
    {
        return $this->page_title;
    }
    
    public function returnInnerView()
    {
        return $this->inner_view;
    }

    public function returnPage()
    {
        return $this->page;
    }
    
    public function returnValidationErrors()
    {
        return $this->validation_errors;
    }

    abstract public function execute();
}

?>
