<?php 
	require_once("functions.php");
    require_once("Planes.class.php");
	
	$Planes = new Planes($mysqli);
    
    
    //kasutaja muudab andmeid
    if(isset($_GET["update"])){
        $Planes->updatePlaneData($_GET["plane_id"], $_GET["number"], $_GET["mark"], $_GET["year"]);
    }
	
    $plane_array = $Planes->getData($_GET["id"]);
    
?>

<h1>Eralennukite register</h1>
<table border=1>
<tr>
    <th>Lennuki Number</th>
    <th>Lennuki Mark</th>
    <th>Lennuki Väljalaskeaasta</th>
	<th>Isikukood</th>
    <th>Muuda</th>
</tr>
<?php
    
    for($i = 0; $i < count($plane_array); $i++){
        
        
        if(isset($_GET["edit"]) && $_GET["edit"] == $plane_array[$i]->id){
            echo "<tr>";
            echo "<form action='table.php' method='get'>";
            echo "<input type='hidden' name='plane_id' value='".$plane_array[$i]->id."'>";
            echo "<td><input name='number' value='".$plane_array[$i]->number."'></td>";
            echo "<td><input name='mark' value='".$plane_array[$i]->mark."'></td>";
			echo "<td><input name='year' value='".$plane_array[$i]->year."'></td>";
			echo "<td>".$plane_array[$i]->user_id."</td>";            
            echo "<td><a href='?table.php=".$plane_array[$i]->id."'>Katkesta</a></td>";
            echo "<td><input name='update' type='submit'></td>";
            echo "</form>";
            echo "</tr>";
        }else{
            
            echo "<tr>";
            echo "<td>".$plane_array[$i]->number."</td>";
            echo "<td>".$plane_array[$i]->mark."</td>";
			echo "<td>".$plane_array[$i]->year."</td>";
			echo "<td><a href='?id=".$plane_array[$i]->user_id."'>".$plane_array[$i]->user_id."</a></td>";
            echo "<td><a href='?edit=".$plane_array[$i]->id."'>Muuda</a></td>";
            echo "</tr>";
            
        }
        
        
    }
    
?>
</table>

<a href="complete_table.php">Vaata kõiki eralennukeid</a>