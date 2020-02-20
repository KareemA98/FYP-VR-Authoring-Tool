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
	$sceneNumber = $_REQUEST['sceneNumber'];
	$sql ="SELECT RoomID , RoomLocation , NextRoom 
	From Rooms
	WHERE SceneID = $sceneNumber";
	if($result = mysqli_query($link,$sql)) {
		$roomArray = array();
		while($row = mysqli_fetch_assoc($result)) {
			$b = array($row["RoomID"] , $row["RoomLocation"]);
			array_push($roomArray,$b);
		} 
	} else {
		echo "ERROR: Could not able to execute " . $sql. mysqli_error($link);
	}
	$sceneArray = array();
	for($i = 0 ; $i < count($roomArray) ; $i++) {
		$objectArray = array();
		$taskArray = array();
		$soundArray = array();
		$sql = "SELECT * FROM RoomObjects WHERE RoomID = " . $roomArray[$i][0];
		if( $result = mysqli_query($link,$sql)) {
			while($row = mysqli_fetch_assoc($result)) {
				$b = array($row['ObjectID'] , $row['XPosition'] , $row['YPosition'] , $row['ZPosition'] , $row['Name'] , $row['Rotation'] , $row["Onclick"]);
				array_push($objectArray , $b);
			} 
		} else {
			echo "ERROR: Could not able to execute " . $sql. mysqli_error($link);
		}
		$sql = "SELECT * FROM RoomSounds WHERE RoomID = " . $roomArray[$i][0];
		if ( $result = mysqli_query($link , $sql)) {
			while($row = mysqli_fetch_assoc($result)) {
				$b = array($row['SoundID'] , $row["X"] , $row["Y"] , $row["StartOnAwake"] , $row["Loops"] , $row["TheRange"] , $row["Name"]);
				array_push($soundArray , $b);
			}
		}
		$sql = "SELECT * FROM RoomTasks WHERE RoomID = " . $roomArray[$i][0];
		if ( $result = mysqli_query($link , $sql)) {
			while($row = mysqli_fetch_assoc($result)) {
				$b = array($row['TaskID'] , $row["Paramater1"] , $row["Paramater2"]);
				array_push($taskArray , $b);
			}
		}
		$a = array ("objects" => $objectArray , "tasks" => $taskArray , "sounds" => $soundArray , "locations" => $roomArray[$i][1]);
		array_push($sceneArray , $a );
	}
	echo json_encode($sceneArray);
	mysqli_close($link);
	//echo $result;
	?>

	