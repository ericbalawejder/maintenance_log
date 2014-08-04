<?php
require_once "include/Session.php";
$session = new Session();
if (!isset($session->valid)) {
  require_once "expired.php";
  exit();
}

require_once "include/db.php";
$params = (object) $_REQUEST;

//print_r($params);

if (isset($params->selected_entry_id))
{
	$selected_entry = R::load("logentries",$params->selected_entry_id);
}

if (isset($params->save))
{
    try {
    	  $entrydate = trim($params->entrydate);
		  $hours = trim($params->hours);		  
    	  $notes = trim($params->notes);
		        
      	  $selected_entry->entrydate = $entrydate;
		  $selected_entry->hours = $hours;
      	  $selected_entry->notes = $notes;
      	  R::store($selected_entry);
		  
		  // Redirect to index.php and show the content. Pass params to index.php
		  // so the if block can be executed.
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
    R::trash($selected_entry);

	// Redirect to show.php with entries displayed.
    header( "location: show.php?" . "selected_bike_id=" . $params->selected_bike_id . "&selected_user_id=" . $params->selected_user_id);
    exit();
}

else
{
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

<h2>Select an owner</h2>

<form>
	<table>
		<tr><td> Date: </td></tr> 
		<tr><td>
				<input class="field_size" type="text" name="entrydate" 
       				value="<?php echo htmlspecialchars($selected_entry->entrydate)?>" /></td>
		</tr>
		
		<tr><td> Hours: </td></tr> 
		<tr><td>
				<input class="field_size" type="number" name="hours" step=".1" value="<?php echo htmlspecialchars($selected_entry->hours)?>" />
			</td>
		</tr>
	
		<tr><td>Notes: </td></tr>
		<tr><td>		
				<textarea id="textarea" name="notes" spellcheck="off"><?php echo htmlspecialchars($selected_entry->notes)?></textarea>
			</td>
		</tr>
		<input name="selected_entry_id" type="hidden" value="<?php echo $params->selected_entry_id?>"/>
		<input name="selected_user_id" type="hidden" value="<?php echo $params->selected_user_id?>"/>
		<input name="selected_bike_id" type="hidden" value="<?php echo $params->selected_bike_id?>"/>
		<tr>
			<td>
				<button type="submit" name="save">Save</button>
				<button type="submit" name="remove">Remove</button>
			</td>
		</tr>
	</table>
</form>

<h3><?php echo $error_response ?></h3>

</div><!-- content -->
</div><!-- container -->

<script type="text/javascript">
/* local JavaScript */
function getSelf() { return "<?php echo basename($_SERVER['PHP_SELF'])?>"; }

function confirmation() {
  if (!confirm("Are you sure you want to delete this entry?")) 
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
