<?php
$aliases['prod'] = array(
    'uri' => 'http://bceln.ca',
    'root' => '/home/bcelnadmin/public_html',
    'remote-host' => 'van-share4.ezp.net',
    'remote-user' => 'bcelnadmin',
    'os' => 'Linux',
    'ssh-options' => '-p 2022',
    'path-aliases' => array(
        '%dump' => 'bceln-db.sql',
    ),
    'variables' => array(
        'site_name' => "BC Electronic Library Network",
    ),
);

$aliases['dev'] = array(
    'uri' => 'http://dev.bceln.affinitybridge.com',
    'root' => '/home/bceln/domains/dev.bceln.affinitybridge.com/public_html',
    'remote-host' => 'affinity02.cantrusthosting.coop',
    'remote-user' => 'bceln',
    'os' => 'Linux',
    'ssh-options' => '-p 22222',
    'path-aliases' => array(
        '%dump' => 'bceln-db.sql',
    ),
    'variables' => array(
        'site_name' => "BC Electronic Library Network",
    ),
    'command-specific' => array(
        'sql-sync' => array(
            'sanitize' => TRUE,
        ),
    ),
);
?>

