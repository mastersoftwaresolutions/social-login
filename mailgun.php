<?php
# Include the Autoloader (see "Libraries" for install instructions)
require 'vendor/autoload.php';
use Mailgun\Mailgun;

# Instantiate the client.
$mgClient = new Mailgun('key-3a-cr7kryju2n0qtwnl0rwuu1feovhb3');
$domain = "http://enochsystems.mastersoftwaresolutionsindia.com";

# Make the call to the client.
$result = $mgClient->sendMessage("$domain",
                  array('from'    => 'Randhir Singh <randhirsinghpaul@gmail.com>',
                        'to'      => 'Baz <mss.randhir@gmail.com>',
                        'subject' => 'Hello',
                        'text'    => 'Testing some Mailgun awesomness!'));
?>
