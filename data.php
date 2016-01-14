<?php
	require_once("functions.php");
	require_once("Planes.class.php");
	
	
	$Planes = new Planes($mysqli);	
	
	if(!isset($_SESSION["logged_in_user_id"])){
		header("Location: login.php");
	}
	
	//kasutaja tahab välja logida
	if(isset($_GET["logout"])){
		//aadressireal on olemas muutuja logout
		
		//kusutame kõik session muutujad ja peatame sessiooni
		session_destroy();
		
		header("Location: login.php");
	}
	
	$number = $mark = $year = "";
	$number_error = $mark_error = $year_error = "";
	
	
	if(isset($_POST["addPlane"])){
		
		if ( empty($_POST["number"]) ) {
				$number_error = "See väli on kohustuslik";
			}else{
				$number = cleanInput($_POST["number"]);
			}

			if ( empty($_POST["mark"]) ) {
				$mark_error = "See väli on kohustuslik";
			} else {
				
				$mark = cleanInput($_POST["mark"]);
				
			}
			
			if ( empty($_POST["year"]) ) {
				$year_error = "See väli on kohustuslik";
			} else {
				
				$year = cleanInput($_POST["year"]);
				
			}
			
		if(	$number_error == "" && $mark_error == "" && $year_error == ""){
			
			echo "Sisestatud!";
				
				
				$Planes->addPlaneData($number, $mark, $year);
			
		}
	}
	function cleanInput($data) {
  	$data = trim($data);
  	$data = stripslashes($data);
  	$data = htmlspecialchars($data);
  	return $data;
  }
	
	
	
?>



		
			
	

	

	
<p>
	Tere, <?=$_SESSION["logged_in_user_id"];?>
	<a href="?logout=1">Logi välja<a>
</p>


<h2>Sisesta eralennuki andmed</h2>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
	<label for="number" >Number</label><br>
  	<input name="number" id="number" type="text"  value="<?php echo $number; ?>"> <?php echo $number_error; ?><br><br>
	<label for="mark" >Mark</label><br>
  	<input name="mark" type="text"  value="<?php echo $mark; ?>"> <?php echo $mark_error; ?><br><br>
	<label for="year" >Väljalaskeaasta</label><br>
  	<input name="year" type="text"  value="<?php echo $year; ?>"> <?php echo $year_error; ?><br><br>
  	<input type="submit" name="addPlane" value="Salvesta">
  </form>
  
  <a href="table.php">Vaata/Muuda eralennukeid</a>
		