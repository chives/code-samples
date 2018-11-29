<?php

class password_reminder_usermodel {
    private $params;
    private $router;
    private $db;
	
    public function __construct() {
    $this->router = registry::register("router");
            $this->params = $this->router->getParams();
            $this->db = registry::register("db");
    }
	
    public function testStrLetters($nameInput, $str){
        if (!preg_match("/^[a-zA-ZąćęłńóśźżĄĆĘŁŃÓŚĆŹŻ]*$/",$str))
            throw new Exception('Pole '.$nameInput.' nie jest poprawne');
        return true;
    }
    
    public function testStrEmail($nameInput, $str){
       if (!filter_var($str, FILTER_VALIDATE_EMAIL)) 
            throw new Exception('Pole '.$nameInput.' nie jest poprawne');
        return true;
    }
    
    
    public function testStrLen($nameInput, $str, $min, $max){
        $len = strlen($str);
        if($len < $min || $len > $max) 
            throw new Exception('Pole '.$nameInput.' nie ma odpowiedniej długości');
        return true;
    }
    
    public function testStrUrl($nameInput, $str){
        if (!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$str))
            throw new Exception('Pole '.$nameInput.' nie jest poprawne');
        return true;
    }
    
    public function testStrPhone($nameInput, $str){
        if(preg_match("/^[0-9]{4} [0-9]{4} [0-9]{4}$/", $str)) 
            throw new Exception('Pole '.$nameInput.' nie jest poprawne');
        return true;
    }
    
    
    
    public function secure_input($data) {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
    }

	
    public function saveNewUser() {
        if(isset($this->params['POST']['name_user'])) {
            $email = $this->secure_input($this->params['POST']['email']);
            $name = $this->secure_input($this->params['POST']['name_user']);
            $surname = $this->secure_input($this->params['POST']['surname']);
            $pass = $this->secure_input(($this->params['POST']['pass1'] == $this->params['POST']['pass2']) ? md5($this->params['POST']['pass2']) : false);
            
            if(!$pass) header("Location: ".SERVER_ADDRESS."user/registration_user");

            $res = $this->db->execute("INSERT Users SET name = '{$name}', id_status = '3', avatar = 'avatar.png', 
                surname = '{$surname}', password = '{$pass}', mail = '{$email}'");

            if($res) 
               header("Location: ".SERVER_ADDRESS."user/index");
        }

        header("Location: ".SERVER_ADDRESS."user/registration_user");
    }
}

?>