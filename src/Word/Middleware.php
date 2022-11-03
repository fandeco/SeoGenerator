<?php
/**
 * Created by Andrey Stepanenko.
 * User: webnitros
 * Date: 02.11.2022
 * Time: 16:50
 */

namespace SeoGenerator\Word;


use SeoGenerator\Word\Abstracts\Service;
use SeoGenerator\Word\implement\TemplateInterface;

class Middleware extends Service
{

    /* @var TemplateInterface[] $middleware */
    protected $middleware;

    public function run(Builder $builder, Snippet $snippet, $ParentSnippet = null)
    {
        if ($middlewares = $this->get()) {
            foreach ($middlewares as $middleware) {
                $middleware->process($builder, $snippet, $ParentSnippet);
            }
        }
    }

    public function get()
    {
        if (!empty($this->middleware)) {
            return $this->middleware;
        }
        return null;
    }

    public function addListenEvent(TemplateInterface $template)
    {
        $this->middleware[] = $template;
        return $this;
    }
}
