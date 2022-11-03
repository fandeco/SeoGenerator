<?php
/**
 * Created by Andrey Stepanenko.
 * User=> webnitros
 * Date=> 29.10.2022
 * Time=> 16=>15
 */

namespace SeoGenerator\Word\Helpers;


use SeoGenerator\Word\Snippet;

class Sort
{
    /**
     * @param Snippet[] $snippets
     * @return Snippet[]
     */
    public static function sort(array $snippets)
    {
        $ranges = [];
        foreach ($snippets as $index => $snippet) {
            $ranges[] = [
                'index' => $index,
                'length' => $snippet->length(),
            ];
        }

        // Сама функция сортировки
        usort($ranges, "cmp");


        foreach ($ranges as $rank => $range) {
            if (array_key_exists($range['index'], $snippets)) {
                $Snippet = $snippets[$range['index']];
                $Snippet->setRank($rank);
            }
        }

        // Сама функция сортировки
        usort($snippets, "cmp_object");

        return array_reverse($snippets);
    }


    public static function positions(array $snippets)
    {
        usort($snippets, 'cmp_object_positions');
        return $snippets;
    }

}
