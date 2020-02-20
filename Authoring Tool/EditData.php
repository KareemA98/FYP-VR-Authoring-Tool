   <?php
   // Configuration
    $hostname = 'localhost';
    $username = 'coka';
    $password = 'h1cYy2Uju8';
    $database = 'coka';
	$link = mysqli_connect($hostname,$username, $password, $database);
	if($link === false){
	die("ERROR: Could not connect. " . mysqli_connect_error());
	}
	$myArray = $_REQUEST['dataArray'];
	$sceneArray = $_REQUEST['sceneArray'];
	$sql = "INSERT INTO SceneData (SceneName) VALUES ('$sceneArray[0]')";
	if(mysqli_multi_query($link, $sql)){
		echo "Scene added successfully.";
		$sceneID = mysqli_insert_id($link);
	} else{
		echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
	}
	$sql2 ="";
	$isThisTheFirstRoom = true;
	for($x = 0 ; $x < count($myArray) ; $x++) {
		$sql = "INSERT INTO Rooms (SceneID ,RoomLocation) VALUES ('$sceneID' , " . $myArray[$x]["locations"] . ")";
		if(mysqli_multi_query($link, $sql)){
			echo "Room added successfully.";
			$roomID = mysqli_insert_id($link);
			if ($isThisTheFirstRoom) {
				$firstRoom = $roomID;
				$previousRoomID = $roomID;
			}
		} 
		else
		{
			echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
		}
		if (!$isThisTheFirstRoom) {
			$sql = "UPDATE Rooms
			SET NextRoom = '" . ($roomID) .
			"' WHERE RoomID ='" . $previousRoomID . "'";
				if(mysqli_multi_query($link, $sql)){
					echo "Room updated successfully.";
				} else{
					echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
				}
			$previousRoomID = $roomID;
		}
		else {
			$isThisTheFirstRoom = false;
		}
		for($y = 0; $y < count($myArray[$x]["objects"]) ; $y++) {
			$sql2 .= "INSERT INTO RoomObjects (RoomID ,ObjectID , XPosition , YPosition , ZPosition , Name , Rotation , Onclick ) VALUES (" . $roomID . ' , ' . $myArray[$x]["objects"][$y][0] . ' , ' . $myArray[$x]["objects"][$y][1] .' , ' . 
			$myArray[$x]["objects"][$y][2] . ' , ' . $myArray[$x]["objects"][$y][3] . ' , "' . $myArray[$x]["objects"][$y][5] . '" , ' . $myArray[$x]["objects"][$y][6] . ' , ' . $myArray[$x]["objects"][$y][7] . ");";
		}
		for($y = 0 ; $y < count($myArray[$x]["tasks"]) ; $y++) {
			$sql2 .= "INSERT INTO RoomTasks (TaskID ,RoomID , Paramater1 , Paramater2) VALUES (" . $myArray[$x]["tasks"][$y][0] . ' , ' . $roomID . ' , "' . $myArray[$x]["tasks"][$y][1] . '"'
			. ' , "' . $myArray[$x]["tasks"][$y][2] . '"' .");";
		}
		for($y = 0 ; $y < count($myArray[$x]["sounds"]) ; $y++) {
			$sql2 .= "INSERT INTO RoomSounds (SoundID ,RoomID , X , Y , StartOnAwake , Loops , TheRange , Name) VALUES (" . $myArray[$x]["sounds"][$y][0] . ' , ' . $roomID . ' , ' . $myArray[$x]["sounds"][$y][1] . ' , ' . $myArray[$x]["sounds"][$y][2]
			. ' , "' . $myArray[$x]["sounds"][$y][3] . '" , "' . $myArray[$x]["sounds"][$y][4] . '" , ' . $myArray[$x]["sounds"][$y][5] . ' , ' . $myArray[$x]["sounds"][$y][6] . ");";
		}
	}
	$sql2 = rtrim($sql2, ';');
	echo $sql2;
	if(mysqli_multi_query($link, $sql2)){
		echo "Objects,Sounds and Tasks added successfully.";
	} else{
		echo "ERROR: Could not able to execute $sql2. " . mysqli_error($link);
	}
	mysqli_close($link);
	$link = mysqli_connect($hostname,$username, $password, $database);
	$sql3 = "UPDATE SceneData
	SET FirstRoom = '" . ($firstRoom) .
	"' WHERE SceneID ='" . $sceneID . "'";
	if(mysqli_query($link, $sql3)){
		echo "Scene updated successfully.";
	} else{
		echo "ERROR: Could not able to execute $sql3. " . mysqli_error($link);
	}
	// Close connection
	?>
	