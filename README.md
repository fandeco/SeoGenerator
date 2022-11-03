## SeoDescription

Создание сео текстов через разметку текста

```php

// Создаем сниппеты с размеченным текстом
$Snippet0 = new Snippet([
    "new"=> false,
    "key"=> "0135135",
    "text"=> "Коллекция FURORE и модель A3990LM-6CC итальянского производителя Arte Lamp разработана для интерьера гостиной в неоклассическом стиле. ",
    "start"=> 0,
    "end"=> 135,
    "length"=> 135,
    "type"=> "block",
    "raw"=> "Коллекция FURORE и модель A3990LM-6CC итальянского производителя Arte Lamp разработана для интерьера гостиной в неоклассическом стиле. ",
    "variable"=> null,
    "no_empty"=> true,
    "variableCheck"=> "",
    "main"=> true
]);
$Snippet1 = new Snippet([
    "new"=> false,
    "key"=> "01919",
    "text"=> "Коллекция FURORE и ",
    "start"=> 0,
    "end"=> 19,
    "length"=> 19,
    "type"=> "block",
    "raw"=> "Коллекция {$collection} и ",
    "variable"=> null,
    "no_empty"=> true
]);
$snippets = [$Snippet0,$Snippet1];    

// Создаем сборщика
$Builder = new Builder([
    // Здесь указываем переменные которые будут использоваться
    'variables' => [
        'collection' => 'REVOLUTION',
    ],
    'snippets' => $snippets
]);


$text = [];

// Получаем все сниппеты
$snippets = $Builder->snippets()->all();
// Сортируем по позиции start
usort($snippets, 'cmp_object_positions');
foreach ($snippets as $snippet) {
    // Обрабатываем только основные снипеты main=1
    if ($snippet->get('main')) {
        $text[$snippet->key()] = [
            'result' => $Builder->parser()->process($snippet), // результат
            'cases' => $snippet->cases(), // причины почему сниппет не собрался
        ];
    }
}
  
```

## Подключения в composer.json

```json
{
  "repositories": [
    {
      "type": "vcs",
      "url": "https://github.com/webnitros/app"
    }
  ],
  "require": {
    "webnitros/app": "^1.0.0"
  }
}
```
