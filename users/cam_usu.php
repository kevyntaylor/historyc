<?php
require("../config/conexion.php");
require("../thyme/header_inicio.php");

?>
<br>
<div class="titulo">Cambiar Contrase&ntilde;a</div><br /><br />
<?php
if (strtolower($_REQUEST["acc"])=="guardar"){
	if($_REQUEST["nombre"]!="" or $_REQUEST["pass1"]!=""or $_REQUEST["pass2"]!="" or $_REQUEST["tipo"]!=""){
		if ($_REQUEST["pass1"]!=$_REQUEST["pass2"]){
		cuadro_error("Las contraseņas introducidas no coinciden");
		}else{
			$set_pass = md5($_REQUEST["pass1"]);
			if (mysql_query("update usuarios set tipo='".$_REQUEST["tipo"]."',nombre='".strtoupper(htmlentities($_REQUEST["nombre"]))."',password='".htmlentities($set_pass)."' where id_usu='".$_REQUEST["iduser"]."' ",$con)){
		echo"<br /><br />";
		cuadro_mensaje("Usuario modificado correctamente. <b><a href=../index.php target=\"_self\"> Volver a Inicio</a></b>");
		require("../thyme/footer_inicio.php");
		exit;
		}else{
			cuadro_error(mysql_error());
		}
		}
}else
{
	cuadro_error("Debe llenar todos los campos.");
}

}
$con = mysql_connect($bd_host, $bd_usuario,$bd_pass);
mysql_select_db($bd_base, $con);
$result=mysql_query("select * from usuarios where login='".$_SESSION["login"]."'",$con);
$iduser=mysql_result($result,0,"id_usu");
$nombre=mysql_result($result,0,"nombre");
$tipo=mysql_result($result,0,"tipo");
$login=mysql_result($result,0,"login");
$password=mysql_result($result,0,"password");
?>



<form name="usuarios" action="cam_usu.php" method="post">
<input type="hidden" name="iduser" value="<?php echo $iduser;?>">
<table class="tabla" align="center" width="500">
<tr>
	<td colspan="2" class="tdatos" align="center"><h3>DATOS DEL MEDICO</h3></td>
</tr>
<tr>
	<td class="tdatos">Nombre</td>
	<td><input type="text" name="nombre" value="<?php echo $nombre; ?>" size="45"></td>
</tr>
<tr>
	<td class="tdatos">Login</td>
	<td><input type="text" name="login" value="<?php echo $login; ?>" readonly size="45"></td>
</tr>
<tr>
	<td class="tdatos">Password Actual</td>
	<td><input type="password" name="pass0" value="<?php echo $_REQUEST['pass0']; ?>" onchange="this.form.submit()" size="45"></td>
</tr>
<?php
$pass = md5($_REQUEST['pass0']);
if ($pass!=""){
if ($pass!=$password){
		echo '
     <tr>
	<td class="cuadro_error" colspan="2" align="center">Contrase&ntilde;a incorrecta, verifique!</td>
      </tr>
		     ';
}
}
?>
<tr>
	<td class="tdatos">Nueva Password</td>
	<td><input type="password" name="pass1" value="<?php echo $_REQUEST['pass1']; ?>" size="45"></td>
</tr>
<tr>
	<td class="tdatos">Repetir Password</td>
	<td><input type="password" name="pass2" value="<?php echo $_REQUEST['pass2']; ?>" size="45"></td>
</tr>
<tr>
	<td class="tdatos">Tipo</td>
	<td>
		<select name="tipo">
			<option value="ADMINISTRADOR" <?php if ($tipo=="ADMINISTRADOR") echo "selected" ?>>ADMINISTRADOR</option>
			<option value="AS" <?php if ($tipo=="ASISTENTE") echo "selected" ?>>ASISTENTE</option>			
		</select>
	</td>
</tr>
<tr>
	<td colspan="2" align="center"><input type="submit" name="acc" value="Guardar" size="20"></td>
</tr>
</table>
</form>

<br /><br />
<?php
require("../thyme/footer_inicio.php");
?>
