<?php
	set_time_limit(1000);
	ini_set('memory_limit','128M');
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Cache-Control: private",false);
?>
<!DOCTYPE html> 
<html>
<body>
<?php
		$username="root";
		$password="r1r7C1h6ZG4ZVWF";
		$database="cohorte";
		mysql_connect("cohorte.cvssq77sdkiq.sa-east-1.rds.amazonaws.com",$username,$password);
		mysql_select_db($database) or die( "Unable to select database");
		$query = "select TerapiaID from TerapiaDroga group by TerapiaID;";
		$result = mysql_query($query) or die(mysql_error());
		$terapias[]=array();
		if(mysql_num_rows($result)>0){
			while($row = mysql_fetch_array($result)){
				$query = "select Nombre from TerapiaDroga, Droga where TerapiaDroga.TerapiaID={$row[0]} AND TerapiaDroga.Numero IN (1,2,3) AND TerapiaDroga.DrogaID = Droga.ID order by Droga.Nombre;";
				$result2 = mysql_query($query) or die(mysql_error());
				$drogas=array();
				while($row2 = mysql_fetch_array($result2)){
					$drogas[]=$row2[0];
				}
				$key=implode("-",$drogas);
				if(!isset($terapias[$key])){
					$terapias[$key]=1;
				}else{
					$terapias[$key]++;
				}
			}
		}
		arsort($terapias);
		echo "<pre>";
		print_r($terapias);
		echo "</pre>";
		mysql_close();
?>
</body>
</html>