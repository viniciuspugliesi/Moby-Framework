<?php

namespace Http;

use Http\Interfaces\InterfaceRequest;
use Validation\Validation;
use Session\Session;
use Http\RequestFile;

/**
 * Class Request responsible for receipt parameters $_POST
 *
 * Contains validation functions
 * Return of $_POSTs 
 */	
class Request implements InterfaceRequest
{
    /**
     * Stores the errors what validation functions generate
     *
     * @var array
     */
    private $errors = [];
    
    /**
     * Stores the posts received for page
     *
     * @var array
     */
    private $post = [];
    
    /**
     * Stores the files received for page
     *
     * @var array
     */
    private $files = [];
    
    /**
     * History URL
     * 
     * @var string
     */ 
    private static $historyURL = '';
    
    /**
     * Current URL
     * 
     * @var string
     */ 
    private static $currentURL = '';
    
    
    /**
     * Start the class storing the $_POST
     *
     * @return void
     */
    public function __construct()
    {
        if (!isset($_POST)) {
            return;
        }
        
        $this->post  = $_POST;
        $this->files = $_FILES;
            
        // unset($_POST);
        // unset($_FILES);
    }
    
    
    /**
     * Function responsible for retorns one input
     *
     * @param string $param(optional)
     * @return string OR array OR null
     */
    public function input($param = null)
    {
        if ($param)
            return $this->post[$param];
        
        return $this->post;
    }
    
    
    /**
     * Function responsible for return one input with validation
     *
     * @param string $param (Parameter of $_POST)
     * @param type_filter $restriction (Validation of input)
     * 
     * @return string OR BOOL(false)
     */
    public function filter_input($param, $restriction)
    {  
        /**
         * EXEMPLE VALIDATION:
         * 
         * FILTER_VALIDATE_URL
         * FILTER_VALIDATE_EMAIL
         * FILTER_VALIDATE_BOOLEAN
         * FILTER_VALIDATE_IP
         * FILTER_FLAG_NO_PRIV_RANGE 
         * FILTER_FLAG_ALLOW_OCTAL
         * FILTER_VALIDATE_INT
         * FILTER_SANITIZE_EMAIL
         */ 
        if (!filter_var($this->post[$param], $restriction))
            return false;
            
        return $this->post[$param];
    }
    
    
    /**
     * Funciton responsible for return one file
     *
     * @param string $param(optional)
     * @return array file OR file
     */
    public function file($key = null)
    {
        if (!$key) {
            return $this;
        }
        
        if (!isset($this->files[$key]) || !$this->files[$key]) {
            return false;
        }
        
        return new RequestFile($this->files[$key]);
    }
    
    
    /**
     * Function responsible file validation and valid
     *
     * @return bool
     */
    public function isValid()
    {
        $validator   = true;
        $restrictions = $this->files();
        
        foreach ($restrictions as $key_restriction => $restriction) {
            $restriction = explode('|', $restriction);
                
            if (!isset($this->files[$key_restriction])) {
                Validation::setErrors($key_restriction, 'required');
                return false;
            }
                      
            foreach ($restriction as $key_restr => $restr) {
                if (!Validation::make($this->files[$key_restriction], $restr, $key_restriction)) {
                    $validator = false;
                }
            }
        }
        
        return $validator;
    }
    
    
    /**
     * Returns the extension of file
     *
     * @return string
     */
    public function getExtension($fileName)
    {
        return pathinfo($fileName['name'], PATHINFO_EXTENSION);
    }
    
    
    /**
     * Function responsible for upload file
     *
     * @return string OR bool(false)
     */
    public function saveAllFiles()
    {
        if (!$this->files) {
            return false;
        }
        
        $response = [];
        
        foreach ($this->files as $file) {
            $uploadFile = rand(111111,999999) . '.' . $this->getExtension($file);
            
            $response[] = $uploadFile;
            
            if(!move_uploaded_file($file['tmp_name'], './public/uploads/' . $uploadFile)) {
                return false;
            }
        }    
        
        return $response;
    }
    
    
    /**
     * Function responsible for get errors of the Validation
     *
     * @return array
     */
    public function getErrors()
    {
        return Validation::getErrors();
    }
    
    
    /**
     * Function responsible for start the form validation
     *
     * @return bool
     */
    public function run()
    {
        $validator  = true;
        $rules      = $this->rules();
        
        $this->setMessages($this->messages());
        
        foreach ($rules as $key => $values) {
            $values = explode('|', $values);
            
            foreach ($values as $value) {
                if (!Validation::make($this->post[$key], $value, $key)) {
                    $validator = false;
                }
            }
        }
        
        $this->clearAtributes();
        
        return $validator;
    }
    
    
    /**
     * Function responsible for reset class atributes
     *
     * @return void
     */
    private function clearAtributes()
    {
        $this->rules = [];
        $this->dados = [];
    }
    
    
    /**
     * Set current URL
     * 
     * @param string $url
     * @return void
     */ 
    public static function setCurrentURL($url)
    {
        if (Session::has('currentURL')) {
            static::$historyURL = Session::get('currentURL');
        }
        
        Session::set('currentURL', $url);
        static::$currentURL = $url;
    }
    
    
    /**
     * Get current URL
     * 
     * @return string
     */ 
    public static function getCurrentURL()
    {
        return static::$currentURL;
    }
    
    
    /**
     * Get history URL
     * 
     * @return string
     */ 
    public static function getHistoryURL()
    {
        return static::$historyURL;
    }
    
    
    /**
     * Set validation messages
     * 
     * @param array $messages (optional)
     * @return void
     */ 
    public function setMessages($messages = [])
    {
        if (!$messages) {
            return;
        }
        
        foreach ($messages as $key => $message) {
            Validation::setMessage($key, $message);
        }
    }
}