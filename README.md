# MarkupBarcodeBundle

[![Build Status](https://api.travis-ci.org/usemarkup/BarcodeBundle.png?branch=master)](http://travis-ci.org/usemarkup/BarcodeBundle)

## About

This Symfony bundle provides a means of generating barcodes using the [Laminas barcode component](https://docs.laminas.dev/laminas-barcode/) and printing them inline using a data URI.  It avoids problems with parts of the Laminas component that retain state and so allows isolated barcode generation in the same execution cycle.

## Installation

Add MarkupBarcodeBundle to your composer.json:

```js
{
    "require": {
        "markup/barcode-bundle": "@dev"
    }
}
```

Add MarkupBarcodeBundle to your AppKernel.php:

```php
    public function registerBundles()
    {
        $bundles = [
            ...
            new Markup\BarcodeBundle\MarkupBarcodeBundle(),
        ];
        ...
    }
```

Finally, install the bundle using Composer:

```bash
$ php composer.phar update markup/barcode-bundle
```

## Usage

The bundle works by allowing the declaration of named barcode definitions (specifying the spec being used for the barcode, the output format, etc). These definitions are then referred to when rendering an individual barcode.

Say you had a barcode you needed to generate for an "invoice" in your application.  This invoice uses barcodes that were Code 128, and you want to use PNG as the image format for the barcode (PNG is, incidentally, the default).

You can achieve this by declaring the definition in the bundle's semantic configuration:

```yml
    markup_barcode:
        definitions:
            invoice:
                type: code128
                format: png
```

Alternatively, if you need more flexibility, you can write your own definition class that implements `Markup\BarcodeBundle\Definition\DefinitionInterface` and declare it as a service within your bundle, using a `markup_barcode.definition` tag with a declared alias:

```yml
    my.barcode_definition:
        class: Me\MyBundle\Barcode\MyInvoiceBarcodeDefinition
        tags:
            - { name: markup_barcode.definition, alias: invoice }
```

Then, within a Twig template, you would use the following Twig filter (`markup_barcode_data_uri`) to generate a barcode from the text you are encoding:

```html+jinja
    <img src="{{ barcode_text_you_are_encoding|markup_barcode_data_uri('invoice') }}">
```

## License

Released under the MIT License. See LICENSE.
