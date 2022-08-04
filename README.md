# Инструкция для разворачивания рабочей среды

В данном документе описывается подготовка окружения для тестирования.
Разработка тестов ведётcя на машине тестировщика с применением `Codeception` (фреймворка для тестирования PHP проектов).

Необходимое ПО: 

       1. PHP: https://www.php.net/downloads.php
       
       2. Java: https://java.com/ru/download/
       
       3. Composer: https://getcomposer.org/download/
       
       4. Git: https://git-scm.com/

       5. Google Chrome: https://www.google.com/intl/ru_ru/chrome/

       6. Chromedriver: https://chromedriver.chromium.org/
       
## Настройка рабочего окружения
### 1.1. Клонирование проекта и проверка Codeception

После установки ПО необходимо склонировать проект к себе на компьютер.
    
    $ git clone <репозиторий> <каталог_проекта>
    
Далее переходим в каталог проекта и выполняем команду
    
    $ composer install
    
Проверяем работу `Codeception`
    
    $ vendor/bin/codecept
    
Должен вывестить список доступных команд и версия Codeception.

### 1.2. Настройка параметров запуска тестов
1) В корне проекта копируем файл `.env.local.dist` в этот же корень, только изменяем название файла на `.env.local`

2) В папке `test` находим файл `acceptance.suite.dist.yml` и копируем его в это же место, только изменяем название файла на `acceptance.suite.yml`

3) Открываем файл acceptance.suite.yml и вставляем туда конфиг

<details>
  <summary>Конфиг</summary>
    
    actor: AcceptanceTester
       extensions:
         enabled:
           - Codeception\Extension\RunProcess:
               - chromedriver --url-base=/wd/hub
       modules:
         enabled:
           - \Helper\Acceptance
           - WebDriver:
               browser: 'chrome'
               url: '%URL%'
               port: '9515'
               restart: true
         config:
           WebDriver:
             browser: 'chrome'
             window_size: maximize
             capabilities:
               chromeOptions:
                 args:
                   - '--window-size=1920,1080'
                   - '--no-sandbox'
                   - '--disable-dev-shm-usage'
                   - '--disable-gpu'
                   - '--disable-notifications'          
</details>
4) Скачиваем подходящий для нас chromedriver и закидываем в папку с проектом

### 1.3. Настройка PHPStorm для запуска тестов
Переходим в меню 
    
    *Run->Edit Configurations->Add new Configuration->Codeception*

В разделе `Test Runner` выбираем `Type` и ниже выбираем тип тестов, в нашем случае `acceptance`

Далее в разделе `Use alternative configuration file` справа кликаем на иконку с `"Ключом и шестерёнкой"` и заполняем поле `Path to Сodeception executable`  `[PathToProject]/vendor/codeception/codeception/codecept`
и кликаем на иконку обновить, ниже должна появиться версия текущего Codeception.
Не забыть выбрать интерпретатор PHP.


#### 1.4 Установка PHP fixer
#Устанавливаем через composer и настраиваем PHPCSFixer в Symfony-проекте:
    *cd /ваш/проект*
    *composer req --dev friendsofphp/php-cs-fixer*

Если используете docker-compose, то устанавливайте в нём

docker-compose exec web composer req --dev friendsofphp/php-cs-fixer

<details>
  <summary>Создаём в корне проекта файл .php_cs</summary> 

    <?php

        $finder = PhpCsFixer\Finder::create()
        ->in([
        __DIR__ . '/src',
        __DIR__ . '/tests'
        ])
        ;
        
        return PhpCsFixer\Config::create()
        ->setRules([
        '@Symfony' => true,
        'array_syntax' => ['syntax' => 'short'],
        'concat_space' => ['spacing' => 'one'],
        'increment_style' => ['style' => 'post'],
        'no_extra_blank_lines' => ['tokens' => [
        'extra',
        'parenthesis_brace_block',
        'square_brace_block',
        'throw',
        'use',
        ]],
        'no_superfluous_phpdoc_tags' => false,
        'phpdoc_align' => false,
        'phpdoc_annotation_without_dot' => false,
        'trailing_comma_in_multiline_array' => false,
        'yoda_style' => false
        ])
        ->setFinder($finder)
    ;
</details>

Теперь вы можете запустить проверку всего проекта (или конкретного пути) с помощью команды

#только поиск ошибок
    *./vendor/bin/php-cs-fixer  fix --dry-run --diff ./*
#поиск ошибок и их автоматический фикс
    *./vendor/bin/php-cs-fixer fix ./*

