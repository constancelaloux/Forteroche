<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace blog\database;

/**
 * Description of Str
 *
 * @author constancelaloux
 */
class Str 
{
        /**
     * The cache of studly-cased words.
     *
     * @var array
     */
    protected static $studlyCache = [];
        /**
     * Convert a value to studly caps case.
     *
     * @param  string  $value
     * @return string
     */
    public static function studly($value)
    {
        $key = $value;
        if (isset(static::$studlyCache[$key]))
        {
            return static::$studlyCache[$key];
        }
        $value = ucwords(str_replace(['-', '_'], ' ', $value));
        //print_r($value);
        //print_r(static::$studlyCache[$key] = str_replace(' ', '', $value));
        return static::$studlyCache[$key] = str_replace(' ', '', $value);
    }
    //put your code here
}
