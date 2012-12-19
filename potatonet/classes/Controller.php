<?php

abstract class Controller
{

    protected $model, $view, $page;

    public function returnModel()
    {
        return $this->model;
    }

    public function returnView()
    {
        return $this->view;
    }

    public function returnPage()
    {
        return $this->page;
    }

    abstract public function execute();
}

?>
