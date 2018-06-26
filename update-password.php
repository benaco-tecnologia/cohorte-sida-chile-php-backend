<?php
	set_time_limit(1000);
	ini_set('memory_limit','128M');
?>
<!DOCTYPE html>
<html>
<body>
<div class="line"></div>
<div class="wrapper">
	<div class="widget">
	<form action="update-password.php" method="POST" enctype="multipart/form-data">
		<fieldset>
		<table cellpadding="0" cellspacing="0" width="100%" class="sTable">
			<tr>
				<td><input type="file" name="archivoCSV" /><input type="submit" value="Aceptar" name="cargarCSV" /></td>
			</tr>
		</table>
		</fieldset>
	</form>
	</div>
</div>
<p>&nbsp;</p>
<table border="1" cellspacing="0" cellpadding="3" width="100%">
<?php
	if(isset($_POST)||isset($_FILES)){
		$username="root";
		$password="r1r7C1h6ZG4ZVWF";
		$database="cohorte";
		mysql_connect("cohorte.cvssq77sdkiq.sa-east-1.rds.amazonaws.com",$username,$password);
		mysql_select_db($database) or die( "Unable to select database");
		if ($_FILES["archivoCSV"]["error"] == 0 && $_FILES["archivoCSV"]["size"] > 0) {
			if (($handle = fopen($_FILES["archivoCSV"]["tmp_name"], "r")) !== FALSE) {
				while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
					$num = count($data);
					echo "<tr>";
					 for ($c=0; $c < $num; $c++) {
						$tmp = explode(";", $data[$c]);
						$usuario=trim(strtoupper($tmp[0]));
						$password=md5(strtoupper(trim($tmp[1])));
						$query = "UPDATE Usuario SET Contrasena='$password' WHERE TRIM(UPPER(NombreUsuario))='$usuario';";
						echo "<td style=\"background-color:red;color:white;\">$query</td>";
						/*$result = mysql_query($query);
						if(mysql_num_rows($result)>0){
							$query = "INSERT INTO Paciente (Codigo,CentroID) VALUES ('$codigo',$centroID);";
							echo "<td style=\"background-color:red;color:white;\">$query</td>";
						}*/
					}
					echo "</tr>";
				}
			}
		}
		mysql_close();
	}
?>
</table>
</body>
</html>