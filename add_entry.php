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
  	$entry = R::dispense("logentries");
	$entry->entrydate = $params->entrydate;
  	$entry->hours = $params->hours;
	$entry->notes = $params->notes;
	$entry->bikeid = $params->selected_bike_id;
	$id = R::store($entry);
	
	// Redirect to index.php with the added content displayed. Pass the params.
    header( "location: show.php?" . "selected_bike_id=" . $params->selected_bike_id . "&selected_user_id=" . $params->selected_user_id);
	exit();
}

else
{
	// This is used to avoid undefined variable errors.
	if (!isset($params->selected_user_id))
	{
		$params->selected_user_id = "";
	}
	
	$params->entrydate = "";
	$params->hours = "";
	$params->notes = "";
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
textarea[name='notes'] 
{
  width: 50em;
  height: 30em;
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

<h2>Add Entry</h2>

<table>
	<form id="add" action="" method="">
		<tr>
			<td>
			 	<select name="selected_user_id">
			  	  	<?php foreach ($users as $user): ?>
			   		 	<option value="<?php echo $user->id?>" <?php if ($user->id == $params->selected_user_id) echo "selected" ?> >
							<?php echo $user->owner ?>
						</option>
			  		<?php endforeach ?>
			 	</select>

				<button type='submit'>Submit</button>
				
			</td>
		</tr>
		</form>
		
		<form id="add" action="" method="">
		<tr>
			<td>
				<?php if (isset($params->selected_user_id)): ?>
					
					<?php $bikes = R::find("logbikes", 'userid = ?', array($params->selected_user_id))?>
					
					<?php if (count($bikes) > 0): ?>

					 		<select name="selected_bike_id">
								<?php $bikes = R::find("logbikes", 'userid = ?', array($params->selected_user_id))?>
					  	  		<?php foreach ($bikes as $bike): ?>
					   		 		<option value="<?php echo $bike->id?>" >
										<?php echo $bike->year . " " . $bike->make . " " . $bike->model ?>
									</option>
					  			<?php endforeach ?>
					 		</select>
							
							<input name="selected_user_id" type="hidden" value="<?php echo $params->selected_user_id?>"/>
					<?php endif;?>
					
					<a href="add_bike.php?selected_user_id=<?php echo $params->selected_user_id?> ">Add Bike</a>
					
				<?php endif;?>
			</td>
		</tr>
		<?php if (count($bikes) > 0): ?>
			<tr><td> Date: </td></tr> 
			<tr><td>
					<input class="field_size" type="text" name="entrydate" 
	       				value="<?php echo htmlspecialchars($params->entrydate)?>" /></td>
			</tr>
			
			<tr><td> Hours: </td></tr> 
			<tr><td>
					<input class="field_size" type="number" name="hours" step=".1" value="<?php echo htmlspecialchars($params->hours)?>" />
				</td>
			</tr>
		
			<tr><td>Notes: </td></tr>
			<tr><td>		
					<textarea id="textarea" name="notes" spellcheck="off"><?php echo htmlspecialchars($params->notes)?></textarea>
				</td>
			</tr>
			<tr>
				<td><button type="submit" name="add">Add</button></td>
			</tr>
		<?php endif;?>
	</form>
</table>
  
<h3><?php echo $error_response ?></h3>

</div><!-- content -->
</div><!-- container -->

</body>
</html>
