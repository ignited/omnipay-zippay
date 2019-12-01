# Omnipay: ZipPay

**ZipPay gateway for the Omnipay PHP payment processing library**

[![Latest Version on Packagist](https://img.shields.io/packagist/v/ignited/omnipay-zippay.svg?style=flat-square)](https://packagist.org/packages/ignited/omnipay-zippay)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/ignited/omnipay-zippay/master.svg?style=flat-square)](https://travis-ci.org/ignited/omnipay-zippay)
[![Coverage Status](https://img.shields.io/scrutinizer/coverage/g/ignited/omnipay-zippay.svg?style=flat-square)](https://scrutinizer-ci.com/g/ignited/omnipay-zippay/code-structure)
[![Quality Score](https://img.shields.io/scrutinizer/g/ignited/omnipay-zippay.svg?style=flat-square)](https://scrutinizer-ci.com/g/ignited/omnipay-zippay)
[![Total Downloads](https://img.shields.io/packagist/dt/ignited/omnipay-zippay.svg?style=flat-square)](https://packagist.org/packages/ignited/omnipay-zippay)


[Omnipay](https://github.com/thephpleague/omnipay) is a framework agnostic, multi-gateway payment
processing library for PHP 5.3+. This package implements ZipPay support for Omnipay.

## Install

Install the gateway using require. Require the `league/omnipay` base package and this gateway.

``` bash
$ composer require league/omnipay ignited/omnipay-zippay
```

## Usage

The following gateways are provided by this package:

 * ZipPay

For general usage instructions, please see the main [Omnipay](https://github.com/thephpleague/omnipay) repository.\


A quick example looks something like this:

Process your Authorization
```php
$omniZip = Omnipay::create('ZipPay_Rest');
$omniZip->setApiKey($zipApiKey);
$authTx = $omniZip->authorize([
  'reference'=> $ref,
  'amount' => 10.00,
  'currency' => 'AUD',
  'returnUrl' => 'https://mysite.com/zip/return',
  'card' => $this->OmniPayCardFactory(), //Customers Details, no credit card number
  'items' => $this->zipItemList(), // Array of items implementing Omnipay\ZipPay\ItemInterface   
]);
$result = $authTx->send();
if($response->isRedirect()) { // Authorize worked
  $resData = $result->getData();
  $this->saveAuthorizeId($resData['id']);
  $response->redirect(); //Sends customer off to ZipPay to complete signup
}
```

Return url (eg /zip/return)
```php
if (!isset($_REQUEST['result']) || $_REQUEST['result'] !== 'approved') 
  throw new \RuntimeError('Problem with your authorization');
$omniZip = Omnipay::create('ZipPay_Rest');
$omniZip->setApiKey($zipApiKey);
$compTx = $omniZip->completeAuthorize([
  'authorityType' => 'checkout_id',
  'authorityValue' => $this->getAuthorizeId(),
  'amount' => 10.00,
  'currency' => 'AUD',
  'captureFunds' => true;
]);
$result = $compTx->send();
if($result->isSuccessful())
  $this->paid();
else
  $this->paymentFailed();
```

## Support

If you are having general issues with Omnipay, we suggest posting on
[Stack Overflow](http://stackoverflow.com/). Be sure to add the
[omnipay tag](http://stackoverflow.com/questions/tagged/omnipay) so it can be easily found.

If you want to keep up to date with release announcements, discuss ideas for the project,
or ask more detailed questions, there is also a [mailing list](https://groups.google.com/forum/#!forum/omnipay) which
you can subscribe to.

If you believe you have found a bug, please report it using the [GitHub issue tracker](https://github.com/ignited/omnipay-zippay/issues),
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

If you discover any security related issues, please email daniel@ignitedlabs.com.au instead of using the issue tracker.

## Credits

- [Daniel Condie](https://github.com/dcon138)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
