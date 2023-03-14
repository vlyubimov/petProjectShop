<?php
    class Basket extends Controller {
        public function index() {
            $data = [];
            $cart = $this->model('BasketModel');
            if (isset($_POST['item_id'])){
                $cart->addToCart($_POST['item_id']);
            }

            if (!$cart->isSetSession()){
                $data['empty'] = 'Пустая корзина';
            }
            else {
                $products = $this->model('ProductsModel');
                $data['products'] = $products->getProductsCart($cart->getSession());
            }

            $this->view('basket/index', $data);
        }

        public function removeAllProducts() {
            $cart = $this->model('BasketModel');
            if ($cart->isSetSession()){
                $cart->deleteSession();
                $data['empty'] = 'Пустая корзина';
            }
            $this->view('basket/index', $data);
        }

        public function removeOneProducts($id) {

            $data = [];
            $cart = $this->model('BasketModel');
            $cart->removeFromCart($id);
            $this->view('basket/index', $data);
        }
    }