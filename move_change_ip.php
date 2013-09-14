<?php

check_host_name();

$ip_new = $argv[1];

$domain_list = file('sites_moved.txt');

foreach ($domain_list as $domain_name)
{
    $domain_name =  trim($domain_name);
    if (!empty($domain_name))
    {
        $zone_file = "/var/named/$domain_name.db";

        if (file_exists($zone_file))
        {
            $ip_old_real = find_ip($domain_name, 'localhost');
            $ip_new_real = find_ip($domain_name, $ip_new);

            if ($ip_old_real != $ip_new_real)
            {
                echo "Domain Name $domain_name have old ip = $ip_old_real and new ip = $ip_new_real\n";
                $cmd = "/usr/bin/replace $ip_old_real $ip_new_real -- /var/named/$domain_name.db";
                exec("$cmd");
            }
            else
            {
                echo "Domain Name $domain_name already points to new IP: $ip_new_real\n";
            }
        }
        else
        {
            echo "Zone file missing - $zone_file\n";
        }
    }
}

function find_ip($domain_name, $dns_server)
{
    exec("dig +short $domain_name @$dns_server", $output, $retval);

    if ($retval != 0)
    {
        die('Failed finding local IP for ' . $domain_name);
    }
    else
    {
       return $output[0];
    }
}

exec("service named reload");



function check_host_name()
{
    exec("/bin/hostname",$output, $retval);

    if ($retval == 0)
    {
        $hostname = $output[0];
    }
    else
    {
        die('Failed to find hostname');
    }

    if (strpos($hostname, 'old') === false)
    {
        die('Old server hostname should control word old, if your server host name is server2.hosthat.com, change it to oldserver2.hosthat.com');
    }
}

