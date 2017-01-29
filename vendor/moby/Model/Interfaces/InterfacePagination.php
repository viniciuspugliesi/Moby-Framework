<?php

namespace Model\Interfaces;

/**
 * Interface of Pagination class
 *
 * @package Pagination
 * @author `Vinicius Pugliesi`
 */
interface InterfacePagination
{
    public function paginate($number);
}