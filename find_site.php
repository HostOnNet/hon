<?php

$site = $argv[1];

$dir = "/oldhome/";

if (is_dir($dir))
{
    if ($dh = opendir($dir))
    {
        while (($file = readdir($dh)) !== false)
        {
        	if ($file == '.' || $file == '..' || $file == 'BUAgent.LOG')
        	{
        		continue;
        	}
        	
        	if (filetype($dir . $file) == "dir")
        	{
            	$cpanel_user_file = $dir . $file . "/mail/" . $site;
            	
    	       	if (file_exists($cpanel_user_file))
	           	{
	           		echo "\n\n";
            		echo $cpanel_user_file. "\n";
            		echo "\n\n";
            		exit;
            	}
            	
        	}
        }
        closedir($dh);
    }
}
