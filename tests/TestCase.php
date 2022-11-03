<?php
/**
 * Created by Andrey Stepanenko.
 * User: webnitros
 * Date: 24.03.2021
 * Time: 22:49
 */

namespace Tests;

use SeoGenerator\Word\Builder;
use SeoGenerator\Word\Snippet;
use Mockery\Adapter\Phpunit\MockeryTestCase;

abstract class TestCase extends MockeryTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    public static function texts($name = 'first')
    {
        $texts = file_get_contents(dirname(__FILE__, 1) . '/texts/' . $name . '.json');
        return \GuzzleHttp\json_decode($texts, 1);
    }

    public function snippetsFull()
    {
        $texts = file_get_contents(dirname(__FILE__, 1) . '/texts/first_full.json');
        return \GuzzleHttp\json_decode($texts, 1);
    }

    /**
     * @return  Snippet[]
     */
    public function snippets()
    {
        $Snippet0 = new Snippet([
            "new" => false,
            "key" => "0135135",
            "text" => "Коллекция FURORE и модель A3990LM-6CC итальянского производителя Arte Lamp разработана для интерьера гостиной в неоклассическом стиле. ",
            "start" => 0,
            "end" => 135,
            "length" => 135,
            "type" => "block",
            "variable" => null
        ]);

        $Snippet1 = new Snippet([
            "new" => false,
            "key" => "10166",
            "text" => "FURORE",
            "start" => 10,
            "end" => 16,
            "length" => 6,
            "type" => "variable",
            "variable" => "collection"
        ]);


        $Snippet2 = new Snippet([
            "new" => false,
            "key" => "01919",
            "text" => "Коллекция FURORE и ",
            "start" => 0,
            "end" => 19,
            "length" => 19,
            "type" => "block",
            "variable" => null
        ]);


        $Snippet4 = new Snippet([
            "new" => false,
            "key" => "17181",
            "text" => "и",
            "start" => 17,
            "end" => 18,
            "length" => 1,
            "type" => "block",
            "variable" => ""
        ]);

        return [$Snippet0, $Snippet1, $Snippet2, $Snippet4];
    }

    public function text()
    {
        return 'Коллекция FURORE и модель A3990LM-6CC итальянского производителя Arte Lamp разработана для интерьера гостиной в неоклассическом стиле.';
    }


    public function builder(array $snippets)
    {
        $Builder = new Builder([
            'variables' => [
                'pult' => 'пультом управления',
                'collection' => 'REVOLUTION',
                'article' => 'ART_999999',
                'brand_country' => 'российского',
                'brand' => 'Divinare',
                'lamp_style' => 'АЛЮМИНОВОМ',
                'interer' => 'для интерьера ванной',
                // Two
                'krepej' => 'на монтажную пластину',
                'dopolnitelno' => 'на подвесном потолке',

                // Четвертый блок
                'pagetitle' => 'Люстра Arte Lamp SWING A2527SP-6WH',
                'diameter' => '9',
                'height' => '666',
                'weight_netto' => '10.9',
                'ploshad_osvesheniya' => '100',


                #'armature_material' => '',
                'armature_material' => 'алюминия',

                'armature_color' => 'черного цвета',
                'forma_plafona' => 'корпаративный',
                'plafond_color' => 'плафон сиреневого цвета',
                'shade_direction' => 'вверх',
                'plafond_material' => '',
                #'plafond_material' => 'стекла',
                'reviews' => 'отзывы',
                'files' => 'инструкции по сборке',
                'discount' => '30',
                'type_product' => 'люстру',
                'price' => '126000',
                'city' => 'Ноовокузнецку',
            ],
            'snippets' => $snippets
        ]);

        // Загрузка переменных
        #$Builder->variable()->fromArray($varibles);

        // Загрузка сниппетов
        #$Builder->snippets()->fromArray($snippets);
        return $Builder;
    }
}
