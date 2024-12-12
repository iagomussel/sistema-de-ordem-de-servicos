<?php

class Query
{
    protected static $_query;
    protected static $est;

    public function __construct()
    {
        self::$_query = [];
    }

    private function get_return()
    {
        if (isset(self::$_query)) {
            return self::$_query;
        } else {
            new Query();

            return self::$_query;
        }
    }

    public function json($pretty = false)
    {
        header('Content-Type: application/json');
        if ($pretty) {
            echo json_encode(self::$_query, JSON_PRETTY_PRINT);
        } else {
            echo json_encode(self::$_query);
        }
    }

    public function erro($str = '', $parar = false)
    {
        if (!isset(self::$_query['error'])) {
            self::$_query['error'] = [];
        }
        self::$_query['error'][] = $str;
        if ($parar) {
            self::json();
            exit;
        }
    }

    public function data($_data)
    {
        if (!isset(self::$_query)) {
            self::$_query = [];
        }
        self::$_query['data'] = $_data;
    }

    public function request($_data)
    {
        if (!isset(self::$_query)) {
            self::$_query = [];
        }
        self::$_query['request'] = $_data;
    }
}
