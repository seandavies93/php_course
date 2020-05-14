<?php

  class Account {

    private $con;
    private $errorArray;
    public function __construct($con) {
      $this->con = $con;
      $this->errorArray = array();
    }

    public function login($un, $pw) {
      $pw = md5($pw);
      $query = mysqli_query($this->con, "SELECT * FROM users WHERE username='$un' AND password='$pw'");
      if(mysqli_num_rows($query) == 1) {
        return true;
      }
      array_push($this->errorArray, Constants::$loginFailed);
      return false;
    }

    public function register($un, $fn, $ln, $em, $em1, $pw, $pw1) {
      $this->validateUsername($un);
      $this->validateFirstName($fn);
      $this->validateLastName($ln);
      $this->validateEmails($em, $em1);
      $this->validatePasswords($pw, $pw1);
      if(empty($this->errorArray)) {
        //insert into database
        return $this->insertUserDetails($un, $fn, $ln, $em, $pw);
      } else {
        return false;
      }
    }

    public function getError($error) {
      if(!in_array($error, $this->errorArray)) {
        $error = "";
      }
      return "<span class='errorMessage'>$error</span>";
    }

    private function insertUserDetails($un, $fn, $ln, $em, $pw) {
      $encryptedPw = md5($pw);
      $profilePic = "assets/images/profile-pics/default.png";
      $date = date("Y-m-d");

      $result = mysqli_query($this->con, "INSERT INTO users VALUES ('', '$un', '$fn', '$ln', '$em', '$encryptedPw', '$date', '$profilePic')");
      return $result;
    }

    private function validateUsername($un) {
      if(strlen($un) > 25 || strlen($un) < 5) {
        array_push($this->errorArray, "Your username must be between 5 and 25 characters long");
        return;
      }
      $checkUsernameQuery = mysqli_query($this->con, "SELECT username FROM users WHERE username='$un'");
      if(mysqli_num_rows($checkUsernameQuery) != 0) {
        array_push($this->errorArray, Constants::$usernameTaken);
        return;
      }
    }

    private function validateFirstName($fn) {
      if(strlen($fn) > 25 || strlen($fn) < 2) {
        array_push($this->errorArray, Constants::$firstNameLength);
        return;
      }
    }

    private function validateLastName($ln) {
      if(strlen($ln) > 25 || strlen($ln) < 2) {
        array_push($this->errorArray, Constants::$lastNameLength);
        return;
      }
    }

    private function validateEmails($em, $em1) {
      if($em != $em1) {
        array_push($this->errorArray, Constants::$emailsDoNotMatch);
        return;
      }
      if(!filter_var($em, FILTER_VALIDATE_EMAIL)) {
        array_push($this->errorArray, Constants::$invalidEmails);
        return;
      }
      $checkEmailQuery = mysqli_query($this->con, "SELECT email FROM users WHERE email='$em'");
      if(mysqli_num_rows($checkEmailQuery) != 0) {
        array_push($this->errorArray, Constants:: $emailTaken);
        return;
      }
    }

    private function validatePasswords($pw, $pw1) {
      if($pw != $pw1) {
        array_push($this->errorArray, Constants::$passwordsDoNotMatch);
        return;
      }
      if(preg_match('/[^A-Za-z0-9]/', $pw)) {
        array_push($this->errorArray, Constants::$invalidPassword);
        return;
      }
      if(strlen($pw) > 30 || strlen($pw) < 8) {
        array_push($this->errorArray, Constants::$passwordsWrongLength);
        return;
      }
    }
  }

?>
