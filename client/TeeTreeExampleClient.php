<?php
// In order to first ensure we have a TeeTree Environment ( Kettle :) we include our configuration file and then the bootstrap
// It is in order to keep things simple here that the service controller port MUST be set in the configuration file

require_once(__DIR__. "/../serviceClasses/TeeTreeConfiguration.php");
// Note: this file is set to be the same instance as the server configuration, it may be different if required.
require_once("/home/webapps/TeeTree/config/TeeTreeBootStrap.php");

// Now we can declare our service proxy classes
// Here we define the class we wish to use as a proxy and configure the host and port of the TeeTree Controller
// The class name must match and only existing authorised method calls will be available
// Note to self: add service method manifest to avoid failed method calls

class ExampleServiceClass extends TeeTreeClient{protected $serviceHost = 'localhost'; protected $serviceControllerPort = TeeTreeConfiguration::TEETREE_SERVER_PORT;}

// Now we simply instantiate the class and use it
$exampleObject = new ExampleServiceClass("Some configurartion parameters");

// We can access the configuration parameter for the remote object instance
$response = $exampleObject->getConstructorParams();
echo $response[0] . "\n";

// You may now call the remote service object via the proxy instance exactly as if they were native to your code.
echo $exampleObject->shuffle("this is a nice day for a walk in the park") . "\n";

// Don't forget that the TeeTree controller will continue to run and service further requests
// untill it is closed by executing "php StartTeeTreeController.php stop"

// Try running this script repeatedly and tailing the following log files
// /var/log/TeeTree/
