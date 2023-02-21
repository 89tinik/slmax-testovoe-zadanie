<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInitdf32328c1e3ca767ccbaaec7d9d98b0d
{
    private static $loader;

    public static function loadClassLoader($class)
    {
        if ('Composer\Autoload\ClassLoader' === $class) {
            require __DIR__ . '/ClassLoader.php';
        }
    }

    /**
     * @return \Composer\Autoload\ClassLoader
     */
    public static function getLoader()
    {
        if (null !== self::$loader) {
            return self::$loader;
        }

        spl_autoload_register(array('ComposerAutoloaderInitdf32328c1e3ca767ccbaaec7d9d98b0d', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInitdf32328c1e3ca767ccbaaec7d9d98b0d', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInitdf32328c1e3ca767ccbaaec7d9d98b0d::getInitializer($loader));

        $loader->register(true);

        return $loader;
    }
}
