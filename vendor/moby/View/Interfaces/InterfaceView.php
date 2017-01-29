<?php

namespace View\Interfaces;

/**
 * Interface for the View class
 *
 * @package View
 * @author `Vinicius Pugliesi`
 */
interface InterfaceView
{
    public function __construct($view, $param);
    
    public function initialize();
    
    public function randomNameView();
    
    public function getView();
    
    public function getTemplate($viewName);
    
    public function writeTemplate($viewName, $view);
    
    public function includeView($template);
    
    public function deleteTemplate($viewNewName);
    
    public function clearParams();
}