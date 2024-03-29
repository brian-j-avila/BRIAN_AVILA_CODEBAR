<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit96353b07464fc7ec8f5ca35c4aae85db
{
    public static $prefixLengthsPsr4 = array (
        'V' => 
        array (
            'Vendor\\ArticulosCodebar\\' => 24,
        ),
        'P' => 
        array (
            'Picqer\\Barcode\\' => 15,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Vendor\\ArticulosCodebar\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
        'Picqer\\Barcode\\' => 
        array (
            0 => __DIR__ . '/..' . '/picqer/php-barcode-generator/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit96353b07464fc7ec8f5ca35c4aae85db::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit96353b07464fc7ec8f5ca35c4aae85db::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit96353b07464fc7ec8f5ca35c4aae85db::$classMap;

        }, null, ClassLoader::class);
    }
}
