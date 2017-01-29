<?php

namespace Model\Interfaces;

/**
 * Interface of Model class
 *
 * @package Model
 * @author `Vinicius Pugliesi`
 */
interface InterfaceModel
{
    public function __construct();

    public static function table($table);

    public static function select($content);

    public static function all();

    public static function where($param1, $param2 = false);

    public static function or_where($param1, $param2 = false);

    public static function order_by($order_by);

    public static function limit($limit);

    public static function join($table, $relation, $type);

    public static function like($field, $like);

    public function first($return_type = null);

    public static function count();

    public function get($return_type = 'obj');

    public function query($query);
}