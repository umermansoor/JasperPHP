<h2> Login to LiveCams </h2>

<?php
// Check if the previous attempt failed
if (isset($failed))
{
	print("<p>Incorrect username or password</p>");
}

?>

<?php
$submitUrl = "../controllers/$controller.php";
?>

<form action = "<?php /* The controller URL */ print($submitUrl);?>" method="get">
Username: <input type="text" name="username" /> <br />
Password: <input type="text" name="password">
<input type="hidden" name="a" value="<?php /* Required action within controller */  print($action);?>">
<input type="submit" value="Submit" /> 	
</form>
