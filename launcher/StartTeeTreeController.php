<?php
/**
 * @package TeeTreeExample
 * @author Andrew Boxer
 * @copyright Andrew Boxer 2012
 * @license Released under version 3 of the GNU public license - pls see http://www.opensource.org/licenses/gpl-3.0.html
 *
 */

// First ensure that it is our version of TeeTreeConfiguration that loads first
$configurationFile = __DIR__. "/../serviceClasses/TeeTreeConfiguration.php";
require_once($configurationFile);

// Now we call the bootstrap to setup the TeeTree environment ( I think I'll call this a Kettle :)
require_once("/home/webapps/TeeTree/config/TeeTreeBootStrap.php");

if(isset($argv[1]) && $argv[1] === "start")
{
    // Now we can get started and kick off the TeeTree Controller process
    print("controller starting ...\n");
    // We start the service controller passing a port nunber and the class path to our services classes ( This is strictly one directory intentionally and must be r/o )
    TeeTreeController::startServer(TeeTreeConfiguration::DEFAULT_SERVICE_PATH, TeeTreeConfiguration::TEETREE_SERVER_PORT);
    // This process will now continue untill the TeeTreeController::stopServer call is made using the same port no.
}
else
{
    // So we want to bail, kill the server
    TeeTreeController::stopServer('localhost', TeeTreeConfiguration::TEETREE_SERVER_PORT);
}
?>