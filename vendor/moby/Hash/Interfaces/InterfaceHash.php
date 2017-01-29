<?php

namespace Hash\Interfaces;

/**
 * Interface of Hash class
 *
 * @package Hash
 * @author `Vinicius Pugliesi`
 */
interface InterfaceHash
{
    public static function make($string, $cost = false);

    public static function check($string, $hash);
    
    public function generateRandomSalt();
}