# TeeTree Example project (quick start)

## This project represents a simple basic use of the [TeeTree](https://github.com/andyboxer/TeeTree) RSI mechanism

### Pre-requisites

A working installation of the [TeeTree](https://github.com/andyboxer/TeeTree) RSI project.
For the purposes of this document we will assume a TeeTree Server deployment directory of /usr/local/TeeTree.

### Installation

Clone this repository to a directory on your machine, for the purposes of this document we will assume a deployment directory of /usr/local/TeeTreeExample.

#### Created directories

You will find the following directories under your chosen deployment directory:

* TeeTreeClient ~ In this directory is a client script that we shall run to demonstrate the TeeTree RSI.
* TeeTreeServer ~ In this directory is an example of a TeeTree remote service class "ExampleServiceClass.php" and a configuration file "TeeTreeConfiguration.php".

### Configuration

In order to be able to run the example project you will need to set some configuration options, in order to do this edit the TeeTreeConfiguration.php file.
The contents of the file look as follows:

        class TeeTreeConfiguration
        {
            // the path to the php executable file - this MUST be an absolute path
            // However this example assumes that the executable is on the current users path
            const PATH_TO_PHP_EXE = "php";
        
            // the port on which the TeeTree controller has been configured to listen
            const TEETREE_SERVER_PORT = 11511;
        
            // the port on which the TeeTree controller has been configured to listen
            const TEETREE_SERVER_HOST = "localhost";
        
            // the initial value for service instance message channel ports
            const MINIMUM_SERVICE_PORT = 22000;
        
            // the maximum value for service instance message channel ports
            const MAXIMUM_SERVICE_PORT = 48000;
        
            // maximum size of a TeeTree message, any large than this and you may just be using the wrong mechanism for it's transport.
            const MAX_MESSAGE_SIZE = 1000000;
        
            // socket accept timeout for all socket listeners
            const ACCEPT_TIMEOUT = 120;
        
            // timeout for socket read and write operations
            const READWRITE_TIMEOUT = 30;
        
            // timeout for connection to the TeeTree controller
            const CLIENT_CONNECT_TIMEOUT = 120;
        
            // The maximum number of times to try and send a constructor response back on a TeeTree controller pipe.
            const CONSTRUCTOR_MAX_RETRY = 5;
        
            // The delay in microseconds to wait before retrying a constructor call
            const CONSTRUCTOR_RETRY_DELAY = 500;
        
            // The minimum time before a TeeTree remote service instance may be re-used
            // Note: this value must be at least 1 to prevent object collisions.
            // A large value would give a larger pool of process connections ( be careful of memory usage if increased )
            const OBJECT_REUSE_DELAY = 3;
        
            // enable tracing of messages read and written by the service server call handler. Useful for debugging service classes
            const ENABLE_CALL_LOGGING = true;
        
            // the server error log
            const TEETREE_ERROR_LOG = "/var/log/TeeTree/exampleError.log";
        
            // the server message log
            const TEETREE_SERVER_LOG = "/var/log/TeeTree/exampleServer.log";
        
            // the path to the call tracing log file
            const TEETREE_CALL_LOG = "/var/log/TeeTree/exampleCall.log";
        
            // PLACE USER DEFINED VALUE PAIRS BELOW THIS LINE //
        
            // This is parameter for the use of this example project only it will have no meaning for nor effect upon the operation of the TeeTree RSI
            const EXAMPLE_DEBUG_LOG = "/var/log/TeeTree/exampleServiceClass.log";       // the path to the Example debugging log
        }

You should change these values as required for your environment, however this file MUST contain all the values if you require them changed or not

The values you will most likely want to change are:

* PATH_TO_PHP_EXE ~ you should set this to the full absolute path to your php executable file.
* DEFAULT_SERVICE_PATH ~ you should set this to the full absolute path to the directory in whish your service classes and configuration file now live.
* TEETREE_SERVER_HOST ~ you may use this value to run cross network tests with a remote TeeTree Controller instance.

Next ensure you have your logging files configured correctly and that any required directories exist in the file system and have appropriate permissions for the launching user.

### Running the server example

Once you have configured the TeeTreeConfiguration file appropriately you can then start the TeeTree controller.

Execute the following command to start the TeeTree Controller

    php /usr/local/TeeTree/server/TeeTreeAdmin.php start /usr/local/TeeTreeExample/TeeTreeServer 11511
    
This will start the controller listening on port 11511 and using class definition files below the /usr/local/TeeTreeExample/TeeTreeServer only.
    
This should print 'Controller starting ...' and exit.

The TeeTree controller should now be running and waiting for service requests on the configured port ( 11511 in example above )
The /var/log/TeeTree/exampleServer.log should now contain the startup messages from the server detailing the service port and host name.

e.g.

        Date: 2012-09-05 19:06:09, Origin: service controller, Code: TTSVR02, Message: Service controller started on port 11511

In order to shut down the TeeTree Controller execute the following command

        php /usr/local/TeeTree/server/TeeTreeAdmin.php stop /usr/local/TeeTreeExample/TeeTreeServer 11511
        
This should terminate the TeeTree controller and print the following lines to the exampleServer.log

        Date: 2012-09-05 19:08:04, Origin: service controller, Code: TTSVR03, Message: Service controller shutdown on port 11511
        
### Running the client example

To run the client example you will need to start the TeeTree controller by executing the start command as above.

    php /usr/local/TeeTree/server/TeeTreeAdmin.php start /usr/local/TeeTreeExample/TeeTreeServer 11511
    .
Now change directory to the TeeTreeClient directory of the deployment.

To run the client run the following command:

    php TeeTreeExampleClient.php 
    
Note: this will make use of the same configuration file as the server uses to start. In practical use there would be a configuration file for each.
    
The TeeTreeExampleClient script will instantiate the service class ExampleServiceClass and then call the following methods upon it:

* getConstructorParams() ~ this is a TeeTreeClient supplied method which enables a client to read back the constructor params used to instantiate the service object instance.
        
        You should see the following output from this call in your terminal output
        
        Some configurartion parameters        
        
* shuffle($string) ~ this is a method which will take a parameter string apply str_shuffle to it and return the result.

        You should see output similar to the following from this call in your terminal output
        
        bakatcha:   innk l  ai aaahr ohpkr ssdwfteei yit ca
        
### Test service logging output

Unless you have changed the log path for the example then the TeeTree system logs will be placed at /var/log/TeeTree

The following logs are created during the example execution.

#### The exampleCall.log 

This log contains details of the messages which flow between client and server during remote service invocation.
        
In the exampleCall.log file you will see a log of the service constructor and method invocation messages looking something like as follows:

        Date: 2012-08-01 06:19:47, Origin: unknown, Code: 0, Message: TeeTree worker waiting
        Date: 2012-08-01 06:19:47, Origin: unknown, Code: 0, Message: TeeTree worker message received : {"serviceClass":"ExampleServiceClass","serviceMethod":"getConstructorParams","serviceData":[],"serviceMessageType":"TEETREE_CALL"}
        Date: 2012-08-01 06:19:47, Origin: unknown, Code: 0, Message: TeeTree worker sending response : {"serviceClass":"ExampleServiceClass","serviceMethod":"getConstructorParams","serviceData":["Some configurartion parameters"],"serviceMessageType":"TEETREE_CALL"}
        Date: 2012-08-01 06:19:47, Origin: unknown, Code: 0, Message: TeeTree worker message received : {"serviceClass":"ExampleServiceClass","serviceMethod":"shuffle","serviceData":["this is a nice day for a walk in the park"],"serviceMessageType":"TEETREE_CALL"}
        Date: 2012-08-01 06:19:47, Origin: unknown, Code: 0, Message: TeeTree worker sending response : {"serviceClass":"ExampleServiceClass","serviceMethod":"shuffle","serviceData":"\nbakatcha:   innk l  ai aaahr ohpkr ssdwfteei yit ca\n","serviceMessageType":"TEETREE_CALL"}
        Date: 2012-08-01 06:19:47, Origin: unknown, Code: 0, Message: TeeTree worker message received : {"serviceClass":"ExampleServiceClass","serviceMethod":null,"serviceData":null,"serviceMessageType":"TEETREE_FINAL"}
        Date: 2012-08-01 06:19:47, Origin: unknown, Code: 0, Message: TeeTree worker waiting
        Date: 2012-08-01 06:19:57, Origin: unknown, Code: 0, Message: TeeTree worker exiting
 
You will notice that the worker thread does not exit immediately but are returned to a pool and re-used subject to a wait timeout.

#### The exampleError.log 

This log contains details of any runtime errors encountered by the server, this should be empty if the installation is good and first point of call if it isn't.

#### The exampleServiceClass.log 

This log is used by the example service instance and records each request recieved by the service worker.

 
For further details eg. configuring for execution on a remote host, controlling the TeeTree controller, gathering controller stats and other admin tasks pls see the [project wiki](https://github.com/andyboxer/TeeTree/wiki).
