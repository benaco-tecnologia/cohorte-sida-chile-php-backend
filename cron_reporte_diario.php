<?php
	set_time_limit(1000);
	ini_set('memory_limit','128M');
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Cache-Control: private",false);
	$dia_actual=date("Y-m-d",strtotime("-1 days"));
	$dia_actual_mail=date("d-m-Y",strtotime("-1 days"));
	$body = "";

$body.='<html>';
$body.='<body>';
$body.="<p>A continuación se detallan los accesos a la plataforma y las moficiaciones realizadas por los usuarios en la <a href='http://cohorte.salmonsoftware.cl'>Plataforma de Cohorte</a> el día $dia_actual_mail</p>\r\n";
$body.='<h3>Registro Accesos</h3>';
$body.='<table border="1" cellspacing="0" cellpadding="5" width="100%">';
$body.='	<tr style="color: #ffffff;background-color: #1c7dfa;">';
 $body.="   	<th>Nombre</th>\r\n";
$body.="		<th>Usuario</th>\r\n";
   $body.="     <th nowrap>Centro Usuario</th>\r\n";
    $body.="    <th>Nivel</th>\r\n";
     $body.="   <th>Fecha</th>\r\n";
		$body.="<th>Hora</th>\r\n";
$body.="	</tr>\r\n";

		$username="root";
		$password="r1r7C1h6ZG4ZVWF";
		$database="cohorte";
		//mysql_connect("cohorte.cvssq77sdkiq.sa-east-1.rds.amazonaws.com",$username,$password);
		mysql_connect("cohorte.cbupq68leyb4.us-east-1.rds.amazonaws.com",$username,$password) or die(mysql_error());
		mysql_select_db($database) or die(mysql_error());
		$query = "SELECT UPPER(Usuario.Nombre), UPPER(Usuario.Apellido), UPPER(Usuario.NombreUsuario), UsuarioRegistro.Fecha,UPPER(NivelUsuario.Nombre),Usuario.NivelUsuarioID,Usuario.ID ";
		$query .= " FROM UsuarioRegistro ";
		$query .= " LEFT JOIN Usuario ON UsuarioRegistro.UsuarioID=Usuario.ID ";
		$query .= " LEFT JOIN NivelUsuario ON Usuario.NivelUsuarioID=NivelUsuario.ID ";
		$query .= " WHERE UsuarioRegistro.UsuarioID NOT IN (1,48) ";
		$query .= " AND UsuarioRegistro.Fecha BETWEEN '$dia_actual 00:00:00' AND '$dia_actual 23:59:59' ";
		$query .= " ORDER BY UsuarioRegistro.Fecha DESC ";
		//echo $query;
		$result = mysql_query($query);// or die(mysql_error());
		if(mysql_num_rows($result)>0){
			while($row = mysql_fetch_array($result)){
				$fecha=strtotime($row[3]);
				$body.="<tr>\r\n";
				$body.= "<td nowrap> {$row[0]} {$row[1]} </td>\r\n";
				$body.="<td nowrap> {$row[2]} </td>\r\n";
				if($row[5]=="1"){
					$body.= "<td nowrap> TODOS </td>\r\n";
				}else{
					$query = " SELECT Centro.Nombre FROM Permiso,Centro ";
					$query .= " WHERE Permiso.UsuarioID={$row[6]} AND Permiso.CentroID=Centro.ID;";
					$result2 = mysql_query($query);// or die(mysql_error());
					if($row2 = mysql_fetch_array($result2)){			
						$body.= "<td nowrap> {$row2[0]} </td>\r\n";
					}else{
						$body.= "<td nowrap> SIN DATOS </td>\r\n";
					}
				}
				$body.= "<td nowrap> {$row[4]} </td>\r\n";;
				$body.= "<td nowrap> ".date("d-m-Y",$fecha)." </td>\r\n";
				$body.= "<td nowrap> ".date("h:i A",$fecha)." </td>\r\n";
				$body.= "</tr>";
			}
		}
$body.="<tr> <td colspan='6' align='center'> Total Accesos día ". $dia_actual_mail .": <strong> ".mysql_num_rows($result)."</strong> </td> </tr>\r\n";
$body.='</table>';
$body.='<h3>Registro de Modificaciones</h3>';
$body.='<table border="1" cellspacing="0" cellpadding="5" width="100%">';
$body.='	<tr style="color: #ffffff;background-color: #1c7dfa;">';
 $body.='   	<th>Nombre</th>';
$body.='		<th>Usuario</th>';
  $body.='      <th nowrap>Centro Ususario</th>';
  $body.='      <th>Codigo</th>';
	$body.='	<th>Sección</th>';
	$body.='	<th>Acción</th>';
   $body.='     <th>Fecha</th>';
	$body.='	<th>Hora</th>';
	$body.='</tr>';
		//$dia_actual=date("Y-m-d",strtotime("-21 hours"));
		$query = "SELECT UPPER(Usuario.Nombre), UPPER(Usuario.Apellido), UPPER(Usuario.NombreUsuario), registro_modificaciones.Fecha,UPPER(NivelUsuario.Nombre),Usuario.NivelUsuarioID,Usuario.ID, UPPER(registro_modificaciones.seccion), registro_modificaciones.accion,registro_modificaciones.paciente_id,registro_modificaciones.identificador ";
		$query .= " FROM registro_modificaciones ";
		$query .= " LEFT JOIN Usuario ON registro_modificaciones.usuario_id=Usuario.ID ";
		$query .= " LEFT JOIN NivelUsuario ON Usuario.NivelUsuarioID=NivelUsuario.ID ";
		$query .= " WHERE registro_modificaciones.usuario_id NOT IN (1,48) ";
		$query .= " AND registro_modificaciones.Fecha between '$dia_actual 00:00:00' AND '$dia_actual 23:59:59' ";
		$query .= " ORDER BY registro_modificaciones.Fecha DESC ";
		$result = mysql_query($query);// or die(mysql_error());
		$i=0;
		if(mysql_num_rows($result)>0){
			while($row = mysql_fetch_array($result)){
				// Obtención de datos de paciente
				$query2="";
				if($row[7]=="PACIENTE"){
					$query2="select UPPER(Paciente.Codigo) from Paciente where ID={$row[9]}";
				}elseif($row[7]=="BASALES"){
					$query2="select UPPER(Paciente.Codigo) from DatoBasal,Paciente where DatoBasal.ID={$row[10]} AND DatoBasal.PacienteID=Paciente.ID;";
				}elseif($row[7]=="CONTROLES"){
					$query2="select UPPER(Paciente.Codigo) from Control,Paciente where Control.ID={$row[10]} AND Control.PacienteID=Paciente.ID;";
				}elseif($row[7]=="LABORATORIO"){
					$query2="select UPPER(Paciente.Codigo) from Laboratorio,Paciente where Laboratorio.ID={$row[10]} AND Laboratorio.PacienteID=Paciente.ID;";
				}elseif($row[7]=="TERAPIA"){
					$query2="select UPPER(Paciente.Codigo) from Terapia,Paciente where Terapia.ID={$row[10]} AND Terapia.PacienteID=Paciente.ID;";
				}elseif($row[7]=="SEGUIMIENTO"){
					$query2="select UPPER(Paciente.Codigo) from Seguimiento,Paciente where Seguimiento.ID={$row[10]} AND Seguimiento.PacienteID=Paciente.ID;"; 
				}
				$codigo="";
				$result2=@mysql_query($query2);// or die(mysql_error());
				if(@mysql_num_rows($result2)>0){
					$row2=mysql_fetch_array($result2);
					$codigo=$row2[0];
				}
				$i++;
				if($codigo==""){
					continue;	
				}
				
				$fecha=strtotime($row[3]);
				$body.= "<tr> \r\n";
				$body.= "<td nowrap> {$row[0]} {$row[1]} </td>\r\n";
				$body.= "<td nowrap> {$row[2]} </td>\r\n";
				if($row[5]=="1"){
					$body.= "<td>TODOS</td>\r\n";
				}else{
					$query = " SELECT Centro.Nombre FROM Permiso,Centro ";
					$query .= " WHERE Permiso.UsuarioID={$row[6]} AND Permiso.CentroID=Centro.ID;";
					$result2 = mysql_query($query);// or die(mysql_error());
					if($row2 = mysql_fetch_array($result2)){			
						$body.= "<td nowrap> {$row2[0]} </td>\r\n";
					}else{
						$body.= "<td nowrap> SIN DATOS </td>\r\n";
					}
				}
				$body.= "<td nowrap> ".$codigo." </td>\r\n";
				$body.= "<td> ".$row[7]." </td>\r\n";
				if($row[8]=="I"){
					$body.= "<td> INGRESO </td>\r\n";
				}else{
					$body.= "<td> ACTUALIZACION </td>\r\n";
				}
				//echo "<td>{$row[8]}</td>";
				//$body.= "<td nowrap> ".date("d-m-Y",$fecha-60*60*3)." </td>\r\n";
				//$body.= "<td nowrap> ".date("h:i A",$fecha-60*60*3)." </td>\r\n";
				
				$body.= "<td nowrap> ".date("d-m-Y",$fecha)." </td>\r\n";
				$body.= "<td nowrap> ".date("h:i A",$fecha)." </td>\r\n";
				/*if($fecha>=1452553200){
					$body.= "<td nowrap> ".date("h:i A",$fecha-60*60*3)." </td>\r\n";
				}else{
					$body.= "<td nowrap> ".date("h:i A",$fecha)." </td>\r\n";
				}*/
				
				$body.= "</tr>";
			}
		}
		mysql_close();
		$body.="<tr> <td colspan='8' align='center'> Total Ingresos y Modificaciones día ". $dia_actual_mail .": <strong> ".$i."</strong> </td> </tr>\r\n";
		$body.="</table>\r\n";
		$body.="</body>\r\n";
		$body.="</html>\r\n";
	$destinatario = "soporte@sidachile.cl"; 
	//echo $body;
	//$destinatario = "daniel.fuentes.b@gmail.com"; 
	$asunto = "Reporte Diario $dia_actual_mail"; 
	$headers = "MIME-Version: 1.0\r\n"; 
	$headers .= "Content-type: text/html; charset=iso-8859-1\r\n"; 
	$headers .= "From: Plataforma Cohorte <alertas@salmonsoftware.cl>\r\n"; 
	$headers .= "Reply-To: daniel@salmonsoftware.cl\r\n";
	$headers .= "Cc: ggomez@ei.cl,amce08@yahoo.es,daniel@salmonsoftware.cl\r\n"; 
	$headers .= 'X-Mailer: PHP/' . phpversion();
	mail($destinatario,$asunto,$body,$headers);
	//echo "OK";
?>