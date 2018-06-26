<?php
	set_time_limit(1000);
	ini_set('memory_limit','128M');
	header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
	header("Content-Disposition: attachment; filename=CohorteSeguimiento.xls");
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
<h3>Seguimiento</h3>
<table border="1" cellspacing="0" cellpadding="3" width="100%">
	<tr>
    	<th>C&oacute;digo</th>
        <th>Centro</th>
		<th>Tipo</th>
        <th>Numero</th>
        <th>Fecha</th>
        <th>Examen</th>
		 <th>Enfermedad</th>
        <th>Tratamiento</th>
        <th>CVHepatitis</th>
         <th>Antigeno</th>
		 <th>FechaControl</th>
		 <th>Observacion</th>
	</tr>
<?php
		$username="root";
		$password="r1r7C1h6ZG4ZVWF";
		$database="cohorte";
		//mysql_connect("cohorte.cvssq77sdkiq.sa-east-1.rds.amazonaws.com",$username,$password);
		mysql_connect("cohorte.cbupq68leyb4.us-east-1.rds.amazonaws.com",$username,$password) or die(mysql_error());
		mysql_select_db($database) or die(mysql_error());
		$query = "SELECT Paciente.Codigo as Codigo, Centro.Nombre as Centro, Seguimiento.*, Patologia.Nombre as Enfermedad ";
		$query .= " FROM Paciente ";
		$query .= " LEFT JOIN Centro ON Paciente.CentroID=Centro.ID ";	
		$query .= " LEFT JOIN Seguimiento ON Paciente.ID=Seguimiento.PacienteID ";
		$query .= " LEFT JOIN Patologia ON Patologia.ID=Seguimiento.PatologiaID ";
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
				if($row["Tipo"]=="EA"){
					echo "<td>ENFERMEDADES ASOCIADAS</td>";
				}elseif($row["Tipo"]=="SE"){
					echo "<td>SEROLOGÍAS</td>";
				}elseif($row["Tipo"]=="CM"){
					echo "<td>CONTROL MÉDICO</td>";
				}elseif($row["Tipo"]=="CO"){
					echo "<td>CONTROL VHB</td>";
				}else{
					echo "<td></td>";
				}
				
				echo "<td>{$row["NumeroControl"]}</td>";
				echo "<td>".str_replace("0000-00-00","",$row["Fecha"])."</td>";
				
				echo "<td>";
				switch($row["Examen"]){
					case 'VH':
						echo "VHC";
						break;
					case 'VD':
						echo "VDRL";
						break;
					case 'CH':
						echo "CHAGAS";
						break;
					case 'PA':
						echo "PAP";
						break;
					case 'HB':
						echo "HDSAG";
						break;
				}
				echo "</td>";
				
				
				echo "<td>{$row["Enfermedad"]}</td>";
				if($row["Tratamiento"]=="S"){
					echo "<td>SI</td>";
				}elseif($row["Tratamiento"]=="N"){
					echo "<td>NO</td>";
				}else{
					echo "<td></td>";
				}
				echo "<td>{$row["CVHepatitis"]}</td>";
				if($row["Antigeno"]=="P"){
					echo "<td>POSITIVO</td>";
				}elseif($row["Antigeno"]=="N"){
					echo "<td>NEGATIVO</td>";
				}else{
					echo "<td></td>";
				}
				echo "<td>".str_replace("0000-00-00","",$row["FechaControl"])."</td>";
				echo "<td>{$row["Observacion"]}</td>";
				echo "</tr>";
			}
		}
		mysql_close();
?>
</table>
</body>
</html>