<?php 
	require_once("functions.php");
    require_once("Planes.class.php");
	
	$Planes = new Planes($mysqli);
    
    
    //kasutaja muudab andmeid
    if(isset($_GET["update"])){
        $Planes->updatePlaneData($_GET["plane_id"], $_GET["number"], $_GET["mark"], $_GET["year"]);
    }
	
    $plane_array = $Planes->getCompleteData($_GET["id"]);
    
?>

<h1>Eralennukite register</h1>
<table border=1>
<tr>
    <th>Lennuki Number</th>
    <th>Lennuki Mark</th>
    <th>Lennuki Väljalaskeaasta</th>
	<th>Isikukood</th>
    
</tr>
<?php
    
    for($i = 0; $i < count($plane_array); $i++){
        
            
            echo "<tr>";
            echo "<td>".$plane_array[$i]->number."</td>";
            echo "<td>".$plane_array[$i]->mark."</td>";
			echo "<td>".$plane_array[$i]->year."</td>";
			echo "<td><a href='?id=".$plane_array[$i]->user_id."'>".$plane_array[$i]->user_id."</a></td>";
            echo "</tr>";
            
    
        
        
    }
    
?>
</table>

<a href="data.php">Tagasi</a>
