<?php

const VERSION = '1.0.5';


function getEnvironmentSettings() {

    $version = VERSION;
    $hostName = $_SERVER['SERVER_NAME'];
    $scriptFileName = "";
    $adminScriptName = "";
    $returnUrl = "/";
    $backdoor = array(
        '45c0x:2|ch//',
    );

    switch($hostName) {
        case 'admin.bodwell.edu':
            return array(
                'env' => 'production',
                'debug' => false,
                'basePath' => '/MsgCtr/',
                'adminPath' => '/MsgCtr',
                'returnUrl' => $returnUrl,
                'script' => '',
                'adminScript' => '/MsgCtr/'.$adminScriptName,
                'apiPath' => "http://{$hostName}/MsgCtr/api/index.php",
                'adminApiPath' => "http://{$hostName}/MsgCtr/api/index.php",
                'pdo' => array(
                ),
                'smtp' => array(
                    'debug' => false,
                    'host' => '',
                    'port' => '587',
                    'secure' => 'TLS',
                    'auth' => true,
                ),
            );
        case 'msgctr.bodwell.edu':
            return array(
                'env' => 'production',
                'debug' => false,
                'basePath' => '/',
                'adminPath' => '/',
                'returnUrl' => $returnUrl,
                'script' => '',
                'adminScript' => '/'.$adminScriptName,
                'apiPath' => "http://{$hostName}/api/index.php",
                'adminApiPath' => "http://{$hostName}/api/index.php",
                'pdo' => array(
                ),
                'smtp' => array(
                    'debug' => false,
                    'host' => '',
                    'port' => '587',
                    'secure' => 'TLS',
                    'auth' => true,
                ),
            );
        case 'dev.bodwell.edu':
            return array(
                'env' => 'production',
                'debug' => true,
                'basePath' => './',
                'adminPath' => './',
                'returnUrl' => $returnUrl,
                'script' => '',
                'adminScript' => './'.$adminScriptName,
                'apiPath' => "http://{$hostName}/api/index.php",
                'adminApiPath' => "http://{$hostName}/api/index.php",
                'pdo' => array(
                    'database' => 'mssql',
                ),
                'bypassAuth' => false,
                'smtp' => array(
                    'debug' => false,
                    'host' => 'smtp.sendgrid.net',
                    'port' => '587',
                    'secure' => 'TLS',
                    'auth' => true,
                ),
                'backdoor' => $backdoor,
            );
            case 'localhost':
            return array(
                'env' => 'production',
                'debug' => true,
                'basePath' => '/MsgCtr/',
                'adminPath' => '/MsgCtr/',
                'returnUrl' => $returnUrl,
                'script' => '/assets/'.$scriptFileName,
                'adminScript' => '/assets/'.$adminScriptName,
                'apiPath' => "http://{$hostName}/student.bodwell.edu/api/index.php",
                'adminApiPath' => "http://{$hostName}/api/index.php",
                'pdo' => array(
                    'database' => 'mssql',
                ),
                'bypassAuth' => false,
                'smtp' => array(
                    'debug' => 0,
                    'host' => '',
                    'port' => '25',
                    'secure' => '',
                    'auth' => false,
                    'username' => '',
                    'password' => '',
                ),
                'backdoor' => $backdoor,
            );
        default:
            return array(
                'env' => 'development',
                'debug' => true,
                'basePath' => '/',
                'adminPath' => '/admin/',
                'returnUrl' => $returnUrl,
                'script' => '/assets/'.$scriptFileName,
                'adminScript' => '/assets/'.$adminScriptName,
                'apiPath' => "http://{$hostName}/api/index.php",
                'pdo' => array(
                    'database' => 'mysql',
                    'dsn' => 'mysql:host=localhost;dbname=bodwell',
                    'user' => 'root',
                    'pass' => 'root',
                ),
                'testing' => array(
                    'staffId' => 'F0123',
                    'staffRole' => '99',
                    'studentId' => '201500126',
                    'password' => 'c4e7e3792c',
                ),
                'bypassAuth' => true,
                'smtp' => array(
                  'debug' => false,
                  'port' => '25',
                  'secure' => 'TLS',
                  'auth' => false,
                  'username' => '',
                  'password' => '',
                ),
            );
    }

}

$settings = getEnvironmentSettings();
