<?php

namespace Base;

class Request
{
    function __construct()
    {
        $this->bootstrapSelf();
    }

    protected function bootstrapSelf()
    {
        foreach($_SERVER as $key => $value)
        {
            $this->{$this->toCamelCase($key)} = $value;
        }
    }

    protected function toCamelCase($string)
    {
        $result = strtolower($string);
        preg_match_all('/_[a-z]/', $result, $matches);
        foreach($matches[0] as $match) {
            $c = str_replace('_', '', strtoupper($match));
            $result = str_replace($match, $c, $result);
        }
        return $result;
    }

    public function get($key)
    {
        return (isset($_REQUEST[$key])) ? $_REQUEST[$key] : null;
    }

    public function getImageInfo($key)
    {
        if (!isset($_FILES[$key])) {
            return ['valid' => false];
        }

        $tmpName = $_FILES[$key]['tmp_name'];
        switch ($_FILES[$key]['type'])
        {
            case 'image/jpeg':
                $valid = true;
                $type = 'jpg';
                break;
            case 'image/png':
                $valid = true;
                $type = 'jpg';
                break;
            case 'image/gif':
                $valid = true;
                $type = 'jpg';
                break;
            default:
                $valid = false;
                $type = null;
                break;
        }

        return [
            'valid' => $valid,
            'type' => $type,
            'tmpName' => $tmpName,
        ];
    }
}