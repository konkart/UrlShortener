<?php
include_once('db.php');
function getExpir($ex) {
	switch ($ex) {
		case "minutes":
			$ex = 600;
			break;
		case "hour":
			$ex = 3600;
			break;
		case "week":
			$ex = 604800;
			break;
		case "day":
		default:
			$ex = 86400;
			break;
	}
	return $ex;
}
$slug = $_GET['slug'];
$query = "SELECT original,expir,renew,selection,activeUrl FROM urls WHERE slug='$slug';";
$result = $con->query($query);
if ($result->num_rows > 0)
{	
    $row = $result->fetch_array(MYSQLI_BOTH);
    if ($row["activeUrl"]==0)
    {
        header('Location: /shortu/index.php');
        die();
    } 
    if(time()>$row["expir"]) {
        if ($row["renew"]==0) {
            
            $newexpir = time() + getExpir($row["selection"]);
            $query = "UPDATE urls SET expir=?,renew=? WHERE original=?";
            $stm = $con->prepare($query);
            $one = 1;
            $stm->bind_param("iis",$newexpir,$one,$url);
            if ($stm->execute())
                echo 'success';
            else
                echo 'fail';

            header('Location: '.$row["original"]);
            die();
        }
        header('Location: /shortu/index.php');
        die();
    }
    else{
        header('Location: '.$row["original"]);
        die();
    }
}
else {
    header('Location: /shortu/index.php');
    die();
}
$con->close();