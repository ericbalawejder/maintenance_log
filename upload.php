<?php
require_once "include/Session.php";
$session = new Session();
if (!isset($session->valid)) {
  require_once "expired.php";
  exit();
}
//==== start below here

require_once "include/extra.php";
$params = (object) $_REQUEST;
 
if (isset($params->doit)) {
  try {
    $upload = (object) $_FILES["upload"];
    if ($upload->error > 0) {
      throw new Exception("upload error");
    }
    $filename = basename($upload->name);
    $full_path = "$images_dir/$filename";
 
	// check upload file type and reject non-images
	$mimetype = $upload->type;
	list($type,$subtype) = explode("/",$mimetype);
	if ($type !== "image") {
	   throw new Exception("file not an image");
	}
    
	// avoid replacing an existing file
	if (file_exists($full_path)) {
	   throw new Exception("file already exists");
	}
	
    // move file to upload folder and set world-read permissions
    $success = rename($upload->tmp_name, $full_path);
    if (!$success) {
      throw new Exception("file move failure");
    }
    chmod($full_path, 0777);
    //-----
 
    $response = "OK";
  } catch(Exception $ex) {
    $response = $ex->getMessage();
  } 
}
else {
  $response = "";
  $upload = "";
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" 
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
<title>Upload</title>

<link rel="stylesheet" type="text/css" href="css/layout.css" />
<style type="text/css">
/* local style rules */
input[type='file'] {
  background: #900;
  color: white;
  width: 500px;  /* works for Chrome, not Firefox */
}
</style>

<script type="text/javascript" src="js/jquery-1.6.4.min.js"></script>
<script type="text/javascript" src="js/init.js"></script>
<script type="text/javascript">
/* local JavaScript */
function getSelf() { return "<?php echo basename($_SERVER['PHP_SELF'])?>"; }
$(window).load(function() {
  $.getJSON("isvalid.php", function(valid) { if (!valid) location.reload() })
});
$(window).unload(function() { }); // Safari hack
 
</script>
</script>
</head>

<body>
<div id="navigation"><?php require_once "include/links.php" ?></div>
<div id="container">
<div id="header"><?php require_once "include/header.php" ?></div>
<div id="content"><!-- content -->


<h2>Upload Image</h2>

<pre><?php
//print_r($params);
//print_r($upload);
?></pre>
 
<form enctype="multipart/form-data" action="" method="post">
File:
<br />
<input type="file" name="upload" size="60" />
<br />
<br />
<button type="submit" name="doit">Upload</button>
</form>
 
<h3 id="response"><?php echo $response ?></h3>

<pre><?php
//echo "params: "; 
//echo "upload: "; 
?></pre>

<script type="text/javascript">
function getSelf() { ... }
 
$(document).ready(function() {
  $("#response").fadeOut(5000); 
});
</script>

</div><!-- content -->
</div><!-- container -->

</body>
</html>
