<?php
    class Error404 extends Controller {
        public function index() {

            $this->view('error/404');
//            require_once 'app/views/error/404.php';
        }
    }