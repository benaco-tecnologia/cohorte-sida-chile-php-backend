<?php
	set_time_limit(1000);
	ini_set('memory_limit','128M');
	$username="root";
	$password="r1r7C1h6ZG4ZVWF";
	$database="cohorte";
	//mysql_connect("cohorte.cvssq77sdkiq.sa-east-1.rds.amazonaws.com",$username,$password);
		mysql_connect("cohorte.cbupq68leyb4.us-east-1.rds.amazonaws.com",$username,$password) or die(mysql_error());
		mysql_select_db($database) or die(mysql_error());
?>
<?php
	if(isset($_POST)&&isset($_POST["crearUsuario"])){
		//print_r($_POST);
		$contrasena=rand(10000,99999);
		echo "Contraseña es $contrasena<br />";
		$contrasena=md5($contrasena);
		$query="INSERT INTO Usuario (NivelUsuarioID,NombreUsuario,Contrasena,Nombre,Apellido,Estado) VALUES ({$_POST["nivelusuarioid"]},'{$_POST["nombreusuario"]}','$contrasena','{$_POST["nombre"]}','{$_POST["apellido"]}','A');";
		//echo $query;
		
		mysql_query($query);
		$id=mysql_insert_id();
		$query="INSERT INTO Permiso (CentroID,UsuarioID) VALUES ({$_POST["centroid"]},$id);";
		mysql_query($query);
		//echo $query;
	}
?>
<!DOCTYPE html>
<html>
<body>
<div class="line"></div>
<div class="wrapper">
	<div class="widget">
	<form action="ing_usuario.php" method="POST">
		<fieldset>
		<table cellpadding="0" cellspacing="0" width="100%" class="sTable">
			<tr>
				<td>Nombre:</td>
				<td><input type="text" name="nombre" /></td>
			</tr>
			<tr>
				<td>Apellido:</td>
				<td><input type="text" name="apellido" /></td>
			</tr>
				<tr>
				<td>Usuario:</td>
				<td><input type="text" name="nombreusuario" /></td>
			</tr>
			
			<tr>
				<td>Centro:</td>
				<td>
					<select name="centroid">
				<?php
					$query = "SELECT ID, Nombre FROM Centro ORDER BY Nombre;";
					$result = mysql_query($query);
					if(mysql_num_rows($result)>0){
						while($row = mysql_fetch_array($result)){
							echo "<option value=\"{$row["ID"]}\">{$row["Nombre"]}</option>";
						}
					}
				?>
					</select>
				</td>
			</tr>
			<tr>
				<td>Nivel:</td>
				<td>
					<select name="nivelusuarioid">
						<option value="3">Usuario</option>
						<option value="2">Supervisor</option>
						<option value="1">Administrador</option>
					</select>
					</td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td colspan="2" align="right">
					<input type="submit" value="Aceptar" name="crearUsuario" />
				</td>
		  </tr>
         
		</table>
		</fieldset>
	</form>
	</div>
</div>