#  PayMob

A Laravel Package to help with Integration With Paymob  gateway 


## Installation

Require via composer

```bash
$ composer require ahmadabdallah/paymob
```

In `config/app.php` file

```php
'providers' => [
    ...
    Ahmadabbdallah\PayMob\PayMobServiceProvider::class,
    ...
];

'aliases' => [
    ...
    'PayMob' => Ahmadabbdallah\PayMob\Facades\PayMob::class,
    ...
];
```

First of all, make an account on [WeAccept portal](https://www.weaccept.co/portal/login), run this command to generate the PayMob configuration file
```bash
$ php artisan vendor:publish    

fill in the desired value for keys in `config/paymob.php` file in your .env file. Make sure to make an iframe in your dashboard .
