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
  --color-primary: #661C32;
  --color-secondary: #AC905B;
  --color-tertiary: #A4A5A8;
}
body {
  background-color: #f5f5f5;
}
.card-container {
  max-width: 350px;
  padding: 40px;
  background-color: #fff;
  border-radius: 10px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}
.profile-img-card {
  width: 96px;
  height: 96px;
  margin: 0 auto 10px;
  display: block;
  border-radius: 50%;
}
.btn-login {
  background-color: var(--color-secondary);
  color: white;
  border: none;
  transition: all 0.3s ease;
}
.btn-login:hover {
  background-color: #8c7342;
  color: white;
}
.brand-title {
  color: var(--color-primary);
  font-weight: 600;
  margin-bottom: 5px;
}
.brand-subtitle {
  color: var(--color-tertiary);
  font-size: 0.8rem;
  margin-bottom: 15px;
}
</style>
</head>
<body>
 <div class="container d-flex justify-content-center align-items-center min-vh-100">
	<div class="card-container">
        <div class="text-center mb-4">
          <h4 class="brand-title">Secretaría de Gobierno Municipal</h4>
          <p class="brand-subtitle">Programa de Identificación, Empadronamiento, Regulación y Revalidación de Establecimientos Que Expiden y Venden al Público en Envase Cerrado y Abierto, Bebidas con Contenido Alcohólico</p>
        </div>
        <img id="profile-img" class="profile-img-card" src="img/avatar_2x.png" />
        <form method="post" accept-charset="utf-8" action="login.php" name="loginform" autocomplete="off" role="form" class="mt-3">
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
            <div class="form-floating mb-3">
                <input class="form-control" id="floatingInput" placeholder="Usuario" name="user_name" type="text" value="" required>
                <label for="floatingInput">Usuario</label>
            </div>
            <div class="form-floating mb-3">
                <input class="form-control" id="floatingPassword" placeholder="Contraseña" name="user_password" type="password" value="" autocomplete="off" required>
                <label for="floatingPassword">Contraseña</label>
            </div>
            <div class="d-grid">
                <button type="submit" class="btn btn-lg btn-login" name="login" id="submit">
                    <i class="bi bi-box-arrow-in-right me-2"></i>Iniciar Sesión
                </button>
            </div>
        </form>
    </div>
</div>
</body>
</html>

	<?php
}
