<?php

namespace Console\Interfaces;

/**
 * Interface of Console class
 *
 * @package Console
 * @author `Vinicius Pugliesi`
 */
interface InterfaceConsole
{
    public static function run(array $arguments);
    
    public static function writeTemplate($template, $newTemplate);
    
    public static function openNewTemplate();
    
    public static function getSuccessComand();
    
    public static function getErrorComand($controlNamberError = 1);
    
    public static function getTemplate();
}