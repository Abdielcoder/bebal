<?php

include_once('../config/db.php');
$_SESSION["conf"] = $conf;


$conexion = mysqli_connect($conf["host"], $conf["usuario"], $conf["contrasena"],$conf["basededatos"]);
if (mysqli_connect_errno()) {
echo "Failed to connect to MySQL: " . mysqli_connect_error();
exit();
}



if(!empty($_POST["UNIDAD"])) {

$id_delegacion=$_POST["UNIDAD"];

echo '<option value="" selected>Seleccione Colonia</option>';

$sql_colonias="SELECT * FROM colonias WHERE id_delegacion=".$id_delegacion;

$result_colonias = mysqli_query($conexion,$sql_colonias);
$rows = mysqli_num_rows($result_colonias);
for ($i2 = 0; $i2 < $rows; $i2++) {
$ROW= mysqli_fetch_array($result_colonias,MYSQLI_NUM);
$ID_COLONIA = $ROW[0];
$COLONIA = $ROW[3];

echo '<option value="'.$ID_COLONIA.'">'.$COLONIA.'</option>';
}
echo '<option value="99999">No Existe Colonia en Catalogo</option>';

} else {
echo '<option value="0">No Informacion Catalogo</option>';
}
mysqli_close($conexion);
?>
