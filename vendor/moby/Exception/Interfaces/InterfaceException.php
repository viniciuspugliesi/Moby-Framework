<?php

namespace Exception\Interfaces;

/**
 * Interface of Exception class
 *
 * @package Exception
 * @author `Vinicius Pugliesi`
 */
interface InterfaceException
{
    public function render($view, $args = []);
}