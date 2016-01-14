<?php
	require_once("functions.php");
	require_once("User.class.php");
	
	
	if(isset($_SESSION["logged_in_user_id"])){
			header("Location: data.php");
		}
		
	$User = new User($mysqli);	

	$email_error = "";
	$password_error = "";
	$create_email_error = "";
	$create_password_error = "";
	$person_id_error = "";
	
	$email = "";
	$create_email = "";
	$person_id = "";
	
		if($_SERVER["REQUEST_METHOD"] == "POST") {
		
		// LOGI SISSE
		
		if (isset($_POST["login"])) {
			
			//kontrollin, et e-post ei ole tühi
			if (empty($_POST["email"])) {
				$email_error = "This field is mandatory";
				
			}else{
				$email = test_input($_POST["email"]);
			}
				
			//kontrollin, et parool ei ole tühi
			if (empty($_POST["password"])) {
				$password_error = "This field is mandatory";
			} else {
				$password = test_input($_POST["password"]);				
			}
			
			// võib sisse logida
			
			if($password_error == "" && $email_error == ""){
				
				
				$hash = hash("sha512", $password);
				
				$login_response = $User->loginUser($email, $hash, $person_id);
				var_dump($login_response);
				//kasutaja logis edukalt sisse
				if(isset($login_response->success)){
					
					$_SESSION["logged_in_user_id"] = $login_response->user->id;
					$_SESSION["logged_in_user_email"] = $login_response->user->email;
					
					
					//saadan sõnumi teise faili kasutades SESSIOONI
					$_SESSION["login_success_message"] = $login_response->success->message;
					
					header("Location: data.php");
					
				}
				
				
			}
			
		}
		
		// LOO KASUTAJA
		
		elseif (isset($_POST["create"])) //registration field errors
		{
			
			
			if (empty($_POST["person_id"])) {
				$person_id_error = "This field is mandatory";	
			} else {
				$person_id = test_input($_POST["person_id"]);
			}
			
			
			
			if (empty($_POST["create_email"])) {
				$create_email_error = "This field is mandatory";
				
			}else{
				
				$create_email = test_input($_POST["create_email"]);
			}
			
			
			
			if (empty($_POST["create_password"])) {
				$create_password_error = "This field is mandatory";
			
				
			}else{
				if(strlen($_POST["create_password"]) <8) {
					
					$create_password_error = "Password needs to be at least 8 characters long ";
				
				}else{
					$create_password = test_input($_POST["create_password"]);
				}
				
			}
			
			if ($person_id_error == ""){
				echo "saved to database ".$person_id;
			}
			
			if(	$create_email_error == "" && $create_password_error == "" && $person_id_error == ""){
				
				$hash = hash("sha512", $create_password);
				echo "User has been created! Registrated e-mail is ".$create_email.", ID_number is ".$person_id." and password is ".$create_password."and hash is ".$hash;
				$User->createUser($create_email, $hash, $person_id);
				
			}
			
		}
		
	}	


	function test_input($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}


	
?>


<html>
<head>
	<title>Kasutaja leht</title>
</head>
<body>
	
	<h2>Logi sisse</h2>
	
	<form action="login.php" method="post">
		<input name="email" type="email" placeholder="E-post" value="<?php echo $email; ?>"> <?php echo $email_error; ?> <br><br>
		<input name="password" type="password" placeholder="Parool"> <?php echo $password_error; ?> <br><br>
		<input type="submit" name="login" value="Logi sisse">
	</form>	
		
	<h2>Loo kasutaja</h2>
	
	<form action="login.php" method="post">
		
		<input name="create_email" type="email" placeholder="E-post" value="<?php echo $create_email; ?>"> <?php echo $create_email_error; ?> <br><br>
		<input name="create_password" type="password" placeholder="Parool"> <?php echo $create_password_error; ?> <br><br>
		<input name="person_id" type="text" placeholder="Isikukood"> <?php echo $person_id_error; ?> <br><br>
		<input name="create" type="submit" value="Sisesta">
	</form>	
	
	
</body>

</html>