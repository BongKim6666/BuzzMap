<?php

class Database
{
    public static function getPdo(): PDO
    {
        return new PDO(
            'mysql:charset=UTF8;dbname=buzz_map;
                host=localhost',
            'root',
            'root'
            // ''
        );
    }
}