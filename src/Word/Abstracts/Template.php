<?php
/**
 * Created by Andrey Stepanenko.
 * User: webnitros
 * Date: 02.11.2022
 * Time: 17:16
 */

namespace SeoGenerator\Word\Abstracts;


use SeoGenerator\Word\Snippet;

class Template
{

    public static function disabled(Snippet $snippet)
    {
        $snippet->disabled();
        $snippet->setResult('');
        $snippet->set('value_replace', '');
    }
}
