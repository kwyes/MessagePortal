<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit29a2360349ce0efb2d89168e84c6dd27
{
    public static $prefixLengthsPsr4 = array (
        'E' => 
        array (
            'ExponentPhpSDK\\' => 15,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'ExponentPhpSDK\\' => 
        array (
            0 => __DIR__ . '/..' . '/alymosul/exponent-server-sdk-php/lib',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit29a2360349ce0efb2d89168e84c6dd27::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit29a2360349ce0efb2d89168e84c6dd27::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}