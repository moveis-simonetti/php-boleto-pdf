<?php

namespace Simonetti\Boleto;

use Simonetti\Boleto\Util\Modulo;

abstract class Banco
{

    /**
     * @var Código do Banco
     */
    private $codigo;

    /**
     * @var Dígito Verificador Banco
     */
    private $digitoVerificador;

    /**
     * @var Especie
     */
    private $especie;

    /**
     * @var Especie Documento
     */
    private $especieDocumento;

    /**
     * @var Nome
     */
    private $nome;

    /**
     * @var Logomarca
     */
    private $logomarca;

    /**
     * @var Carteira
     */
    private $carteira;

    /**
     * @var Local Pagamento
     */
    private $localPagamento;

    public function __construct()
    {
        $this->init();
    }

    protected abstract function init();

    /**
     * @param string $carteira
     */
    public function setCarteira($carteira)
    {
        $this->carteira = $carteira;
    }

    /**
     * @return string
     */
    public function getCarteira()
    {
        return $this->carteira;
    }

    /**
     * @param string $especie
     */
    public function setEspecie($especie)
    {
        $this->especie = $especie;
    }

    /**
     * @return string
     */
    public function getEspecie()
    {
        return $this->especie;
    }

    /**
     * @param string $especieDocumento
     */
    public function setEspecieDocumento($especieDocumento)
    {
        $this->especieDocumento = $especieDocumento;
    }

    /**
     * @return string
     */
    public function getEspecieDocumento()
    {
        return $this->especieDocumento;
    }

    /**
     * @param string $localPagamento
     */
    public function setLocalPagamento($localPagamento)
    {
        $this->localPagamento = $localPagamento;
    }

    /**
     * @return string
     */
    public function getLocalPagamento()
    {
        return $this->localPagamento;
    }

    /**
     * @param string $logomarca
     */
    public function setLogomarca($logomarca)
    {
        $this->logomarca = $logomarca;
    }

    /**
     * @return string
     */
    public function getLogomarca()
    {
        return $this->logomarca;
    }

    /**
     * @param string $nome
     */
    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    /**
     * @return string
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * @param string $codigo
     */
    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;
    }

    /**
     * @return string
     */
    public function getCodigo()
    {
        return $this->codigo;
    }

    /**
     * @param string $digitoVerificador
     */
    public function setDigitoVerificador($digitoVerificador)
    {
        $this->digitoVerificador = $digitoVerificador;
    }

    /**
     * @return string
     */
    public function getDigitoVerificador()
    {
        return $this->digitoVerificador;
    }

    /**
     * @return string
     */
    public function getCodigoComDigitoVerificador()
    {
        return $this->geraCodigoBanco();
    }

    public function geraCodigoBanco()
    {
        $parte1 = substr($this->codigo, 0, 3);
        $parte2 = Modulo::modulo11($parte1);
        return $parte1 . "-" . $parte2;
    }


}