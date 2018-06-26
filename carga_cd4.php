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
	<form action="carga_cd4.php" method="POST" enctype="multipart/form-data">
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
	<tr>
		
	</tr>
<?php
	if(isset($_POST)||isset($_FILES)){
		$username="root";
		$password="r1r7C1h6ZG4ZVWF";
		$database="cohorte";
		$i=1;
		$link = mysqli_connect("cohorte.cbupq68leyb4.us-east-1.rds.amazonaws.com",$username,$password);
		mysqli_select_db($link, $database) or die( "Unable to select database");
		if ($_FILES["archivoCSV"]["error"] == 0 && $_FILES["archivoCSV"]["size"] > 0) {
			if (($handle = fopen($_FILES["archivoCSV"]["tmp_name"], "r")) !== FALSE) {
				while ($data = fgets($handle)) {
					if($i==50){
						//break;
					}
					$num = count($data);
					 //for ($c=0; $c < $num; $c++) {
						$tmp = explode(";", $data);
						$codigo = trim(strtoupper($tmp[0]));
						//$tipo = trim(strtoupper($tmp[1]));
						$tipo = "CV";
						/*$numero = trim(strtoupper($tmp[2]));
						$resultado = trim(strtoupper($tmp[3]));
						$fecha = date("Y-m-d",strtotime(trim(strtoupper($tmp[4]))));
						$porcentaje = trim(strtoupper($tmp[5]));
						
						if(!is_numeric($porcentaje)){
							$porcentaje = "NULL";
						}*/
						
						
						$numero = trim(strtoupper($tmp[1]));
						$resultado = trim(strtoupper($tmp[2]));
						$fecha = date("Y-m-d",strtotime(trim(strtoupper($tmp[3]))));
						$log = trim(strtoupper($tmp[4]));
						$log  = str_replace(",",".",$log);
						if(!is_numeric($log)){
							$log = "NULL";
						}
						echo "<tr>";
						echo "<td>".($i++)."</td>";
						$numero = intval(trim(strtoupper($tmp[1])));
						$query = "SELECT ID, Codigo from Paciente WHERE TRIM(UPPER(Codigo))='$codigo'";
						$result = mysqli_query($link,$query);
						if(mysqli_num_rows($result)>0){
							$row = mysqli_fetch_array($result);
							if($row['ID']!=null&&$row['ID']!=""){
								echo "<td style=\"background-color:green;color:white;\">$codigo</td>";
							}else{
								echo "<td style=\"background-color:yellow;color:black;\">$codigo</td>";
							}
							if($tipo=="CV"){
								$query2 = "SELECT ID, PacienteID, Tipo, NumeroControl from Control WHERE PacienteID={$row['ID']} AND NumeroControl=$numero AND TRIM(UPPER(Tipo))='CV'";
								$result2 = mysqli_query($link,$query2);
								if(mysqli_num_rows($result2)>0){
									$row2 = mysqli_fetch_array($result2);
									//$query3= "UPDATE Control SET NumeroControl=$numero, Resultado=$resultado, Logaritmo=$log, Fecha='$fecha' WHERE ID={$row2["ID"]};";
									//mysqli_query($link,$query3);
									echo "<td style=\"background-color:green;color:white;\">CD4 $numero</td>";
								}else{
									$query3= "INSERT INTO Control (PacienteID, Tipo, NumeroControl, Fecha, Resultado, Logaritmo) VALUES ({$row['ID']},'CV',$numero,'$fecha',$resultado,$log);";
									echo "<td style=\"background-color:yellow;color:black;\">CD4 $numero $query3</td>";
									mysqli_query($link,$query3);
								}
							}
							/*if($tipo=="CV"){
								$query2 = "SELECT PacienteID, Tipo, NumeroControl from Control WHERE PacienteID={$row['ID']} AND NumeroControl=$numero AND TRIM(UPPER(Tipo))='CV'";
								$result2 = mysqli_query($query2);
								if(mysqli_num_rows($result2)>0){
									$row2 = mysqli_fetch_array($result2);
									echo "<td style=\"background-color:green;color:white;\">CV $numero</td>";
								}else{
									echo "<td style=\"background-color:yellow;color:black;\">CV $numero</td>";
									$query3= "INSERT INTO Control (PacienteID, Tipo, NumeroControl, Fecha, Resultado, Logaritmo) VALUES ({$row['ID']},'CV',$numero,'{$tmp[3]}',{$tmp[4]},{$tmp[5]})";
									//echo "<td>$query3</td>";
									mysqli_query($query3);
								}
							}*/
						}else{
							echo "<td style=\"background-color:red;color:white;\">$codigo</td>";
						}
						echo "</tr>";
					//}
					
				}
			}
		}
		mysqli_close($link);
	}
?>
</table>
</body>
</html>