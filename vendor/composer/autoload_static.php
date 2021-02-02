<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit80d6f561a6ab3b460c1d13ad53cdca96
{
    public static $files = array (
        '45e8c92354af155465588409ef796dbc' => __DIR__ . '/..' . '/bcosca/fatfree/lib/base.php',
        'decc78cc4436b1292c6c0d151b19445c' => __DIR__ . '/..' . '/phpseclib/phpseclib/phpseclib/bootstrap.php',
    );

    public static $prefixLengthsPsr4 = array (
        'p' => 
        array (
            'phpseclib\\' => 10,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'phpseclib\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpseclib/phpseclib/phpseclib',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
        'FPDF' => __DIR__ . '/..' . '/setasign/fpdf/fpdf.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit80d6f561a6ab3b460c1d13ad53cdca96::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit80d6f561a6ab3b460c1d13ad53cdca96::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit80d6f561a6ab3b460c1d13ad53cdca96::$classMap;

        }, null, ClassLoader::class);
    }
}
