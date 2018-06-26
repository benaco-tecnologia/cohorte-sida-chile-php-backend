<?php
	set_time_limit(1000);
	ini_set('memory_limit','128M');
	header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
	header("Content-Disposition: attachment; filename=CohorteTerapias.xls");
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Cache-Control: private",false);
	$d1=array("PO","NN","NE","ND","NS");
	$d2=array("POSITIVO","NO DISPONIBLE NO SOLICITADO","NEGATIVO","NO DISPONIBLE","NO DISPONIBLE SOLICITADO");
	
	
	$NoContinua=array("SD","CA","SU");
	$NoContinua2=array("SIN DATOS","CAMBIO","SUSPENDIO");
?>
<!DOCTYPE html>
<html>
<body>
<h3>Terapias</h3>
<table border="1" cellspacing="0" cellpadding="3" width="100%">
	<tr>
    	<th>C&oacute;digo</th>
        <th>Centro</th>
        <th>Numero</th>
        <th>Fecha</th>
        <th>Droga 1</th>
        <th>Droga 2</th>
        <th>Droga 3</th>
        <th>Droga 4</th>
        <th>Droga 5</th>
        <th>Droga 6</th>
        <th>NoContinua</th>
        <th>CausaTermino</th>
        <th>RazonToxicidad</th>
        <th>FechaTermino</th>
         <th>Geno</th>
         <th>GenoFecha</th>
         <th>GenoObs</th>
         <th>Tropismo Viral</th>
         <th>Observacion</th>
        
	</tr>
<?php
		$username="root";
		$password="r1r7C1h6ZG4ZVWF";
		$database="cohorte";
		//mysql_connect("cohorte.cvssq77sdkiq.sa-east-1.rds.amazonaws.com",$username,$password);
		mysql_connect("cohorte.cbupq68leyb4.us-east-1.rds.amazonaws.com",$username,$password) or die(mysql_error());
		mysql_select_db($database) or die(mysql_error());
		$query = "SELECT Paciente.Codigo, Centro.Nombre, Terapia.*, RazonToxicidad.Nombre as RazonToxicidad, CausaTermino.Nombre as CausaTermino";
		$query .= " FROM Paciente ";
		$query .= " LEFT JOIN Centro ON Paciente.CentroID=Centro.ID ";	
		$query .= " LEFT JOIN Terapia ON Paciente.ID=Terapia.PacienteID ";	
		$query .= " LEFT JOIN RazonToxicidad ON RazonToxicidad.ID=Terapia.RazonToxicidadID ";
		$query .= " LEFT JOIN CausaTermino ON CausaTermino.ID=Terapia.CausaTerminoID ";
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
				//Terapias
				echo "<td>{$row["NumeroTar"]}</td>";
				echo "<td>{$row["Fecha"]}</td>";
				
				if($row["ID"]!=null&&$row["ID"]!=""){
					$query = " SELECT Droga.Nombre FROM TerapiaDroga, Droga ";
					$query .= " WHERE TerapiaDroga.TerapiaID={$row["ID"]} AND TerapiaDroga.DrogaID = Droga.ID ORDER BY TerapiaDroga.Numero LIMIT 6;";
					$result2 = mysql_query($query) or die(mysql_error());
					while($row2 = mysql_fetch_array($result2)){			
						echo "<td>{$row2[0]}</td>";
					}
					for($i=mysql_num_rows($result2)+1;$i<=6;$i++){
						echo "<td></td>";
					}
				}else{
					echo "<td></td>";
					echo "<td></td>";
					echo "<td></td>";
					echo "<td></td>";
					echo "<td></td>";
					echo "<td></td>";	
				}
				echo "<td>".str_replace($NoContinua,$NoContinua2,$row["NoContinua"])."</td>";
				echo "<td>{$row["CausaTermino"]}</td>";
				echo "<td>{$row["RazonToxicidad"]}</td>";
				echo "<td>{$row["FechaTermino"]}</td>";
				echo "<td>{$row["Geno"]}</td>";
				echo "<td>{$row["GenoFecha"]}</td>";
				echo "<td>{$row["GenoObs"]}</td>";
				echo "<td>".str_replace($d1,$d2,$row["Tropismo"])."</td>";
				echo "<td>{$row["Observacion"]}</td>";
				echo "</tr>";
			}
		}
		mysql_close();
?>
</table>
</body>
</html>