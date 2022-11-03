<?php
/**
 * Created by Andrey Stepanenko.
 * User: webnitros
 * Date: 24.10.2022
 * Time: 22:30
 */
if (!function_exists('mb_ucfirst') && extension_loaded('mbstring')) {
    /**
     * mb_ucfirst - преобразует первый символ в верхний регистр
     * @param string $str - строка
     * @param string $encoding - кодировка, по-умолчанию UTF-8
     * @return string
     */
    function mb_ucfirst($str, $encoding = 'UTF-8')
    {
        $str = mb_ereg_replace('^[\ ]+', '', $str);
        $str = mb_strtoupper(mb_substr($str, 0, 1, $encoding), $encoding) .
            mb_substr($str, 1, mb_strlen($str), $encoding);
        return $str;
    }
}

if (!function_exists('after_space')) {
    /**
     * Добавляет пробел в конце строки
     * @param $str
     * @return mixed
     */
    function after_space($str)
    {
        return trim($str) . ' ';
    }
}


if (!function_exists('after_eol')) {
    /**
     * Добавляет пробел в конце строки
     * @param $str
     * @return mixed
     */
    function after_eol($str)
    {
        return $str . PHP_EOL;
    }
}
if (!function_exists('before_eol')) {
    /**
     * Добавляет пробел в конце строки
     * @param $str
     * @return mixed
     */
    function before_eol($str)
    {
        return PHP_EOL . $str;
    }
}


if (!function_exists('cmp')) {
    // Правило, по которому будут сравниваться строки
    function cmp($a, $b)
    {
        return strnatcmp($a["length"], $b["length"]);
    }
}

if (!function_exists('cmp_start')) {
    // Правило, по которому будут сравниваться строки
    function cmp_start($a, $b)
    {
        return strnatcmp($a["start"], $b["start"]);
    }
}


if (!function_exists('cmp_end')) {
    // Правило, по которому будут сравниваться строки
    function cmp_end($a, $b)
    {
        return strnatcmp($a["end"], $b["end"]);
    }
}


if (!function_exists('cmp_object_end')) {
    // Правило, по которому будут сравниваться строки
    function cmp_object_end($a, $b)
    {
        return strnatcmp($a->get('end'), $b->get('end'));
    }
}


if (!function_exists('cmp_object')) {
    // Правило, по которому будут сравниваться строки
    function cmp_object($a, $b)
    {
        return strnatcmp($a->rank(), $b->rank());
    }

}

if (!function_exists('cmp_object_positions')) {
    // Правило, по которому будут сравниваться строки
    function cmp_object_positions($a, $b)
    {
        return strnatcmp($a->start(), $b->start());
    }
}

if (!function_exists('cmp_positions')) {
    // Правило, по которому будут сравниваться строки
    function cmp_positions($a, $b)
    {
        return strnatcmp($a['start'], $b['start']);
    }
}


if (!function_exists('mb_substr_replace')) {
    function mb_substr_replace($string, $replacement, $start, $length = NULL)
    {
        if (is_array($string)) {
            $num = count($string);
            // $replacement
            $replacement = is_array($replacement) ? array_slice($replacement, 0, $num) : array_pad(array($replacement), $num, $replacement);
            // $start
            if (is_array($start)) {
                $start = array_slice($start, 0, $num);
                foreach ($start as $key => $value)
                    $start[$key] = is_int($value) ? $value : 0;
            } else {
                $start = array_pad(array($start), $num, $start);
            }
            // $length
            if (!isset($length)) {
                $length = array_fill(0, $num, 0);
            } elseif (is_array($length)) {
                $length = array_slice($length, 0, $num);
                foreach ($length as $key => $value)
                    $length[$key] = isset($value) ? (is_int($value) ? $value : $num) : 0;
            } else {
                $length = array_pad(array($length), $num, $length);
            }
            // Recursive call
            return array_map(__FUNCTION__, $string, $replacement, $start, $length);
        }
        preg_match_all('/./us', (string)$string, $smatches);
        preg_match_all('/./us', (string)$replacement, $rmatches);
        if ($length === NULL) $length = mb_strlen($string);
        array_splice($smatches[0], $start, $length, $rmatches[0]);
        return join($smatches[0]);
    }

}


if (!function_exists('mb_substr_replace_2')) {
    function mb_substr_replace_2($string, $replacement, $start, $length = NULL)
    {
        if (is_array($string)) {
            $num = count($string);
            // $replacement
            $replacement = is_array($replacement) ? array_slice($replacement, 0, $num) : array_pad(array($replacement), $num, $replacement);
            // $start
            if (is_array($start)) {
                $start = array_slice($start, 0, $num);
                foreach ($start as $key => $value)
                    $start[$key] = is_int($value) ? $value : 0;
            } else {
                $start = array_pad(array($start), $num, $start);
            }
            // $length
            if (!isset($length)) {
                $length = array_fill(0, $num, 0);
            } elseif (is_array($length)) {
                $length = array_slice($length, 0, $num);
                foreach ($length as $key => $value)
                    $length[$key] = isset($value) ? (is_int($value) ? $value : $num) : 0;
            } else {
                $length = array_pad(array($length), $num, $length);
            }
            // Recursive call
            return array_map(__FUNCTION__, $string, $replacement, $start, $length);
        }
        preg_match_all('/./us', (string)$string, $smatches);
        preg_match_all('/./us', (string)$replacement, $rmatches);
        if ($length === NULL) $length = mb_strlen($string);
        array_splice($smatches[0], $start, $length, $rmatches[0]);
        return join($smatches[0]);
    }

}


if (!function_exists('createText')) {
    /**
     * Вернет текст от start до финши с добавлением
     * @return string
     */
    function createText($start, $symbol = '^')
    {
        if ($start != 0) {
            $start--;
        }
        $arr = range(0, $start);
        $text = '';
        foreach ($arr as $item) {
            $text .= $symbol;
        }
        return $text;
    }
}

if (!function_exists('mb_substr_start_end')) {
    /**
     * Вернет текст от start до финши с добавлением
     * @return string
     */
    function mb_substr_start_end($text, $start, $end)
    {
        $len = $end - $start;
        return mb_substr($text, $start, $len);
    }


}

if (!function_exists('mask')) {

    /**
     *
     *
     * // Usage:
     * # $string = $text;
     * #$string = '1234 5678 9123 45678';
     *
     * #$string = '1234 5678 9123 4567КУСОК8';
     * #echo mask($string,null,strlen($string)-4); // *************5678
     * @param $str
     * @param int $start
     * @param null $length
     * @return array|string
     */
    function mask($str, $start = 0, $length = null)
    {
        $mask = preg_replace("/\S/", "*", $str);
        $mask = str_ireplace(' ', '*', $mask);
        if (is_null($length)) {
            $mask = mb_substr($mask, $start);
            $str = mb_substr_replace_2($str, $mask, $start);
        } else {
            $mask = mb_substr($mask, $start, $length);
            $str = mb_substr_replace_2($str, $mask, $start, $length);
        }
        return $str;
    }
}
if (!function_exists('mask2')) {

    /**
     *
     *
     * // Usage:
     * # $string = $text;
     * #$string = '1234 5678 9123 45678';
     *
     * #$string = '1234 5678 9123 4567КУСОК8';
     * #echo mask($string,null,strlen($string)-4); // *************5678
     * @param $str
     * @param int $start
     * @param null $length
     * @return array|string
     */
    function mask2($str, $start = 0, $length = null)
    {
        $mask = preg_replace("/\S/", "*", $str);
        if (is_null($length)) {
            $mask = mb_substr($mask, $start);
            $str = mb_substr_replace_2($str, $mask, $start);
        } else {
            $mask = mb_substr($mask, $start, $length);
            $str = mb_substr_replace_2($str, $mask, $start, $length);
        }
        return $str;
    }
}


if (!function_exists('replace_symbol')) {

    /**
     * @param $mask
     * @param $value
     * @return array|string|string[]
     */
    function replace_symbol($mask, $value)
    {
        $symbols = [];
        $len = strlen($mask);
        for ($i = 0; $i < $len; $i++) {
            if ($mask[$i] == '*') {
                $symbols[] = '*';
            }
        }
        $symbols = implode('', $symbols);
        $value = str_ireplace($symbols, $value, $mask);
        return $value;
    }
}


if (!function_exists('find_symbol')) {

    /**
     * @param $mask
     * @param $value
     * @return array|string|string[]
     */
    function find_symbol($mask)
    {
        $symbols = [];
        $len = strlen($mask);
        $count = 0;
        $start = false;
        for ($i = 0; $i < $len; $i++) {
            if ($mask[$i] == '*') {
                $start = true;
                $symbols[$count]['str'][] = '*';
            } else {
                if ($start) {
                    $count++;
                    $start = false;
                }
            }
        }
        return $symbols;
    }
}
