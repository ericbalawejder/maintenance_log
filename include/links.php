<?php
require_once "include/Session.php";
$session = new Session();
?>
<ul>
  <li><a href="index.php">Home</a></li>
  <?php if (isset($session->valid)): ?>
      <li><a href="add_user.php">Add User</a></li>
      <li><a href="add_bike.php">Add Bike</a></li>
	  <li><a href="add_entry.php">Add Entry</a></li>
	<li><a href="modify_user.php">Modify User</a></li>
	<li><a href="modify_bike.php">Modify Bike</a></li>
  <?php endif  ?>
  <li style="position: absolute;bottom:5px;left:0">
    <?php if (!isset($session->valid)): ?>
    <a href="login.php">Login</a>
    <?php else: ?>
    <a href="logout.php">Logout</a>
    <?php endif  ?>
  </li>
</ul>
