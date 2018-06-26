<?php
	set_time_limit(1000);
	ini_set('memory_limit','128M');
	header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
	header("Content-Disposition: attachment; filename=CohorteDatosBasales.xls");
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Cache-Control: private",false);
	$d1=array("PO","NN","NE","ND","NS");
	$d2=array("POSITIVO","NO DISPONIBLE NO SOLICITADO","NEGATIVO","NO DISPONIBLE","NO DISPONIBLE SOLICITADO");
?>
<!DOCTYPE html>
<html>
<body>
<h3>Basales</h3>
<table border="1" cellspacing="0" cellpadding="3" width="100%">
	<tr>
    	<th>C&oacute;digo</th>
        <th>Centro</th>
        <th>CD4</th>
        <th>CD4Fecha</th>
        <th>Chagas</th>
        <th>ChagasFecha</th>
        <th>ClasificacionL</th>
        <th>ClasificacionN</th>
        <th>ColesterolHDL</th>
        <th>ColesterolLDL</th>
        <th>ColeterolTotal</th>
        <th>CV</th>
        <th>CVFecha</th>
        <th>Dislipidemias</th>
        <th>DislipidemiasFecha</th>
        <th>Enf1</th>
        <th>Enf1Fecha</th>
        <th>Enf2</th>
        <th>Enf2Fecha</th>
        <th>Enf3</th>
        <th>Enf3Fecha</th>
        <th>Enf4</th>
        <th>Enf4Fecha</th>
        <th>ExamenOrina</th>
        <th>Glice</th>
        <th>GliceDiag</th>
        <th>GliceFecha</th>
        <th>Glicemia</th>
        <th>GlicemiaFecha</th>
        <th>Got</th>
        <th>Gpt</th>
        <th>Hbs</th>
        <th>HbsaFecha</th>
        <th>HemaFecha</th>
        <th>Hematocrito</th>
        <th>HematocritoFecha</th>
        <th>HiperDiag</th>
        <th>HiperFecha</th>
        <th>Hipertencion</th>
        <th>HipertencionFecha</th>
        <th>Hla</th>
        <th>HlaFecha</th>
        <th>Imc</th>
        <th>Log</th>
        <th>Pap</th>
        <th>PapFecha</th>
        <th>PCD4</th>
        <th>PDias</th>
        <th>Peso</th>
        <th>Ppd</th>
        <th>PpdFecha</th>
        <th>PpdTratamiento</th>
        <th>PSist</th>
        <th>RxTorax</th>
        <th>Siges</th>
        <th>Sistolica</th>
        <th>Talla</th>
        <th>ToxoFecha</th>
        <th>Toxoplasmosis</th>
        <th>Transaminasas</th>
        <th>Tratamiento</th>
        <th>Trigi</th>
        <th>Vdrl</th>
        <th>VdrlFecha</th>
        <th>Vhc</th>
        <th>VhcFecha</th>
        <th>Observaciones</th>
	</tr>
<?php
		$username="root";
		$password="r1r7C1h6ZG4ZVWF";
		$database="cohorte";
		//mysql_connect("cohorte.cvssq77sdkiq.sa-east-1.rds.amazonaws.com",$username,$password);
		mysql_connect("cohorte.cbupq68leyb4.us-east-1.rds.amazonaws.com",$username,$password) or die(mysql_error());
		mysql_select_db($database) or die(mysql_error());
		$query = "SELECT Paciente.Codigo, Centro.Nombre, DatoBasal.* ";
		$query .= " FROM Paciente ";
		$query .= " LEFT JOIN Centro ON Paciente.CentroID=Centro.ID ";	
		$query .= " LEFT JOIN DatoBasal ON Paciente.ID=DatoBasal.PacienteID ";	
		if(isset($_GET["c"]) && is_numeric($_GET["c"])){
			$query .= " WHERE Paciente.CentroID={$_GET["c"]}";
		}
		$query .= " ORDER BY Paciente.Codigo ";
		//$query .= " LIMIT 500;";
		$result = mysql_query($query) or die(mysql_error());
		if(mysql_num_rows($result)>0){
			while($row = mysql_fetch_array($result)){
				echo "<tr>";
				//Codigo
				echo "<td>{$row[0]}</td>";
				//Centro
				echo "<td>{$row[1]}</td>";
				//Basales
				echo "<td>{$row["CD4"]}</td>";
				echo "<td>".str_replace("0000-00-00","",$row["CD4Fecha"])."</td>";
				echo "<td>".str_replace($d1,$d2,$row["Chagas"])."</td>";
				echo "<td>".str_replace("0000-00-00","",$row["ChagasFecha"])."</td>";
				echo "<td>{$row["ClasificacionL"]}</td>";
				echo "<td>{$row["ClasificacionN"]}</td>";
				echo "<td>{$row["ColesHdl"]}</td>";
				echo "<td>{$row["ColesLdl"]}</td>";
				echo "<td>{$row["ColesTotal"]}</td>";
				echo "<td>{$row["CV"]}</td>";
				echo "<td>".str_replace("0000-00-00","",$row["CVFecha"])."</td>";
				echo "<td>{$row["Dislipidemias"]}</td>";
				echo "<td>{$row["DislipidemiasFecha"]}</td>";
				
				if(is_numeric($row["Enf1ID"]) && intval($row["Enf1ID"]) > 0){
					$query = " SELECT Nombre FROM Patologia ";
					$query .= " WHERE ID={$row["Enf1ID"]};";
					$result2 = mysql_query($query) or die(mysql_error());
					if($row2 = mysql_fetch_array($result2)){			
						echo "<td>{$row2["Nombre"]}</td>";
					}
					echo "<td>{$row["Enf1Fecha"]}</td>";
				} else {
					echo "<td></td>";	
					echo "<td></td>";	
				}
				
				if(is_numeric($row["Enf2ID"]) && intval($row["Enf2ID"]) > 0){
					$query = " SELECT Nombre FROM Patologia ";
					$query .= " WHERE ID={$row["Enf2ID"]};";
					$result2 = mysql_query($query) or die(mysql_error());
					if($row2 = mysql_fetch_array($result2)){			
						echo "<td>{$row2["Nombre"]}</td>";
					}
					echo "<td>{$row["Enf2Fecha"]}</td>";
				} else {
					echo "<td></td>";	
					echo "<td></td>";	
				}
				
				if(is_numeric($row["Enf3ID"]) && intval($row["Enf3ID"]) > 0){
					$query = " SELECT Nombre FROM Patologia ";
					$query .= " WHERE ID={$row["Enf3ID"]};";
					$result2 = mysql_query($query) or die(mysql_error());
					if($row2 = mysql_fetch_array($result2)){			
						echo "<td>{$row2["Nombre"]}</td>";
					}
					echo "<td>{$row["Enf3Fecha"]}</td>";
				} else {
					echo "<td></td>";	
					echo "<td></td>";	
				}
				
				if(is_numeric($row["Enf4ID"]) && intval($row["Enf4ID"]) > 0){
					$query = " SELECT Nombre FROM Patologia ";
					$query .= " WHERE ID={$row["Enf4ID"]};";
					$result2 = mysql_query($query) or die(mysql_error());
					if($row2 = mysql_fetch_array($result2)){			
						echo "<td>{$row2["Nombre"]}</td>";
					}
					echo "<td>{$row["Enf4Fecha"]}</td>";
				} else {
					echo "<td></td>";	
					echo "<td></td>";	
				}
				
				
				echo "<td>".str_replace(array("S","N"),array("SI","NO"),$row["ExamenOrina"])."</td>";
				echo "<td>{$row["Glice"]}</td>";
				echo "<td>{$row["GliceDiag"]}</td>";
				echo "<td>".str_replace("0000-00-00","",$row["GliceFecha"])."</td>";
				echo "<td>{$row["Glicemia"]}</td>";
				echo "<td>".str_replace("0000-00-00","",$row["GlicemiaFecha"])."</td>";
				echo "<td>{$row["Got"]}</td>";
				echo "<td>{$row["Gpt"]}</td>";
				echo "<td>".str_replace($d1,$d2,$row["Hbs"])."</td>";
				
				echo "<td>".str_replace("0000-00-00","",$row["HbsaFecha"])."</td>";
				echo "<td>".str_replace("0000-00-00","",$row["HemaFecha"])."</td>";		
				echo "<td>{$row["Hematocrito"]}</td>";
				echo "<td>".str_replace("0000-00-00","",$row["HematocritoFecha"])."</td>";
				echo "<td>{$row["HiperDiag"]}</td>";
				echo "<td>".str_replace("0000-00-00","",$row["HiperFecha"])."</td>";
				echo "<td>{$row["Hipertencion"]}</td>";
				echo "<td>".str_replace("0000-00-00","",$row["HipertencionFecha"])."</td>";
				echo "<td>".str_replace($d1,$d2,$row["Hla"])."</td>";
				echo "<td>".str_replace("0000-00-00","",$row["HlaFecha"])."</td>";
				echo "<td>{$row["Imc"]}</td>";
				echo "<td>{$row["Log"]}</td>";
				
				echo "<td>{$row["Pap"]}</td>";
				echo "<td>".str_replace("0000-00-00","",$row["PapFecha"])."</td>";
				echo "<td>{$row["PCD4"]}</td>";
				echo "<td>{$row["PDias"]}</td>";
				echo "<td>{$row["Peso"]}</td>";
				echo "<td>".str_replace($d1,$d2,$row["Ppd"])."</td>";
				echo "<td>".str_replace("0000-00-00","",$row["PpdFecha"])."</td>";
				echo "<td>".str_replace(array("S","N"),array("SI","NO"),$row["PpdTratamiento"])."</td>";
				echo "<td>{$row["PSist"]}</td>";
				echo "<td>".str_replace(array("S","N"),array("SI","NO"),$row["RxTorax"])."</td>";
				echo "<td>".str_replace(array("S","N"),array("SI","NO"),$row["Siges"])."</td>";
				echo "<td>{$row["Sistolica"]}</td>";
				echo "<td>{$row["Talla"]}</td>";
				echo "<td>".str_replace("0000-00-00","",$row["ToxoFecha"])."</td>";
				echo "<td>{$row["Toxoplasmosis"]}</td>";
				echo "<td>{$row["Transaminasas"]}</td>";
				echo "<td>{$row["Tratamiento"]}</td>";
				echo "<td>{$row["Trigi"]}</td>";
				echo "<td>".str_replace($d1,$d2,$row["Vdrl"])."</td>";
				echo "<td>".str_replace("0000-00-00","",$row["VdrlFecha"])."</td>";
				echo "<td>".str_replace($d1,$d2,$row["Vhc"])."</td>";
				echo "<td>".str_replace("0000-00-00","",$row["VhcFecha"])."</td>";
				echo "<td>{$row["Observaciones"]}</td>";
				
				
				//RazonTest
				/*$query = " SELECT RazonTest.Nombre FROM RazonTest, PacienteRazonTest ";
				$query .= " WHERE PacienteRazonTest.PacienteID={$row[22]} AND RazonTest.ID = PacienteRazonTest.RazonTestID;";
				$result2 = mysql_query($query) or die(mysql_error());
				echo "<td>";
				$razones=array();
				while($row2 = mysql_fetch_array($result2)){			
					$razones[]=$row2[0];
				}
				echo implode(" / ", $razones);
				echo "</td>";
				
				//RazonTest
				$query = " SELECT Habito.Nombre FROM Habito, PacienteHabito ";
				$query .= " WHERE PacienteHabito.PacienteID={$row[22]} AND Habito.ID = PacienteHabito.HabitoID;";
				$result2 = mysql_query($query) or die(mysql_error());
				echo "<td>";
				$habitos=array();
				while($row2 = mysql_fetch_array($result2)){			
					$habitos[]=$row2[0];
				}
				echo implode(" / ", $habitos);
				echo "</td>";*/
				/*echo "<td>".str_replace("0000-00-00","",$row[11])."</td>";
				echo "<td>{$row[12]}</td>";
				echo "<td>{$row[13]}</td>";
				echo "<td>".str_replace("0000-00-00","",$row[14])."</td>";
				echo "<td>{$row[15]}</td>";
				echo "<td>".str_replace("0000-00-00","",$row[16])."</td>";
				echo "<td>".str_replace("0000-00-00","",$row[17])."</td>";
				echo "<td>".str_replace("0000-00-00","",$row[18])."</td>";
				echo "<td>".base64_decode($row[19])."</td>";
				echo "<td>{$row[20]}</td>";
				echo "<td>".str_replace("0000-00-00","",$row[21])."</td>";*/
				echo "</tr>";
			}
		}
		mysql_close();
?>
</table>
</body>
</html>