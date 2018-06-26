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
	<form action="carga_fichas.php" method="POST" enctype="multipart/form-data">
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
		<td>#</td>
		<td>Código</td>
		<td>Centro Archivo</td>
		<td>Centro Base Datos</td>
	</tr>
<?php
	$i=0;
	$username="root";
	$password="r1r7C1h6ZG4ZVWF"; 
	$database="cohorte";
	$link = mysqli_connect("cohorte.cbupq68leyb4.us-east-1.rds.amazonaws.com",$username,$password);
	mysqli_select_db($link, $database) or die(mysqli_error());
	if (($handle = fopen("carga_20161116.csv", "r")) !== FALSE) {
		while ($data = fgets($handle)) {
			if($i++==50){
				//break;
			}
			$num = count($data);
			echo "<tr>";
			//for ($c=0; $c < $num; $c++) {
				echo "<td>$i</td>";
				$tmp = explode(";", $data);
				//print_r($tmp);
				$codigo = trim(strtoupper($tmp[0]));
				$codigo = str_replace(" ","",$codigo);
				//$centro = trim(strtoupper($tmp[2]));
				$centroID = trim(strtoupper($tmp[1]));
				/*$fecha_nacimiento = date("Y-m-d",strtotime(trim(strtoupper($tmp[7]))));
				$fecha_ingreso = date("Y-m-d",strtotime(trim(strtoupper($tmp[13]))));
				$fecha_isp = date("Y-m-d",strtotime(trim(strtoupper($tmp[12]))));
				
				
				$ficha = "'".trim(strtoupper($tmp[3]))."'";
				$cd4 = trim(strtoupper($tmp[14]));
				$paisorigen = trim(strtoupper($tmp[9]));
				$sexo = trim(strtoupper($tmp[10]));
				if($sexo="MASCULINO"){$sexo=2;}
				elseif($sexo="FEMENINO"){$sexo=1;}
				else{$sexo="NULL";}
				
				if(!is_numeric($cd4)){
					$cd4 = "NULL";
				}
				
				if($ficha=="''"){
					$ficha = "NULL";
				}
				
				$codigo=str_replace(" ","",$codigo);
				$query = "SELECT ID FROM cohorte.Centro where Codigo='$centro';";
				$result = mysqli_query($link, $query);
				if($row = mysqli_fetch_assoc($result)){
					$centroID = $row["ID"];
				}else{
					$centroID = 0;
				}
				
				
				$query = "SELECT ID FROM cohorte.PaisOrigen where Nombre='$paisorigen';";
				$result = mysqli_query($link, $query);
				if($row = mysqli_fetch_assoc($result)){
					$paisorigen = $row["ID"];
				}else{
					$paisorigen = "NULL";
				}
				
				$preferenciasexual = trim(strtoupper($tmp[11]));
				$query = "SELECT ID FROM cohorte.PreferenciaSexual where Nombre='$preferenciasexual';";
				$result = mysqli_query($link, $query);
				if($row = mysqli_fetch_assoc($result)){
					$preferenciasexual = $row["ID"];
				}else{
					$preferenciasexual = "NULL";
				}
				
				$usoanticonceptivo = trim(strtoupper($tmp[16]));
				$query = "SELECT ID FROM cohorte.UsoAnticonceptivo where Nombre='$usoanticonceptivo';";
				$result = mysqli_query($link, $query);
				if($row = mysqli_fetch_assoc($result)){
					$usoanticonceptivo = $row["ID"];
				}else{
					$usoanticonceptivo = "NULL";
				}
				
				$empleo = trim(strtoupper($tmp[18]));
				$query = "SELECT ID FROM cohorte.Empleo where Nombre='$empleo';";
				$result = mysqli_query($link, $query);
				if($row = mysqli_fetch_assoc($result)){
					$empleo = $row["ID"];
				}else{
					$empleo = "NULL";
				}
				
				$niveleducacional = trim(strtoupper($tmp[17]));
				$query = "SELECT ID FROM cohorte.NivelEducacional where Nombre='$niveleducacional';";
				$result = mysqli_query($link, $query);
				if($row = mysqli_fetch_assoc($result)){
					$niveleducacional = $row["ID"];
				}else{
					$niveleducacional = "NULL";
				}
				
				$etnia = trim(strtoupper($tmp[19]));
				$query = "SELECT ID FROM cohorte.Etnia where Nombre='$etnia';";
				$result = mysqli_query($link, $query);
				if($row = mysqli_fetch_assoc($result)){
					$etnia = $row["ID"];
				}else{
					$etnia = "NULL";
				}
				
				// Rut
				$rut = trim(strtoupper($tmp[6]));
				$rut = explode("-", $rut);
				$dv = "";
				if(is_array($rut)){
					$dv = "'".trim(strtoupper($rut[1]))."'";
					$rut = "TO_BASE64('".trim(strtoupper($rut[0]))."')";
				}else{
					$rut = "NULL";
					$dv = "NULL";
				}
				
				if($dv=="''"){
					$dv = "NULL";
				}
				
				if($rut=="TO_BASE64('')"){
					$rut = "NULL";
				}
				*/
				$query = "INSERT INTO Paciente (Codigo,CentroID) VALUES ('$codigo',$centroID);";
				mysqli_query($link, $query) or print_r(mysqli_error($link));
				$query = "UPDATE Paciente SET CentroID=$centroID where Codigo='$codigo';";
				mysqli_query($link, $query) or print_r(mysqli_error($link));
				echo "<td style=\"background-color:red;color:white;\">$query</td>";
				/*
				$query = "SELECT ID, Codigo, CentroID from Paciente WHERE TRIM(UPPER(Codigo))='$codigo'";
				$result = mysqli_query($link, $query);
				if($row = mysqli_fetch_assoc($result)){
					//$query = "UPDATE Paciente SET CentroID=$centroID WHERE Codigo='$codigo';";
					$query = "UPDATE Paciente SET FechaNacimiento='$fecha_nacimiento', FechaIngreso='$fecha_ingreso', FechaISP='$fecha_isp', Ficha=$ficha, CD4=$cd4, SexoID=$sexo, PaisOrigenID=$paisorigen, PreferenciaSexualID=$preferenciasexual, UsoAnticonceptivoID=$usoanticonceptivo, EmpleoID=$empleo, NivelEducacionalID=$niveleducacional, EtniaID=$etnia, Rut=$rut, DV=$dv WHERE ID={$row["ID"]};";
					mysqli_query($link, $query);
					echo "<td style=\"background-color:red;color:white;\">$query</td>";
					
					$query = "SELECT ID, PacienteID from DatoBasal WHERE PacienteID={$row["ID"]};";
					$result2 = mysqli_query($link, $query);
					if($row2 = mysqli_fetch_assoc($result2)){
						
					}else{
						$query = "INSERT INTO DatoBasal (PacienteID) VALUES ({$row["ID"]})";
						mysqli_query($link, $query);
					}
					
				}else{
					$query = "INSERT INTO Paciente (Codigo,CentroID) VALUES ('$codigo',$centroID);";
					//mysqli_query($link, $query);
					echo "<td style=\"background-color:red;color:white;\">$query</td>";
				}*/
			//}
			echo "</tr>";
		}
	}
	mysqli_close();
?>
</table>
</body>
</html>