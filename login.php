<?php
// checking for minimum PHP version
if (version_compare(PHP_VERSION, '5.3.7', '<')) {
    exit("Sorry, Simple PHP Login does not run on a PHP version smaller than 5.3.7 !");
} else if (version_compare(PHP_VERSION, '5.5.0', '<')) {
    // if you are using PHP 5.3 or PHP 5.4 you have to include the password_api_compatibility_library.php
    // (this library adds the PHP 5.5 password hashing functions to older versions of PHP)
    require_once("libraries/password_compatibility_library.php");
}

// include the configs / constants for the database connection
require_once("config/db.php");

// load the login class
require_once("classes/Login.php");

// create a login object. when this object is created, it will do all login/logout stuff automatically
// so this single line handles the entire login process. in consequence, you can simply ...
$login = new Login();

// ... ask if we are logged in here:
if ($login->isUserLoggedIn() == true) {
    // the user is logged in. you can do whatever you want here.
	// for demonstration purposes, we simply show the "you are logged in" view.
   header("location: principal.php");

} else {
    // the user is not logged in. you can do whatever you want here.
    // for demonstration purposes, we simply show the "you are not logged in" view.
    ?>
	<!DOCTYPE html>
<html lang="es">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no"/>
  <title>Bebal | Login</title>
	<!-- Bootstrap 5 CSS and JS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- CSS  -->
<link href="css/login.css" type="text/css" rel="stylesheet" media="screen,projection"/>
<link rel=icon href='img/logo-icon.png' sizes="32x32" type="image/png">
<style>
:root {
  --color-primary: #742c32;
  --color-primary-dark: #5e2328;
  --color-primary-light: #8a363c;
  --color-secondary: #fde5b7;
  --color-secondary-dark: #8c7342;
  --color-secondary-light: #c4ab7a;
  --color-tertiary: #A4A5A8;
  --color-tertiary-dark: #87888c;
  --color-tertiary-light: #c2c3c5;
  --color-white: #f7f7f7;
  --color-text-dark: #333333;
}

/* Estilo basado en la imagen de referencia */
body {
  background: linear-gradient(135deg, var(--color-primary-light) 0%, var(--color-primary) 35%, var(--color-primary-dark) 100%);
  height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
  font-family: Arial, sans-serif;
}

.login-container {
  background-color: rgba(255, 255, 255, 0.15);
  border-radius: 10px;
  max-width: 350px;
  width: 100%;
  padding: 30px;
  box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
  backdrop-filter: blur(10px);
  color: var(--color-white);
}

.avatar-container {
  width: 120px;
  height: 120px;
  background-color: var(--color-primary-dark);
  border-radius: 50%;
  margin: 0 auto 30px;
  display: flex;
  align-items: center;
  justify-content: center;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
  border: 3px solid rgba(255, 255, 255, 0.2);
}

.avatar-icon {
  color: white;
  font-size: 60px;
}

.form-group {
  position: relative;
  margin-bottom: 25px;
}

.form-control {
  background-color: transparent !important;
  border: none;
  border-bottom: 1px solid white;
  border-radius: 0;
  padding-left: 35px;
  color: white;
  height: 45px;
}

.form-control::placeholder {
  color: rgba(255, 255, 255, 0.7);
}

.form-control:focus {
  box-shadow: none;
  border-color: var(--color-secondary);
}

.form-icon {
  position: absolute;
  top: 12px;
  left: 5px;
  color: white;
  font-size: 18px;
}

.login-btn {
  background-color: var(--color-secondary);
  color: var(--color-primary);
  text-transform: uppercase;
  letter-spacing: 1px;
  font-size: 14px;
  border: none;
  padding: 12px;
  border-radius: 5px;
  width: 100%;
  font-weight: 600;
  margin-top: 10px;
  transition: all 0.3s;
}

.login-btn:hover {
  background-color: var(--color-secondary-dark);
  color: var(--color-white);
  transform: translateY(-2px);
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
}

.remember-group {
  display: flex;
  justify-content: space-between;
  margin-bottom: 20px;
  font-size: 14px;
}

.remember-check {
  display: flex;
  align-items: center;
}

.remember-check input {
  margin-right: 5px;
}

.forgot-link {
  color: white;
  text-decoration: none;
}

.forgot-link:hover {
  color: var(--color-secondary);
}

</style>
</head>
<body>
  <div class="login-container">
    <div class="avatar-container">
      <i class="bi bi-person avatar-icon"></i>
    </div>
    
    <?php
    // show potential errors / feedback (from login object)
    if (isset($login)) {
        if ($login->errors) {
            ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error!</strong>
            <?php
            foreach ($login->errors as $error) {
                echo $error;
            }
            ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php
        }
        if ($login->messages) {
            ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Aviso!</strong>
            <?php
            foreach ($login->messages as $message) {
                echo $message;
            }
            ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php
        }
    }
    ?>
    
    <form method="post" accept-charset="utf-8" action="login.php" name="loginform" autocomplete="off" role="form">
      <div class="form-group">
        <i class="bi bi-envelope form-icon"></i>
        <input type="text" class="form-control" name="user_name" placeholder="Usuario" required>
      </div>
      
      <div class="form-group">
        <i class="bi bi-lock form-icon"></i>
        <input type="password" class="form-control" name="user_password" placeholder="Contraseña" autocomplete="off" required>
      </div>
      
      <div class="remember-group">
        <div class="remember-check">
          <input type="checkbox" id="remember">
          <label for="remember">Recordarme</label>
        </div>
        <a href="#" class="forgot-link">¿Olvidó su contraseña?</a>
      </div>
      
      <button type="submit" class="login-btn" name="login">INICIAR SESIÓN</button>
    </form>
  </div>
</body>
</html>

	<?php
}
