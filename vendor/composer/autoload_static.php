<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit1dd74ed76e45997ccf60e1707ab1fb72
{
    public static $prefixLengthsPsr4 = array (
        'M' => 
        array (
            'MiamiTrips\\' => 11,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'MiamiTrips\\' => 
        array (
            0 => __DIR__ . '/../..' . '/inc',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit1dd74ed76e45997ccf60e1707ab1fb72::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit1dd74ed76e45997ccf60e1707ab1fb72::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
