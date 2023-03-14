<?php
    class Product extends Controller {
        public function  index($id) {
            $product = $this->model('ProductsModel');
            $this->view('product/index', $product->getOneProduct($id));
        }
    }