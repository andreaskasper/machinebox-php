# machinebox-php
php class wrapper for machinebox.io

Build status: [![Build Status](https://travis-ci.org/andreaskasper/machinebox-php.svg)](https://travis-ci.org/andreaskasper/machinebox-php)

[![Latest Stable Version](https://poser.pugx.org/andreaskasper/machinebox-php/v/stable.svg)](https://packagist.org/packages/andreaskasper/machinebox-php) [![Total Downloads](https://poser.pugx.org/andreaskasper/machinebox-php/downloads)](https://packagist.org/packages/andreaskasper/machinebox-php) [![Latest Unstable Version](https://poser.pugx.org/andreaskasper/machinebox-php/v/unstable.svg)](https://packagist.org/packages/andreaskasper/machinebox-php) [![License](https://poser.pugx.org/andreaskasper/machinebox-php/license.svg)](https://packagist.org/packages/andreaskasper/machinebox-php)

# Features

# Steps
- [x] Build a base test image to test this build process (Travis/Docker)
- [ ] Build tests
- [ ] Gnomes
- [ ] Profit

# Installation
## via Composer

```json
{
  "repositories": [
    {
      "type": "vcs",
      "url": "https://github.com/andreaskasper/machinebox-php"
    }
  ],
  "require": {
    "andreaskasper/machinebox-php": "*"
  },
	"require-dev": {
    "andreaskasper/machinebox-php": "dev-master"
  }
}
```

```bash
php composer.phar update
```


# Examples
## Simple Example

```php
<?php

//Load Composer's autoloader
require 'vendor/autoload.php';

$box = new \machinebox\classificationbox("http://127.0.0.1:8080");

$box->createmodel("sprache01", "Spracherkennung", array("english","deutsch"));

$input = new inputlist();
$input->add("text", "Hallo dies ist ein deutscher Satz.");
$box->teach("deutsch", $input);

$input = new inputlist();
$input->add("text", "Hello, this is an english sentence.");
$box->teach("english", $input);

$input = new inputlist();
$input->add("text", "Welche Sprache hat dieser Satz?");
$out = $box->predict($input);

print_r($out);

```
