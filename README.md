# php-zint
A barcode generation wrapper class using Zint
## Requirements
This lib requires that zint is installed on your server. See http://www.zint.org.uk for details.
## Installation
This will be composer installable soon, once I have written unit tests and tagged a stable release. In the meantime, you can copy this class, and require it's only dependency, the awesome PHP League's Flysystem.
```
composer require league/flysystem
```
## Usage
```php
use Del\Barcode\Service\BarcodeService;

$path = realpath('/path/to/genration/folder'); // Where zint will dump the image (gets deleted after generation)
$barcodeService = new BarcodeService($path);

$image = $barcodeService->generate(
    BarcodeService::TYPE_GS1_DATABAR_EXPANDED,
    '[255]9980101762001[3902]19099[17]160610[21]358139065068904056'
);

echo $image;
```
