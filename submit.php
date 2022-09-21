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

if (isset($_POST['url']) && filter_var($_POST['url'], FILTER_VALIDATE_URL)) {
	$stringUniq = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghjiklmnopqrstuvwxyz1234567890_";
	$url = $con->real_escape_string($_POST['url']);
	
	$renewable = $_POST['renewable'] == "false" ? -1 : 0;
	
	$rand = random_int(0,54);
	$slug = substr(str_shuffle($stringUniq),$rand,7);
	$renewed = 0;
	$activeUrl = 1;
	$query = "SELECT slug FROM urls;";
	$result = $con->query($query);
	$existingSlug = array();
	if ($result) {
		while ($index = mysqli_fetch_row($result)){
			$existingSlug[] = $index;
		}
	}
	while (in_array($slug,$existingSlug))
	{
		$rand = random_int(0,54);
		$slug = substr(str_shuffle($stringUniq),$rand,7);
	}

	$expir = time() + getExpir($_POST['expi']);
	$query  = "INSERT INTO urls (slug,expir,original,renew,activeUrl,selection) 
			VALUES(?,?,?,?,?,?)";
	$stm = $con->prepare($query);
	$stm->bind_param("sisiis",$slug,$expir,$url,$renewable,$activeUrl,$_POST['expi']);
	if ($stm->execute()) { 
		echo 'success.... Slug: '.$slug;
	} else {
		echo 'fail';
	}
	$stm->close();
	$con->close();
}
		
?>