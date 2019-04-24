<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once('src/JAXL/jaxl.php');
//in port 8222 update starttls_required: true to false
$client = new JAXL(array(
        'jid' => 'php@example.com',
        'pass' => '123',
        'host'=> '127.0.0.1',
        'port'=> 5222,
        //'domain'=> 'example.com',
        'strict' => false
        // 'force_tls' => true,
        // 'auth_type' => 'PLAIN'
));

$client->add_cb('on_connect_error', function() {
    echo 'Connect Error';
});

$client->add_cb('on_auth_failure', function() {
    echo 'Auth Error';
});

$client->add_cb('on_auth_success', function() {
    global $client;
    echo 'connected!';
    $client->set_status('Available');
    $users = ['asmaa_user@example.com', 'admin@example.com'];
    foreach($users as $userJid)
    {
        $client->send_chat_msg($userJid, 'I did it');
    }
    $client->disconnected('end_stream', NULL);
});

$client->add_cb('on_disconnect', function() {
    global $client;
    echo "disconnected!";

});

$client->start();
?>