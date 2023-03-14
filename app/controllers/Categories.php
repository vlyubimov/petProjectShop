<?php
    class Categories extends Controller {

        public function index() {
            $products = $this->model('ProductsModel');
            $data = ['products' => $products->getProducts(), 'title' => 'Все товары на сайте', 'page' => 1,'category' => 'all'];
            $this->view('categories/index', $data);

        }

        public function all($page = '') {
            if ($page != '') {
                $page = (int) mb_substr($page, 4);
            }
            $products = $this->model('ProductsModel');
            $data = ['products' => $products->getProducts(), 'title' => 'Все товары на сайте', 'page' => $page=='' ? 1 : $page,'category' => 'all'];
            $this->view('categories/index', $data);

        }

        public function shoes($page = '') {
            $this->callSection('shoes', $page, 'Категория обувь');

        }

        public function hats($page = '') {
            $this->callSection('hats', $page, 'Категория головные уборы');
        }

        public function shirts($page = '') {
            $this->callSection('shirts', $page, 'Категория футболки');
        }

        public function watches($page = '') {
            $this->callSection('watches', $page, 'Категория часы');
        }


        public function callSection($category, $page, $title) {
            $products = $this->model('ProductsModel');
            $data = ['products' => $products->getProductsCategory($category),
                'title' => $title,
                'page' => $page=='' ? 1 : (int) mb_substr($page, 4),
                'category' => $category];
            $this->view('categories/index', $data);

        }
    }