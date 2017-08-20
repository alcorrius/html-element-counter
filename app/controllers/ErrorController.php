<?php
/**
 * Created by PhpStorm.
 * User: alcorrius
 * Date: 19.08.17
 * Time: 17:08
 */

namespace controllers;


class ErrorController extends BaseController
{
    public function index() {
        echo "Page not found";
    }
}