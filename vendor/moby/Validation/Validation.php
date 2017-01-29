<?php

namespace Validation;

use Exception\RenderException;
use Validation\Interfaces\InterfaceValidation; 

/**
 * Class responsible for validation 
 */
class Validation implements InterfaceValidation
{
    /**
     * Stores the messages what use validation functions
     * 
     * @var array
     */
    private static $messages = [
        'required'          => 'The field $key is required',
        'max'               => 'The field $key must be smaller what $key2',
        'min'               => 'The field $key must be large what $key2',
        'list'              => 'The field $key must be presents in list $key2',
        'int'               => 'The field $key must to contain only numbers',
        'alpha'             => 'The field $key must conter only letters',
        'email'             => 'The field $key must conter one valid email',
        'url'               => 'The field $key must conter one valid URL',
        'cep'               => 'The field $key must conter one valid CEP. Ex: 99999999',
        'cep_point'         => 'The field $key must conter one CEP válido. Ex: 99999-999',
        'tel'               => 'The field $key must conter one valid telephone. Ex: 9999-9999',
        'tel_ddd'           => 'The field $key must conter one telephone with valid DDD. Ex: (99)9999-9999',
        'cell_phone_no_ddd' => 'The field $key must conter one valid cell phone. Ex: 99999-9999',
        'cell_phone'        => 'The field $key must conter one valid cell phone with valid DDD. Ex: (99)99999-9999',
        'cpf'               => 'The field $key must conter one valid CPF. Ex: 99999999999',
        'cpf_point'         => 'The field $key must conter one valid CPF. Ex: 999.999.999-99',
        'cnpj_point'        => 'The field $key must conter one valid CNPJ. Ex: 999.999.999/9999-99',
        'extension'         => 'The field $key must be present in list: $key2',
        'max_size'          => 'The field $key must be smaller what $key2',
    ]; 
     
     
    /**
     * Stores the errors what validation functions generate
     *
     * @var array
     */
    private static $errors = [];


    
    /**
     * Stores the rules of validation
     *
     * @var array
     */
    private static $rules = [];
    
    
    /**
     * Stores the restriction of validation
     *
     * @var array
     */
    private static $restriction = [];
    
    
    /**
     * Instance this class
     *
     * @var object this
     */
    private static $instance = false;
    
    
    /**
     * 
     * 
     * @param array $input
     * @param array $rules
     * @param array $messages (optional)
     * @return void
     */
    public static function rules(array $input, array $rules, $messages = [])
    {
        if (!static::$instance) {
            $instance = new Validation();
        } else {
            $instance = static::$instance;
        }
        
        foreach ($messages as $key => $message) {
            static::setMessage($key, $message);
        }
        
        static::$rules       = $input;
        static::$restriction = $rules;
    }
    
    
    /**
     * Function responsible for start the form validation
     *
     * @return bool
     */
    public static function run()
    {
        $validator = true;
        
        $rules       = static::$rules;
        $restriction = static::$restriction;
        
        foreach ($restriction as $key => $values) {
            $values = explode('|', $values);
            
            foreach ($values as $value) {
                if (!Validation::make($rules[$key], $value, $key)) {
                    $validator = false;
                }
            }
        }
        
        Validation::clearAtributes();
        
        return $validator;
    }
    
    
    /**
     * Funciton responsible for validation each field
     *
     * @param string $param
     * @param string $restriction (restrinction validation)
     * @param string $key (position post)
     * 
     * @return bool
     */
    public static function make($param, $restriction, $key = false)
    {
        if (!static::$instance) {
            $instance = new Validation();
        } else {
            $instance = static::$instance;
        }
        
        $response = true;
        
        // Verify if existis the caracter '[' for validations (max_length, min_length, is_unique, in_list)
        if (strpos($restriction, '[')) {
            $restriction_explode = explode('[', $restriction);
            
            $min_max_unique_inList_extension_maxsize = str_replace(']', '', $restriction_explode[1]);
            $restriction = $restriction_explode[0];
        }
        
        // Search what validation must be applied for that rule
        switch ($restriction) {
            case 'required':
                if (!$param) {
                    $response = false;
                    $instance->setErrors($key, 'required');
                }
                break;
                
            case 'unique':
                // code
                break;
                
            case 'max':
                if (strlen($param) > $min_max_unique_inList_extension_maxsize) {
                    $response = false;
                    $instance->setErrors($key, 'max', $min_max_unique_inList_extension_maxsize);
                }
                break;
                
            case 'min':
                if (strlen($param) < $min_max_unique_inList_extension_maxsize) {
                    $response = false;
                    $instance->setErrors($key, 'min', $min_max_unique_inList_extension_maxsize);
                }
                break;
                
            case 'list':
                $in_list = explode(',', $min_max_unique_inList_extension_maxsize);
                $compare_in_list = false;
                $list = '';
                
                foreach ($in_list as $il) {
                    if ($param == $il) {
                        $compare_in_list = true;
                    }
                    $list .= $il . ', ';
                }
                
                if (!$compare_in_list) {
                    $response = false;
                    $instance->setErrors($key, 'list', substr($list, 0, -2));
                } 
                break;
                
            case 'int':
                if (!preg_match('/^[0-9]+$/', $param)) {
                    $response = false;
                    $instance->setErrors($key, 'int');
                }
                break;
                
            case 'alpha':
                if (!preg_match('/^[a-zA-Z]+$/', $param)) {
                    $response = false;
                    $instance->setErrors($key, 'alpha');
                }
                break;
                
            case 'email':
                if (!preg_match('/^[a-z0-9_\.\-]+@[a-z0-9_\.\-]*[a-z0-9_\-]+\.[a-z]{2,4}$/i', $param)) {
                    $response = false;
                    $instance->setErrors($key, 'email');
                }
                break;
                
            case 'url':
                if (!filter_var($param, FILTER_VALIDATE_URL)) {
                    $response = false;
                    $instance->setErrors($key, 'url');
                }
                break;
                
            case 'cep':
                if (!preg_match('/^\d{8}$/', $param)) {
                    $response = false;
                    $instance->setErrors($key, 'cep');
                }
                break;
                
            case 'cep_point':
                if (!preg_match('/^\d{5}-\d{3}$/', $param)) {
                    $response = false;
                    $instance->setErrors($key, 'cep_point');
                }
                break;
                
            case 'tel':
                if (!preg_match('/^\d{4}-\d{4}$/', $param)) {
                    $response = false;
                    $instance->setErrors($key, 'tel');
                }
                break;
                
            case 'tel_ddd':
                if (!preg_match('/^\(\d{2}\)[\s-]?\d{4}-\d{4}$/', $param)) {
                    $response = false;
                    $instance->setErrors($key, 'tel_ddd');
                }
                break;
                
            case 'cell_phone_no_ddd':
                if (!preg_match('/^\d{5}-\d{4}$/', $param)) {
                    $response = false;
                    $instance->setErrors($key, 'cell_phone_no_ddd');
                }
                break;
                
            case 'cell_phone':
                if (!preg_match('/^\(\d{2}\)[\s-]?\d{5}-\d{4}$/', $param)) {
                    $response = false;
                    $instance->setErrors($key, 'cell_phone');
                }
                break;
                
            case 'cpf':
                if (!preg_match('/^[0-9]{11}$/', $param)) {
                    $response = false;
                    $instance->setErrors($key, 'cpf');
                }
                break;
                
            case 'cpf_point':
                if (!preg_match('/^[0-9]{3}\.[0-9]{3}\.[0-9]{3}\-[0-9]{2,2}$/', $param)) {
                    $response = false;
                    $instance->setErrors($key, 'cpf_point');
                }
                break;
                
            case 'cnpj_point':
                if (!preg_match('/^\d{3}.\d{3}.\d{3}/\d{4}-\d{2}$/', $param)) {
                    $response = false;
                    $instance->setErrors($key, 'cnpj_point');
                }
                break;
                
            case 'extension':
                $extensions = explode(',', $min_max_unique_inList_extension_maxsize);
                $compare_extension = false;
                $list = '';
                
                $extension_file_type = pathinfo($param['name'], PATHINFO_EXTENSION);
                
                foreach ($extensions as $extension) {
                    if ($extension_file_type == $extension)
                        $compare_extension = true;
                    
                    $list .= $extension . ', ';
                }
                
                if (!$compare_extension) {
                    $response = false;
                    $instance->setErrors($key, 'extension', substr($list, 0, -2));
                } 
                break;
            
            case 'max_size':
                if ($param['size'] > (str_replace('MB', '', $min_max_unique_inList_extension_maxsize) * 1000000)) {
                    $response = false;
                    $instance->setErrors($key, 'max_size', $min_max_unique_inList_extension_maxsize);
                }
                
                break;
        }
        
        return $response;
    }
    
    
    /**
     * Funciton responsible for reset class atributes
     *
     * @return void
     */
    public static function clearAtributes()
    {
        static::$rules       = [];
        static::$restriction = [];
    }
    
    
    /**
     * Funciton responsible for returns errors of array
     *
     * @return array
     */
    public static function getErrors()
    {
        return static::$errors;
    }
    
    
    /**
     * Set one error in array of errors
     *
     * @param string $key
     * @param string $restriction
     * @param string $key2 (optional)
     * @return void
     */
    public function setErrors($key, $restriction, $key2 = false)
    {
        if (isset(static::$messages[$key.'.'.$restriction])) {
            $message = static::$messages[$key.'.'.$restriction];
        } else {
            $message = static::$messages[$restriction];
        }
        
        if ($key2) {
            static::$errors[] = str_replace('$key', $key, $message);
        } else {
            static::$errors[] = str_replace(['$key', '$key2'], [$key, $key2], $message);
        }
    }
    
    
    /**
     * Set error message
     *
     * @param string $key
     * @param string $message
     * @return void
     */
    public static function setMessage($key, $message)
    {
        static::$messages[$key] = $message;
    }
}