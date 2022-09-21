<?php 
include_once('db.php');

function isAdmin($connection){
    $query  = "SELECT ip,timest FROM admin WHERE ip=?";
	$stm = $connection->prepare($query);
	$stm->bind_param("s",$_SERVER['REMOTE_ADDR']);
	if ($stm->execute()) { 
        $result = $stm->get_result();
        $row = $result->fetch_array(MYSQLI_NUM);
        $stm->close();
		if (!empty($row) && time()-86400<$row[1]){
            return true;
        }
	} else {
		return false;
	}
	
}
function edit($edit,$slug,$conne,$switch=0){
    if (!isAdmin($conne))
        return false;

    if ($edit=="delete"){
        $query  = "DELETE FROM urls WHERE slug=?";
        $stm = $conne->prepare($query);
        $stm->bind_param("s",$slug);
        if ($stm->execute())
        {
            echo 'pass';
        }
        $stm->close();
        $conne->close(); 
    }else if ($edit=="switched"){
        
        $query  = "UPDATE urls SET activeURL=? WHERE slug=?";
        $stm = $conne->prepare($query);
        $stm->bind_param("is",$switch,$slug);
        if ($stm->execute())
        {
            echo 'pass';
        }
        else
            echo 'failed';
        $stm->close();
        $conne->close(); 
    }
        
}
    
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['edit']) && isset($_POST['slug']) && isset($_POST['switched'])){
        $editType =  $_POST['edit'];
        $switche = $_POST['switched'];
        $slugg = $_POST['slug'];
        edit($editType,$slugg,$con,$switche);
    }
}
else if ($_SERVER['REQUEST_METHOD'] === 'GET'){
    $one = 1;
    $query  = "SELECT slug FROM urls WHERE activeUrl=$one";
    $result = $con->query($query);
    echo ''. $result->num_rows;
}
