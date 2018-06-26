<?php
	set_time_limit(1000);
	ini_set('memory_limit','128M');
	header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
	header("Content-Disposition: attachment; filename=CohorteRegistroModificacioness.xls");
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Cache-Control: private",false);
?>
<!DOCTYPE html> 
<html>
<body>
<h3>Registro de Modificaciones</h3>
<table border="1" cellspacing="0" cellpadding="3" width="100%">
	<tr>
    	<th>Nombre</th>
		<th>Usuario</th>
        <th nowrap>Centro Usuario</th>
		<th>Codigo</th>
        <th>Sección</th>
		<th>Acción</th>
        <th>Fecha</th>
		<th>Hora</th>
	</tr>
<?php
		$username="root";
		$password="r1r7C1h6ZG4ZVWF";
		$database="cohorte";
		//mysql_connect("cohorte.cvssq77sdkiq.sa-east-1.rds.amazonaws.com",$username,$password);
		mysql_connect("cohorte.cbupq68leyb4.us-east-1.rds.amazonaws.com",$username,$password) or die(mysql_error());
		mysql_select_db($database) or die(mysql_error());
		$query = "SELECT UPPER(Usuario.Nombre), UPPER(Usuario.Apellido), UPPER(Usuario.NombreUsuario), registro_modificaciones.Fecha,UPPER(NivelUsuario.Nombre),Usuario.NivelUsuarioID,Usuario.ID, UPPER(registro_modificaciones.seccion), registro_modificaciones.accion,registro_modificaciones.paciente_id,registro_modificaciones.identificador ";
		$query .= " FROM registro_modificaciones ";
		$query .= " LEFT JOIN Usuario ON registro_modificaciones.usuario_id=Usuario.ID ";
		$query .= " LEFT JOIN NivelUsuario ON Usuario.NivelUsuarioID=NivelUsuario.ID ";
		$query .= " WHERE registro_modificaciones.usuario_id NOT IN (1,48) ";
		$query .= " ORDER BY registro_modificaciones.Fecha DESC ";
		$result = mysql_query($query) or die(mysql_error());
		if(mysql_num_rows($result)>0){
			while($row = mysql_fetch_array($result)){
				$fecha=strtotime($row[3]);
				echo "<tr>";
				echo "<td nowrap>{$row[0]} ";
				echo "{$row[1]}</td>";
				echo "<td nowrap>{$row[2]}</td>";
				if($row[5]=="1"){
					echo "<td nowrap>TODOS</td>";
				}else{
					$query = " SELECT Centro.Nombre FROM Permiso,Centro ";
					$query .= " WHERE Permiso.UsuarioID={$row[6]} AND Permiso.CentroID=Centro.ID;";
					$result2 = mysql_query($query) or die(mysql_error());
					if($row2 = mysql_fetch_array($result2)){			
						echo "<td nowrap>{$row2[0]}</td>";
					}else{
						echo "<td nowrap>SIN DATOS</td>";
					}
				}
				
				$query2="";
				if($row[7]=="PACIENTE"&&@$row[9]!=""){
					$query2="select UPPER(Paciente.Codigo) from Paciente where ID={$row[9]}";
				}elseif($row[7]=="BASALES"&&@$row[10]!=""){
					$query2="select UPPER(Paciente.Codigo) from DatoBasal,Paciente where DatoBasal.ID={$row[10]} AND DatoBasal.PacienteID=Paciente.ID;";
				}elseif($row[7]=="CONTROLES"&&@$row[10]!=""){
					$query2="select UPPER(Paciente.Codigo) from Control,Paciente where Control.ID={$row[10]} AND Control.PacienteID=Paciente.ID;";
				}elseif($row[7]=="LABORATORIO"&&@$row[10]!=""){
					$query2="select UPPER(Paciente.Codigo) from Laboratorio,Paciente where Laboratorio.ID={$row[10]} AND Laboratorio.PacienteID=Paciente.ID;";
				}elseif($row[7]=="TERAPIA"&&@$row[10]!=""){
					$query2="select UPPER(Paciente.Codigo) from Terapia,Paciente where Terapia.ID={$row[10]} AND Terapia.PacienteID=Paciente.ID;";
				}elseif($row[7]=="SEGUIMIENTO"&&@$row[10]!=""){
					$query2="select UPPER(Paciente.Codigo) from Seguimiento,Paciente where Seguimiento.ID={$row[10]} AND Seguimiento.PacienteID=Paciente.ID;"; 
				}else{
					continue;
				}
				$codigo="";
				$result2=mysql_query($query2) or die(mysql_error());
				if(mysql_num_rows($result2)>0){
					$row2=mysql_fetch_array($result2);
					$codigo=$row2[0];
					$codigo=str_replace(" ","",$codigo);
				}
				echo "<td>$codigo</td>";
				echo "<td>{$row[7]}</td>";
				if($row[8]=="I"){
					echo "<td>INGRESO</td>";
				}else{
					echo "<td>ACTUALIZACION</td>";
				}
				//echo "<td>{$row[8]}</td>";
				echo "<td nowrap>".date("d-m-Y",$fecha)."</td>";
				if($fecha>=1452553200&&$fecha<1457046000){
					echo "<td nowrap>".date("h:i A",$fecha-60*60*3)."</td>";
				}else{
					echo "<td nowrap>".date("h:i A",$fecha)."</td>";
				}
				
				echo "</tr>";
			}
		}
		mysql_close();
?>
</table>
</body>
</html>