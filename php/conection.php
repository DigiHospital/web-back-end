<?php
	$mysqli=new mysqli("localhost","c1801093_login","voDApose33","c1801093_login"); // server, database user, user password, database name
	
	if(mysqli_connect_errno()){
		echo 'Conexion Fallida : ', mysqli_connect_error();
		exit();
	}
?>