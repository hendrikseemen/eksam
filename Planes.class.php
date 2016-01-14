<?php
class Planes {
	
	private $connection;
	private $user_id;

	
	function __construct($mysqli){
		
		$this->connection = $mysqli;
		
		
	}
	
	function addPlaneData($plane_number, $plane_mark, $plane_year) {
		
		
		$stmt = $this->connection->prepare("INSERT INTO planes (user_id, number, mark, year) VALUES (?,?,?,?)");
				
		
		$stmt->bind_param("issi",  $_SESSION['logged_in_user_id'], $plane_number, $plane_mark, $plane_year);
		if($stmt->execute()) {
			
			$success = new StdClass();
			$success->message = "Eralennuki andmed sisestatud!";
			$response->success = $success;
			
			
		}else {
			
			//midagi läks katki
			$error = new StdClass();
			$error->id = 1;
			$error->message = "Midagi läks katki!";
			
			$response->error = $error;
			
			
		}
		
		
		$stmt->close();
		
		return $response;
		
		
		
		
	}
	
	
	function getData($id){
        
        $ID_number = "%".$id."%";
        $stmt = $this->connection->prepare("SELECT planes.id, planes.user_id, planes.number, planes.mark, planes.year, users_exam.person_id FROM planes JOIN users_exam ON planes.user_id = users_exam.id WHERE users_exam.id = ? AND users_exam.person_id LIKE ?");
        $stmt->bind_param("is",  $_SESSION['logged_in_user_id'], $ID_number);
		$stmt->error;
		$stmt->bind_result($id, $user_id, $number, $mark, $year, $person_id);
		
        $stmt->execute();
  
       
        
        $plane_array = array(); 
        
        while($stmt->fetch()){
            
            $planes = new StdClass();
            $planes->id = $id;
            $planes->number = $number;
            $planes->mark = $mark;
            $planes->year = $year;
			$planes->user_id = $person_id;
			
            
            array_push($plane_array, $planes);
            
        }

        return $plane_array;
        
        $stmt->close();
        $mysqli->close();
    }
	
	function getCompleteData($id){
   
        $ID_number = "%".$id."%";
        $stmt = $this->connection->prepare("SELECT planes.id, planes.user_id, planes.number, planes.mark, planes.year, users_exam.person_id FROM planes JOIN users_exam ON planes.user_id = users_exam.id WHERE users_exam.person_id LIKE ?");
		echo $this->connection->error;
		$stmt->bind_param("s", $ID_number);
		$stmt->bind_result($id, $user_id, $number, $mark, $year, $person_id);
		
        $stmt->execute();
  
       
        
        $plane_array = array(); 
        
        while($stmt->fetch()){

            $planes = new StdClass();
            $planes->id = $id;
            $planes->number = $number;
            $planes->mark = $mark;
            $planes->year = $year;
			$planes->user_id = $person_id;
			
            
            array_push($plane_array, $planes);
            
        }

        return $plane_array;
        
        $stmt->close();
        $mysqli->close();
    }
	
	
	
	
	
		
	function updatePlaneData($plane_id, $number, $mark, $year){
        $stmt = $this->connection->prepare("UPDATE planes SET number=?, mark=?, year=? WHERE id=?");
        $stmt->bind_param("ssii", $number, $mark, $year, $plane_id);
        $stmt->execute();
        header("Location: table.php");
        
        
        $stmt->close();
    }	
		
	
	
	
} ?>