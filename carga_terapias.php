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
	<form action="carga_terapias.php" method="POST" enctype="multipart/form-data">
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
	//if(isset($_POST)||isset($_FILES)){
		$username="root";
		$password="r1r7C1h6ZG4ZVWF";
		$database="cohorte";
		$i=1;
		$link = mysqli_connect("cohorte.cbupq68leyb4.us-east-1.rds.amazonaws.com",$username,$password);
		//if ($_FILES["archivoCSV"]["error"] == 0 && $_FILES["archivoCSV"]["size"] > 0) {
		mysqli_select_db($link, $database) or die(mysqli_error());
		if (($handle = fopen("TAR.csv", "r")) !== FALSE) {
			while ($data = fgets($handle)) {
					$num = count($data);
					if($i++==50){
						//break;
					}
						
					// for ($c=0; $c < $num; $c++) {
						$tmp = explode(";", $data);
						$codigo = trim(strtoupper($tmp[0]));
						$numero = trim(strtoupper($tmp[1]));
						$fecha = date("Y-m-d",strtotime(trim(strtoupper($tmp[2]))));
						/*$fecha = trim(strtoupper($tmp[2]));
						if($fecha==''){
							$fecha="NULL";
						}else{
							$fecha="'$fecha'";
						}*/
						$d1 = trim(strtoupper($tmp[3]));
						$d2 = trim(strtoupper($tmp[4]));
						$d3 = trim(strtoupper($tmp[5]));
						$d4 = trim(strtoupper($tmp[6]));
						$d5 = trim(strtoupper($tmp[7]));
						$d6 = trim(strtoupper($tmp[8]));
						$nocontinua = trim(strtoupper($tmp[9]));
						$geno=trim(strtoupper($tmp[13]));
						$geno_fecha = date("Y-m-d",strtotime(trim(strtoupper($tmp[14]))));
						//$geno_fecha=trim(strtoupper($tmp[14]));
						$fecha_termino = date("Y-m-d",strtotime(trim(strtoupper($tmp[12]))));
						//$fecha_termino=trim(strtoupper($tmp[12]));
						
						
						$causaTermino=trim(strtoupper($tmp[10]));
						$razonToxicidad=trim(strtoupper($tmp[11]));

						
						if($geno=="TRUE"||$geno=="SI"){
							$geno="'SI'";
						}else{
							$geno="'NO'";
						}
						if($geno_fecha==''||$geno_fecha=="1969-12-31"){
							$geno_fecha="NULL";
						}else{
							$geno_fecha="'$geno_fecha'";
						}
						if($fecha_termino==''||$fecha_termino=="1969-12-31"){
							$fecha_termino="NULL";
						}else{
							$fecha_termino="'$fecha_termino'";
						}
						if($fecha==''||$fecha=="1969-12-31"){
							$fecha="NULL";
						}else{
							$fecha="'$fecha'";
						}
						
						switch($nocontinua){
							case 'CAMBIO':
							case 'CA':
								$nocontinua="'CA'";
								break;
							case 'SUSPENDIO':
							case 'SU':
								$nocontinua="'SU'";
								break;
							case 'FALLECIO':
							case 'FA':
								$nocontinua="'FA'";
								break;														
						}
						if($nocontinua==""){
							$nocontinua="'SD'";
						}
						
						
						if($causaTermino=="FINPROTOCOLOTV"){
							$causaTermino="7";
						}elseif($causaTermino=="FRACASO"){
							$causaTermino="8";
						}elseif($causaTermino=="FRACASO/TOXICIDAD"){
							$causaTermino="9";
						}elseif($causaTermino=="INICIOPROTOCOLOTV"){
							$causaTermino="14";
						}elseif($causaTermino=="OTRA"){
							$causaTermino="10";
						}elseif($causaTermino=="OTRAS"){
							$causaTermino="10";
						}elseif($causaTermino=="PARTICIPACIONENPROTOCOLOS"){
							$causaTermino="11";
						}elseif($causaTermino=="SUGERENCIACONASIDA/STOCK"){
							$causaTermino="12";
						}elseif($causaTermino=="TERMINOTV"){
							$causaTermino="7";
						}elseif($causaTermino=="TOXICIDAD"){
							$causaTermino="13";
						}else{
							$causaTermino = "NULL"; 
						}
						
						if($razonToxicidad=="METABOLICA"){
							$razonToxicidad="19";
						}elseif($razonToxicidad=="FALLAVIRO"){
							$razonToxicidad="17";
						}elseif($razonToxicidad=="ACIDOSISL"){
							$razonToxicidad="1";
						}elseif($razonToxicidad=="ANEMIA"){
							$razonToxicidad="20";
						}elseif($razonToxicidad=="INTOLERANC"){
							$razonToxicidad="21";
						}elseif($razonToxicidad=="ACIDOSISLACTICA"){
							$razonToxicidad="1";
						}elseif($razonToxicidad=="ALERGIA"){
							$razonToxicidad="2";
						}elseif($razonToxicidad=="GASTROINTESTINAL"){
							$razonToxicidad="3";
						}elseif($razonToxicidad=="HEMATOLOGICA"){
							$razonToxicidad="4";
						}elseif($razonToxicidad=="HEPATOTOXICA"){
							$razonToxicidad="5";
						}elseif($razonToxicidad=="METABOLICACONHIPERCOLESTERODYTRIGLICERIDEMIA"){
							$razonToxicidad="6";
						}elseif($razonToxicidad=="METABOLICACONHIPERCOLESTEROLEMIA"){
							$razonToxicidad="7";
						}elseif($razonToxicidad=="METABOLICACONHIPERTRIGLICERIDEMIA"){
							$razonToxicidad="8";
						}elseif($razonToxicidad=="METABOLICACONLIPOATROFIA"){
							$razonToxicidad="9";
						}elseif($razonToxicidad=="METABOLICACONLIPODISTROFIA"){
							$razonToxicidad="10";
						}elseif($razonToxicidad=="NEUROLOGICACENTRAL"){
							$razonToxicidad="11";
						}elseif($razonToxicidad=="NEUROLOGICAPERIFERICA"){
							$razonToxicidad="12";
						}elseif($razonToxicidad=="OTRA"){
							$razonToxicidad="15";
						}elseif($razonToxicidad=="PANCREATITIS"){
							$razonToxicidad="13";
						}else{
							$razonToxicidad = "NULL";
						}
						
						
						echo "<tr>";
						echo "<td>".($i)."</td>";
						
						/*if(is_numeric($codigo[2])){
							$letras=$codigo[0].$codigo[1];
							$codigo=substr($codigo,2);
							$query = "SELECT ID, Codigo from Paciente WHERE TRIM(UPPER(Codigo)) LIKE '$letras%' AND TRIM(UPPER(Codigo)) LIKE '%$codigo'";
						}else{
							$query = "SELECT ID, Codigo from Paciente WHERE TRIM(UPPER(Codigo))='$codigo'";
						}*/
						$query = "SELECT ID, Codigo from Paciente WHERE TRIM(UPPER(Codigo))='$codigo'";
						$result = mysqli_query($link, $query);
						if(mysqli_num_rows($result)>0){
							$row = mysqli_fetch_array($result);
							//if($row['ID']!=null&&$row['ID']!=""){
							//	echo "<td style=\"background-color:green;color:white;\">$codigo / {$row['Codigo']} / ".mysqli_num_rows($result)."</td>";
							//}else{
							//	echo "<td style=\"background-color:yellow;color:black;\">$codigo</td>";
							//}
							//$query2 = "SELECT ID, PacienteID, NumeroTar from Terapia WHERE PacienteID={$row['ID']} AND NumeroTar=$numero;";
							//echo "<td style=\"background-color:green;color:white;\">$query2</td>";	
							//$result2 = mysqli_query($link, $query2); 
							//if(mysqli_num_rows($result2)>0){
								//$row2 = mysqli_fetch_array($result2);
								//$terapia_id=$row2["ID"];
								//echo "<td style=\"background-color:green;color:white;\">TAR $numero</td>";
								
								//if($nocontinua!="SD"){
								//	echo "<td style=\"background-color:green;color:white;\">Update Terapia SET RazonToxicidadID=$razonToxicidad where ID = $terapia_id;</td>";								
								//	mysqli_query("Update Terapia SET RazonToxicidadID=$razonToxicidad where ID = $terapia_id;");
								//}
								//mysqli_query("Update Terapia SET NoContinua= where ID = $terapia_id;");
								/*if($d1!=""){
									$query3= "select ID from Droga Where Nombre='$d1'";
									$result3 = mysqli_query($query3);
									$row3 = mysqli_fetch_array($result3); 
									if($row3["ID"]!=null&&is_numeric($row3["ID"])){
										$d1=$row3["ID"];
										//mysqli_query("UPDATE TerapiaDroga SET Numero=1 WHERE TerapiaID=$terapia_id AND DrogaID=$d1;");
									}
								}
								if($d2!=""){
									$query3= "select ID from Droga Where Nombre='$d2'";
									$result3 = mysqli_query($query3);
									$row3 = mysqli_fetch_array($result3);
									if($row3["ID"]!=null&&is_numeric($row3["ID"])){
										$d1=$row3["ID"];
										//mysqli_query("UPDATE TerapiaDroga SET Numero=2 WHERE TerapiaID=$terapia_id AND DrogaID=$d1;");
									}
								}
								if($d3!=""){
									$query3= "select ID from Droga Where Nombre='$d3'";
									$result3 = mysqli_query($query3);
									$row3 = mysqli_fetch_array($result3);
									if($row3["ID"]!=null&&is_numeric($row3["ID"])){
										$d1=$row3["ID"];
										//mysqli_query("UPDATE TerapiaDroga SET Numero=3 WHERE TerapiaID=$terapia_id AND DrogaID=$d1;");
									}
								}
								if($d4!=""){
									$query3= "select ID from Droga Where Nombre='$d4'";
									$result3 = mysqli_query($query3);
									$row3 = mysqli_fetch_array($result3);
									if($row3["ID"]!=null&&is_numeric($row3["ID"])){
										$d1=$row3["ID"];
										//mysqli_query("UPDATE TerapiaDroga SET Numero=4 WHERE TerapiaID=$terapia_id AND DrogaID=$d1;");
									}
								}
								if($d5!=""){
									$query3= "select ID from Droga Where Nombre='$d5'";
									$result3 = mysqli_query($query3);
									$row3 = mysqli_fetch_array($result3);
									if($row3["ID"]!=null&&is_numeric($row3["ID"])){
										$d1=$row3["ID"];
										//mysqli_query("UPDATE TerapiaDroga SET Numero=5 WHERE TerapiaID=$terapia_id AND DrogaID=$d1;");
									}
								}
								if($d6!=""){
									$query3= "select ID from Droga Where Nombre='$d6'";
									$result3 = mysqli_query($query3);
									$row3 = mysqli_fetch_array($result3);
									if($row3["ID"]!=null&&is_numeric($row3["ID"])){
										$d1=$row3["ID"];
										//mysqli_query("UPDATE TerapiaDroga SET Numero=6 WHERE TerapiaID=$terapia_id AND DrogaID=$d1;");
									}
								}*/
							//}else{
								echo "<td style=\"background-color:yellow;color:black;\">TAR $numero</td>";
								//$query3= "INSERT INTO Control (PacienteID, Tipo, NumeroControl, Fecha, Resultado, Logaritmo) VALUES ({$row['ID']},'CV',$numero,'{$tmp[3]}',{$tmp[4]},{$tmp[5]})";
								//echo "<td>$query3</td>";
								//mysqli_query($query3);
								//$query = "INSERT INTO Terapia (PacienteID, NumeroTar, Fecha,Geno,GenoFecha,FechaTermino,NoContinua) VALUES ({$row['ID']},$numero,$fecha,$geno,$geno_fecha,$fecha_termino,$nocontinua);";
								$query = "SELECT ID FROM Terapia WHERE PacienteID = {$row['ID']} AND NumeroTar = $numero;";
								//echo $query;
								//echo "<td>INSERT INTO Terapia (PacienteID, NumeroTar, Fecha,Geno,GenoFecha,FechaTermino,NoContinua) VALUES ({$row['ID']},$numero,$fecha,'$geno',$geno_fecha,$fecha_termino,$nocontinua);</td>";
								/*mysqli_query("INSERT INTO Terapia (PacienteID, NumeroTar, Fecha,Geno,GenoFecha,FechaTermino,NoContinua) VALUES ({$row['ID']},$numero,$fecha,'$geno',$geno_fecha,$fecha_termino,$nocontinua);");
								$terapia_id=@mysqli_insert_id();
								
								*/
								$terapia_id = 0;
								$result = mysqli_query($link, $query);
								if(mysqli_num_rows($result)>0){
									$row = mysqli_fetch_array($result);
									$terapia_id = $row["ID"];
								}
								//$terapia_id=mysqli_insert_id($link);
								
								if($d1!=""){
									$query3= "select ID from Droga Where Nombre='$d1'";
									$result3 = mysqli_query($link,$query3);
									$row3 = mysqli_fetch_array($result3);
									if($row3["ID"]!=null&&is_numeric($row3["ID"])){
										$d1=$row3["ID"];
										$query="REPLACE  INTO TerapiaDroga (DrogaID,TerapiaID,Numero) VALUES ($d1,$terapia_id,1);";
										mysqli_query($link,"DELETE FROM TerapiaDroga WHERE TerapiaID = $terapia_id AND Numero=1 LIMIT 1;");
										mysqli_query($link,$query);
									}
								}
								if($d2!=""){
									$query3= "select ID from Droga Where Nombre='$d2'";
									$result3 = mysqli_query($link,$query3);
									$row3 = mysqli_fetch_array($result3);
									if($row3["ID"]!=null&&is_numeric($row3["ID"])){
										$d2=$row3["ID"];
										//mysqli_query( "REPLACE  INTO TerapiaDroga (DrogaID,TerapiaID,Numero) VALUES ($d2,$terapia_id,2);");
										mysqli_query($link,"DELETE FROM TerapiaDroga WHERE TerapiaID = $terapia_id AND Numero=2 LIMIT 1;");
										$query="REPLACE  INTO TerapiaDroga (DrogaID,TerapiaID,Numero) VALUES ($d2,$terapia_id,2);";
										mysqli_query($link,$query);
									}
								}
								if($d3!=""){
									$query3= "select ID from Droga Where Nombre='$d3'";
									$result3 = mysqli_query($link,$query3);
									$row3 = mysqli_fetch_array($result3);
									if($row3["ID"]!=null&&is_numeric($row3["ID"])){
										$d3=$row3["ID"];
										//mysqli_query( "REPLACE  INTO TerapiaDroga (DrogaID,TerapiaID,Numero) VALUES ($d3,$terapia_id,3);");
										mysqli_query($link,"DELETE FROM TerapiaDroga WHERE TerapiaID = $terapia_id AND Numero=3 LIMIT 1;");
										$query="REPLACE  INTO TerapiaDroga (DrogaID,TerapiaID,Numero) VALUES ($d3,$terapia_id,3);";
										mysqli_query($link,$query);
									}
								}
								if($d4!=""){
									$query3= "select ID from Droga Where Nombre='$d4'";
									$result3 = mysqli_query($link,$query3);
									$row3 = mysqli_fetch_array($result3);
									if($row3["ID"]!=null&&is_numeric($row3["ID"])){
										$d4=$row3["ID"];
										//mysqli_query( "REPLACE  INTO TerapiaDroga (DrogaID,TerapiaID,Numero) VALUES ($d4,$terapia_id,4);");
										mysqli_query($link,"DELETE FROM TerapiaDroga WHERE TerapiaID = $terapia_id AND Numero=4 LIMIT 1;");
										$query="REPLACE  INTO TerapiaDroga (DrogaID,TerapiaID,Numero) VALUES ($d4,$terapia_id,4);";
										mysqli_query($link,$query);
									}
								}
								if($d5!=""){
									$query3= "select ID from Droga Where Nombre='$d5'";
									$result3 = mysqli_query($link,$query3);
									$row3 = mysqli_fetch_array($result3);
									if($row3["ID"]!=null&&is_numeric($row3["ID"])){
										$d5=$row3["ID"];
										//mysqli_query( "REPLACE  INTO TerapiaDroga (DrogaID,TerapiaID,Numero) VALUES ($d5,$terapia_id,5);");
										mysqli_query($link,"DELETE FROM TerapiaDroga WHERE TerapiaID = $terapia_id AND Numero=5 LIMIT 1;");
										$query="REPLACE  INTO TerapiaDroga (DrogaID,TerapiaID,Numero) VALUES ($d5,$terapia_id,5);";
										mysqli_query($link,$query);
									}	
								}
								if($d6!=""){
									$query3= "select ID from Droga Where Nombre='$d6'";
									$result3 = mysqli_query($link,$query3);
									$row3 = mysqli_fetch_array($result3);
									if($row3["ID"]!=null&&is_numeric($row3["ID"])){
										$d6=$row3["ID"];
										//mysqli_query( "REPLACE  INTO TerapiaDroga (DrogaID,TerapiaID,Numero) VALUES ($d6,$terapia_id,6);");
										mysqli_query($link,"DELETE FROM TerapiaDroga WHERE TerapiaID = $terapia_id AND Numero=6 LIMIT 1;");
										$query="REPLACE  INTO TerapiaDroga (DrogaID,TerapiaID,Numero) VALUES ($d6,$terapia_id,6);";
										mysqli_query($link,$query);
										//echo $query;
									}
								}
								
							//}
						}else{
							echo "<td style=\"background-color:red;color:white;\">".trim(strtoupper($tmp[0]))." / $codigo / 0</td>";
							//@mysqli_query("INSERT INTO Paciente (Codigo) VALUES ('".trim(strtoupper($tmp[0]))."');");
						}
						echo "</tr>";
					//}
					
				}
			}
		//}
		mysqli_close($link);
	//}
?>
</table>
</body>
</html>