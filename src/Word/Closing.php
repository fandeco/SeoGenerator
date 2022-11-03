<?php
/**
 * Получение замыкающих блоков текстов
 */

namespace SeoGenerator\Word;

use SeoGenerator\Word\Abstracts\Service;

class Closing extends Service
{
    /* @var array $closings */
    protected $closings = null;

    public function all()
    {
        $this->closings = [];
        if ($snippets = $this->builder->snippets()->all()) {
            foreach ($snippets as $snippet) {
                $this->closingSnippet($snippet);
            }
        }
        return $this->closings;
    }

    public function main()
    {
        $ids = [];
        $all = $this->all();
        $this->closings = [];
        foreach ($all as $snippet) {
            if (!empty($snippet['main'])) {
                $ids[] = [
                    'key' => $snippet['key'],
                    'text' => $snippet['text'],
                ];
            }
        }
        return $ids;
    }

    private function closingSnippet(Snippet $snippet)
    {

        if ($snippets = $this->builder->snippets()->all()) {
            foreach ($snippets as $compare) {
                if ($snippet->start() <= $compare->start() && $snippet->end() >= $compare->end()) {
                    $key = $snippet->key();
                    if (!array_key_exists($key, $this->closings)) {
                        $this->closings[$key] = [
                            'key' => $snippet->key(),
                            'text' => $snippet->text(),
                            'start' => $snippet->start(),
                            'end' => $snippet->end(),
                            'main' => $snippet->get('main'),
                            'value' => '',
                            'child' => null
                        ];
                    }
                    if ($key !== $compare->key()) {
                        $this->closings[$key]['child'][$compare->key()] = [
                            'key' => $compare->key(),
                            'start' => $compare->start(),
                            'text' => $compare->text(),
                            'end' => $compare->end(),
                            'value' => '',
                        ];

                        #$snippet->addMany($compare);

                    }

                }
            }
        }

    }
}
