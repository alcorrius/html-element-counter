<?php
/**
 * Created by PhpStorm.
 * User: alcorrius
 * Date: 08.07.17
 * Time: 17:22
 */

namespace controllers;


abstract class BaseController
{
    protected $title = null;

    protected $content = array();

    protected function setTitle($title = null)
    {
        $this->title = $title;
    }

    protected function getTitle()
    {
        return $this->title;
    }

    protected function setContent($content = null)
    {
        $this->content = $content;
    }

    protected function getContent()
    {
        return $this->content;
    }

    protected function render($name)
    {
        $content = $this->getContent();
        include(__DIR__ . "/../views/{$name}.php");
        $view = $template;
        $this->layoutRender($view);
    }

    protected function layoutRender($view)
    {
        $title = $this->getTitle();
        include(__DIR__ . '/../layouts/main.php');
    }
}