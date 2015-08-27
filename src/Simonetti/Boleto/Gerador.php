<?php
namespace Simonetti\Boleto;

use Simonetti\Boleto\Util\Substr;
use Simonetti\Boleto\Util\UnidadeMedida;

abstract class Gerador
{
    public static function getDirImages()
    {
        return __DIR__ . '/Resources/imgs/';
    }

}