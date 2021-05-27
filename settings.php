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
                    'database' => 'mssql',
                    'dsn' => 'odbc:Driver={SQL Server};Server=10.0.0.108;Database=Bodwell;Uid=sa;Pwd=Yv9FrUpx0a;',
                ),
                'smtp' => array(
                    'debug' => false,
                    'host' => 'smtp.sendgrid.net',
                    'port' => '587',
                    'secure' => 'TLS',
                    'auth' => true,
                    'username' => 'apikey',
                    'password' => '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',
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
                    'database' => 'mssql',
                    'dsn' => 'odbc:Driver={SQL Server};Server=10.100.4.6;Database=Bodwell;Uid=web;Pwd=AJgw!cG4nw;',
                ),
                'smtp' => array(
                    'debug' => false,
                    'host' => 'smtp.sendgrid.net',
                    'port' => '587',
                    'secure' => 'TLS',
                    'auth' => true,
                    'username' => 'apikey',
                    'password' => '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',
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
                    'dsn' => 'odbc:Driver={SQL Server};Server=10.100.0.5;Database=Bodwell;Uid=devweb;Pwd=9zQjq4WRgkFF;',
                ),
                'bypassAuth' => false,
                'smtp' => array(
                    'debug' => false,
                    'host' => 'smtp.sendgrid.net',
                    'port' => '587',
                    'secure' => 'TLS',
                    'auth' => true,
                    'username' => 'apikey',
                    'password' => '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',
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
                    'dsn' => 'odbc:Driver={SQL Server};Server=10.0.0.209;Database=Bodwell;Uid=sa;Pwd=pm2em9GhOOWt;',
                ),
                'bypassAuth' => false,
                'smtp' => array(
                    'debug' => 0,
                    'host' => 'smtp.van.terago.ca',
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
                    'email' => 'dev.user201500126@student.bodwell.edu'.PHP_EOL,
                    'password' => 'c4e7e3792c',
                ),
                'bypassAuth' => true,
                'smtp' => array(
                  'debug' => false,
                  'host' => 'bodwell-edu.mail.protection.outlook.com',
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
