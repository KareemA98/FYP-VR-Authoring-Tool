<?php
    // Configuration
    $hostname = 'localhost';
    $username = 'coka';
    $password = 'h1cYy2Uju8';
    $database = 'coka';
	
	$link = mysqli_connect($hostname , $username , $password ,$database);
	if($link === false) {
		die("ERROR: Could not connect. " . mysqli_connect_error());
	}
	$sceneID = $_REQUEST['levelNumber'];
	$sql = "SELECT * FROM Rooms WHERE RoomID = $sceneID";
	if( $result = mysqli_query($link, $sql)) {
		while($row = mysqli_fetch_assoc($result)) {
			$data = $row["RoomLocation"] . "," . $row["NextRoom"] . ";";
		}
	}else {
		echo "ERROR: Could not able to execute " . $sql. mysqli_error($link);
	}
	$sql = "SELECT * FROM RoomObjects WHERE RoomID = $sceneID";
	if( $result = mysqli_query($link,$sql)) {
		while($row = mysqli_fetch_assoc($result)) {
		$data .= $row['ObjectID'] . "," . $row['XPosition'] . "," . $row['YPosition'] . "," . $row['ZPosition'] . "," . $row['Name'] . "," . $row['Rotation'] . "~";
		} 
	} else {
		echo "ERROR: Could not able to execute " . $sql. mysqli_error($link);
	}
	$data = rtrim($data, '~');
	$data .= ";";
	$sql = "SELECT * FROM RoomSounds WHERE RoomID = $sceneID";
	if ( $result = mysqli_query($link , $sql)) {
		while($row = mysqli_fetch_assoc($result)) {
			$data .= $row['SoundID'] . "," . $row["X"] . "," . $row["Y"] . "," . $row["StartOnAwake"] . "," . $row["Loops"] . "," . $row["TheRange"] . "," . $row["Name"] . "~";
		}
	}
	$data = rtrim($data, '~');
	$data .= ";";
	$sql = "SELECT * FROM RoomTasks WHERE RoomID = $sceneID";
	if ( $result = mysqli_query($link , $sql)) {
		while($row = mysqli_fetch_assoc($result)) {
			$data .= $row['TaskID'] . "," . $row["Paramater1"] . "," . $row["Paramater2"] . "~";
		}
	}
	$data = rtrim($data, '~');
	echo $data;
	mysqli_close($link);
?>