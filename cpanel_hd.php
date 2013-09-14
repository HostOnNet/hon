<?php

$dir = "/oldhome/";

if (is_dir($dir))
{
    if ($dh = opendir($dir))
    {
        while (($file = readdir($dh)) !== false)
        {
        	if (filetype($dir . $file) == "dir")
        	{
            	$cpanel_user_file = '/var/cpanel/users/' . $file;
            	
            	if (!file_exists($cpanel_user_file))
            	{
            		echo $file. "\n";
            	}
            	
        	}
        }
        closedir($dh);
    }
}