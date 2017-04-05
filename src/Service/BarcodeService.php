<?php

namespace Del\Barcode\Service;

use Exception;
use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;

class BarcodeService
{
    const TYPE_AUSTRALIA_POST_REDIRECTION = 68;
    const TYPE_AUSTRALIA_POST_REPLY_PAID = 66;
    const TYPE_AUSTRALIA_POST_ROUTING = 67;
    const TYPE_AUSTRALIA_POST_STANDARD = 63;
    const TYPE_AZTEC_CODE = 92;
    const TYPE_AZTEC_RUNES = 128;
    const TYPE_CHANNEL_CODE = 140;
    const TYPE_CODABAR = 18;
    const TYPE_CODABLOCK_F = 74;
    const TYPE_CODE_2_OF_5 = 2;
    const TYPE_CODE_2_OF_5_DATALOGIC = 6;
    const TYPE_CODE_2_OF_5_IATA = 4;
    const TYPE_CODE_2_OF_5_INDUSTRIAL = 7;
    const TYPE_CODE_11 = 1;
    const TYPE_CODE_16K = 23;
    const TYPE_CODE_32 = 129;
    const TYPE_CODE_39 = 8;
    const TYPE_CODE_39_PLUS = 9;
    const TYPE_CODE_49 = 24;
    const TYPE_CODE_93 = 25;
    const TYPE_CODE_128 = 20;
    const TYPE_CODE_128_SUBSET_B = 60;
    const TYPE_CODE_ONE = 141;
    const TYPE_COMPOSITE_EAN = 130;
    const TYPE_COMPOSITE_GS1_128 = 131;
    const TYPE_COMPOSITE_GS1_DATABAR_14 = 132;
    const TYPE_COMPOSITE_GS1_DATABAR_14_EXPANDED_STACKED = 139;
    const TYPE_COMPOSITE_GS1_DATABAR_14_STACKED = 137;
    const TYPE_COMPOSITE_GS1_DATABAR_14_STACKED_OMNIDIRECTIONAL = 138;
    const TYPE_COMPOSITE_GS1_DATABAR_EXPANDED = 134;
    const TYPE_COMPOSITE_GS1_DATABAR_LIMITED = 133;
    const TYPE_COMPOSITE_UPC_A = 135;
    const TYPE_COMPOSITE_UPC_E = 136;
    const TYPE_DAFT_CODE = 93;
    const TYPE_DATA_MATRIX = 71;
    const TYPE_DEUTSHE_POST_LEIT = 21;
    const TYPE_DOT_CODE = 115;
    const TYPE_DUTCH_POST_KIX_CODE = 90;
    const TYPE_EAN_13 = 13;
    const TYPE_EAN_14 = 72;
    const TYPE_EAN_PLUS = 14;
    const TYPE_FIM = 49;
    const TYPE_FLATTERMARKEN = 28;
    const TYPE_GS1_128 = 16;
    const TYPE_GS1_DATABAR_14 = 29;
    const TYPE_GS1_DATABAR_14_STACKED = 79;
    const TYPE_GS1_DATABAR_14_STACKED_OMNIDIRECTIONAL = 80;
    const TYPE_GS1_DATABAR_EXPANDED = 31;
    const TYPE_GS1_DATABAR_EXPANDED_STACKED = 81;
    const TYPE_GS1_DATABAR_LIMITED = 30;
    const TYPE_GRID_MATRIX = 142;
    const TYPE_HAN_XIN = 116;
    const TYPE_HIBC_AZTEC_CODE = 112;
    const TYPE_HIBC_CODE_39 = 99;
    const TYPE_HIBC_CODE_128 = 98;
    const TYPE_HIBC_DATAMATRIX = 102;
    const TYPE_HIBC_MICRO_PDF_417 = 108;
    const TYPE_HIBC_PDF_417 = 106;
    const TYPE_HIBC_QR_CODE = 104;
    const TYPE_ISBN = 69;
    const TYPE_ITF_14 = 89;
    const TYPE_JAPANESE_POST_CODE = 76;
    const TYPE_KOREA_POST = 77;
    const TYPE_INTERLEAVED_2_OF_5 = 3;
    const TYPE_LOGMARS = 50;
    const TYPE_MAICODE = 57;
    const TYPE_MICRO_PDF_417 = 84;
    const TYPE_MICRO_QR_CODE = 97;
    const TYPE_MSI_PLESSY = 47;
    const TYPE_NVE_18 = 75;
    const TYPE_PDF_417 = 55;
    const TYPE_PDF_417_TRUNCATED = 56;
    const TYPE_PHARMACODE_1_TRACK = 51;
    const TYPE_PHARMACODE_2_TRACK = 53;
    const TYPE_PLANET = 82;
    const TYPE_PLESSY_CODE = 86;
    const TYPE_POSTNET = 40;
    const TYPE_PZN = 52;
    const TYPE_QR_CODE = 58;
    const TYPE_ROYAL_MAIL_4_STATE = 70;
    const TYPE_TELEPEN_ALPHA = 32;
    const TYPE_TELEPEN_NUMERIC = 87;
    const TYPE_UPC_A = 34;
    const TYPE_UPC_A_PLUS_CHECK_DIGIT = 35;
    const TYPE_UPC_E = 37;
    const TYPE_UPC_E_PLUS_CHECK_DIGIT = 38;
    const TYPE_USPS_ONECODE = 85;

    /** @var Filesystem $fileManager */
    private $fileManager;

    /** @var string $generationDirectory */
    private $generationDirectory;

    public function __construct($generationDirectory)
    {
        $localFileAdapter = new Local($generationDirectory);
        $this->fileManager = new Filesystem($localFileAdapter);
        $this->generationDirectory = $generationDirectory;
    }

    public function generate($type, $string, array $options = array())
    {
        $tmpName = md5($string).'.svg';
        $command = 'cd '.$this->generationDirectory.'; zint --barcode='.$type.' -o '.$tmpName.' -d "'.$string.'"';
        exec($command);
        if ($this->fileManager->has('/'.$tmpName)) {
            $image = $this->fileManager->readAndDelete($tmpName);
            return $image;
        } else {
            throw new Exception('File did not appear to generate, not found!');
        }
    }
}
