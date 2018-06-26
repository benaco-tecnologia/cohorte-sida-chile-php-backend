<?php
	set_time_limit(1000);
	ini_set('memory_limit','128M');
	header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
	header("Content-Disposition: attachment; filename=CohorteRegistroAcceso.xls");
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Cache-Control: private",false);
?>
<!DOCTYPE html> 
<html>
<body>
<h3>Registro Accesos</h3>
<table border="1" cellspacing="0" cellpadding="3" width="100%">
	<tr>
    	<th>Nombre</th>
		<th>Usuario</th>
        <th>Centro</th>
        <th>Nivel</th>
        <th>Fecha</th>
		<th>Hora</th>
	</tr>
<?php
		$username="root";
		$password="r1r7C1h6ZG4ZVWF";
		$database="cohorte";
		//mysql_connect("cohorte.cvssq77sdkiq.sa-east-1.rds.amazonaws.com",$username,$password);
		mysql_connect("cohorte.cbupq68leyb4.us-east-1.rds.amazonaws.com",$username,$password) or die(mysql_error());
		mysql_select_db($database) or die(mysql_error());
		$query = "SELECT UPPER(Usuario.Nombre), UPPER(Usuario.Apellido), UPPER(Usuario.NombreUsuario), UsuarioRegistro.Fecha,UPPER(NivelUsuario.Nombre),Usuario.NivelUsuarioID,Usuario.ID ";
		$query .= " FROM UsuarioRegistro ";
		$query .= " LEFT JOIN Usuario ON UsuarioRegistro.UsuarioID=Usuario.ID ";
		$query .= " LEFT JOIN NivelUsuario ON Usuario.NivelUsuarioID=NivelUsuario.ID ";
		$query .= " WHERE UsuarioRegistro.UsuarioID NOT IN (1,48) ";
		$query .= " ORDER BY UsuarioRegistro.Fecha DESC ";
		$result = mysql_query($query) or die(mysql_error());
		if(mysql_num_rows($result)>0){
			while($row = mysql_fetch_array($result)){
				$fecha=strtotime($row[3]);
				echo "<tr>";
				echo "<td>{$row[0]} ";
				echo "{$row[1]}</td>";
				echo "<td>{$row[2]}</td>";
				if($row[5]=="1"){
					echo "<td>TODOS</td>";
				}else{
					$query = " SELECT Centro.Nombre FROM Permiso,Centro ";
					$query .= " WHERE Permiso.UsuarioID={$row[6]} AND Permiso.CentroID=Centro.ID;";
					$result2 = mysql_query($query) or die(mysql_error());
					if($row2 = mysql_fetch_array($result2)){			
						echo "<td>{$row2[0]}</td>";
					}else{
						echo "<td>SIN DATOS</td>";
					}
				}
				echo "<td>{$row[4]}</td>";
				echo "<td>".date("d-m-Y",$fecha)."</td>";
				echo "<td>".date("h:i A",$fecha)."</td>";
				echo "</tr>";
			}
		}
		mysql_close();
?>
</table>
</body>
</html>