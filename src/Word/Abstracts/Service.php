<?php
/**
 * Created by Andrey Stepanenko.
 * User: webnitros
 * Date: 29.10.2022
 * Time: 13:10
 */

namespace SeoGenerator\Word\Abstracts;


use SeoGenerator\Word\Builder;
use SeoGenerator\Word\Snippet;

abstract class Service
{
    protected Builder $parser;

    public function __construct(Builder $builder)
    {
        $this->builder = $builder;
    }
}
