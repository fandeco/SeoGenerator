<?php
/**
 * Created by Andrey Stepanenko.
 * User: webnitros
 * Date: 31.10.2022
 * Time: 16:03
 */

namespace SeoGenerator\Word;


use SeoGenerator\Word\Abstracts\Service;
use function DeepCopy\deep_copy;

class Parser extends Service
{

    public function process(Snippet $Snippet)
    {
        $Snippet->result($this->builder, $Snippet);
        $text = $Snippet->getResult();

        $text = trim($text);
        if (!empty($text)) {
            $text = mb_ucfirst($text);

            // Финишная обработка
            $text = str_ireplace('  ', ' ', $text);
            $last = mb_substr($text, -2);
            if (' .' === $last) {
                $text = mb_substr($text, 0, -2);
                $text .= '.';
            }
            if ($text === '.') {
                $text = '';
            }
        }
        return $text;

    }
}
