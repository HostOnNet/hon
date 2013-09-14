<?php 

if (!isset($_POST['submit']))
{

?>


<form method="post">

New IP : <input type="text" name="new_ip">
<br />
Sites:

<br />

<textarea name="sites" cols="50" rows="20"></textarea>

<br />

<input type="submit" name="submit">
</form>


<?php 

}
else
{

	$new_ip = $_POST['new_ip'];
	$sites_a = $_POST['sites'];
	$sites = explode("\n",$sites_a);
	$sites_ok = "";
	
	foreach ($sites as $site)
	{
		$site = trim($site);
		
		if (strlen($site) > 4)
		{
			$site_ip = gethostbyname($site);
			
			if ($site_ip != $new_ip)
			{
				echo "$site == $site_ip<br/>";
			}
			else
			{
				$sites_ok .=  "<a href=\"http://$site\">$site == $site_ip</a><br/>";
			}
		}
	}
	
	echo "<br><hr><br>";
	echo "<p>Following sites are ok</p>";
	echo $sites_ok;
	
	
}

