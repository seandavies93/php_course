<?php
  include("includes/config.php");
  include("includes/classes/Account.php");
  include("includes/classes/Constants.php");
  $account = new Account($con);

  include("includes/handlers/register-handler.php");
  include("includes/handlers/login-handler.php");

  function getInputValue($name) {
    if(isset($_POST[$name])) {
      echo $_POST[$name];
    }
  }

 ?>

<html>
<head>
  <title>Slotify</title>
  <link rel="stylesheet" type="text/css" href="assets/css/register.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="assets/js/register.js"></script>
</head>
<body>
  <?php
  if(isset($_POST['registerButton'])) {
    echo '<script>
      $(document).ready(function(){
        $("#loginForm").hide();
        $("#registerForm").show();
      });
    </script>';
  } else {
    echo '<script>
      $(document).ready(function(){
        $("#loginForm").show();
        $("#registerForm").hide();
      });
    </script>';
  }

  ?>

  <div id="background">
  <div id="loginContainer">
    <div id="inputContainer">
      <form id="loginForm" action="register.php" method="POST">
        <h2>Login to your account</h2>
        <p>
          <?php echo $account->getError(Constants::$loginFailed); ?>
          <label for="loginUsername">Username</label>
          <input id="loginUsername" name="loginUsername" type="text" placeholder="BartSimpson" value="<?php getInputValue('loginUsername'); ?>" required>
        </p>
        <p>
          <label for="loginPassword">Password</label>
          <input id="loginPassword" name="loginPassword" type="password" required>
        </p>
        <button type="submit" name="loginButton">Log in</button>
        <div class="hasAccountText">
          <span id="hideLogin">Don't have an account yet? Sign up here</span>
        </div>
      </form>

      <form id="registerForm" action="register.php" method="POST">
        <h2>Create your free account</h2>
        <p>
          <?php echo $account->getError(Constants::$usernameLength); ?>
          <?php echo $account->getError(Constants::$usernameTaken); ?>
          <label for="username">Username</label>
          <input id="username" name="username" type="text" placeholder="BartSimpson" value="<?php getInputValue('username'); ?>" required>
        </p>
        <p>
          <?php echo $account->getError(Constants::$firstNameLength); ?>
          <label for="firstName">First name</label>
          <input id="firstName" name="firstName" type="text" placeholder="Bart"  value="<?php getInputValue('firstName'); ?>" required>
        </p>
        <p>
          <?php echo $account->getError(Constants::$lastNameLength); ?>
          <label for="lastName">Last name</label>
          <input id="lastName" name="lastName" type="text" placeholder="Simpson"  value="<?php getInputValue('lastName'); ?>" required>
        </p>
        <p>
          <?php echo $account->getError(Constants::$invalidEmails); ?>
          <?php echo $account->getError(Constants::$emailTaken); ?>
          <label for="email">Email</label>
          <input id="email" name="email" type="email" placeholder="BartSimpson@gmail.com"  value="<?php getInputValue('email'); ?>" required>
        </p>
        <p>
          <?php echo $account->getError(Constants::$emailsDoNotMatch); ?>
          <label for="email1">Email confirmation</label>
          <input id="email1" name="email1" type="email" placeholder="BartSimpson@gmail.com" value="<?php getInputValue('email1'); ?>" required>
        </p>
        <p>
          <?php echo $account->getError(Constants::$invalidPassword); ?>
          <?php echo $account->getError(Constants::$passwordWrongLength); ?>
          <label for="password">Password</label>
          <input id="password" name="password" type="password" value="<?php getInputValue('password'); ?>" required>
        </p>
        <p>
          <?php echo $account->getError(Constants::$passwordsDoNotMatch); ?>
          <label for="password1">Password confirmation</label>
          <input id="password1" name="password1" type="password" value="<?php getInputValue('password1'); ?>" required>
        </p>
        <button type="submit" name="registerButton">Register</button>
        <div class="hasAccountText">
          <span id="hideRegister">Already have an account? Login here</span>
        </div>
      </form>
    </div>
    <div id="loginText">
    <h1>Great music, right now</h1>
    <h2>Listen to loads of songs for free</h2>
    <ul>
      <li>Discover music you'll fall in love with</li>
      <li>Create your own playlists</li>
      <li>Follow artists to keep up to date</li>
    </ul>
    </div>
  </div>
</div>
</body>
</html>
