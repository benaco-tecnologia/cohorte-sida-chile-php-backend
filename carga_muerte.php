<?php
	set_time_limit(5000000);
	ini_set('memory_limit','512M');
?>
<!DOCTYPE html>
<html>
<body>
<div class="line"></div>
<div class="wrapper">
	<div class="widget">
	<form action="carga_muerte.php" method="POST" enctype="multipart/form-data">
		<fieldset>
		<table cellpadding="0" cellspacing="0" width="100%" class="sTable">
			<tr>
				<td>Seleccione archivo:</td>
				<td><input type="file" name="archivoCSV" /></td>
			</tr>
             <tr>
				<td></td>
                <td></td>
				<td></td>
				<td></td>
		  </tr>
			<tr>
				<td></td>
				<td></td>
				<td colspan="2" align="right">
					<input type="submit" value="Aceptar" name="cargarCSV" />
				</td>
		  </tr>
         
		</table>
		</fieldset>
	</form>
	</div>
</div>
<p>&nbsp;</p>
<table border="1" cellspacing="0" cellpadding="3" width="100%">
<?php

/*$fh = fopen('filename.txt','r');
 {
  // <... Do your work with the line ...>
  // echo($line);
}
*/

	if(isset($_POST)||isset($_FILES)){
		$i=1;
		$username="root";
		$password="r1r7C1h6ZG4ZVWF";
		$database="cohorte";
		mysql_connect("cohorte.cbupq68leyb4.us-east-1.rds.amazonaws.com",$username,$password);
		mysql_select_db($database) or die( "Unable to select database");
		if ($_FILES["archivoCSV"]["error"] == 0 && $_FILES["archivoCSV"]["size"] > 0) {
			if (($handle = fopen($_FILES["archivoCSV"]["tmp_name"], "r")) !== FALSE) {
				while ($line = fgets($handle)) {
					/*if($i==25){
						break;
					}*/
					
					$tmp = explode(";",$line);
					$codigo=trim(strtoupper($tmp[0]));
					$muerte_fecha = date("Y-m-d",strtotime(trim(strtoupper($tmp[35]))));
					if($muerte_fecha==''||$muerte_fecha=='1969-12-31'){
						continue;
					}
					echo "<tr>";
					echo "<td>".($i++)."</td>";
					$muerte_causa = trim(strtoupper($tmp[36]));
					$muerte_observacion = trim(strtoupper($tmp[37]));
					$muerte_causa_id = "11";
					
					switch($muerte_causa){
						case 'MUESIDA':
							$muerte_causa_id = 7;
							break;
						case 'ND':
							$muerte_causa_id = 11;
							break;
						case 'MUENOSIDA':
							$muerte_causa_id = 6;
							break;
						case 'MUENEUROLO':
							$muerte_causa_id = 4;
							break;
						case 'MUECANCSID':
							$muerte_causa_id = 1;
							break;
						case 'CANCER':
							$muerte_causa_id = 10;
							break;
						case 'OTRA - INS':
							$muerte_causa_id = 10;
							break;
						case 'MUECARDIOV':
							$muerte_causa_id = 2;
							break;
						case 'EVENTOS CA':
							$muerte_causa_id = 10;
							break;
						case 'MUEHEPATIC':
							$muerte_causa_id = 3;
							break;
						case 'ACCIDENTAL':
							$muerte_causa_id = 9;
							break;
						case 'MUENOASOSI':
							$muerte_causa_id = 6;
							break;
						case 'SUICIDIO':
							$muerte_causa_id = 8;
							break;
						default:
							$muerte_causa_id = "11";
							break;
					}
					
					/*if($muerte_causa!=""){
						$q = "SELECT ID FROM CausaMuerte WHERE Nombre = '$muerte_causa';";
						$result = mysql_query($q);						
						if(mysql_num_rows($result)>0){
							$row = mysql_fetch_assoc($result);
							$muerte_causa_id = $row["ID"];
						}
					}*/
					
					$query = "SELECT ID FROM Paciente WHERE TRIM(UPPER(Paciente.Codigo))='$codigo';";
					$result = mysql_query($query);						
					if(mysql_num_rows($result)>0){
						$row = mysql_fetch_assoc($result);
						$pacienteID=$row["ID"];
						$query = "REPLACE INTO Muerte (PacienteID,CausaMuerteID,Fecha,Observacion) VALUES ($pacienteID,$muerte_causa_id,'$muerte_fecha','$muerte_observacion');";
						$query = str_replace("'1969-12-31'","NULL",$query);
						$query = str_replace("''","NULL",$query);
						mysql_query("DELETE FROM Muerte WHERE PacienteID = $pacienteID;") or print(mysql_error());
						mysql_query($query) or print(mysql_error());
						echo "<td style=\"background-color:green;color:white;\">$codigo INGRESADO $query</td>";
					}else{ 
						echo "<td style=\"background-color:red;color:white;\">$codigo NO INGRESADO</td>";
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