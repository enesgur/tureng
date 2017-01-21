# Tureng Çeviri

[Tureng Sözlük](http://tureng.com) kullanılarak **İngilizce-Türkçe** çeviri yapan bir kütüphanedir.

## Bağımlılıklar
* PHP 5.6 ve üzeri
* composer
* php-curl
* php-xml

## Kurulum

* composer require enesgur/tureng
* composer update

## Örnek Kullanım

```php
use enesgur\Tureng;

// Tekil kelime örneği
$sozluk = new Tureng();
$sozluk->word('home');
var_dump($sozluk->translate());

$sozluk->clear();

// Çoklu kelime örneği
$sozluk->word(['home', 'car']);
var_dump($sozluk->translate());
```

## Geliştiriciler İçin

```bash
composer update
```

 ```bash
./vendor/bin/phpunit --bootstrap vendor/autoload.php tests/TurengTest
```
