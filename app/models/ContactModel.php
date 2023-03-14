<?php
    class ContactModel {
        private $name;
        private $email;
        private $age;
        private $message;


        public function setData($name, $email, $age, $message)
        {
            $this->name = $name;
            $this->email = $email;
            $this->age = $age;
            $this->message = $message;
        }

        public function validForm() {
            if(strlen($this->name) < 3){
                return 'Имя слишком короткое';
            }
            elseif (strlen($this->email) < 3){
                return 'Email слишком короткий';
            }
            elseif (!is_numeric($this->age) or $this->age <= 0 or $this > 90){
                return 'Введите возраст числом';
            }
            elseif (strlen($this->message) < 10){
                return 'Сообщение слишком короткое';
            }
            else{
                return "Верно";
            }
        }

        public function mail() {
            $to = 'lyubimov1998@gmail.com';
            $message = "Имя: " . $this->name . ". Возраст: " . $this->age . ". Сообщение: " . $this->message;

            $subject = "=?utf-8?B?".base64_decode("Сообщение с нашего сайта")."?=";
            $headers = "From:  $this->email\r\nReply-to: $this->email\r\nContent-type: text/html; charset=utf-8\r\n";
            $success = mail($to, $subject, $message, $headers);

            if (!$success){
                return "Сообщение не было отправлено";
            }
            else{
                return true;
            }
        }
    }