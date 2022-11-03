<?php
/**
 * Created by Andrey Stepanenko.
 * User: webnitros
 * Date: 31.10.2022
 * Time: 11:40
 */

namespace Tests\Feature;

use SeoGenerator\Word\Builder;
use Tests\TestCase;

class WordTest extends TestCase
{
    public function testProcess()
    {
        // Правила формрования
        $Builder = $this->builder($this::texts('two_viribles'));

        // События по желанию с шаблоном
        #$Builder->Middleware()->addListenEvent(new FirstTemplate());

        #$main = $snippets = $Builder->closing()->main();
        # $Snippet = $Builder->snippets()->get('528677149');
        # $text = $Builder->parser()->process($Snippet);
        $text = [];
        $snippets = $Builder->snippets()->all();
        usort($snippets, 'cmp_object_positions');
        foreach ($snippets as $snippet) {
            if ($snippet->get('main')) {
                $text[$snippet->key()] = [
                    'result' => $Builder->parser()->process($snippet),
                    'cases' => $snippet->cases(),
                ];
            }
        }

        self::assertEquals('Коллекция REVOLUTION и модель ART_999999 российского производителя Divinare разработана для интерьера ванной в АЛЮМИНОВОМ стиле.', $text['0135135']['result']);
    }


    /**
     * Проверка создания текстов и генерации обрывков
     */
    public function testRunManual()
    {

        // Создаем сборщика
        $Builder = new Builder([
            // Здесь указываем переменные которые будут использоваться
            'variables' => [
                'collection' => 'REVOLUTION',
            ],
            // Создаем сниппеты с размеченным текстом
            'snippets' => [
                [
                    "key" => "01919", // уникальный ключ в рамка сборки
                    "text" => "Коллекция FURORE и ",
                    "start" => 0, // старт откуда ничинается текста
                    "end" => 19, // финиш, где заканчивается
                    "length" => 19, // длина текста
                    // этот текста встанет в место текста Коллекция FURORE и но уже с новым значением
                    // $collection - это перменная которая будет обработана шаблонизатором
                    "raw" => 'Коллекция {$collection} и ',
                    "no_empty" => true // true означает что переменные находязиеся в raw не могут быть пустыми, в случае если будут пустыми текст заменить на пусто
                ],
                [
                    "key" => "0135135",
                    "text" => "Коллекция FURORE и модель A3990LM-6CC итальянского производителя Arte Lamp разработана для интерьера гостиной в неоклассическом стиле. ",
                    "start" => 0,
                    "end" => 135,
                    "length" => 135,
                    "raw" => "Коллекция FURORE и модель A3990LM-6CC итальянского производителя Arte Lamp разработана для интерьера гостиной в неоклассическом стиле. ",
                    "no_empty" => true,
                    "variableCheck" => "collection", // здесь можно перечислить обязательные переменные для текста, без которых он не будет выводиться
                    "main" => true
                ]
            ]
        ]);
        $resutls = $Builder->build();
        self::assertEquals('Коллекция REVOLUTION и модель A3990LM-6CC итальянского производителя Arte Lamp разработана для интерьера гостиной в неоклассическом стиле.', $resutls['0135135']['result']);
    }

    /**
     * Два текста не замену
     */
    public function testRunManualTwo()
    {

        // Создаем сборщика
        $Builder = new Builder([
            // Здесь указываем переменные которые будут использоваться
            'variables' => [
                'collection' => 'REVOLUTION',
                'country' => 'российского',
            ],
            // Создаем сниппеты с размеченным текстом
            'snippets' => [
                [
                    "key" => "01919", // уникальный ключ в рамка сборки
                    "text" => "Коллекция FURORE и ",
                    "start" => 0, // старт откуда ничинается текста
                    "end" => 19, // финиш, где заканчивается
                    "length" => 19, // длина текста
                    // этот текста встанет в место текста Коллекция FURORE и но уже с новым значением
                    // $collection - это перменная которая будет обработана шаблонизатором
                    "raw" => 'Коллекция {$collection} и ',
                    "no_empty" => true // true означает что переменные находязиеся в raw не могут быть пустыми, в случае если будут пустыми текст заменить на пусто
                ],
                [
                    "key" => "01919", // уникальный ключ в рамка сборки
                    "text" => "итальянского ",
                    "start" => 38, // старт откуда ничинается текста
                    "end" => 41, // финиш, где заканчивается
                    "length" => 13, // длина текста
                    // этот текста встанет в место текста Коллекция FURORE и но уже с новым значением
                    // $collection - это перменная которая будет обработана шаблонизатором
                    "raw" => '{$country} ',
                    "no_empty" => true // true означает что переменные находязиеся в raw не могут быть пустыми, в случае если будут пустыми текст заменить на пусто
                ],
                [
                    "key" => "0135135",
                    "text" => "Коллекция FURORE и модель A3990LM-6CC итальянского производителя Arte Lamp разработана для интерьера гостиной в неоклассическом стиле. ",
                    "start" => 0,
                    "end" => 135,
                    "length" => 135,
                    "raw" => "Коллекция FURORE и модель A3990LM-6CC итальянского производителя Arte Lamp разработана для интерьера гостиной в неоклассическом стиле. ",
                    "no_empty" => true,
                    "variableCheck" => "collection", // здесь можно перечислить обязательные переменные для текста, без которых он не будет выводиться
                    "main" => true
                ]
            ]
        ]);
        $resutls = $Builder->build();
        self::assertEquals('Коллекция REVOLUTION и модель A3990LM-6CC российского производителя Arte Lamp разработана для интерьера гостиной в неоклассическом стиле.', $resutls['0135135']['result']);
    }


}
