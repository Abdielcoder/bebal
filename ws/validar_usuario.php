<?php

//###
require 'jwt.php';
//###

$configuracion="conf.php";
include_once($configuracion);
$_SESSION["conf"] = $conf;

 header('Access-Control-Allow-Origin: *');
 header('Content-Type: application/json');
 header('Content-Type: text/html; charset=utf-8');


$usu_usuario=$_POST['usuario'];
$usu_password=$_POST['password'];

##$usu_usuario="tjop1";
##$usu_password="op1";

#################################
#################################
mysqli_report(MYSQLI_REPORT_OFF);
$conn = @mysqli_connect($conf["host"], $conf["usuario"], $conf["contrasena"],$conf["basededatos"]);
if ( !$conn ) {
##echo "Failed to connect to MySQL: " . mysqli_connect_error();
$resultado = "Conection Error - Data Base";
##$alldata[] = (object) array('validarUser'=>$resultado);
##$obj1[] = (object) array('DATA-USER'=>$alldata);
echo json_encode(['success' => false, 'data' => NULL, 'message' => 'Failed to connect to MySQL', 'error' => 'Failed to connect to MySQL' ]);
error_log('Connection error: ' . $mysqli_connect_error());
##exit();
} else {


##$Kuery= "SELECT profile,user_id,id_municipio FROM users WHERE user_name='".$usu_usuario."' AND user_password_hash='".$usu_password."'";
$Kuery= "SELECT profile,user_id,id_municipio FROM users WHERE user_name='".$usu_usuario."' AND passwd2='".$usu_password."'";
##echo $Kuery;
$sql = mysqli_query($conn,$Kuery) or die(mysql_error());
$count=mysqli_num_rows($sql);

##echo "<br>COUNT = ".$count."<br>";

if($count==1) {

##echo "success";

$ArregloKuery=mysqli_fetch_array($sql);
$PROFILE=$ArregloKuery[0];
$UsersID=$ArregloKuery[1];
$municipioID=$ArregloKuery[2];

###############
$arregloMUNICIPIO = mysqli_fetch_array(mysqli_query($conn,"SELECT * FROM `municipio` WHERE id=".$municipioID));
$MUNICIPIO = $arregloMUNICIPIO[1];
###############
$userData = [
    'id' => $UserID,
    'username' => $usu_usuario
];
// Agregar los tiempos de emisión y expiración al payload del JWT
$issuedAt = time();
$expirationTime = $issuedAt + 3600;  // jwt válido por 1 hora
$payload = [
    'iat' => $issuedAt,
    'exp' => $expirationTime,
    'userData' => $userData
];

// Generar el JWT
$jwt = encode_jwt($payload);

//###
//#########################################


 $resultado[] = array("id_user"=>$UsersID,"username"=>$usu_usuario,"profile"=>$PROFILE, "municipio"=> $MUNICIPIO, "municipioID"=> $municipioID, "token" => $jwt );

} else {
$resultado = "USER ERROR";
}

mysqli_close($conn);

#################
 ##$alldata[] = (object) array('validarUser'=>$resultado);
 ##$obj1[] = (object) array('DATA-USER'=>$alldata);
 ##echo json_encode($obj1,JSON_PRETTY_PRINT);
 echo json_encode(['success' => true, 'data' => $resultado,'message' => 'OK', 'errors' => null  ]);
}
?>
