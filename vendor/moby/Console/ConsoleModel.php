<?php

namespace Console;

use Console\Interfaces\InterfaceConsole;
use Connection\Connection;

/**
 * 
 */
class ConsoleModel implements InterfaceConsole
{
    /**
     * Store args of passed
     * @var array
     */
    private static $arguments = [];
    
    
    /**
     * Store all results of database
     * @var array
     */
    private static $descTable = [];
    
    
    /**
     * If has connection with the database
     * @var bool
     */
    private static $hasDatabase = false;
    
    
    /**
     * Connection with database
     * @var object
     */
    private static $connection;
    
    
    /**
     * Ignore letters for create model
     * @var array
     */
    private static $ignoreLetter = [
        'tb_', 'tr_', 'tc_'
    ];
    
    
    /**
     * 
     */
    public static function run(array $arguments)
    {
        ConsoleModel::$arguments = $arguments;
        ConsoleModel::hasDatabase();
            
        $template = ConsoleModel::getTemplate(1);
        
        if (!$newTemplate = ConsoleModel::openNewTemplate())
            return ConsoleModel::getErrorComand(1);
        
        if (ConsoleModel::writeTemplate($template, $newTemplate))
            return ConsoleModel::getErrorComand(2);
        
        if (!fclose($newTemplate))
            return ConsoleModel::getErrorComand(2);
            
        return ConsoleModel::getSuccessComand();
    }
    
    
    /**
     * 
     */
    public static function hasDatabase()
    {
        if (ConsoleModel::$arguments[2] != '--database' || !isset(ConsoleModel::$arguments[3]))
            return;
        
        ConsoleModel::$hasDatabase = true;
        
        $conn = new Connection();
        ConsoleModel::$connection = $conn->connect();
        
        if (!ConsoleModel::hasTable(ConsoleModel::$arguments[3]))
            return;
        
        ConsoleModel::setTable(ConsoleModel::$arguments[3]);
        
        if (!$newTemplate = ConsoleModel::openNewTemplate())
            return ConsoleModel::getErrorComand(3);
            
        ConsoleModel::getDescTable();
            
        $template = ConsoleModel::getTemplate(2);
        
        if (ConsoleModel::writeTemplateByTable($template, $newTemplate))
            return ConsoleModel::getErrorComand(2);
            
        if (!fclose($newTemplate))
            return ConsoleModel::getErrorComand(2);
                
        echo ConsoleModel::getSuccessComand(2);
        exit;
    }
    
    
    /**
     * 
     */
    public static function openNewTemplate()
    {
        if (!ConsoleModel::$arguments[2])
            return false;
        
        if (ConsoleModel::$hasDatabase && !isset(ConsoleModel::$arguments[3]))
            return false;
        
        if (ConsoleModel::$hasDatabase && isset(ConsoleModel::$arguments[3]))
            return fopen('App/Models/'.ucwords(ConsoleModel::$arguments[3].'.php'), 'w');
            
        return fopen('App/Models/'.ucwords(ConsoleModel::$arguments[2].'.php'), 'w');
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
    public static function hasTable($table)
    {
        $tables = ConsoleModel::$connection->prepare("SHOW TABLES");
        
        $tables->execute();
        $tables = $tables->fetchAll();
        
        foreach ($tables as $tableBD) {
            if ($tableBD[0] == $table)
                return true;
        }
        
        return false;
    }
    
    
    /**
     * 
     */
    public static function setTable($table)
    {
        $ignore = ConsoleModel::$ignoreLetter;
        
        ConsoleModel::$arguments[2] = $table;
        ConsoleModel::$arguments[3] = str_replace($ignore, '', strtolower($table));
        
        return;
    }
    
    
    /**
     * 
     */
    public static function getDescTable()
    {
        $descTable = ConsoleModel::$connection->prepare("DESC " . ConsoleModel::$arguments[2]);
        
        $descTable->execute();
        return ConsoleModel::$descTable = $descTable->fetchAll();
    }
    
    
    /**
     * 
     */
    public static function writeTemplate($template, $newTemplate)
    {
        $template = str_replace('[#class#]', ucwords(ConsoleModel::$arguments[2]), $template);
        
        fwrite($newTemplate, $template);
    }
    
    
    /**
     * 
     */
    public static function writeTemplateByTable($template, $newTemplate)
    {
        $fields_value   = "'";
        $fields         = "'";
        $primary_key    = '';
        
        foreach (ConsoleModel::$descTable as $field) {
            if ($field[3] == 'PRI')
                $primary_key = $field[0];
            else {
                $fields .= $field[0]."', '";
                $fields_value .= $field[0]."' => " . '$dados[' . "'" . $field[0] .  "'],
            '";
            }
        }
        
        $template = str_replace('[#class#]', ucwords(strtolower(ConsoleModel::$arguments[3])), $template);
        $template = str_replace('[#table#]', ConsoleModel::$arguments[2], $template);
        $template = str_replace('[#primary_key#]', $primary_key, $template);
        $template = str_replace('[#fields#]', substr($fields, 0, -3), $template);
        $template = str_replace('[#fields_value#]', substr($fields_value, 0, -3), $template);
        
        fwrite($newTemplate, $template);
    }
    
    
    /**
     * 
     */
    public static function getTemplate($code = 1)
    {
        switch ($code) {
            case '1':
                return file_get_contents('vendor/moby/Console/Templates/ModelTemplate.php');
                break;
                
            case '2':
                return file_get_contents('vendor/moby/Console/Templates/ModelCompletTemplate.php');
                break;
        }
    }
    
    
    /**
     * 
     */
    public static function getSuccessComand($code = 1)
    {
        switch ($code) {
            case '1':
                return "Moby Framework \n \n"
                    ."Model ".ConsoleModel::$arguments[2]." successfully Consoled";
                break;
            
            case '2':
                return "Model " . ConsoleModel::$arguments[2] . " successfully Consoled \n \n";
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
                return "Model name not found in comand: \n"
                        ."$ php moby make:model \n \n"
                        ."Need help? \n"
                        ."$ php moby help";
                break;
                
            case '2':
                return "Internal server error: \n"
                        ."Try again \n \n"
                        ."Need help? \n"
                        ."$ php moby help";
                break;
                
            case '3':
                return "Comand error: $ php moby make:model \n"
                        ."Try $ php moby make:model --database \n \n"
                        ."Need help? \n"
                        ."$ php moby help";
                break;
                
            case '4':
                $table = ConsoleModel::$arguments[2];
                
                return "Comand error: $ php moby make:model --database $table \n"
                        ."Table not exists \n \n"
                        ."Need help? \n"
                        ."$ php moby help";
                break;
        }
        
    }
}