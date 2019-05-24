Yii2 Custom Field 
============================
Yii2 Custom Field

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist vthang87/yii2-customfield "*"
```

or add

```
"vthang87/yii2-customfield": "*"
```

to the require section of your `composer.json` file.


Usage
-----

Run migration to create tables

```
yii migrate --migrationPath=@vthang87/customfield/migrations
```