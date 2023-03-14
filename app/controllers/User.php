<?php
    class User extends Controller {
        public function reg() {

            $data = [];

            if (isset($_POST['name'])){
                $user = $this->model('UserModel');
                $user->setData($_POST['name'], $_POST['email'], $_POST['pass'], $_POST['re_pass']);
                $isValid = $user->validForm();
                if ($isValid == "Верно"){
                    $user->addUser();
                }
                else {
                    $data['message'] = $isValid;
                }
            }

            $this->view('user/reg', $data);
        }

        public function dashBoard() {
            $user = $this->model('UserModel');
            if (isset($_POST['exit_btn'])) {
                $user->logOut();
                exit();
            }


            $this->view('user/dashboard', $user->getUser());
        }

        public function auth() {
            $data = [];
            if (isset($_POST['email'])) {
                $user = $this->model('UserModel');
                $data['message'] = $user->auth($_POST['email'], $_POST['pass']);
            }

            $this->view('user/auth', $data);

        }

        public function downLoadPhoto() {
            if (isset($_FILES) && $_FILES['user_photo']['error'] == 0) {
                $user = $this->model('UserModel');
                $oldPhoto = $user->getUser()['user_photo'];
                $new_file = time().$_FILES['user_photo']['name'];
                $user->setPhoto($new_file);
                move_uploaded_file($_FILES['user_photo']['tmp_name'], 'public/img/'.$new_file );

                if ($oldPhoto != 'default_user_photo.svg'){
                    unlink('public/img/'.$oldPhoto);
                }


                $data['message'] = 'Успешно';

            }
            else {
                $data['message'] = 'Вы не указали фото для загрузки';
            }
            header('Location: /user/dashboard');
        }

        public function updateInfo() {
            if (isset($_POST['about']) or isset($_POST['address']) or isset($_POST['tel']) ){
                $user = $this->model('UserModel');
                $user->setInfo($_POST['about'], $_POST['address'], $_POST['tel']);
                $user->addInfo();
            }
            else {
                $data['message'] = 'Вы не указали никакой информации';
            }
            header('Location: /user/dashboard');
        }
    }