<?php
/**
 * Created by Andrey Stepanenko.
 * User: webnitros
 * Date: 30.10.2022
 * Time: 01:38
 */

namespace SeoGenerator\Word;

use SeoGenerator\Word\Abstracts\Service;
use SeoGenerator\Word\Helpers\Sort;

class Snippets extends Service
{
    public function all()
    {
        return $this->snippets;
    }


    /**
     * Надет всех родителей сниппета и добавит детей для него
     * @param Builder $Builder
     * @param $snippets
     * @param Snippet $snippet
     */
    public static function findParents(Builder $Builder, $snippets, Snippet $snippet)
    {
        /* @var Snippet $compare */
        foreach ($snippets as $compare) {
            if ($snippet->snippetEnter($compare)) {
                $snippet->addChild($compare);
            }
        }
    }


    public function sortAll()
    {
        $snippets = $this->snippets;
        usort($snippets, 'cmp_object');
        return $snippets;
    }

    public function sortAllPositions()
    {
        $snippets = $this->snippets;
        usort($snippets, 'cmp_object_positions');
        return $snippets;
    }


    public function fromArray(array $arrays)
    {
        $snippets = [];
        foreach ($arrays as $snippet) {
            $snippets[] = new Snippet($snippet);
        }
        // Сортировка чтобы закрывающие блоки были сверху
        $this->snippets = Sort::sort($snippets);

        /* @var Snippet[] $snippets */
        #$snippets = array_reverse($snippets);
        foreach ($this->snippets as $snippet) {
            self::findParents($this->builder, $snippets, $snippet);
        }
        return true;
    }


    public function toArray()
    {
        if (!$results = $this->all()) {
            return null;
        }
        return array_map(function ($restul) {
            return $restul->toArray();
        }, $results);
    }

    /**
     * @param $key
     * @return Snippet|null
     */
    public function get(string $key)
    {
        $snippets = $this->all();
        foreach ($snippets as $snippet) {
            if ($snippet->key() == $key) {
                return $snippet;
            }
        }
        return null;
    }
}
