<?php
/**
 * Created by Andrey Stepanenko.
 * User: webnitros
 * Date: 03.11.2022
 * Time: 01:09
 */

namespace SeoGenerator\Word;


use SeoGenerator\Word\Abstracts\Service;

class Cases extends Service
{

    protected $cases;

    public function setCase(Snippet $snippet, $case)
    {
        $this->cases[$snippet->key()] = [
            'raw' => $snippet->get('raw'),
            'case' => $case,
        ];
        $snippet->set('cases', $this->cases);
    }

    public function cases()
    {
        return $this->cases;
    }

}
