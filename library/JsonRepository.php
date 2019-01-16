<?php

class JsonRepository implements RepositoryInterface
{
    const FILE = 'tiktok.json';

    public function init()
    {
        $field = [
            [null,null,null],
            [null,null,null],
            [null,null,null]
        ];
        $json = json_encode($field);
        file_put_contents(self::FILE,$json);
    }

    public function write(Array $field)
    {
        $field_in_json = json_encode($field);
        file_put_contents(self::FILE,$field_in_json);        
    }

    public function read()
    {
        $content = file_get_contents(self::FILE);
        $field = json_decode($content);
        return $field;
    }
}