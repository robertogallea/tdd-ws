`composer require pestphp/pest --dev --with-all-dependencies`

`composer require pestphp/pest-plugin-laravel --dev`

`php artisan pest:install`

`php artisan test`

- Ctrl+Shift+F10 -> lancia il test/file/directory su cui ho il focus
- Ctrl+F5        -> lancia l'ultimo test effettuato

`composer require pestphp/pest-plugin-parallel --dev`

`composer require infection/infection --dev`

`XDEBUG_MODE=coverage ./vendor/bin/pest --coverage-html tests/coverage`

`vendor/bin/infection --test-framework=pest --filter=app/Http/Middleware/AfterHours.php --min-covered-msi=90`
