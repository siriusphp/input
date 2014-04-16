<?php

namespace Sirius\Forms\Util;


class Arr {

    const PATH_ROOT = '/';

    protected static function getSelectorParts($selector)
    {
        $firstOpen = strpos($selector, '[');
        if ($firstOpen === false) {
            return array($selector, '');
        }
        $firstClose = strpos($selector, ']');
        $container = substr($selector, 0, $firstOpen);
        $subselector = substr($selector, $firstOpen + 1, $firstClose - $firstOpen - 1) . substr(
                $selector,
                $firstClose + 1
            );
        return array($container, $subselector);
    }

    /**
     * Retrieves an element from an array via its path
     * Path examples:
     *        key
     *        key[subkey]
     *        key[0][subkey]
     *
     * @param  array $array
     * @param  string $path
     * @return mixed
     */
    static function arrayGetByPath($array, $path = self::PATH_ROOT)
    {
        $path = trim($path);
        if (!$path || $path == self::PATH_ROOT) {
            return $array;
        }
        // fix the path in case it was provided as `[item][subitem]`
        if (strpos($path, '[') === 0) {
            $path = preg_replace('/]/', '', ltrim($path, '['), 1);
        }

        list($container, $subpath) = self::getSelectorParts($path);
        if ($subpath === '') {
            return array_key_exists($container, $array) ? $array[$container] : null;
        }
        return array_key_exists($container, $array) ? self::arrayGetByPath($array[$container], $subpath) : null;
    }

    /**
     * Get values in the array by selector
     *
     * @example
     * Arr::getBySelector(array(), 'email');
     * Arr::getBySelector(array(), 'addresses[0][line]');
     * Arr::getBySelector(array(), 'addresses[*][line]');
     *
     * @param  array $array
     * @param  string $selector
     * @return array
     */
    static function getBySelector($array, $selector)
    {
        if (strpos($selector, '[*]') === false) {
            return array(
                $selector => self::arrayGetByPath($array, $selector)
            );
        }
        $result = array();
        list($preffix, $suffix) = explode('[*]', $selector, 2);

        $base = self::arrayGetByPath($array, $preffix);
        if (!is_array($base)) {
            $base = array();
        }
        // we don't have a suffix, the selector was something like path[subpath][*]
        if (!$suffix) {
            foreach ($base as $k => $v) {
                $result["{$preffix}[{$k}]"] = $v;
            }
            // we have a suffix, the selector was something like path[*][item]
        } else {
            foreach ($base as $itemKey => $itemValue) {
                if (is_array($itemValue)) {
                    $result["{$preffix}[{$itemKey}]{$suffix}"] = self::arrayGetByPath($itemValue, $suffix);
                }
            }
        }
        return $result;
    }

}