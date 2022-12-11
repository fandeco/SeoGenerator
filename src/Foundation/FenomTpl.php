<?php
/**
 * Created by Andrey Stepanenko.
 * User: webnitros
 * Date: 02.11.2022
 * Time: 21:28
 */

namespace SeoGenerator\Foundation;


use SeoGenerator\Word\Abstracts\Service;
use SeoGenerator\Word\Builder;
use Fenom;

class FenomTpl extends Service
{
    protected Fenom $fenom;

    public function __construct(Builder $builder)
    {
        parent::__construct($builder);
        if (!defined('FENOM_RESOURCES')) {
            throw new \Exception('Укажите константу FENOM_RESOURCES для хранения шаблона fenom ');
        }
        Fenom::registerAutoload();
        $this->fenom = new Fenom($provider = new \Fenom\Provider(FENOM_RESOURCES . '/template'));
        if (!file_exists(FENOM_RESOURCES . '/compile')) {
            if (!mkdir($concurrentDirectory = FENOM_RESOURCES . '/compile') && !is_dir($concurrentDirectory)) {
                throw new \RuntimeException(sprintf('Directory "%s" was not created', $concurrentDirectory));
            }
        }
        $this->fenom->setCompileDir(FENOM_RESOURCES . '/compile');
    }

    public function tpl($content, $arrays = null)
    {
        $vars = $this->builder->variable()->toArray();
        if (!is_null($arrays)) {
            $vars = array_merge($vars, $arrays);
        }

        $Template = $this->fenom->compileCode($content);
        $body = '';
        if ($Template instanceof Fenom\Template) {
            if (!empty($vars) && is_array($vars)) {
                $body = $Template->fetch($vars);
                $this->fenom->clearAllCompiles();
            }
        }
        return $body;
    }
}
