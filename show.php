<?php
require_once "include/Session.php";
$session = new Session();
if (!isset($session->valid)) {
  require_once "must_login.php";
  exit();
}

require_once "include/db.php";
$params = (object) $_REQUEST;

//print_r($params);

$entries = R::find("logentries", 'bikeid = ?', array($params->selected_bike_id));
$selected_bike = R::findOne("logbikes", "id = ?", array($params->selected_bike_id));
$selected_user = R::findOne("logusers", "id = ?", array($params->selected_user_id));

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" 
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
<title>Show</title>

<link rel="stylesheet" type="text/css" href="css/layout.css" />
<style type="text/css">
/* local style rules */
</style>

</head>

<body>
<div id="navigation"><?php require_once "include/links.php" ?></div>
<div id="container">
<div id="header"><?php require_once "include/header.php" ?></div>
<div id="content"><!-- content -->

<h2>Documented work</h2>

<?php if (count($entries) > 0): ?>
	
<?php foreach ($entries as $entry): ?>
	
Owner: <?php echo $selected_user->owner?>
<br />
Make: <?php echo $selected_bike->make?>

Model: <?php echo $selected_bike->model?>

Year: <?php echo $selected_bike->year?>
<br />
Entry date: <?php echo $entry->entrydate?>
<br />
Hours: <?php echo $entry->hours?>
<br />
Notes: <?php echo $entry->notes?>
<br />
<a href="modify_entry.php?selected_entry_id=<?php echo $entry->id ?>&selected_bike_id=<?php echo $selected_bike->id?>&selected_user_id=<?php echo $selected_user->id ?> ">Modify</a>
<p />

<?php endforeach ?>

<?php else: ?>
	<h3>No entries for this bike<h3>
	
<?php endif; ?>
		
</div><!-- content -->
</div><!-- container -->

<script type="text/javascript" src="js/jquery-1.6.4.min.js"></script>
<script type="text/javascript" src="js/init.js"></script>
<script type="text/javascript">
/* local JavaScript */
function getSelf() { return "<?php echo basename($_SERVER['PHP_SELF'])?>"; }
</script>

</body>
</html>
