<?php
	set_time_limit(1000);
	ini_set('memory_limit','128M');
	header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
	header("Content-Disposition: attachment; filename=CohorteLaboratorios.xls");
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
<h3>Laboratorios</h3>
<table border="1" cellspacing="0" cellpadding="3" width="100%">
	<tr>
    	<th>C&oacute;digo</th>
        <th>Centro</th>
		<th>Tipo</th>
        <th>Numero</th>
        <th>Fecha</th>
        <th>Diagnostico</th>
        <th>Sistolica</th>
        <th>Diastolica</th>
         <th>ColesTotal</th>
		 <th>ColesLdh</th>
		 <th>ColesHdl</th>
		 <th>Trigli</th>
		 <th>Glice</th>
		 <th>Peso</th>
        <th>Hematocrito</th>
		<th>Gpt</th>
		<th>Got</th>
	</tr>
<?php
		$username="root";
		$password="r1r7C1h6ZG4ZVWF";
		$database="cohorte";
		//mysql_connect("cohorte.cvssq77sdkiq.sa-east-1.rds.amazonaws.com",$username,$password);
		mysql_connect("cohorte.cbupq68leyb4.us-east-1.rds.amazonaws.com",$username,$password) or die(mysql_error());
		mysql_select_db($database) or die(mysql_error());
		$query = "SELECT Paciente.Codigo as Codigo, Centro.Nombre as Centro, Laboratorio.*";
		$query .= " FROM Paciente ";
		$query .= " LEFT JOIN Centro ON Paciente.CentroID=Centro.ID ";	
		$query .= " LEFT JOIN Laboratorio ON Paciente.ID=Laboratorio.PacienteID ";
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
				echo "<td>{$row["Codigo"]}</td>";
				//Centro
				echo "<td>{$row["Centro"]}</td>";
				//Controles
				if($row["Tipo"]=="HI"){
					echo "<td>HIPERTENSIÓN ARTERIAL</td>";
				}elseif($row["Tipo"]=="DI"){
					echo "<td>DISLIPIDEMIA</td>";
				}elseif($row["Tipo"]=="GL"){
					echo "<td>GLICEMIA Y DIABETES</td>";
				}elseif($row["Tipo"]=="HE"){
					echo "<td>HEMATOCRITO Y TRANSAMINASAS</td>";
				}else{
					echo "<td></td>";
				}
				
				echo "<td>{$row["NumeroControl"]}</td>";
				echo "<td>".str_replace("0000-00-00","",$row["Fecha"])."</td>";
				
				echo "<td>{$row["Diagnostico"]}</td>";
				echo "<td>{$row["Sistolica"]}</td>";
				echo "<td>{$row["Diastolica"]}</td>";
				echo "<td>{$row["ColesTotal"]}</td>";
				echo "<td>{$row["ColesLdh"]}</td>";
				echo "<td>{$row["ColesHdl"]}</td>";
				echo "<td>{$row["Trigli"]}</td>";
				echo "<td>{$row["Glice"]}</td>";
				echo "<td>{$row["Peso"]}</td>";
				echo "<td>{$row["Hematocrito"]}</td>";
				echo "<td>{$row["Gpt"]}</td>";
				echo "<td>{$row["Got"]}</td>";
				echo "</tr>";
			}
		}
		mysql_close();
?>
</table>
</body>
</html>