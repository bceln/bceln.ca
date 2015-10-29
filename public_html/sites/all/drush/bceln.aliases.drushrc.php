<?php
$aliases['ezp'] = array(
    'uri' => 'http://coppul.ca',
    'root' => '/home/coppul/public_html',
    'remote-host' => 'van-ded-1345-2.ezp.net',
    'remote-user' => 'coppul',
    'os' => 'Linux',
    'ssh-options' => '-p 2022',
    'path-aliases' => array(
        '%dump' => 'coppul-db.sql',
    ),
);

$aliases['prod'] = array(
    'uri' => 'http://coppulca.ctweb10.ct.coop',
    'root' => '/home/coppul/public_html',
    'remote-host' => 'ctweb10.cantrusthosting.coop',
    'remote-user' => 'coppul',
    'os' => 'Linux',
    'ssh-options' => '-p 22222',
    'path-aliases' => array(
        '%dump' => 'coppul-db.sql',
    ),
    'variables' => array(
        'site_name' => "Council of Prairie and Pacific University Libraries",
    ),
);

$aliases['stage'] = array(
    'parent' => '@prod',
    'uri' => 'http://stagecoppulca.ctweb10.ct.coop',
    'root' => '/home/coppul/domains/stage.coppul.ca/public_html',
    'variables' => array(
        'site_name' => "Council of Prairie and Pacific University Libraries (stage)",
    ),
);

$aliases['dev'] = array(
    'parent' => '@prod',
    'uri' => 'http://dev.coppul.affinitybridge.com',
    'root' => '/home/coppul/domains/dev.coppul.affinitybridge.com/public_html',
    'remote-host' => 'affinity02.cantrusthosting.coop',
    'remote-user' => 'coppul',
    'variables' => array(
        'site_name' => "Council of Prairie and Pacific University Libraries (dev)",
    ),
    'command-specific' => array(
        'sql-sync' => array(
            'sanitize' => TRUE,
        ),
    ),
);
?>
