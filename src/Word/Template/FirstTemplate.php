<?php
/**
 * Created by Andrey Stepanenko.
 * User: webnitros
 * Date: 02.11.2022
 * Time: 16:50
 */

namespace SeoGenerator\Word\Template;


use SeoGenerator\Word\Abstracts\Template;
use SeoGenerator\Word\Builder;
use SeoGenerator\Word\implement\TemplateInterface;
use SeoGenerator\Word\Snippet;

class FirstTemplate extends Template implements TemplateInterface
{

    public function process(Builder $builder, Snippet $snippet, $ParentSnippet = null): void
    {

    }

}
