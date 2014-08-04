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

//print_r($params);

if (isset($params->modify))
{
	$selected_bike = R::load("logbikes",$params->selected_bike_id);
	$error_response = "";	
}

elseif (isset($params->save))
{	
    try {
    	  $year = trim($params->year);		  
    	  $make = trim($params->make);		  
    	  $model = trim($params->model);	
		  	  
	  	  $selected_bike = R::load("logbikes",$params->selected_bike_id);	
		  
      	  $selected_bike->year = $year;
      	  $selected_bike->make = $make;
      	  $selected_bike->model = $model;
      	  R::store($selected_bike);

		  // Redirect to show.php and show the content. 
		  header( "location: show.php?" . "selected_bike_id=" . $params->selected_bike_id . "&selected_user_id=" . $params->selected_user_id);
		  exit();
    }
	
    catch(Exception $ex) 
	{
		$error_response = $ex->getMessage();
	}
}

elseif (isset($params->remove))
{	
	try {
    $id = $params->selected_bike_id;
    $bike = R::load("logbikes",$id);
    R::trash($bike);
	
	// Redirect to index.php with nothing displayed.
    header( "location: index.php");
    exit();
	}
	
	catch(RedBean_Exception_SQL $red_bean_exception)
	{
		$error_response = "Cannot cascade delete. Must delete entry, bike and owner in that order.";
	}
	catch(Exception $ex)
	{
		$error_response = $ex->getMessage();
	}
}

else
{
	// This is used to avoid undefined variable errors.
	if (!isset($params->selected_user_id))
	{
		$params->selected_user_id = "";
	}
	
	// This is used to avoid undefined variable errors.
	if (!isset($params->selected_bike_id))
	{
		$params->selected_bike_id = "";
	}
	$error_response = "";
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" 
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
<title>Modify</title>

<link rel="stylesheet" type="text/css" href="css/layout.css" />
<style type="text/css">

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

<h2>Select an owner</h2>

<table>
	<form action="" method="">
		<tr>
		 	<select name="selected_user_id">
		  	  	<?php foreach ($users as $user): ?>
		   		 	<option value="<?php echo $user->id?>" <?php if ($user->id == $params->selected_user_id) echo "selected" ?> >
						<?php echo $user->owner ?>
					</option>
		  	<?php endforeach ?>
		 	</select>
			
			<button type="submit" name="submit">Show</button>
		</tr>
	</form>
	<form action="" method="">
		<tr>
			<td>
				<?php if (isset($params->selected_user_id)): ?>
					<?php $bikes = R::find("logbikes", 'userid = ?', array($params->selected_user_id))?>
			
					<?php if (count($bikes) > 0): ?>

				 			<select name="selected_bike_id">
								<?php $bikes = R::find("logbikes", 'userid = ?', array($params->selected_user_id))?>
				  	  			<?php foreach ($bikes as $bike): ?>
				   		 			<option value="<?php echo $bike->id?>" <?php if ($bike->id == $params->selected_bike_id) echo "selected" ?> >
										<?php echo $bike->year . " " . $bike->make . " " . $bike->model ?>
									</option>
				  				<?php endforeach ?>
				 			</select>
							<input name="selected_user_id" type="hidden" value="<?php echo $params->selected_user_id?>"/>
							<button type="submit" name="modify">Modify/Remove</button>
					<?php else:?>
					<tr>
						<td>
							<a href="add_bike.php?selected_user_id=<?php echo $params->selected_user_id?> ">Add Bike</a>
						</td>
					</tr>
					<?php endif; ?>
				<?php endif;?>
			</td>
		</tr>	
		
		<?php if (isset($params->modify)): ?>	
		<tr><td> Year: </td></tr> 
		<tr><td>
				<input class="field_size" type="text" name="year" 
       				value="<?php echo htmlspecialchars($selected_bike->year)?>" /></td>
		</tr>
	
		<tr><td> Make: </td></tr> 
		<tr><td><input class="field_size" type="text" name="make" 
	       			value="<?php echo htmlspecialchars($selected_bike->make)?>" /></td>
		</tr>
	
		<tr><td> Model: </td></tr> 
		<tr><td><input class="field_size" type="text" name="model" 
	       			value="<?php echo htmlspecialchars($selected_bike->model)?>" /></td>
		</tr>
	
		<tr>
			<td>
				<button type="submit" name="save">Save</button>
				<button type="submit" name="remove">Remove</button>
			</td>
		</tr>
	<?php endif; ?>
	</form>
</table>

<h3><?php echo $error_response ?></h3>

</div><!-- content -->
</div><!-- container -->

<script type="text/javascript">
/* local JavaScript */
function getSelf() { return "<?php echo basename($_SERVER['PHP_SELF'])?>"; }

function confirmation() {
  if (!confirm("Are you sure you want to delete this bike?")) 
  {
    return false;    // false return value means no submission
  }
  return true;       // true return value means submission
}
 
$(document).ready(function(){
  // when remove button is activated, use confirmation as handler
  $("button[name='remove']").click(confirmation); 
});
</script>

</body>
</html>
