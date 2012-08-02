<?php
/**
 * @package TeeTreeExample
 * @author Andrew Boxer
 * @copyright Andrew Boxer 2012
 * @license Released under version 3 of the GNU public license - pls see http://www.opensource.org/licenses/gpl-3.0.html
 *
 */

/*
 * NOTE: When over-riding this configuration file you MUST implement all the parameters
 * as this will NOT inherit from the configuration class in the TeeTree project.
 * You may of course add additional values for your own purposes without affecting the operation of the client or server.
 * You must also ensure that your copy of this file is included before all and any inclusion of TeeTreeBootStrap.php
 */

class TeeTreeConfiguration
{
    const TEETREE_SERVER_PORT = 11511;                                          // the port on which the TeeTree controller has been configured to listen
    const MINIMUM_SERVICE_PORT = 22000;                                         // the initial value for service instance message channel ports
    const MAX_MESSAGE_SIZE = 1000000;                                           // maximum size of a TeeTree message, any large than this and you may just be using the wrong mechanism for it's transport.
    const ACCEPT_TIMEOUT = 10;                                                  // socket accept timeout for all socket listeners
    const READWRITE_TIMEOUT = 600;                                              // timeout for socket read and write operations
    const CLIENT_CONNECT_TIMEOUT = 93;                                          // timeout for connection to the TeeTree controller
    const CONSTRUCTOR_MAX_RETRY = 5;                                            // The maximum number of times to try and send a constructor response back on a TeeTree controller pipe.
    const DEFAULT_SERVICE_PATH = "/home/webapps/TeeTreeExample/serviceClasses";	// the service class directory for the test scripts
    const PATH_TO_PHP_EXE = "/usr/local/zend/bin/php";                          // the path to the php executable file - this MUST be an absolute path
    const DEFAULT_ERROR_LOG = "/var/log/TeeTree/exampleError.log";              // the server error log
    const DEFAULT_SERVER_LOG = "/var/log/TeeTree/exampleServer.log";            // the server message log
    const ENABLE_CALL_TRACING = true;                                           // enable tracing of messages read and written by the service server call handler. Useful for debugging service classes
    const CALL_TRACING_LOG = "/var/log/TeeTree/exampleCall.log";                // the path to the call tracing log file

    // This is parameter for the use of this example project only it will have no meaning for nor effect upon the operation of the TeeTree RSI
    const EXAMPLE_DEBUG_LOG = "/var/log/TeeTree/exampleServiceClass.log";       // the path to the Example debugging log
}
?>
