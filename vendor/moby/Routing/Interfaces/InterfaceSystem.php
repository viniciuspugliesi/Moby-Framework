<?php

namespace Routing\Interfaces;

/**
 * Interface for the System class
 *
 * @package Routing
 * @author `Vinicius Pugliesi`
 */
interface InterfaceSystem
{
    public static function run($url = [], $param = []);
}