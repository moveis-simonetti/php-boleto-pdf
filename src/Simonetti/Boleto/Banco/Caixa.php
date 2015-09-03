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
        return $boleto->digitoVerificadorNossonumero($this->getNossoNumeroSemDigitoVerificador($boleto));
    }

    /**
     * @param Boleto $boleto
     * @return string
     */
    public function getNossoNumeroSemDigitoVerificador(Boleto $boleto)
    {
        return $this->getCarteiraModalidade() . $this->getTipoImpressao() . $boleto->getNossoNumero();
    }

    /**
     * @param Boleto $boleto
     * @return string
     */
    public function getCarteiraENossoNumeroComDigitoVerificador(Boleto $boleto)
    {
        $nossoNumero = $this->getCarteiraModalidade() . $this->getTipoImpressao() . '/' . $boleto->getNossoNumero();

        return $nossoNumero . '-' . $this->tratarRestoDigitoVerificador(
            Modulo::modulo11($boleto->getNossoNumeroSemDigitoVerificador(), 9, 1)
        );
    }

    /**
     * @param Boleto $boleto
     * @return int
     */
    public function getDigitoVerificadorCodigoBarras(Boleto $boleto)
    {
        $numero =
            $this->getCodigo() .
            $boleto->getNumeroMoeda() .
            $boleto->getFatorVencimento() .
            $boleto->getValorBoletoSemVirgula() .
            $this->getCampoLivre($boleto) .
            $this->getDvCampoLivre($boleto);

        return $this->tratarRestoDigitoVerificador(Modulo::modulo11($numero, 9, 1));
    }

    /**
     * @param $numero
     * @return int
     */
    public function digitoVerificadorNossonumero($numero)
    {
        return $this->tratarRestoDigitoVerificador(Modulo::modulo11($numero, 9, 1));
    }

    /**
     * @param Boleto $boleto
     * @return string
     */
    function getLinha(Boleto $boleto)
    {
        return
            $this->getCodigo() .
            $boleto->getNumeroMoeda() .
            $this->getDigitoVerificadorCodigoBarras($boleto) .
            $boleto->getFatorVencimento() .
            $boleto->getValorBoletoSemVirgula() .
            $this->getCampoLivre($boleto) .
            $this->getDvCampoLivre($boleto);
    }

    /**
     * @param Boleto $boleto
     * @return string
     */
    public function getCampoLivre(Boleto $boleto)
    {
        return $boleto->getCedente()->getConta() .
            $boleto->getCedente()->getDvConta() .
            substr($this->getNossoNumeroSemDigitoVerificador($boleto), 2, 3) .
            $this->getCarteiraModalidade() .
            substr($this->getNossoNumeroSemDigitoVerificador($boleto), 5, 3) .
            $this->getTipoImpressao() .
            substr($this->getNossoNumeroSemDigitoVerificador($boleto), 8, 9);

    }

    /**
     * @param Boleto $boleto
     * @return int
     */
    public function getDvCampoLivre(Boleto $boleto)
    {
        $campoLivre = $this->getCampoLivre($boleto);

        return $this->tratarRestoDigitoVerificador(Modulo::modulo11($campoLivre, 9, 1));
    }

    /**
     * @param $resto
     * @return int
     */
    private function tratarRestoDigitoVerificador($resto)
    {
        if ($resto == 0 || $resto == 1 || $resto == 10) {
            return 1;
        }

        return 11 - $resto;
    }

}