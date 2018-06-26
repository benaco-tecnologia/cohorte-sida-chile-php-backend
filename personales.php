<?php
	set_time_limit(1000);
	ini_set('memory_limit','128M');
	header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
	header("Content-Disposition: attachment; filename=CohorteDatosPersonales.xls");
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Cache-Control: private",false);
?>
<!DOCTYPE html>
<html>
<body>
<h3>Personales</h3>
<table border="1" cellspacing="0" cellpadding="3" width="100%">
	<tr>
    	<th>C&oacute;digo</th>
        <th>Centro</th>
        <th>Sexo</th>
        <th>UsoAnticonceptivo</th>
        <th>PaisOrigen</th>
        <th>NivelEducacional</th>
        <th>Empleo</th>
        <th>Etnia</th>
        <th>PreferenciaSexual</th>
        <th>Comuna</th>
        <th>IdentidadGenero</th>
        <th>RazonTest</th>
        <th>Habitos</th>
        <th>FechaISP</th>
        <th>RegistroISP</th>
        <th>CD4</th>
        <th>FechaNotificacion</th>
        <th>Ficha</th>
        <th>FechaIngreso</th>
        <th>FechaCD4</th>
        <th>FechaEncuesta</th>
        <th>Rut</th>
        <th>FechaNacimiento</th>
		<th>FechaMuerte</th>
	</tr>
<?php
		$username="root";
		$password="r1r7C1h6ZG4ZVWF";
		$database="cohorte";
		//mysql_connect("cohorte.cvssq77sdkiq.sa-east-1.rds.amazonaws.com",$username,$password);
		mysql_connect("cohorte.cbupq68leyb4.us-east-1.rds.amazonaws.com",$username,$password) or die(mysql_error());
		mysql_select_db($database) or die(mysql_error());
		$query = "SELECT Paciente.Codigo, Centro.Nombre, Sexo.Nombre, UsoAnticonceptivo.Nombre, ";
		$query .= " PaisOrigen.Nombre, NivelEducacional.Nombre, Empleo.Nombre, Etnia.Nombre, ";
		$query .= " PreferenciaSexual.Nombre, Comuna.Nombre, IdentidadGenero.Nombre, ";
		$query .= " FechaISP, RegistroISP, CD4, FechaNotificacion, Ficha, FechaIngreso, FechaCD4, FechaEncuesta, Rut, DV, FechaNacimiento, Paciente.ID, Muerte.Fecha ";
		$query .= " FROM Paciente ";
		$query .= " LEFT JOIN Sexo ON Paciente.SexoID=Sexo.ID ";
		$query .= " LEFT JOIN Centro ON Paciente.CentroID=Centro.ID ";
		$query .= " LEFT JOIN FactorRiesgo ON Paciente.FactorRiesgoID=FactorRiesgo.ID ";
		$query .= " LEFT JOIN UsoAnticonceptivo ON Paciente.UsoAnticonceptivoID=UsoAnticonceptivo.ID ";
		$query .= " LEFT JOIN PaisOrigen ON Paciente.PaisOrigenID=PaisOrigen.ID ";
		$query .= " LEFT JOIN NivelEducacional ON Paciente.NivelEducacionalID=NivelEducacional.ID ";
		$query .= " LEFT JOIN Empleo ON Paciente.EmpleoID=Empleo.ID ";
		$query .= " LEFT JOIN Etnia ON Paciente.EtniaID=Etnia.ID ";
		$query .= " LEFT JOIN PreferenciaSexual ON Paciente.PreferenciaSexualID=PreferenciaSexual.ID ";
		$query .= " LEFT JOIN Comuna ON Paciente.ComunaID=Comuna.ID ";
		$query .= " LEFT JOIN IdentidadGenero ON Paciente.IdentidadGeneroID=IdentidadGenero.ID ";
		$query .= " LEFT JOIN Muerte ON Paciente.ID=Muerte.PacienteID ";
		if(isset($_GET["c"]) && is_numeric($_GET["c"])){
			$query .= " WHERE Paciente.CentroID={$_GET["c"]}";
		}
		$query .= " ORDER BY Paciente.Codigo ";
		//$query .= " LIMIT 500;";
		$result = mysql_query($query) or die(mysql_error());
		if(mysql_num_rows($result)>0){
			while($row = mysql_fetch_array($result)){
				echo "<tr>";
				echo "<td>{$row[0]}</td>";
				echo "<td>{$row[1]}</td>";
				echo "<td>{$row[2]}</td>";
				echo "<td>{$row[3]}</td>";
				echo "<td>{$row[4]}</td>";
				echo "<td>{$row[5]}</td>";
				echo "<td>{$row[6]}</td>";
				echo "<td>{$row[7]}</td>";
				echo "<td>{$row[8]}</td>";
				echo "<td>{$row[9]}</td>";
				echo "<td>{$row[10]}</td>";
				//RazonTest
				$query = " SELECT RazonTest.Nombre FROM RazonTest, PacienteRazonTest ";
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
				echo "</td>";
				echo "<td>".str_replace("0000-00-00","",$row[11])."</td>";
				echo "<td>{$row[12]}</td>";
				echo "<td>{$row[13]}</td>";
				echo "<td>".str_replace("0000-00-00","",$row[14])."</td>";
				echo "<td>{$row[15]}</td>";
				echo "<td>".str_replace("0000-00-00","",$row[16])."</td>";
				echo "<td>".str_replace("0000-00-00","",$row[17])."</td>";
				echo "<td>".str_replace("0000-00-00","",$row[18])."</td>";
				echo "<td>".base64_encode($row[19].base64_encode($row[20]))."</td>";
				echo "<td>".str_replace("0000-00-00","",$row[21])."</td>";
				echo "<td>".str_replace("0000-00-00","",$row[23])."</td>";
				echo "</tr>";
			}
		}
		mysql_close();
?>
</table>
</body>
</html>