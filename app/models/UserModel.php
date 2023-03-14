<?php
    require 'DB.php';
    class UserModel {
        private $name;
        private $email;
        private $pass;
        private $re_pass;
        private $about;
        private $address;
        private $tel;


        private $_db = null;

        public function __construct(){
            $this->_db = DB::getInstence();
        }


        public function setData($name, $email, $pass, $re_pass)
        {
            $this->name = $name;
            $this->email = $email;
            $this->pass = $pass;
            $this->re_pass = $re_pass;
        }

        public function validForm() {
            if(strlen($this->name) < 3){
                return 'Имя слишком короткое';
            }
            elseif (strlen($this->email) < 3){
                return 'Email слишком короткий';
            }
            elseif (strlen($this->pass) < 8){
                return 'Пароль не меньше 8 символов';
            }
            elseif ($this->re_pass != $this->pass){
                return 'Пароли не совпадают';
            }
            else{
                return "Верно";
            }
        }

        public function addUser() {
            $sql = 'INSERT INTO users(name, email, pass, user_photo) VALUES (:name, :email, :pass, :user_photo)';
            $query = $this->_db->prepare($sql);
//            md5();
//            sha1();

            $pass = password_hash($this->pass, PASSWORD_DEFAULT);


            $query->execute(['name' => $this->name,'email' => $this->email,'pass' => $pass, 'user_photo' => 'default_user_photo.svg']);

            $this->setAuth($this->email);
        }

        public function getUser() {
            $email = $_COOKIE['login'];
            $result = $this->_db->query("SELECT * FROM `users` WHERE `email` = '$email'");
            return $result->fetch(PDO::FETCH_ASSOC);
        }

        public function logOut() {
            setcookie('login', $this->email, time() - 3600, '/');
            unset($_COOKIE['login']);
            header('Location: /user/auth');
        }


        public function auth($email, $pass) {
            $result = $this->_db->query("SELECT * FROM `users` WHERE `email` = '$email'");
            $user = $result->fetch(PDO::FETCH_ASSOC);

            if ($user['email'] == ''){
                return 'Пользователь с таким email не существует';
            }
            elseif (password_verify($pass, $user['pass'])) {
                $this->setAuth($email);
            }
            else {
                return 'Неверный пароль';
            }
        }

        public function setAuth($email) {
            setcookie('login', $email, time() + 3600, '/');
            header('Location: /user/dashboard');
        }


        public function setPhoto($photo) {
            $user = $this->getUser();
            $user_id = $user['id'];
            $this->_db->query("UPDATE users SET `user_photo` = '$photo' WHERE id = $user_id");
        }

        public function setInfo($about, $address, $tel)
        {
            $this->about = $about;
            $this->address = $address;
            $this->tel = $tel;
        }

        public function addInfo() {
            $user = $this->getUser();
            $user_id = $user['id'];
            $sql = "UPDATE users SET `about` = :about, `address` = :address,`tel` = :tel WHERE id = $user_id";
            $query = $this->_db->prepare($sql);


            $query->execute(['about' => $this->about,'address' => $this->address,'tel' => $this->tel]);

        }



    }