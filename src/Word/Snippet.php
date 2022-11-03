<?php
/**
 * Created by Andrey Stepanenko.
 * User: webnitros
 * Date: 29.10.2022
 * Time: 14:35
 */

namespace SeoGenerator\Word;

use SeoGenerator\Word\Helpers\RangeCheck;
use SeoGenerator\Word\Helpers\Sort;

class Snippet
{
    private array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
        $this->RangeCheck = new RangeCheck();
    }

    public function toArray()
    {
        return $this->data;
    }

    public function get(string $key)
    {
        if (array_key_exists($key, $this->data)) {
            return $this->data[$key];
        }
        return null;
    }

    public function set(string $key, $value)
    {
        $this->data[$key] = $value;
        return $this;
    }

    public function start()
    {
        return $this->get('start');
    }

    public function value()
    {
        return $this->get('value');
    }

    public function end()
    {
        return $this->get('end');
    }

    public function text()
    {
        return $this->get('text');
    }

    public function mask($keys)
    {
        return $this->RangeCheck->mask($this, $keys);
    }

    public function beginning($text = null)
    {
        return str_repeat("^", $this->start());
    }

    public function beginningInser($length, $start, $value = null)
    {
        $beginning = $this->beginning() . $this->get('value_replace');
        $result = mb_substr_replace($beginning, $value, $start, $length);
        $result = str_ireplace('^', '', $result);
        return $result;
    }

    public function key()
    {
        return (string)$this->get('key');
    }

    public function isKey(string $key)
    {
        return $this->key() === $key;
    }


    public function length()
    {
        return $this->get('length');
    }


    /**
     * Диапазоны совпадают
     * @param int $start
     * @param int $end
     * @return bool
     */
    public function equal(int $start, int $end)
    {
        return $this->RangeCheck->equal($this, $start, $end);
    }

    /**
     * Проверка что сниппет входит в проверяемй диапазон
     * то есть если объект сниппета находиться в дипазоне от 20 до 100 и проверяемы будет с диапазоном с 30 до 40 то вернуться true
     * так же проверяем что сам сниппет в себя не входит
     * @param int $start
     * @param int $end
     * @return bool
     */
    public function snippetEnter(Snippet $compare)
    {
        return $this->RangeCheck->compareEnter($this, $compare);
    }


    public function setRank(int $rank)
    {
        $this->set('rank', $rank);
        return $this;
    }

    public function rank()
    {
        return $this->get('rank');
    }


    protected $values;

    public function values()
    {
        return $this->values;
    }

    /* @var Snippet[]|null $childs */
    protected $childs;

    /* @var Snippet[]|null $parents */
    protected $parents;


    public function addChild(Snippet $snippet)
    {
        // Записиываем родителя чтобы понимать если ли у переменной кто то из родителей
        $snippet->addParent($this->key());

        $this->childs[] = $snippet;
        return $this;
    }

    /**
     * @return Snippet[]|null
     */
    public function childs()
    {
        if (!$this->childs) {
            return null;
        }
        return Sort::positions($this->childs);
    }

    public function childsEnd($exclud = false)
    {
        if (!$this->childs) {
            return null;
        }
        $snippets = $this->childs;


        if ($exclud) {
            // получаем детей только идущих в переди, без задних
            $exclude = [];
            foreach ($snippets as $snippet) {
                if ($childs = $snippet->childs()) {
                    foreach ($childs as $child) {
                        $exclude[$child->key()] = true;
                    }
                }
            }
            foreach ($snippets as $k => $snippet) {
                if (array_key_exists($snippet->key(), $exclude)) {
                    unset($snippets[$k]);
                }
            }
        }

        usort($snippets, 'cmp_object_end');
        $snippets = array_reverse($snippets);

        return $snippets;
    }

    public function addParent($id)
    {
        $this->parents[] = $id;
        return $this;
    }

    /**
     * @return Snippet[]|null
     */
    public function parents()
    {
        return $this->parents;
    }

    protected $_build = false;

    public function isBuild()
    {
        return $this->_build;
    }

    public function setBuild()
    {
        $this->_build = true;
    }

    protected $result;
    protected $disabled = false;


    public function disabled($value = true)
    {
        $this->disabled = $value;
        return $this;
    }

    public function isDisabled()
    {
        return $this->disabled;
    }


    public function result(Builder $builder, $Snippet = null)
    {
        if (!$this->isBuild()) {
            $this->setBuild();
            $raw = $this->get('raw');

            // Получение только первых уровней с детьми
            if ($childs = $this->childsEnd(true)) {

                $results = [];
                foreach ($childs as $k => $snip) {
                    // Если резултат не устроил то пропускаем
                    self::prepareResultChild($snip, $builder);
                    /**
                     * Результаты формирования сниппета
                     */
                    $result = $snip->getResult();

                    // Если наступила причина то генерируем произвольные цифры для замены
                    if ($snip->get('cases')) {
                        #$result = str_repeat("^", $this->length()); // на всю область заменяемог сниппета

                        $beginning = $this->beginning() . $raw;
                        $replace = mb_substr_replace($beginning, $result, $snip->start(), $snip->length());
                        $raw = str_ireplace('^', '', $replace);
                    } else {
                        $beginning = $this->beginning() . $raw;
                        $replace = mb_substr_replace($beginning, $result, $snip->start(), $snip->length());
                        $raw = str_ireplace('^', '', $replace);
                    }

                    $results[] = [
                        '$result' => $result,
                        '$raw' => $raw,
                    ];
                }


                $this->prepareResult($raw, $this, $builder);
            } else {
                $this->prepareResult($raw, $Snippet, $builder);
            }
        }
        return $this->result;
    }

    public static function prepareResultChild(Snippet $Snippet, Builder $builder)
    {
        // Обнуление значений если что то не найдено
        $content = $builder->fenom()->tpl($Snippet->get('raw'));
        $set = true;
        if (!empty($Snippet->get('no_empty')) && $vars = $Snippet->getVarsRaw()) {
            $set = false;
            foreach ($vars as $var) {
                $value = $builder->variable()->get($var);
                if (!empty($value)) {
                    $set = true;
                }
            }
        }


        if (!empty($Snippet->get('no_empty')) && $vars = $Snippet->getVarsRaw()) {
            $set = false;
            foreach ($vars as $var) {
                $value = $builder->variable()->get($var);
                if (!empty($value)) {
                    $set = true;
                }
            }
            if (!$set) {
                $builder->cases()->setCase($Snippet, 'значение переменной пусто: ' . implode(',', $vars));
            }

        }

        // Если установлены ограничения то сразу выбрасываем блок
        if (!$Snippet->checkRequired($builder)) {
            $builder->cases()->setCase($Snippet, 'Не достаточно переменных: ' . $Snippet->get('variableCheck'));
            $set = false; // Обнуляем результаты
        }


        if (!$set) {
            $content = '';
        }
        $Snippet->setResult($content);
        $builder->middleware()->run($builder, $Snippet);
    }


    public function prepareResult($raw, Snippet $Snippet, Builder $builder)
    {
        // Обнуление значений если что то не найдено
        $content = $builder->fenom()->tpl($raw);

        $set = true;
        // Если были указанны какие то переменные и они по итогу оказались пустыми то сброс обеспечен
        if (!empty($this->get('no_empty')) && $vars = $this->getVarsRaw()) {
            $set = false;
            foreach ($vars as $var) {
                $value = $builder->variable()->get($var);
                if (!empty($value)) {
                    $set = true;
                }
            }
        }


        if (!empty($this->get('no_empty')) && $vars = $this->getVarsRaw()) {
            $set = false;

            foreach ($vars as $var) {
                $value = $builder->variable()->get($var);
                if (!empty($value)) {
                    $set = true;
                }
            }

            if (!$set) {
                $builder->cases()->setCase($this, 'значение переменной пусто: ' . implode(',', $vars));
            }

        }

        // Если установлены ограничения то сразу выбрасываем блок
        if (!$Snippet->checkRequired($builder)) {
            $builder->cases()->setCase($this, 'Не достаточно переменных ' . $Snippet->get('variableCheck'));
            $set = false; // Обнуляем результаты
        }


        if (!$set) {
            $content = '';
        }

        $this->setResult($content);
        $builder->middleware()->run($builder, $this, $this);
    }

    public function checkRequired(Builder $builder)
    {
        $variableCheck = $this->get('variableCheck');
        if (!empty($variableCheck)) {
            $symbol = '|';
            if (strripos($variableCheck, '&') !== false) {
                $symbol = '&';
            }


            $vars = explode($symbol, $variableCheck);
            $values = [];
            foreach ($vars as $var) {
                if (!$builder->variable()->isEmpty($var)) {
                    $values[$var] = $builder->variable()->get($var);
                }
            }

            if ($symbol === '&') {
                $res = !empty($values);
                if (!$res) {
                    $builder->cases()->setCase($this, 'Не заполнена одна или все перменные: ' . $variableCheck);
                }
                return $res;
            } else {
                if (count($values) != count($vars)) {
                    $builder->cases()->setCase($this, 'Не заполнены перменные: ' . implode(' или ', explode('|', $variableCheck)));
                    return false;
                }
            }

        }
        return true;
    }


    public function getVarsRaw()
    {
        $string = $this->get('raw');
        preg_match_all('/\{\s*(?P<str>[^}]+?)\s*\}/', $string, $matches);
        $vars = null;
        if ($matches['str']) {
            foreach ($matches['str'] as $match) {
                $vars[] = str_ireplace('$', '', $match);
            }
        }
        return $vars;
    }

    public function setResult($string)
    {
        $this->result = $string;
    }

    public function getResult()
    {
        return $this->result;
    }

    public function cases()
    {
        $cases = $this->get('cases');
        if (!empty($cases[$this->key()])) {
            return $cases[$this->key()];
        }
        return null;
    }


}
