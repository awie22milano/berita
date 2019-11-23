<?php 
	//Headers Dokumen
	header('Access-Control-Allow-Origin: *');
	header('Content-Type: application/json');

	//include external file
	include_once '../config/Database.php';
	include_once '../models/Berita.php';
	include_once '../models/User.php';


	// Instantiate DB & connect
	$database = new Database();
	$db = $database->connect();
	
	$token = isset($_GET['token']) ? $_GET['token'] : error();
	
	$user = new User($db);
	$user->token = $token;
	$token_exists = $user->tokenExists();
	
	if($token_exists){

		// Instantiate data
		$berita = new Berita($db);
		$result = $berita->all_news();
		$num = $result->rowCount();


		// Cek jika ada recordnya
		if($num > 0) {
			// variabel berita dalam array
			$berita_arr = array();
		

			while($row = $result->fetch(PDO::FETCH_ASSOC)) {
				extract($row);

				$berita_item = array(
					'id' => $id,
					'header' => $header,
					'ringkasan' => $ringkasan,
					'sumber' => $sumber,
					'tanggal' => $tanggal,
					'link' => $link);

		  
				array_push($berita_arr, $berita_item);
			}

			// set response code - 200 OK
			http_response_code(200);
			// Turn to JSON & output
			echo json_encode($berita_arr);

		} else {
			// set response code - 404 Not found
			http_response_code(404);
			// No hotels
			echo json_encode(
				array('message' => 'No News Found')
			);
		}
	}else{
		// set response code
		http_response_code(401);
   
		// tell the client access denied  & show error message
		echo json_encode(array("message" => "Token is not Registered."));
	}
  
	function error(){
		// set response code
		http_response_code(401);
   
		// tell the client access denied  & show error message
		echo json_encode(array("message" => "Access Denied."));
		die();
	}
  ?>
  
