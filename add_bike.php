<?php
require_once "include/Session.php";
$session = new Session();
if (!isset($session->valid)) {
  require_once "expired.php";
  exit();
}

require_once "include/db.php";
$params = (object) $_REQUEST;
$users = R::find("logusers");

if (isset($params->add))
{
  	$bike = R::dispense("logbikes");
  	$bike->year = $params->year;
	$bike->make = $params->make;
	$bike->model = $params->model;
	$bike->userid = $params->selected_user_id;
	$id = R::store($bike);
	
	// Redirect to index.php with the added content displayed. Pass the params.
	header( "location: index.php?selected_user_id=$params->selected_user_id" ); 
	exit();
}

else
{
	// This is used to avoid undefined variable errors.
	if (!isset($params->selected_user_id))
	{
		$selected_user_id = "";
	}
	$params->year = "";
	$params->make = "";
	$params->model = "";
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

<h2>Add Bike</h2>

<table>
	<form id="add" action="" method="">
		<tr>
		 	<select name="selected_user_id">
		  	  	<?php foreach ($users as $user): ?>
		   		 	<option value="<?php echo $user->id?>" <?php if ($user->id == $params->selected_user_id) echo "selected" ?> >
						<?php echo $user->owner ?>
					</option>
		  	<?php endforeach ?>
		 	</select>
		</tr>
		
		<tr><td> Year: </td></tr> 
		<tr><td>
				<input class="field_size" type="text" name="year" 
       				value="<?php echo htmlspecialchars($params->year)?>" /></td>
		</tr>
		
		<tr><td> Make: </td></tr> 
		<tr><td><input class="field_size" type="text" name="make" 
	       			value="<?php echo htmlspecialchars($params->make)?>" /></td>
		</tr>
		
		<tr><td> Model: </td></tr> 
		<tr><td><input class="field_size" type="text" name="model" 
	       			value="<?php echo htmlspecialchars($params->model)?>" /></td>
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
