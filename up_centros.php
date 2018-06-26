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
	<form action="up_centros.php" method="POST" enctype="multipart/form-data">
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
		mysql_connect(localhost,$username,$password);
		mysql_select_db($database) or die( "Unable to select database");
		if ($_FILES["archivoCSV"]["error"] == 0 && $_FILES["archivoCSV"]["size"] > 0) {
			if (($handle = fopen($_FILES["archivoCSV"]["tmp_name"], "r")) !== FALSE) {
				while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
					$num = count($data);
					
						
					 for ($c=0; $c < $num; $c++) {
						$tmp = explode(";", $data[$c]);
						$codigo = trim(strtoupper($tmp[0]));
						$numero = trim(strtoupper($tmp[1]));
						$fecha = trim(strtoupper($tmp[2]));
						if($fecha==''){
							$fecha="NULL";
						}else{
							$fecha="'$fecha'";
						}
						$sexo = trim(strtoupper($tmp[2]));
						$d2 = trim(strtoupper($tmp[4]));
						$d3 = trim(strtoupper($tmp[5]));
						$d4 = trim(strtoupper($tmp[6]));
						$d5 = trim(strtoupper($tmp[7]));
						$d6 = trim(strtoupper($tmp[8]));
						$nocontinua = trim(strtoupper($tmp[9]));
						$geno=trim(strtoupper($tmp[13]));
						$geno_fecha=trim(strtoupper($tmp[14]));
						$fecha_termino=trim(strtoupper($tmp[12]));
						
						
						$causaTermino=trim(strtoupper($tmp[10]));
						$razonToxicidad=trim(strtoupper($tmp[11]));

						
						if($geno=="TRUE"||$geno=="SI"){
							$geno="SI";
						}else{
							$geno="NO";
						}
						if($geno_fecha==''){
							$geno_fecha="NULL";
						}else{
							$geno_fecha="'$geno_fecha'";
						}
						if($fecha_termino==''){
							$fecha_termino="NULL";
						}else{
							$fecha_termino="'$fecha_termino'";
						}
						switch($sexo){
							case 'M':
							case 'MASCULINO':
							$sexo="2";
							break;
							case 'F':
							case 'FEMENINO':
							$sexo="1";
							break;
							default:
							$sexo="3";							
						}
						if($sexo=="3"){
							//continue;
						}
						echo "<tr>";
						echo "<td>".($i++)."</td>";
						
						
						$query = "SELECT ID, Codigo, CentroID, SexoID from Paciente WHERE TRIM(UPPER(Codigo))='$codigo' AND (SexoID IS NULL OR SexoID='' OR CentroID IS NULL OR CentroID='')";
						$result = mysql_query($query);
						if(mysql_num_rows($result)>0){
							$row = mysql_fetch_array($result);
							if($row['ID']!=null&&$row['ID']!=""){
								echo "<td style=\"background-color:green;color:white;\">$codigo / {$row['Codigo']} / ".mysql_num_rows($result)."</td>";
							}else{
								echo "<td style=\"background-color:yellow;color:black;\">$codigo</td>";
							}
							if($row['CentroID']==null||$row['CentroID']==""){
								echo "<td>NO Centro</td>";
							}
							/*if(($row['SexoID']==null||$row['SexoID']=="")&&$sexo!="3"){
								mysql_query("update Paciente set SexoID=$sexo WHERE ID={$row['ID']}");
							}*/
							//$query2 = "SELECT ID, PacienteID, NumeroTar from Terapia WHERE PacienteID={$row['ID']} AND NumeroTar=$numero;";
							//$result2 = mysql_query($query2);
						}else{
								echo "<td style=\"background-color:red;color:white;\">$codigo</td>";
						}
						echo "</tr>";
					}
					
				}
			}
		}
		mysql_close();
	}
?>
</table>
</body>
</html>