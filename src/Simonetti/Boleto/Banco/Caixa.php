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

    /**
     * @param Boleto $boleto
     * @return int|string
     */
    public function getNossoNumeroComDigitoVerificador(Boleto $boleto)
    {
        $nnum = $this->getNossoNumeroSemDigitoVerificador($boleto);

        return $boleto->digitoVerificadorNossonumero($nnum);
    }

    /**
     * @param Boleto $boleto
     * @return string
     */
    public function getNossoNumeroSemDigitoVerificador(Boleto $boleto)
    {
        return $this->getCarteiraModalidade() . '4' . $boleto->getNossoNumero();
    }

    /**
     * @param Boleto $boleto
     * @return string
     */
    public function getCarteiraENossoNumeroComDigitoVerificador(Boleto $boleto)
    {
        $nossoNumero = $this->getCarteiraModalidade() . '4/' . $boleto->getNossoNumero();
        $resto2 = Modulo::modulo11($boleto->getModalidadeNossoNumeroCompletoSemBarra(), 9, 1);

        if ($resto2 == 0 || $resto2 == 1 || $resto2 == 10) {
            $dv = 1;
        } else {
            $dv = 11 - $resto2;
        }

        return $nossoNumero . '-' . $dv;
    }

    /**
     * @param Boleto $boleto
     * @return int
     */
    public function getDigitoVerificadorCodigoBarras(Boleto $boleto)
    {
        $num =
            $this->getCodigo() .
            $boleto->getNumeroMoeda() .
            $boleto->getFatorVencimento() .
            $boleto->getValorBoletoSemVirgula() .
            $this->getCampoLivre($boleto).
            $this->getDvCampoLivre($boleto);

        $resto2 = Modulo::modulo11($num, 9, 1);

        if ($resto2 == 0 || $resto2 == 1 || $resto2 == 10) {
            $dv = 1;
        } else {
            $dv = 11 - $resto2;
        }

        return $dv;
    }

    /**
     * @param $numero
     * @return int
     */
    public function digitoVerificadorNossonumero($numero)
    {
        $resto2 = Modulo::modulo11($numero, 9, 1);

        if ($resto2 == 0 || $resto2 == 1 || $resto2 == 10) {
            $dv = 1;
        } else {
            $dv = 11 - $resto2;
        }

        return $dv;
    }

    function getLinha(Boleto $boleto)
    {
        return
            $this->getCodigo() .
            $boleto->getNumeroMoeda() .
            $this->getDigitoVerificadorCodigoBarras($boleto) .
            $boleto->getFatorVencimento() .
            $boleto->getValorBoletoSemVirgula() .
            $this->getCampoLivre($boleto).
            $this->getDvCampoLivre($boleto)
            ;
    }


    public function getCampoLivre(Boleto $boleto)
    {
        return $boleto->getCedente()->getConta() .
        $boleto->getCedente()->getDvConta() .
        substr($boleto->getModalidadeNossoNumeroCompletoSemBarra(), 2, 3) .
        $this->getCarteiraModalidade() .
        substr($boleto->getModalidadeNossoNumeroCompletoSemBarra(), 5, 3) .
        '4' .
        substr($boleto->getModalidadeNossoNumeroCompletoSemBarra(), 8, 9);

    }

    public function getDvCampoLivre(Boleto $boleto)
    {
        $campoLivre = $this->getCampoLivre($boleto);

        $resto2 = Modulo::modulo11($campoLivre, 9, 1);

        if ($resto2 == 0 || $resto2 == 1 || $resto2 == 10) {
            $dv = 1;
        } else {
            $dv = 11 - $resto2;
        }

        return $dv;

    }

}