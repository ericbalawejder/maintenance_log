<?php
require_once "include/Session.php";
$session = new Session();
if (!isset($session->valid)) {
  require_once "must_login.php";
  exit();
}

require_once "include/db.php";
$params = (object) $_REQUEST;
$users = R::find("logusers");

//print_r($params) may cause errors when debugging.
//print_r($params);

// This is used to avoid undefined variable errors.
if (!isset($params->selected_user_id))
{
	$params->selected_user_id = "";
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" 
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
<title>Maintenance Log</title>
<link rel="stylesheet" type="text/css" href="css/layout.css" />
<style type="text/css">
/* Added style class in css/layout */
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

<h2>Choose owner name</h2>

<!--  form action must be set for the redirect to work -->
<form action="index.php" method="">

 	<!-- js function located in js/init.js-->
	<!--<select name="selected_user_id"> -->
	<select name="selected_user_id" onchange="selectedUserChanged(this)">
  	  	<?php foreach ($users as $user): ?>
   		 	<option value="<?php echo $user->id?>" <?php if ($user->id == $params->selected_user_id) echo "selected" ?> >
				<?php echo $user->owner ?>
			</option>
  	<?php endforeach ?>
 	</select>

	<button type='submit'>Submit</button>
</form>

<?php if (isset($params->selected_user_id)): ?>
	
	<?php $bikes = R::find("logbikes", 'userid = ?', array($params->selected_user_id))?>
	
	<?php if (count($bikes) > 0): ?>
		<form action="show.php" method="">

		 	<select name="selected_bike_id">
				<?php $bikes = R::find("logbikes", 'userid = ?', array($params->selected_user_id))?>
		  	  	<?php foreach ($bikes as $bike): ?>
		   		 	<option value="<?php echo $bike->id?>" >
						<?php echo $bike->year . " " . $bike->make . " " . $bike->model ?>
					</option>
		  	<?php endforeach ?>
		 	</select>
			
			<input name="selected_user_id" type="hidden" value="<?php echo $params->selected_user_id?>"/>
			
			<button type='submit'>Show details</button>
		</form>
	<?php endif;?>
	
	<a href="add_bike.php?selected_user_id=<?php echo $params->selected_user_id?> ">Add Bike</a>
		
<?php endif;?>

</div><!-- content -->
</div><!-- container -->

</body>
</html>
