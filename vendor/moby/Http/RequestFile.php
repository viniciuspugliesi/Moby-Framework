<?php

namespace Http;

use Http\Interfaces\InterfaceRequestFile;

/**
 * 
 */
class RequestFile implements InterfaceRequestFile
{
    /**
     * 
     */
    public $destiny = '/uploads/';
    
    
    /**
     * Construct of this class.
     * Create attributes in class same as array parameters
     * 
     * @param array $file
     * @return $this
     */
    public function __construct(array $file)
    {
        foreach ($file as $key => $value) {
            $this->$key = $value;
        }
        
        $this->file = $file;
        
        return $this;
    }
    
    
    /**
     * Function responsible for upload file
     *
     * @return string OR bool(false)
     */
    public function save()
    {
        if (!$this->file) {
            return false;
        }
        
        if (!move_uploaded_file($this->file['tmp_name'], __DIR__ . '/../../../public/' . $this->destiny . '/' . $this->file['name'])) {
            return false;
        }
        
        return $this->file['name'];
    }
    
    
    /**
     * 
     */ 
    public function setDestiny($destiny)
    {
        $this->destiny = $destiny;
        
        return $this;
    }
    
    
    /**
     * 
     */ 
    public function setName($fileName)
    {
        $this->file['name'] = $fileName . $this->getExtension($this->file);
        $this->name         = $fileName . $this->getExtension($this->file);
        
        return $this;
    }
    
    
    /**
     * 
     */ 
    public function setRandonName()
    {
        $rand = rand(1, 9999);
        
        $this->file['name'] = $rand . $this->getExtension($this->file);
        $this->name         = $rand . $this->getExtension($this->file);
        
        return $this;
    }
    
    
    /**
     * 
     */ 
    public function hasExtension($file)
    {
        if (!pathinfo($file['name'], PATHINFO_EXTENSION)) {
            return false;
        }
        
        return true;
    }
    
    
    /**
     * 
     */ 
    public function getExtension($file)
    {
        return pathinfo($file['name'], PATHINFO_EXTENSION);
    }
}