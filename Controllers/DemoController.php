<?php

namespace Controllers;

use Controllers\Controller;

class DemoController extends Controller{

    public function index(){

        /**
         * 如果return array會自動轉為json
         */

        return view('welcome');
    }
}