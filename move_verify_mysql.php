<?php

/*
Verify mysql databases after server move.
Some times cpanel transfer fail to copy databases.
*/

$mysql_dir = "/var/lib/mysql/";
$mysql_backup_dir = "/backup/old_mysql/";

if (is_dir($mysql_backup_dir))
{
    if ($dh = opendir($mysql_backup_dir))
    {
        while (($db_name = readdir($dh)) !== false)
        {
            if ($db_name == '.' || $db_name == '..')
            {
                continue;
            }

            $path_to_db = $mysql_dir . $db_name;
            $path_to_backup_db = $mysql_backup_dir . $db_name;

            if (filetype($path_to_backup_db) == "dir")
            {
                $disk_space_backup =  du($path_to_backup_db);
                $disk_space =  du($path_to_db);

                if ($disk_space < $disk_space_backup)
                {
                    echo "Size of $path_to_backup_db is bigger $disk_space < $disk_space_backup\n";
                }

            }

        }
        closedir($dh);
    }
}


function du( $dir )
{
    $res = `du -s $dir`;
    preg_match( '/\d+/', $res, $output );
    return $output[0];
}
