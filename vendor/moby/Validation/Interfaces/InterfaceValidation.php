<?php

namespace Validation\Interfaces;

/**
 * interface for the Validation class
 *
 * @package Validation
 * @author `Vinicius Pugliesi`
 */
interface InterfaceValidation
{
    public static function rules(array $input, array $rules);
    
    public static function run();
    
    public static function make($param, $restriction, $key = false);
    
    public static function clearAtributes();
    
    public static function getErrors();
}