$(document).ready(function(){
  if (window.getSelf != undefined) {
    $("#navigation a").each(function(){
      var href_file = basename(this.href) ? basename(this.href) : "index.php";
      if (href_file == getSelf()) {
        $(this).addClass('link-highlight');
      } else {
        $(this).removeClass('link-highlight');
      }
    })
  }
});

// from Php.JS
function basename (path, suffix) {
  if (suffix == null) suffix = ""
  var b = path.replace(/^.*[\/\\]/g, '');
  if (typeof(suffix) == 'string' && b.substr(b.length - suffix.length) == suffix) {
     b = b.substr(0, b.length - suffix.length);
  }
  return b;
}

// on index.php if the selected_user changes, refresh the list
// by redirecting with the new selected_user_id
function selectedUserChanged(data){
	var value = data.options[data.selectedIndex].value;
	window.location = "index.php?selected_user_id=" + value;
}
