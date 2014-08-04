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

if (isset($params->selected_user_id))
{
	$selected_user = R::load("logusers",$params->selected_user_id);
}

if (isset($params->save))
{
    try {
    	  $name = trim($params->selected_owner);		  
    	  $number = trim($params->selected_phonenumber);		  
		        
  	  	  if (strlen($name) < 3) 
  	  	  {
          	throw new Exception("Name must have length at least 3 characters.");
          }
		  
      	  $selected_user->owner = $name;
      	  $selected_user->phonenumber = $number;
      	  R::store($selected_user);
		  
		  // Redirect to index.php and show the content. Pass params to index.php.
		  header( "location: index.php?" . "selected_user_id=" . $selected_user->id ); 
		  exit();
    }
	
    catch(Exception $ex) 
	{
		$error_response = $ex->getMessage();
	}
}

// Must delete in order.
/*elseif (isset($params->remove))
{
	try {
	$selected_user = R::load("logusers",$params->selected_user_id);
	R::trash($selected_user);
	
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
}*/

// Cascade delete
elseif (isset($params->remove))
{
	try {
	$selected_user = R::load("logusers",$params->selected_user_id);
	$users_bikes = R::find("logbikes", "userid = ?", array($params->selected_user_id));
	
	foreach($users_bikes as $bike)
	{
		$bike_entries = R::find("logentries", "bikeid = ?", array($bike->id));
		foreach ($bike_entries as $entry)
		{
			R::trash($entry);
		}
		R::trash($bike);
	}
	
	R::trash($selected_user);
	
	// Redirect to index.php with nothing displayed.
    header( "location: index.php");
    exit();
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

<h2>Select an owner</h2>

<form action="" method="">

 	<select name="selected_user_id">
  	  	<?php foreach ($users as $user): ?>
   		 	<option value="<?php echo $user->id?>" <?php if ($user->id == $params->selected_user_id) echo "selected" ?> >
				<?php echo $user->owner ?>
			</option>
  	<?php endforeach ?>
 	</select>

	<button type="submit" name="show">Modify/Remove</button>
</form>

<?php if (isset($params->show)): ?>
<table>
	<form action="" method="">
		<tr><td> Owner: </td></tr> 
		<tr><td>
				<input class="field_size" type="text" name="selected_owner"
       				value="<?php echo $selected_user->owner ?>" /></td>
		</tr>
		
		<tr><td> Phone number: </td></tr> 
		<tr><td><input class="field_size" type="text" name="selected_phonenumber" 
	       			value="<?php echo $selected_user->phonenumber ?>" /></td>
		</tr>
		
		<tr>
			<td>
				<button type="submit" name="save">Save</button>
				<button type="submit" name="remove">Remove</button>
			</td>
		</tr>
		<input name="selected_user_id" type="hidden" value="<?php echo $params->selected_user_id?>"/>
	</form>
</table>
<?php endif;?>

<h3><?php echo $error_response ?></h3>

</div><!-- content -->
</div><!-- container -->

<script type="text/javascript">
/* local JavaScript */
function getSelf() { return "<?php echo basename($_SERVER['PHP_SELF'])?>"; }

function confirmation() {
  if (!confirm("This will delete the owner and all of their information.")) 
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
