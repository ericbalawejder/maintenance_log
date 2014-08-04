<?php
require_once "include/Session.php";
$session = new Session();
if (!isset($session->valid)) {
  require_once "expired.php";
  exit();
}

require_once "include/db.php";
$params = (object) $_REQUEST;

if (isset($params->add)) 
{
	try
	{
  	  $owner = trim($params->owner);
      
	  if (strlen($owner) < 3) 
	  {
        throw new Exception("Name must have length at least 3 characters.");
      }
	  
	  $entry = R::dispense("logusers");
	  $entry->owner = $params->owner;
  	  $entry->phonenumber = $params->phonenumber;
  	  $id = R::store($entry);
	  
	  // Redirect to index.php with the added content displayed. Pass the params.
	  header( "location: index.php?selected_user_id=$id" ); 
  	  exit();
	}
	
	catch(Exception $ex)
	{
		$error_response = $ex->getMessage();
	}
}

else
{
	$params->owner = "";
	$params->phonenumber = "";
	$error_response = "";
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" 
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
<title>Add</title>

<link rel="stylesheet" type="text/css" href="css/layout.css" />
<style type="text/css">
.field_size 
{
  width: 20em;
}
</style>

<script type="text/javascript" src="js/jquery-1.6.4.min.js"></script>
<script type="text/javascript" src="js/init.js"></script>
<script type="text/javascript">
/* local JavaScript */
function getSelf() { return "<?php echo basename($_SERVER['PHP_SELF'])?>"; }
</script>
</head>

<body>
<div id="navigation"><?php require_once "include/links.php" ?></div>
<div id="container">
<div id="header"><?php require_once "include/header.php" ?></div>
<div id="content"><!-- content -->

<h2>Add</h2>

<table>
	<form id="add" action="" method="">
		<tr><td> Owner: </td></tr> 
		<tr><td>
				<input class="field_size" type="text" name="owner" 
       				value="<?php echo htmlspecialchars($params->owner)?>" /></td>
		</tr>
		
		<tr><td> Phone number: </td></tr> 
		<tr><td><input class="field_size" type="text" name="phonenumber" 
	       			value="<?php echo htmlspecialchars($params->phonenumber)?>" /></td>
		</tr>
		
		<tr>
			<td><button type="submit" name="add">Add</button></td>
		</tr>
	</form>
</table>
 
<h3><?php echo $error_response ?></h3>

</div><!-- content -->
</div><!-- container -->

</body>
</html>
