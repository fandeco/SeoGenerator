<?php
/**
 * Created by Andrey Stepanenko.
 * User: webnitros
 * Date: 29.10.2022
 * Time: 13:10
 */

namespace SeoGenerator\Word\Abstracts;


use SeoGenerator\Word\Builder;
use SeoGenerator\Word\Snippet;

abstract class Range
{
    public Builder $parser;
    private int $start;
    private int $end;
    private ?array $data;
    private $_start;
    private $_end;
    /* @var string $text */
    private $_text;

    public function __construct(int $start, int $end, Builder $parser)
    {
        $this->setRange($start, $end);
        $this->parser = $parser;
    }

    public function setRange(int $start, int $end)
    {
        if ($start > $end) {
            throw new \Exception('start не может быть больше end');
        }
        if ($start == $end) {
            throw new \Exception('start не равняться end');
        }

        $this->start = $start;
        $this->end = $end;
        return $this->start;
    }


    public function start()
    {
        return $this->start;
    }

    public function end()
    {
        return $this->end;
    }


    public function rangeAll()
    {
        if ($this->compareStart() && $this->compareEnd()) {
            return true;
        }
        return false;
    }

    /**
     * @return array|null
     */
    public function toArray()
    {
        if (!$results = $this->results()) {
            return null;
        }
        return array_map(function ($restul) {
            return $restul->toArray();
        }, $results);
    }

    /**
     * @return Snippet|null
     */
    public function get(string $key)
    {
        if ($results = $this->results()) {
            foreach ($results as $item) {
                if ($item->key() == $key) {
                    return $item;
                }
            }
        }
        return null;
    }

    /**
     * @return Snippet[]|null
     */
    public function results()
    {
        return $this->data;
    }

    public function add(Snippet $snippet)
    {
        $this->data[] = $snippet;
        return $this;
    }

    public function range()
    {
        if ($this->compareStart() && $this->compareEnd()) {
            return true;
        }
        return false;
    }


    public function compareStart()
    {
        return $this->start() <= $this->startRange();
    }

    public function compareEnd()
    {
        return $this->end() >= $this->endRange();
    }

    protected function startRange()
    {
        return $this->_start;
    }

    protected function textRange()
    {
        return $this->_text;
    }

    protected function endRange()
    {
        return $this->_end;
    }

    protected function setStartRange(int $value)
    {
        $this->_start = $this->_range($value);
        return $this;
    }

    protected function setEndRange(int $value)
    {
        $this->_end = $this->_range($value);
        return $this;
    }

    protected function _range(int $value)
    {
        return $value;
    }

    protected function setTextRange(string $text)
    {
        $this->_text = $text;
        return $this;
    }
}
