<?php
namespace Headzoo\Reflection;

/**
 * Utility class for working with directories.
 */
class Directories
{
    /**
     * Returns the path to the given subdirectory
     *
     * Searches through $haystack a directory named $needle, and returns the path. Returns null when
     * the subdirectory cannot be found.
     *
     * Example:
     * ```php
     * $haystack = "/var/www/headzoo/src/Headzoo/Reflection";
     * $needle   = "src";
     * echo Directories::findSubDirectory($needle, $haystack);
     * // Outputs: "/var/www/headzoo/src"
     * ```
     *
     * @param string $needle
     * @param string $haystack
     *
     * @return string
     */
    public static function findSubDirectory($needle, $haystack)
    {
        $needle   = trim($needle, "/\\");
        $is_found = false;
        $dirs     = [];
        $paths    = preg_split('~[/\\\]~', $haystack, -1, PREG_SPLIT_NO_EMPTY);
        foreach($paths as $path) {
            $dirs[] = $path;
            if ($path === $needle) {
                $is_found = true;
                break;
            }
        }

        $path = null;
        if ($is_found) {
            $path = join("/", $dirs);
            if (!static::isWindowsPath($path) && "/" === $haystack[0]) {
                $path = "/{$path}";
            }
        }

        return $path;
    }

    /**
     * Returns whether a path appears to be a Windows directory
     *
     * @param string $dir The directory
     *
     * @return bool
     */
    public static function isWindowsPath($dir)
    {
        return (bool)preg_match('/^[a-z]+:/i', $dir);
    }
}