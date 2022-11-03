<?php
/**
 * Created by Andrey Stepanenko.
 * User: webnitros
 * Date: 31.10.2022
 * Time: 08:16
 */

namespace SeoGenerator\Word\Helpers;

use SeoGenerator\Word\Snippet;

class RangeCheck
{
    /**
     * Диапазоны совпадают
     * @param Snippet $snippet
     * @param int $start
     * @param int $end
     * @return bool
     */
    public function equal(Snippet $snippet, int $start, int $end)
    {
        return ($start === $snippet->start() && $end === $snippet->end());
    }

    /**
     * Диапазон вхож в сниппет
     * @param Snippet $snippet
     * @param int $start
     * @param int $end
     * @return bool
     */
    public function enterRange(Snippet $snippet, int $start, int $end)
    {
        return ($start >= $snippet->start() && $end <= $snippet->end());
    }

    /**
     * Диапазон вхож в сниппет
     * @param Snippet $snippet
     * @param Snippet $comapre
     * @return bool|null
     */
    public function compareEnter(Snippet $snippet, Snippet $comapre)
    {
        $start = $comapre->start();
        $end = $comapre->end();
        if (!$this->equal($snippet, $start, $end)) {
            return $this->enterRange($snippet, $start, $end);
        }
        return null;
    }

    public function mask(Snippet $snippet, $keys)
    {
        $text = $snippet->text();
        if ($snippet->start() !== 0) {
            $text = createText($snippet->length()) . $text;
        }
        foreach ($keys as $rang) {
            $text = mask($text, $rang['start'], $rang['length']);
        }
        return $text;
    }


    public function beginning(Snippet $snippet)
    {
        $len = $snippet->start();
        #if ($snippet->start() !== 0) {
        #$len++;
        #}

        #$arr = range(0, $len);

        $str = str_repeat("^", $len);
        echo '<pre>';
        print_r($str);
        die;

        echo '<pre>';
        print_r(count($arr));
        die;

        $text = '';
        foreach ($arr as $item) {
            $text .= '^';
        }
        return $text;

        #return createText($len);
    }


    /**
     * Вернет текст от start до финши с добавлением
     * @return string
     */
    /*  public function beginning()
      {
          $start = $this->start();
          $arr = range(0, $start);
          $arr = implode('^', $arr);
          return mb_substr($arr, 0, -1) . $this->text();
      }*/

}
