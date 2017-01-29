<?php

namespace Mail;

use Mail\phpmailer\PHPMailer;
use Mail\Interfaces\InterfaceMail;

/**
 * Class responsible for send mail
 */ 
class Mail implements InterfaceMail
{
    /**
     * 
     */ 
    private static $instance = false;
    
    
    /**
     * 
     */ 
    private static $instancePHPMailer = false;
    
    
    /**
     * Function responsible for store the from mail
     * 
	 * @param  string $emailFrom
	 * @param  string $nameFrom(opcional)
	 * @return object Mail
     */	
    public static function from($emailFrom, $nameFrom = false)
    {
        if (!self::$instancePHPMailer) {
            self::$instancePHPMailer = new PHPMailer();
        }
        
        self::$instancePHPMailer->setFrom($emailFrom, $nameFrom);
        
        if (self::$instance == null) {
            self::$instance = new Mail();
        }
        
        return self::$instance;
    }
    
    
    /**
     * Function responsible for store the subject mail
     * 
	 * @param  string $subject
	 * @return object Mail
     */	
    public static function subject($subject)
    {
        if (!self::$instancePHPMailer) {
            self::$instancePHPMailer = new PHPMailer();
        }
        
        self::$instancePHPMailer->Subject = $subject;
        
        if (self::$instance == null) {
            self::$instance = new Mail();
        }
        
        return self::$instance;
    }
    
    
    /**
     * Function responsible for store the address mail
     * 
	 * @param  string $address
	 * @param  string $name(optional)
	 * @return object Mail
     */	
    public static function address($address, $name = false)
    {
        if (!self::$instancePHPMailer) {
            self::$instancePHPMailer = new PHPMailer();
        }
        
        self::$instancePHPMailer->addAddress($address, $name);
          
        if (self::$instance == null) {
            self::$instance = new Mail();
        }
        
        return self::$instance;
    }
    
    
    /**
     * Function responsible for store the copy mail
     * 
	 * @param  stromg $address
	 * @return object Mail
     */	
    public static function cc($address)
    {
        if (!self::$instancePHPMailer) {
            self::$instancePHPMailer = new PHPMailer();
        }
        
        self::$instancePHPMailer->addCC($address);
        
        if (self::$instance == null) {
            self::$instance = new Mail();
        }
        
        return self::$instance;
    }
    
    
    /**
     * Function responsible for store the hidden copy mail
     * 
	 * @param  string $address
	 * @return object Mail
     */	
    public static function bcc($address)
    {
        if (!self::$instancePHPMailer) {
            self::$instancePHPMailer = new PHPMailer();
        }
        
        self::$instancePHPMailer->addBCC($address);
        
        if (self::$instance == null) {
            self::$instance = new Mail();
        }
        
        return self::$instance;
    }
    
    
    /**
     * Function responsible for store reclicate mail
     * 
	 * @param  string  $address
	 * @param  string  $information(opcional)
	 * @return object Mail
     */	
    public static function replyTo($address, $information = false)
    {
        if (!self::$instancePHPMailer) {
            self::$instancePHPMailer = new PHPMailer();
        }
        
        self::$instancePHPMailer->addReplyTo($address, $information);
            
        if (self::$instance == null) {
            self::$instance = new Mail();
        }
        
        return self::$instance;
    }
    
    
    /**
     * Function responsible for store the body of massage mail
     * 
	 * @param  string $body
	 * @return object Mail
     */	
    public static function body($body)
    {
        if (!self::$instancePHPMailer) {
            self::$instancePHPMailer = new PHPMailer();
        }
        
        self::$instancePHPMailer->Body = $body;
        
        if (self::$instance == null) {
            self::$instance = new Mail();
        }
        
        return self::$instance;
    }
    
    
    /**
     * Function responsible for store 
     * 
	 * @param  string $altBody
	 * @return object Mail
     */	
    public static function altBody($altBody)
    {
        if (!self::$instancePHPMailer) {
            self::$instancePHPMailer = new PHPMailer();
        }
        
        self::$instancePHPMailer->AltBody = $altBody;
        
        if (self::$instance == null) {
            self::$instance = new Mail();
        }
        
        return self::$instance;
    }
    
    
    /**
     * Function responsible for store if mail is HTML
     * 
	 * @param  string $isHtml(opcional)
	 * @return object Mail
     */	
    public static function isHTML($isHtml = false)
    {
        if (!self::$instancePHPMailer) {
            self::$instancePHPMailer = new PHPMailer();
        }
        
        self::$instancePHPMailer->isHTML($isHtml);
        
        if (self::$instance == null) {
            self::$instance = new Mail();
        }
        
        return self::$instance;
    }
    
    
    /**
     * Function responsible for store one attachment
     * 
	 * @param  string $$addAttachment
	 * @param  string $name
	 * @return object Mail
     */	
    public static function attachment($addAttachment, $name)
    {
        if (!self::$instancePHPMailer) {
            self::$instancePHPMailer = new PHPMailer();
        }
        
        if ($name) {
            self::$instancePHPMailer->addAttachment($addAttachment, $name);    // Optional name
        } else {
            self::$instancePHPMailer->addAttachment($addAttachment);
        }
        
        if (self::$instance == null) {
            self::$instance = new Mail();
        }
        
        return self::$instance;
    }
    
    
    /**
     * Function responsible for send mail
     * 
	 * @return bool(true) || string error
     */	
    public static function send()
    {
        if (!self::$instancePHPMailer) {
            self::$instancePHPMailer = new PHPMailer();
        }
        
        self::configuration();
        
        if (!self::$instancePHPMailer->send()) {
            return self::$instancePHPMailer->ErrorInfo;
        }
        
        return true;
    }
    
    
    /**
     * Function responsible for configurations of server in SMTP
     * 
	 * @return void
     */	
    public static function configuration()
    {
        if (!self::$instancePHPMailer) {
            self::$instancePHPMailer = new PHPMailer();
        }
        
        self::$instancePHPMailer->SMTPDebug = 2;                                 // Enable verbose debug output

        self::$instancePHPMailer->isSMTP();                                      // Set mailer to use SMTP
        self::$instancePHPMailer->Host = 'kbrtecmail2.com.br';                   // Endereço do servidor SMTP
        self::$instancePHPMailer->SMTPAuth = true;                               // Enable SMTP authentication
        self::$instancePHPMailer->Username = 'vinicius.vicente@kbrtec.com.br';    // SMTP username
        self::$instancePHPMailer->Password = 'vinicius2016';                     // SMTP password
        self::$instancePHPMailer->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
        self::$instancePHPMailer->Port = 587;                                    // TCP port to connect to
    }
}