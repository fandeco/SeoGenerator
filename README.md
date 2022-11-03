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

$text = $Builder->build();

/*
Было
Коллекция FURORE и модель A3990LM-6CC итальянского производителя Arte Lamp разработана для интерьера гостиной в неоклассическом стиле.

Стало
- Коллекция REVOLUTION и модель A3990LM-6CC итальянского производителя Arte Lamp разработана для интерьера гостиной в неоклассическом стиле.
*/
```

## Подключения в composer.json

```json
{
  "repositories": [
    {
      "type": "vcs",
      "url": "https://github.com/webnitros/seogenerator"
    }
  ],
  "require": {
    "webnitros/seogenerator": "^1.0.0"
  }
}
```
