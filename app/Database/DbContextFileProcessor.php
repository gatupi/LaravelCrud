<?php

namespace App\Database;

class DbContextFileProcessor {

    public const DB_DIR = [
        'mysql' => __DIR__ . '/../../database/mysql/',
        'postgres' => __DIR__ . '/../../database/postgres/'
    ];

    public static function create_fn_content(string $fn_name, string $database = 'mysql'): string {
        return file_get_contents(self::DB_DIR[$database] . 'functions/create_fn_' . $fn_name . '.sql');
    }

    public static function drop_fn_content(string $fn_name, string $database = 'mysql'): string {
        return file_get_contents(self::DB_DIR[$database] . 'functions/drop_fn_' . $fn_name . '.sql');
    }

    public static function create_sp_content(string $sp_name, string $database = 'mysql'): string {
        return file_get_contents(self::DB_DIR[$database] . 'stored_procedures/create_sp_' . $sp_name . '.sql');
    }

    public static function drop_sp_content(string $sp_name, string $database = 'mysql'): string {
        return file_get_contents(self::DB_DIR[$database] . 'stored_procedures/drop_sp_' . $sp_name . '.sql');
    }
}