# User Center of [Dealskoo](https://www.dealskoo.com)

## Remove file
- database/migrations/2014_10_12_000000_create_users_table.php
- database/migrations/2014_10_12_100000_create_password_resets_table.php
- database/factories/UserFactory.php

## Install

```base
$ composer require dealskoo\user
```

### Publish vendor

```base 
$ php artisan vendor:publish --provider="Dealskoo\User\Providers\UserServiceProvider" --tag=public
```

### Publish config

```base 
$ php artisan vendor:publish --provider="Dealskoo\User\Providers\UserServiceProvider" --tag=config
```

### Publish lang

```base 
$ php artisan vendor:publish --provider="Dealskoo\User\Providers\UserServiceProvider" --tag=lang
```

## Support

- [Dealskoo](https://www.dealskoo.com)
- [Best Deals](https://www.dealskoo.com/best_deals)
- [Promo Codes](https://www.dealskoo.com/promo_codes)
