<?php
require_once "include/Session.php";
$session = new Session();
if (isset($session->valid)) {
  require_once "index.php"; 
  exit();
}

$message = $session->message;
unset($session->message);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" 
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
<title>Login</title>

<link rel="stylesheet" type="text/css" href="css/layout.css" />
<style type="text/css">
/* local style rules */
#response {
  color: #00c;
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

<h2>Login</h2>

<h2>Please enter access password</h2>

<form action="validate.php" method="post" autocomplete="off">    
  <input type="password" name="password" />
  <button type="submit">Access</button>
</form>

<h3 id="response"><?php echo $message ?></h3>

</div><!-- content -->
</div><!-- container -->

</body>
</html>
