<?php	
	$error_message = array(
		"Incorrect Password",
		"Could Not Process your Request, Try Again Later",
		" - Success",
		"Incorrect Store ID"
	);
	$json = $_SERVER['HTTP_JSON'];
	if(!isset($json)){
		header('Location: index.php');
	} else {
		require_once('inc/connection.inc.php');
		$data = json_decode($json);

		$storeID = $data->storeid;
		$password = $data->pass;
		$storeDeviceID = $data->regId;
			
		if($password == 'yolo'){
			$query = "SELECT `name` FROM `stores` WHERE `code`='$storeID'";
			if($query_run = mysqli_query($connection,$query)){
				if(mysqli_num_rows($query_run) == 1 ){
					while($query_row = mysqli_fetch_assoc($query_run)){
						$nameOfStore = $query_row['name'];
						$error = 2;
					}	
					$query1 = "UPDATE `stores` SET device_id='$storeDeviceID' WHERE code='$storeID'";
					if(!mysqli_query($connection,$query1)){
						$error = 1;
					}
				} else {
					$error = 3;
				}
			} else {
				$error = 1;
			}
		} else {
			$error = 0;
		}
		if($error == 2){
			echo $nameOfStore;
		}
		echo $error_message[$error];
	}
?>