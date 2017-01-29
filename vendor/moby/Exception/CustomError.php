<?php

namespace Exception;

use Times\Times;

/**
 * Class responsible for customer errors 
 */
class CustomError
{
    /**
     * Code of error
     * @var int
     */
    private $code_error;
    
    
    /**
     * Messagem of error
     * @var string
     */
    private $message_error;
    
    
    /**
     * File of error
     * @var string
     */
    private $file_error;
    
    
    /**
     * Line of error
     * @var int
     */
    private $line_error;
    
    
    /**
     * Construct of class for exchange atributes of this class
     * 
     * @param int $errno
     * @param string $errstr
     * @param string $errfile
     * @param int $errline
     * @return void
     */
    public function __construct($errno, $errstr, $errfile, $errline)
    {
        $this->code_error    = (int) $errno;
        $this->message_error = $errstr;
        $this->file_error    = $errfile;
        $this->line_error    = (int) $errline;
    }
    
    
    /**
     * Function responsible for render view default error
     * 
     * @return view default error
     */
    public function initialize()
    {
        $this->log();
        
        return $this->render('default-error', $this);
    }
    
    
    /**
     * Function responsible for record error log
     * 
     * @return void
     */
    private function log()
    {
        $message_error = $this->getMessageLog();
        
        error_log($message_error, 3, __DIR__ . '/../../../storage/logs/' . Times::now() . '-error-log.log');
    }
    
    
    /**
     * Function responsible for exchenge message error log
     * 
     * @return string
     */
    private function getMessageLog()
    {
        $message_error  = "Message: " . $this->getMessage();
        $message_error .= " File: " . $this->getFile();
        $message_error .= " Line: " . $this->getLine();
        $message_error .= " Code: " . $this->getCode();
        $message_error .= " Hour: " . Times::time() . "\n";
        
        return $message_error;
    }
    
    
    /**
     * Render error view with existing errors
     * 
     * @param array $args
     * @param string $view
     * @return include view
     */ 
    private function render($view, $args = [])
    {
        try {
            if (!file_exists(__DIR__ . '/../../../App/Views/Exceptions/' . $view . '.php')) {
                throw new Exception('Default view error not found', 1110);
            }
            
            return include(__DIR__ . '/../../../App/Views/Exceptions/' . $view . '.php');
            
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    
    
    /**
     * Return this message
     * @return string message
     */
    public function getMessage()
    {
        return $this->message_error;
    }
    
    
    /**
     * Return this file
     * @return string file
     */
    public function getFile()
    {
        return $this->file_error;
    }
    
    
    /**
     * Return this line
     * @return int line
     */
    public function getLine()
    {
        return $this->line_error;
    }
    
    
    /**
     * Return this code
     * @return int code
     */
    public function getCode()
    {
        return $this->code_error;
    }
}