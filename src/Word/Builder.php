<?php
/**
 * Created by Andrey Stepanenko.
 * User: webnitros
 * Date: 29.10.2022
 * Time: 13:10
 */

namespace SeoGenerator\Word;

use SeoGenerator\Foundation\FenomTpl;

class Builder
{

    private Variable $variable;
    private Closing $closing;

    private Snippets $snippets;
    private Parser $parser;
    private Middleware $middleware;
    private FenomTpl $fenom;
    private Cases $cases;

    public function __construct(array $options = [])
    {
        $this->variable = new Variable($this);
        $this->closing = new Closing($this);
        $this->snippets = new Snippets($this);
        $this->parser = new Parser($this);
        $this->middleware = new Middleware($this);
        $this->fenom = new FenomTpl($this);
        $this->cases = new Cases($this);

        if (array_key_exists('variables', $options)) {
            $this->variable()->fromArray($options['variables']);
        }
        if (array_key_exists('snippets', $options)) {
            $this->snippets()->fromArray($options['snippets']);
        }
    }

    public function fenom()
    {
        return $this->fenom;
    }

    public function cases()
    {
        return $this->cases;
    }

    public function middleware()
    {
        return $this->middleware;
    }

    public function parser()
    {
        return $this->parser;
    }


    public function closing()
    {
        return $this->closing;
    }


    public function variable()
    {
        return $this->variable;
    }

    /**
     * @return Snippets
     */
    public function snippets()
    {
        return $this->snippets;
    }

    /**
     * @return Snippets
     */
    public function build()
    {
        $text = [];

        // Получаем все сниппеты
        $snippets = $this->snippets()->all();

        // Сортируем по позиции start
        usort($snippets, 'cmp_object_positions');
        foreach ($snippets as $snippet) {
            // Обрабатываем только основные снипеты main=1
            if ($snippet->get('main')) {
                $text[$snippet->key()] = [
                    'result' => $this->parser()->process($snippet), // результат
                    'cases' => $snippet->cases(), // причины почему сниппет не собрался
                ];
            }
        }
        return $text;
    }


}
