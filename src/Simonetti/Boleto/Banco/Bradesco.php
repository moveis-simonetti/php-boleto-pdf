<?php

namespace Simonetti\Boleto\Banco;


use Simonetti\Boleto\Banco as BancoAbstract;
use Simonetti\Boleto\Boleto;
use Simonetti\Boleto\Util\Numero;
use Simonetti\Boleto\Util\Modulo;

class Bradesco extends BancoAbstract
{
    protected function init()
    {
        $this->setCarteira("25");
        $this->setEspecie("R$");
        $this->setEspecieDocumento("DS");
        $this->setCodigo("237");
        $this->setNome("Bradesco");
        $this->setLogomarca("logobradesco.jpg");
        $this->setLocalPagamento("Pagável em qualquer Banco até o vencimento");
    }

    /**
     * @param Boleto $boleto
     * @return int|string
     */
    public function getNossoNumeroComDigitoVerificador(Boleto $boleto)
    {
        $nnum = Numero::formataNumero($this->getCarteira(), 2, 0) . Numero::formataNumero(
                $boleto->getNossoNumero(),
                11,
                0
            );

        //dv do nosso número
        return $boleto->digitoVerificadorNossonumero($nnum);
    }

    /**
     * @param Boleto $boleto
     * @return string
     */
    public function getNossoNumeroSemDigitoVerificador(Boleto $boleto)
    {
        return Numero::formataNumero($this->getCarteira(), 2, 0) . Numero::formataNumero(
            $boleto->getNossoNumero(),
            11,
            0
        );
    }

    /**
     * @param Boleto $boleto
     * @return string
     */
    public function getCarteiraENossoNumeroComDigitoVerificador(Boleto $boleto)
    {
        $num = Numero::formataNumero($this->getCarteira(), 2, 0) . Numero::formataNumero(
                $boleto->getNossoNumero(),
                11,
                0
            );

        return substr($num, 0, 2) . '/' . substr($num, 2) . '-' . $boleto->digitoVerificadorNossonumero($num);
    }

    /**
     * @param Boleto $boleto
     * @return string
     */
    public function getDigitoVerificadorCodigoBarras(Boleto $boleto)
    {
        $nnum = Numero::formataNumero($this->getCarteira(), 2, 0) . Numero::formataNumero(
                $boleto->getNossoNumero(),
                11,
                0
            );

        $numero = $this->getCodigo() . $boleto->getNumeroMoeda() . $boleto->getFatorVencimento(
            ) . $boleto->getValorBoletoSemVirgula() . $boleto->getCedente()->getAgencia() . $nnum . Numero::formataNumero(
                $boleto->getCedente()->getConta(),
                7,
                0
            ) . '0';

        $resto2 = Modulo::modulo11($numero, 9, 1);
        if ($resto2 == 0 || $resto2 == 1 || $resto2 == 10) {
            $dv = 1;
        } else {
            $dv = 11 - $resto2;
        }

        return $dv;
    }

    public function digitoVerificadorNossonumero($numero)
    {
        $resto2 = Modulo::modulo11($numero, 7, 1);
        $digito = 11 - $resto2;
        if ($digito == 10) {
            $dv = "P";
        } elseif ($digito == 11) {
            $dv = 0;
        } else {
            $dv = $digito;
        }
        return $dv;
    }

    /**
     * @return string
     */
    public function getLinha(Boleto $boleto)
    {
        return
            $this->getCodigo() .
            $boleto->getNumeroMoeda() .
            $boleto->getDigitoVerificadorCodigoBarras() .
            $boleto->getFatorVencimento() .
            $boleto->getValorBoletoSemVirgula() .
            $boleto->getCedente()->getAgencia() .
            $boleto->getNossoNumeroSemDigitoVerificador() .
            Numero::formataNumero($boleto->getCedente()->getConta(), 7, 0) .
            "0";
    }

}