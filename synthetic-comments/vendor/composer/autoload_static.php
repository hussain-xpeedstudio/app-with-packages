<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit683dde6d3d87ad077c8b7b031b40d201
{
    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'SyntheticRevisions\\' => 19,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'SyntheticRevisions\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit683dde6d3d87ad077c8b7b031b40d201::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit683dde6d3d87ad077c8b7b031b40d201::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit683dde6d3d87ad077c8b7b031b40d201::$classMap;

        }, null, ClassLoader::class);
    }
}
