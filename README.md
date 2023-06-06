# Omnipay: omnipay-qiwi

**Qiwi P2P gateway for the Omnipay PHP payment processing library**

[![Latest Version on Packagist](https://img.shields.io/packagist/v/leonardjke/omnipay-qiwi.svg?style=flat-square)](https://packagist.org/packages/leonardjke/omnipay-omnipay-qiwi)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/leonardjke/omnipay-qiwi/master.svg?style=flat-square)](https://travis-ci.org/leonardjke/omnipay-omnipay-qiwi)
[![Coverage Status](https://img.shields.io/scrutinizer/coverage/g/leonardjke/omnipay-qiwi.svg?style=flat-square)](https://scrutinizer-ci.com/g/leonardjke/omnipay-omnipay-qiwi/code-structure)
[![Quality Score](https://img.shields.io/scrutinizer/g/leonardjke/omnipay-qiwi.svg?style=flat-square)](https://scrutinizer-ci.com/g/leonardjke/omnipay-omnipay-qiwi)
[![Total Downloads](https://img.shields.io/packagist/dt/leonardjke/omnipay-qiwi.svg?style=flat-square)](https://packagist.org/packages/leonardjke/omnipay-omnipay-qiwi)


[Omnipay](https://github.com/thephpleague/omnipay) is a framework agnostic, multi-gateway payment
processing library for PHP 5.3+. This package implements omnipay-qiwi support for Omnipay.

This is where your description should go. Try and limit it to a paragraph or two, and maybe throw in a mention of what
PSRs you support to avoid any confusion with users and contributors.

## Install

Instal the gateway using require. Require the `league/omnipay` base package and this gateway.

``` bash
$ composer require league/omnipay leonardjke/omnipay-qiwi
```

## Usage

### How to initialize Qiwi P2P
```php
/** @var P2PGateway $gateway */
$gateway = Omnipay::create('Qiwi_P2P');

$gateway->initialize([
    'public_key' => 'user-public-key',
    'secret_key' => 'user-private-key',
]);
```
To add some custom configs use. Example, https://developer.qiwi.com/en/p2p-payments/#custom
```php
$gateway->setCustomFields(['themeCode' => 'codeStyle']);
```

To set return page use 
```php
$gateway->setSuccessUrl('https://example.com/page-to-return-after-complete');
```

Or everything in initialize step
```php
/** @var P2PGateway $gateway */
$gateway = Omnipay::create('Qiwi_P2P');

$gateway->initialize([
    'public_key' => 'user-public-key',
    'secret_key' => 'user-private-key',
    'success_url' => 'https://example.com/page-to-return-after-complete',
    'custom_fields' => ['themeCode' => 'customCodeStyle'],
]);
```

### How to accept webhook from qiwi
```php
/** @var P2PGateway $gateway */
$gateway = Omnipay::create('Qiwi_P2P');

$gateway->initialize([
    'public_key' => 'user-public-key',
    'secret_key' => 'user-private-key',
]);

/** @var NotificationRequest $gateway */
$response = $gateway->acceptNotification();

// Check request signature
if (!$response->isValid()) {
    return 'error message';
}

// Status from NotificationInterface
$status = $response->getTransactionStatus();

$amount = $response->getAmount();
$message = $response->getMessage();
$currency = $response->getCurrency();
$transactionId = $response->getTransactionId();
$transactionReference = $response->getTransactionReference();
```

## Support

If you are having general issues with Omnipay, we suggest posting on
[Stack Overflow](http://stackoverflow.com/). Be sure to add the
[omnipay tag](http://stackoverflow.com/questions/tagged/omnipay) so it can be easily found.

If you want to keep up to date with release announcements, discuss ideas for the project,
or ask more detailed questions, there is also a [mailing list](https://groups.google.com/forum/#!forum/omnipay) which
you can subscribe to.

If you believe you have found a bug, please report it using the [GitHub issue tracker](https://github.com/leonardjke/omnipay-omnipay-qiwi/issues),
or better yet, fork the library and submit a pull request.

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email :author_email instead of using the issue tracker.

## Credits

- [leonardjke](https://github.com/leonardjke)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
