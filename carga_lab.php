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
	<form action="carga_lab.php" method="POST" enctype="multipart/form-data">
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
		mysql_connect("cohorte.cvssq77sdkiq.sa-east-1.rds.amazonaws.com",$username,$password);
		mysql_select_db($database) or die( "Unable to select database");
		if ($_FILES["archivoCSV"]["error"] == 0 && $_FILES["archivoCSV"]["size"] > 0) {
			if (($handle = fopen($_FILES["archivoCSV"]["tmp_name"], "r")) !== FALSE) {
				while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
					$num = count($data);
					 for ($c=0; $c < $num; $c++) {
						$tmp = explode(";", $data[$c]);
						$codigo=trim(strtoupper($tmp[0]));
						$control=trim(strtoupper($tmp[1]));
						$fecha=trim($tmp[17]);
						//$tipo = trim(strtoupper($tmp[1]));
						/*if($tipo!="CV"){
							continue; 
						}*/
						if(trim($tmp[0])==""){
							continue;
						}
						
						//if($tmp[5]==""||$tmp[5]=="0"){
						//	$tmp[5]="0.0";
						//}
						//$tmp[4]=intval($tmp[4]);
						//$tmp[5]=str_replace(",",".",$tmp[5]);
						//$tmp[5]=floatval($tmp[5]);
						//$tmp[5]=number_format($tmp[5],2);
						echo "<tr>";
						//echo "<td>".($i++)."</td>";
						//$numero = intval(trim(strtoupper($tmp[2])));
						$query = "SELECT ID, Codigo from Paciente WHERE TRIM(UPPER(Codigo))='$codigo'";
						$result = mysql_query($query);
						if(mysql_num_rows($result)>0){
							$row = mysql_fetch_array($result);
							
							if($row['ID']!=null&&$row['ID']!=""){
							
								///echo "<td style=\"background-color:green;color:white;\">$codigo</td>";
								$pid=$row['ID'];
								//HTA
								if($fecha!=""){
									$t="HE";
									$gpt=strtoupper(trim(@$tmp[18]));
									switch($gpt){
										case 'NORMAL':
										$gpt="NO";
										break;
										case 'NO DISPONI':
										case 'NODISPONIB':
										$gpt="ND";
										break;
										case '<2X':
										$gpt="l2X";
										break;
										case '<3X':
										$gpt="l3X";
										break;
										case '<5X':
										$gpt="l5X";
										break;
										case '<10X':
										$gpt="l10X";
										break;
										case '>10X':
										$gpt="g10X";
										break;
										default:
										$gpt="";
									}
									
									$got=strtoupper(trim(@$tmp[19]));
									switch($got){
										case 'NORMAL':
										$got="NO";
										break;
										case 'NO DISPONI':
										case 'NODISPONIB':
										$got="ND";
										break;
										case '<2X':
										$got="l2X";
										break;
										case '<3X':
										$got="l3X";
										break;
										case '<5X':
										$got="l5X";
										break;
										case '<10X':
										$got="l10X";
										break;
										case '>10X':
										$got="g10X";
										break;
										default:
										$got="";
									}
									/*$ps=trim(@$tmp[4]);
									$pd=trim(@$tmp[5]);
									$peso=trim(@$tmp[15]);*/
									/*$ctotal=trim(@$tmp[8]);
									$colldl=trim(@$tmp[10]);
									$colhdl=trim(@$tmp[9]);
									$tri=trim(@$tmp[11]);*/
									$hema=trim(@$tmp[16]);
									$query = "SELECT ID from Laboratorio WHERE PacienteID=$pid AND Tipo='$t' AND NumeroControl=$control;";
									$result = mysql_query($query);
									if($hema==""){
										$hema="NULL";
									}
									/*if($colldl==""){
										$colldl="NULL";
									}
									if($colhdl==""){
										$colhdl="NULL";
									}
									if($tri==""){
										$tri="NULL";
									}*/
									if(mysql_num_rows($result)==0){
										echo "<td style=\"background-color:red;color:white;\">INSERT INTO Laboratorio(PacienteID,Tipo,NumeroControl,Fecha,Hematocrito,Gpt,Got) VALUES($pid,'$t',$control,'$fecha',$hema,'$gpt','$got');</td>";
									}
								}
							}else{
								//echo "<td style=\"background-color:yellow;color:black;\">$codigo</td>";
							}
							
							
							
							
							/*if($tipo=="CD4"){
								$query2 = "SELECT PacienteID, Tipo, NumeroControl from Control WHERE PacienteID={$row['ID']} AND NumeroControl=$numero AND TRIM(UPPER(Tipo))='CD'";
								$result2 = mysql_query($query2);
								if(mysql_num_rows($result2)>0){
									$row2 = mysql_fetch_array($result2);
									echo "<td style=\"background-color:green;color:white;\">CD4 $numero</td>";
								}else{
									echo "<td style=\"background-color:yellow;color:black;\">CD4 $numero</td>";
									$query3= "INSERT INTO Control (PacienteID, Tipo, NumeroControl, Fecha, Resultado, PCD4) VALUES ({$row['ID']},'CD',$numero,'{$tmp[3]}','{$tmp[4]}','{$tmp[5]}')";
									mysql_query($query3);
								}
							}*/
							/*if($tipo=="CV"){
								$query2 = "SELECT PacienteID, Tipo, NumeroControl from Control WHERE PacienteID={$row['ID']} AND NumeroControl=$numero AND TRIM(UPPER(Tipo))='CV'";
								$result2 = mysql_query($query2);
								if(mysql_num_rows($result2)>0){
									$row2 = mysql_fetch_array($result2);
									echo "<td style=\"background-color:green;color:white;\">CV $numero</td>";
								}else{
									echo "<td style=\"background-color:yellow;color:black;\">CV $numero</td>";
									$query3= "INSERT INTO Control (PacienteID, Tipo, NumeroControl, Fecha, Resultado, Logaritmo) VALUES ({$row['ID']},'CV',$numero,'{$tmp[3]}',{$tmp[4]},{$tmp[5]})";
									//echo "<td>$query3</td>";
									mysql_query($query3);
								}
							}*/
						}else{
							//echo "<td style=\"background-color:red;color:white;\">$codigo</td>";
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