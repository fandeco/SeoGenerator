<?php
/**
 * Created by Andrey Stepanenko.
 * User: webnitros
 * Date: 30.10.2022
 * Time: 01:12
 */

namespace SeoGenerator\Word;


use SeoGenerator\Word\Abstracts\Service;

class Variable extends Service
{
    private array $data;

    public function fromArray(array $array)
    {
        return $this->data = $array;
    }

    public function get($key)
    {
        if (array_key_exists($key, $this->data)) {
            return $this->data[$key];
        }
        return null;
    }

    public function isEmpty($key)
    {
        return empty($this->data[$key]);
    }

    public function toArray()
    {
        return $this->data;
    }
}
