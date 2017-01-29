<?php

namespace Hash;

use Hash\Interfaces\InterfaceHash;

/**
 * 
 */
class Hash implements InterfaceHash
{
    /**
     * Default salt prefix
     * 
     * @see http://www.php.net/security/crypt_blowfish.php
     * 
     * @var string
     */
    private $saltPrefix = '2a'; // 2y
    
    
    /**
     * Default hashing cost (4-31)
     * 
     * @var integer
     */
    private $defaultCost = 8;
    
    
    /**
     * Salt limit length
     * 
     * @var integer
     */
    private $saltLength = 22;
    
    
    
    /**
     * Salt limit length
     * 
     * @var integer
     */
    public function __construct()
    {
        $require = require(__DIR__ . '/../../../App/Config/hash.php');
        
        if (isset($require['saltPrefix'])) {
            $this->setSaltPrefix($require['saltPrefix']);
        }
        
        if (isset($require['defaultCost'])) {
            $this->setDefaultCost($require['defaultCost']);
        }
        
        if (isset($require['saltLength'])) {
            $this->setSaltLength($require['saltLength']);
        }
    }
    
    
    /**
     * Hash a string
     * 
     * @param  string  $string The string
     * @param  integer $cost   The hashing cost
     * 
     * @see    http://www.php.net/manual/en/function.crypt.php
     * 
     * @return string
     */
    public static function make($string, $cost = false) 
    {
        $instance = new static();
        
        if (!$cost) {
    	    $cost = $instance->defaultCost;
        }
        
    	// Salt
    	$salt = $instance->generateRandomSalt();
        
    	// Hash string
    	$hashString = $instance->generateHashString((int)$cost, $salt);
        
    	return crypt($string, $hashString);
    }
    
    
    /**
     * Check a hashed string
     * 
     * @param  string $string The string
     * @param  string $hash   The hash
     * 
     * @return boolean
     */
    public static function check($string, $hash) 
    {
        return (crypt($string, $hash) === $hash);
    }
    
    
    /**
     * Generate a random base64 encoded salt
     * 
     * @return string
     */
    public function generateRandomSalt() 
    {
    	// Salt seed
    	$seed = uniqid(mt_rand(), true);
    
    	// Generate salt
    	$salt = base64_encode($seed);
    	$salt = str_replace('+', '.', $salt);
    
    	return substr($salt, 0, $this->saltLength);
    }
    
    
    /**
     * Build a hash string for crypt()
     * 
     * @param  integer $cost The hashing cost
     * @param  string $salt  The salt
     * 
     * @return string
     */
    private function generateHashString($cost, $salt) 
    {
    	return sprintf('$%s$%02d$%s$', $this->saltPrefix, $cost, $salt);
    }
    
    
    /**Set attribute saltPrefix of class
     * 
     * @param string $saltPrefix
     * @return bool
     * 
     */ 
    public function setSaltPrefix($saltPrefix)
    {
        if (!$saltPrefix || !is_string($saltPrefix)) {
            return false;
        }
        
        $this->saltPrefix = $saltPrefix;
        
    }
    
    
    /**
     * Set attribute defaultCost of class
     * 
     * @param int $defaultCost
     * @return bool
     */ 
    public function setDefaultCost($defaultCost)
    {
        if (!$defaultCost || !is_int((int)$defaultCost) || ($defaultCost >= 4 && $defaultCost <= 31)) {
            return false;
        }
        
        $this->defaultCost = (int)$defaultCost;
    }
    
    
    /**
     * Set attribute saltLength of class
     * 
     * @param int $saltLength
     * @return bool
     */ 
    public function setSaltLength($saltLength)
    {
        if (!$saltLength || !is_int((int)$saltLength)) {
            return false;
        }
        
        $this->saltLength = (int)$saltLength;
    }
}