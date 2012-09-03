<?php
echo <<<OUTPUT
/**
 * @package TeeTree
 * @author Andrew Boxer
 * @copyright Andrew Boxer 2012
 * @license Released under version 3 of the GNU public license - pls see http://www.opensource.org/licenses/gpl-3.0.html
 *
 */

This script tests the TeeTree Remote Service Invocation
In order to run this script the TeeTree controller must be started see TeeTree/launcher/StartTeeTreeController.php

This script will instantiate a TeeTree RSI client object via the TeeTree Controller
It then makes calls to two methods on the remote object instance.

Access / call logging will be written to the file configured at TeeTreeConfiguration::TEETREE_CALL_LOG
In order to see the message calls created by object instantiation and method invocation you may tail -f  < the value of TeeTreeConfiguration::TEETREE_CALL_LOG >

Loading environment and defining TeeTree Client proxy classes ...


OUTPUT;

// First we ensure our service configuration class is loaded before all else.
require_once(__DIR__. "/../TeeTreeServer/TeeTreeConfiguration.php");

// The TeeTree bootstrap needs to be included to be able to configure and use TeeTree Remote Service Instances
require_once("/home/webapps/TeeTree/bootstrap/TeeTreeBootStrap.php");

// Now we can declare our service proxy classes
// Here we define the class we wish to use as a proxy and configure the host and port of the TeeTree Controller
// The class name must match and only existing authorised method calls will be available
// Note to self: add service method manifest to avoid failed method calls
class ExampleServiceClass extends TeeTreeClient{protected $serviceHost = 'localhost'; protected $serviceControllerPort = TeeTreeConfiguration::TEETREE_SERVER_PORT;}

// Now we simply instantiate the class and use it
// Note: The constructor sets up tcp connections to the TeeTree controller, instantiates a remote object instance and communicates with it
// You should always wrap TeeTree Client object instantiation in a try catch block
print("Creating an instance of the ExampleServiceClass\n");
try
{
    $exampleObject = new ExampleServiceClass("Some configurartion parameters");
}
catch(TeeTreeExceptionServerConnectionFailed $ex)
{
    print("TeeTree Controller not available :". $ex->getMessage(). "\n");
    die("Client sccript bailing out!!!\n");
}

// We can access the configuration parameter for the remote object instance
$response = $exampleObject->getConstructorParams();
echo "ExampleServiceClass constructor parameters : '{$response[0]}\n";

// You may now call the remote service object via the proxy instance exactly as if they were native to your code.
echo "The return value from shuffle method call is : {$exampleObject->shuffle("this is a nice day for a walk in the park")}\n";

// If you uncomment the following line you can test the through put of a single request to a single object
$time = microtime(true);
for($i = 0; $i < 50; $i++) echo "{$exampleObject->shuffle("this is a nice day for a walk in the park")} No. {$i}\n";
print("Time taken in seconds = ". (microtime(true) - $time). "\n");


// Don't forget that the TeeTree controller will continue to run and service further requests
// untill it is closed by executing the following command:
// php TeeTreeExample/launcher/StartTeeTreeController.php stop

// Try running this script repeatedly and tailing the following log files
//   TEETREE_ERROR_LOG
//   TEETREE_SERVER_LOG
//   TEETREE_CALL_LOG
//   EXAMPLE_DEBUG_LOG

//  NOTE: The option to enable call trace logging should be turned off in production
//  i.e. set   ENABLE_CALL_LOGGING = false in the configuration file
//  ( file contention will cause markedly slower performance, but it's good during debug )
