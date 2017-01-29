<?php

namespace Console\Interfaces;

/**
 * Interface of AbstractConsole class
 *
 * @package Console
 * @author `Vinicius Pugliesi`
 */
interface InterfaceAbstractConsole
{
    public function responseColor($string, $color = 'white', $background_color = null);
}