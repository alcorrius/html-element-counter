<?php

/**
 * Created by PhpStorm.
 * User: alcorrius
 * Date: 19.08.17
 * Time: 16:25
 */

namespace controllers;

class IndexController extends BaseController
{
    public function index() {
        $this->setTitle('HTML Element Counter');
        $this->setContent(array(

        ));
        $this->render('index');
    }
}