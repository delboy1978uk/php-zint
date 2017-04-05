# php-zint
A barcode generation wrapper class using Zint. I was inspired to do this since there were no PHP libraries which could generate GS1 Databar Expanded barcodes, which contain function characters in them like [FNC1].
## Requirements
This lib requires that zint is installed on your server. See http://www.zint.org.uk for details.
## Installation

#### Installing zint
If you don't have a compiler etc on your system, you should run this first. 
```
sudo yum install make automake gcc gcc-c++ kernel-devel
```
Then to install zint, do the following:
```
git clone https://github.com/zint/zint.git 
cd zint
mkdir build
cd build
sudo cmake ..
sudo make
sudo make install
```
#### Installing the PHP lib
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
