<?php
/**
 * Created by Andrey Stepanenko.
 * User: webnitros
 * Date: 02.11.2022
 * Time: 16:54
 */

namespace SeoGenerator\Word\implement;

use SeoGenerator\Word\Builder;
use SeoGenerator\Word\Snippet;

interface TemplateInterface
{
    public function process(Builder $builder, Snippet $snippet, $ParentSnippet = null): void;
}
