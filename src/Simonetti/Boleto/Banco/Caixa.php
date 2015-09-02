<?php
namespace Simonetti\Boleto\Banco;

use Simonetti\Boleto\Boleto;
use Simonetti\Boleto\Banco;
use Simonetti\Boleto\Util\Modulo;
use Simonetti\Boleto\Util\Numero;

class Caixa extends Banco
{
    protected function init()
    {
        $this->setCarteira("01");
        $this->setCarteiraModalidade("2");
        $this->setEspecie("R$");
        $this->setEspecieDocumento("DM");
        $this->setCodigo("104");
        $this->setNome("Caixa");
        $this->setAceite("SIM");
        $this->setLogomarca("logocaixa.jpg");
        $this->setLocalPagamento("Pagável em qualquer Banco até o vencimento");
        $this->setLayoutCarne('caixa/carne.html.twig');
    }

    function getNossoNumeroComDigitoVerificador(Boleto $boleto)
    {
        $nnum = $this->getNossoNumeroSemDigitoVerificador($boleto);

        return $boleto->digitoVerificadorNossonumero($nnum);
    }

    function getNossoNumeroSemDigitoVerificador(Boleto $boleto)
    {
        return $this->getCarteiraModalidade() . '4' . $boleto->getNossoNumero();
    }

    function getCarteiraENossoNumeroComDigitoVerificador(Boleto $boleto)
    {
        $nossoNumero = $this->getCarteiraModalidade() . '4/' . $boleto->getNossoNumero();
        $digito11 = Modulo::modulo11($boleto->getNossoNumero(), 9, 1);

        return $nossoNumero . '-' . $digito11;
    }


}