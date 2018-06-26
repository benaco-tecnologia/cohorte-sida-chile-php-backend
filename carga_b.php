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
	<form action="carga_b.php" method="POST" enctype="multipart/form-data">
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
					echo "<tr>";
						echo "<td>".($i++)."</td>";
						$tmp = explode(";",$line);
						$codigo=trim(strtoupper($tmp[0]));
						$clasificacionl=trim(strtoupper($tmp[1]));
						$clasificacionn=trim(strtoupper($tmp[2]));
						$enf1=trim(strtoupper($tmp[3]));
						$enf1fecha=date("Y-m-d",strtotime(trim(strtoupper($tmp[4]))));
						$enf2=trim(strtoupper($tmp[5]));
						$enf2fecha=date("Y-m-d",strtotime(trim(strtoupper($tmp[6]))));
						$enf3=trim(strtoupper($tmp[7]));
						$enf3fecha=date("Y-m-d",strtotime(trim(strtoupper($tmp[8]))));
						$enf4=trim(strtoupper($tmp[9]));
						$enf4fecha=date("Y-m-d",strtotime(trim(strtoupper($tmp[10]))));
						
						$ppd=trim(strtoupper($tmp[11]));
						$ppdfecha=date("Y-m-d",strtotime(trim(strtoupper($tmp[12]))));
						$ppdtratamiento=trim(strtoupper($tmp[13]));
						$rxtorax=trim(strtoupper($tmp[14]));
						$hbsag=trim(strtoupper($tmp[15]));
						$hbsagfecha=date("Y-m-d",strtotime(trim(strtoupper($tmp[16]))));
						$vhc=trim(strtoupper($tmp[17]));
						$vhcfecha=date("Y-m-d",strtotime(trim(strtoupper($tmp[18]))));
						$toxoplasmosis=trim(strtoupper($tmp[19]));
						$toxofecha=date("Y-m-d",strtotime(trim(strtoupper($tmp[20]))));
						$vdrl=trim(strtoupper($tmp[21]));
						$vdrlfecha=date("Y-m-d",strtotime(trim(strtoupper($tmp[22]))));
						$chagas=trim(strtoupper($tmp[23]));
						$chagasfecha=date("Y-m-d",strtotime(trim(strtoupper($tmp[24]))));
						$pap=trim(strtoupper($tmp[25]));
						$papfecha=date("Y-m-d",strtotime(trim(strtoupper($tmp[26]))));
						$cd4=trim(strtoupper($tmp[27]));
						$cd4fecha=date("Y-m-d",strtotime(trim(strtoupper($tmp[28]))));
						$pcd4=trim(strtoupper($tmp[29]));
						$cv=trim(strtoupper($tmp[30]));
						$cvfecha=date("Y-m-d",strtotime(trim(strtoupper($tmp[31]))));
						$log=trim(strtoupper($tmp[32]));
						
						
						$HiperDiag	=trim(strtoupper($tmp[38]));
						$HiperFecha	=date("Y-m-d",strtotime(trim(strtoupper($tmp[39]))));
						$Psist	=trim(strtoupper($tmp[40]));
						$Pdias	=trim(strtoupper($tmp[41]));
						$Dislipidemias	=trim(strtoupper($tmp[42]));
						$DislipidemiasFecha	=date("Y-m-d",strtotime(trim(strtoupper($tmp[43]))));
						$ColesterolTotal	=trim(strtoupper($tmp[44]));
						$ColesterolHDL	=trim(strtoupper($tmp[45]));
						$ColesterolLDL	=trim(strtoupper($tmp[46]));
						$Trigi	=trim(strtoupper($tmp[47]));
						$GliceDiag	=trim(strtoupper($tmp[48]));
						$GliceFecha	=date("Y-m-d",strtotime(trim(strtoupper($tmp[49]))));
						$Glice	=trim(strtoupper($tmp[50]));
						$Peso	=trim(strtoupper($tmp[51]));
						$Hematocrito	=trim(strtoupper($tmp[52]));
						$HematocritoFecha	=date("Y-m-d",strtotime(trim(strtoupper($tmp[53]))));
						$Gpt	=trim(strtoupper($tmp[54]));
						$Got=trim(strtoupper($tmp[55]));
						
						$log=str_replace(",",".",$log);
						if(!is_numeric($log)){
							$log = "NULL";
						}
						
						$pcd4=str_replace(",",".",$pcd4);
						if(!is_numeric($pcd4)){
							$pcd4 = "NULL";
						}else{
							$pcd4 = $pcd4 * 100;
						}
						
						$enf1ID="";
						$enf2ID="";
						$enf3ID="";
						$enf4ID="";
						
						if($enf1!=""){
							$q = "SELECT ID FROM Patologia WHERE Nombre = '$enf1';";
							$result = mysql_query($q);						
							if(mysql_num_rows($result)>0){
								$row = mysql_fetch_assoc($result);
								$enf1ID = $row["ID"];
							}
						}
						if($enf2!=""){
							$q = "SELECT ID FROM Patologia WHERE Nombre = '$enf2';";
							$result = mysql_query($q);						
							if(mysql_num_rows($result)>0){
								$row = mysql_fetch_assoc($result);
								$enf2ID = $row["ID"];
							}
						}
						if($enf3!=""){
							$q = "SELECT ID FROM Patologia WHERE Nombre = '$enf3';";
							$result = mysql_query($q);						
							if(mysql_num_rows($result)>0){
								$row = mysql_fetch_assoc($result);
								$enf3ID = $row["ID"];
							}
						}
						if($enf4!=""){
							$q = "SELECT ID FROM Patologia WHERE Nombre = '$enf4';";
							$result = mysql_query($q);						
							if(mysql_num_rows($result)>0){
								$row = mysql_fetch_assoc($result);
								$enf4ID = $row["ID"];
							}
						}
						
						$query = "SELECT ID FROM Paciente WHERE TRIM(UPPER(Paciente.Codigo))='$codigo';";
						$result = mysql_query($query);						
						if(mysql_num_rows($result)>0){
							$row = mysql_fetch_assoc($result);
							$pacienteID=$row["ID"];
							$query = "UPDATE DatoBasal SET ".
							"ClasificacionL='$clasificacionl',".
							"ClasificacionN='$clasificacionn',".
							"CD4='$cd4',".
							"CV='$cv',".
							//"Hla='',".
							"Ppd='$ppd',".
							"Hbs='$hbsag',".
							"Vhc='$vhc',".
							"Toxoplasmosis='$toxoplasmosis',".
							"Vdrl='$vdrl',".
							"Chagas='$chagas',".
							"Pap='$pap',".
							"PCD4=$pcd4,".
							"Log=$log,".
							//"Tratamiento='',".
							"RxTorax='$rxtorax',".
							//"ExamenOrina='',".
							"Peso='$Peso',".
							//"Talla='',".
							//"Imc='',".
							//"Siges='',".
							"Hipertencion='$HiperDiag',".
							"HipertencionFecha='$HiperFecha',".
							"Sistolica='$Psist',".
							"Diastolica='$Pdias',".
							"Dislipidemias='$Dislipidemias',".
							"DislipidemiasFecha='$DislipidemiasFecha',".
							"ColesTotal='$ColesterolTotal',".
							"ColesLdl='$ColesterolLDL',".
							"ColesHdl='$ColesterolHDL',".
							"Trigi='$Trigi',".
							"Glicemia='$Glice',".
							"GlicemiaFecha='$GliceFecha',".
							"Hematocrito='$Hematocrito',".
							//"Transaminasas='',".
							"HematocritoFecha='$HematocritoFecha',".
							"Gpt='$Gpt',".
							"Got='$Got',".
							"CD4Fecha='$cd4fecha',".
							"CVFecha='$cvfecha',".
							//"HlaFecha='',".
							"PpdFecha='$ppdfecha',".
							"HbsaFecha='$hbsagfecha',".
							"VhcFecha='$vhcfecha',".
							"ToxoFecha='$toxofecha',".
							"VdrlFecha='$vdrlfecha',".
							"ChagasFecha='$chagasfecha',".
							"PapFecha='$papfecha',".
							"Enf1Fecha='$enf1fecha',".
							"Enf2Fecha='$enf2fecha',".
							"Enf3Fecha='$enf3fecha',".
							"Enf4Fecha='$enf4fecha',".
							"HiperFecha='$HiperFecha',".
							"DisliFecha='$DislipidemiasFecha',".
							"GliceFecha='$GliceFecha',".
							"HemaFecha='$HematocritoFecha',".
							"Enf1ID='$enf1ID',".
							"Enf2ID='$enf2ID',".
							"Enf3ID='$enf3ID',".
							"Enf4ID='$enf4ID',".
							"PpdTratamiento='$ppdtratamiento',".
							"HiperDiag='$HiperDiag',".
							"DisliDiag='$Dislipidemias',".
							"GliceDiag='$GliceDiag',".
							"PSist='$Psist',".
							"PDias='$Pdias' ".
							"WHERE PacienteID=$pacienteID;";
							$query = str_replace("'1969-12-31'","NULL",$query);
							$query = str_replace("''","NULL",$query);
							mysql_query($query);
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