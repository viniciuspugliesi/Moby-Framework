<?php

namespace Console;

use Console\Interfaces\InterfaceConsole;
use Connection\Connection;

/**
 * 
 */
class ConsoleModels implements InterfaceConsole
{
    /**
     * 
     */
    private static $arguments = [];
    
    
    /**
     * 
     */
    private static $descTable = [];
    
    
    /**
     * 
     */
    private static $ignoreLetter = [
        'tb_', 'tr_', 'tc_'
    ];
    
    
    /**
     * 
     */
    public static function run(array $arguments)
    {
        ConsoleModels::$arguments = $arguments;
        
        $template = ConsoleModels::getTemplate();
        
        if (!$conect = ConsoleModels::getConection()) {
            return ConsoleModels::getErrorComand(1);
        }
        
        if (!$tables = ConsoleModels::getTables($conect)) {
            return ConsoleModels::getErrorComand(4);
        }
        
        foreach ($tables as $table) {
            ConsoleModels::setTable($table[0]);
            
            if (!$newTemplate = ConsoleModels::openNewTemplate())
                return ConsoleModels::getErrorComand(2);
            
            ConsoleModels::getDescTable($conect);
            
            if (ConsoleModels::writeTemplate($template, $newTemplate)) {
                return ConsoleModels::getErrorComand(3);
            }
            
            if (!fclose($newTemplate)) {
                return ConsoleModels::getErrorComand(3);
            }
            
            echo ConsoleModels::getSuccessComand(2);
        }
        
        return ConsoleModels::getSuccessComand(1);
    }
    
    
    /**
     * 
     */
    public static function getDescTable($conect)
    {
        $descTable = $conect->prepare("DESC " . ConsoleModels::$arguments[2]);
        
        $descTable->execute();
        return ConsoleModels::$descTable = $descTable->fetchAll();
    }
    
    
    /**
     * 
     */
    public static function setTable($table)
    {
        $ignore = ConsoleModels::$ignoreLetter;
        
        ConsoleModels::$arguments[2] = $table;
        ConsoleModels::$arguments[3] = str_replace($ignore, '', strtolower($table));
        
        return;
    }
    
    
    /**
     * 
     */
    public static function getTables($conect)
    {
        $tables = $conect->prepare("SHOW TABLES");
        
        $tables->execute();
        return $tables->fetchAll();
    }
    
    
    /**
     * 
     */
    public static function openNewTemplate()
    {
        if (!ConsoleModels::$arguments[3])
            return false;
            
        return fopen('App/Models/'.ucwords(strtolower(ConsoleModels::$arguments[3])).'.php', 'w');
    }
    
    
    /**
     * 
     */
    public static function writeTemplate($template, $newTemplate)
    {
        $fields         = "'";
        $fields_value   = "'";
        $fields_update  = '';
        $primary_key    = '';
        
        foreach (ConsoleModels::$descTable as $field) {
            if ($field[3] == 'PRI') {
                $primary_key = $field[0];
            } else {
                $fields        .= $field[0]."', '";
                $fields_update .= '$result->'.$field[0].' = $dados['."'".$field[0]."'".'];
        ';
                $fields_value  .= $field[0]."' => " . '$dados['."'".$field[0]."'],
            '";
            }
        }
        
        $template = str_replace('[#class#]', ucwords(strtolower(ConsoleModels::$arguments[3])), $template);
        $template = str_replace('[#table#]', ConsoleModels::$arguments[2], $template);
        $template = str_replace('[#primary_key#]', $primary_key, $template);
        $template = str_replace('[#fields#]', substr($fields, 0, -3), $template);
        $template = str_replace('[#fields_update#]', substr($fields_update, 0, -3), $template);
        $template = str_replace('[#fields_value#]', substr($fields_value, 0, -3), $template);
        
        fwrite($newTemplate, $template);
    }
    
    
    /**
     * 
     */
    public static function getConection()
    {
        $conn = new Connection();
        
        return $conn->connect();
    }
    
    
    /**
     * 
     */
    public static function getSuccessComand($code = 1)
    {
        switch ($code) {
            case '1':
                return "---------------------------------------------- \n \n \n"
                    ."Moby Framework \n \n"
                    ."All Models successfully Consoled \n";
                break;
            
            case '2':
                return "Model " . ConsoleModels::$arguments[2] . " successfully Consoled \n \n";
                break;
            
            default:
                return " ---------------------------- \n \n \n"
                    ." Moby Framework "
                    ."All Models successfully Consoled";
                break;
        }
        
    }
    
    
    /**
     * 
     */
    public static function getErrorComand($controlNamberError = 1)
    {
        switch ($controlNamberError) {
            case '1':
                return "Database error: \n"
                        ."Check the connection data \n \n"
                        ."Need help? \n"
                        ."$ php moby help";
                break;
                
            case '2':
                return "Comand error: $ php moby Console:models \n"
                        ."Try $ php moby Console:models --database \n \n"
                        ."Need help? \n"
                        ."$ php moby help";
                break;
                
            case '3':
                return "Internal server error: \n"
                        ."Try again \n \n"
                        ."Need help? \n"
                        ."$ php moby help";
                break;
                
            case '4':
                return "Database error: \n"
                        ."No tables \n \n"
                        ."Need help? \n"
                        ."$ php moby help";
                break;
        }
        
    }
    
    
    /**
     * 
     */
    public static function getTemplate()
    {
        return file_get_contents('vendor/moby/Console/Templates/ModelCompletTemplate.php');
    }
}