<?php

namespace Connection\Interfaces;

/**
 * Interface of Connection class
 *
 * @package Connection
 * @author `Vinicius Pugliesi`
 */
interface InterfaceConnection
{
    public function connect();
    
    public function disconnect($con);
}