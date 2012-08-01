# TeeTree Example project (quick start)

## This project represents a simple basic use of the TeeTree RSI mechanism

### Pre-requisites

A working installation of the TeeTree RSI project ( see TeeTree project for details of installation and pre-requisites ).

### Installation

Clone this repository to a directory on your machine, for the purposes of this document we will assume a working directory of /usr/local/TeeTree.

#### Created directories

You will find the following directories under your chosen deployment directory:

* client ~ In this directory is a client script that we shall run to utilise the TeeTree RSI.
* launcher - In this directory is an example of a launcher for the TeeTree Controller, we shall use this to start and stop the Controller.
* serviceClasses ~ In this directory is an example of a TeeTree remote service class and a configuration file for both client and server.

### Configuration

In order to be able to run the example project you will need to set some configuration options, in order to do this edit the TeeTreeConfiguration.php file.
The contents of the file look as follows:

        class TeeTreeConfiguration
        {
            const TEETREE_SERVER_PORT = 11511;                                          // the port on which the TeeTree controller has been configured to listen
            const MINIMUM_SERVICE_PORT = 22000;                                         // the initial value for service instance message channel ports
            const MAX_MESSAGE_SIZE = 1000000;                                           // maximum size of a TeeTree message, any large than this and you may just be using the wrong mechanism for it's transport.
            const ACCEPT_TIMEOUT = 10;                                                  // socket accept timeout for all socket listeners
            const READWRITE_TIMEOUT = 600;                                              // timeout for socket read and write operations
            const CLIENT_CONNECT_TIMEOUT = 93;                                          // timeout for connection to the TeeTree controller
            const DEFAULT_SERVICE_PATH = "/home/webapps/TeeTreeExample/serviceClasses"; // the service class directory for the test scripts
            const PATH_TO_PHP_EXE = "/usr/local/zend/bin/php";                          // the path to the php executable file - this MUST be an absolute path
            const DEFAULT_ERROR_LOG = "/var/log/TeeTree/exampleError.log";              // the server error log
            const DEFAULT_SERVER_LOG = "/var/log/TeeTree/exampleServer.log";            // the server message log
            const DEFAULT_TEST_LOG = "/var/log/TeeTree/exampleService.log";             // the test service output log
            const ENABLE_CALL_TRACING = true;                                           // enable tracing of messages read and written by the service server call handler. Useful for debugging service classes
            const CALL_TRACING_LOG = "/var/log/TeeTree/exampleCall.log";                // the path to the call tracing log file
        }

You should change these values as required for your environment, however this file MUST contain all the values if you require them changed or not

The values you will most likely want to change are:

* PATH_TO_PHP_EXE ~ you should set this to the full absolute path to your php executable file.
* DEFAULT_SERVICE_PATH ~ you should set this to the full absolute path to the directory in whish your service classes and configuration file now live.

Next ensure you have your logging files configured correctly and that any required directories exist in the file system and have appropriate permissions for the launching user.

### Running the server example

Once you have configured the TeeTreeConfiguration file appropriately you can then start the TeeTree controller.
In a terminal navigate to the TeeTreeExample/launcher directory
execute the following command to start the TeeTree Controller

    php StartTeeTreeController.php start
    
This should print 'Controller starting ...' and exit, the TeeTree controller should now be running and waiting for service requests on the configured port ( 11511 in example above )
The exampleServer.log should now contain the startup messages from the server detailing the service port and host name.

e.g.

        Date: 2012-08-01 05:25:09, Origin: service controller, Code: TTSVR02, Message: Service controller starting on port 11511
        Date: 2012-08-01 05:25:09, Origin: service controller, Code: TTSVR02, Message: Service controller started on port 11511


In order to shut down the TeeTree Controller execute the following command

        php StartTeeTreeController.php stop
        
This should terminate the TeeTree controller and print the following lines to the exampleServer.log

        Date: 2012-08-01 06:09:58, Origin: service controller, Code: TTSVR03, Message: Service controller stopped on port 11511
        
### Running the client example

In order to run the client example you will need to restart the TeeTree controller by executing the start command as above

    php StartTeeTreeController.php start
    .
Now you can change directory to the client directory of the deployment.

In order to run the client run the following command:

    php TeeTreeClient.php 
    
This will instantiate the service class ExampleServiceClass and call the following methods upon it:

* getConstructorParams() ~ this is a TeeTree supplied method which enables a client to read back the constructor params used to instantiate the service object instance.
        
        You should see the following output from this call in your terminal output
        
        Some configurartion parameters        
        
* shuffle ~ this is a method which will take a parameter string apply str_shuffle to it and return the result.

        You should see output similar to the following from this call in your terminal output
        
        bakatcha:   innk l  ai aaahr ohpkr ssdwfteei yit ca
        
        
In the exampleService.log file you will see a log of the service constructor and method invocation messages looking something like as follows:

        Date: 2012-08-01 06:19:47, Origin: unknown, Code: 0, Message: TeeTree worker waiting
        Date: 2012-08-01 06:19:47, Origin: unknown, Code: 0, Message: TeeTree worker message received : {"serviceClass":"ExampleServiceClass","serviceMethod":"getConstructorParams","serviceData":[],"serviceMessageType":"TEETREE_CALL"}
        Date: 2012-08-01 06:19:47, Origin: unknown, Code: 0, Message: TeeTree worker sending response : {"serviceClass":"ExampleServiceClass","serviceMethod":"getConstructorParams","serviceData":["Some configurartion parameters"],"serviceMessageType":"TEETREE_CALL"}
        Date: 2012-08-01 06:19:47, Origin: unknown, Code: 0, Message: TeeTree worker message received : {"serviceClass":"ExampleServiceClass","serviceMethod":"shuffle","serviceData":["this is a nice day for a walk in the park"],"serviceMessageType":"TEETREE_CALL"}
        Date: 2012-08-01 06:19:47, Origin: unknown, Code: 0, Message: TeeTree worker sending response : {"serviceClass":"ExampleServiceClass","serviceMethod":"shuffle","serviceData":"\nbakatcha:   innk l  ai aaahr ohpkr ssdwfteei yit ca\n","serviceMessageType":"TEETREE_CALL"}
        Date: 2012-08-01 06:19:47, Origin: unknown, Code: 0, Message: TeeTree worker message received : {"serviceClass":"ExampleServiceClass","serviceMethod":null,"serviceData":null,"serviceMessageType":"TEETREE_FINAL"}
        Date: 2012-08-01 06:19:47, Origin: unknown, Code: 0, Message: TeeTree worker waiting
        Date: 2012-08-01 06:19:57, Origin: unknown, Code: 0, Message: TeeTree worker exiting
 
 You will notice that the worker thread does not exit immediately ( these will be reused in subsequent revisions of the code )
 
 ### In conclusion
 
 This is all that is required to get off the ground with TeeTree, If you take a look at the example files the comments should be enough for you to start creating your own service classes and execute them.
 
 For for further details eg. configuring for execution on a remote host, controlling the TeeTree controller, gathering controller stats and othe admin tasks pls see the project wiki.
