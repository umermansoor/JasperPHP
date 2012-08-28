<h2> Control Panel Main Page</h2>
<?php
$logoutUrl = "../controllers/$controller.php?a=logout";
?>

<!-- Display the member links -->
<?php
foreach ($links as $key => $value )
{
	print("<a href=\"$value\">$key </a> <br />");
}
?>

<a href="<?php print($logoutUrl);?>"> Log Out </a>