<?php

namespace App\Traits;

trait CSVLoadable
{
    public static function seed($path)
    {
        $item = static::loadCSV($path);
        static::insertRows($item);
    }

    public static function loadCSV($path)
    {
        if (!file_exists($path)) {
            return [];
        }
        $items = array_map('str_getcsv', file($path));
        array_walk($items, function (&$item) use ($items) {
            $item = array_combine($items[0], $item);
        });
        array_shift($items);

        return $items;
    }

    public static function insertRows(&$items)
    {
        $now = now();
        $items = array_map(function ($item) use ($now) {
            unset($item['id']);
            $item['created_at'] = $now;
            $item['updated_at'] = $now;

            return $item;
        }, $items);

        static::insert($items);
    }
}
