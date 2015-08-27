<?php
namespace Simonetti\Boleto;

use Simonetti\Boleto\Util\Substr;
use Simonetti\Boleto\Util\UnidadeMedida;
use Picqer\Barcode\BarcodeGeneratorPNG;

/**
 * Class CodigoBarras
 * @package Simonetti\Boleto
 */
class CodigoBarras
{

    public function gerar(Boleto $boleto)
    {
        $generator = new BarcodeGeneratorPNG();
        echo $generator->getBarcode(
            $boleto->getLinha(),
            $generator::TYPE_INTERLEAVED_2_5,
            1,
            49.13
        );
    }
}