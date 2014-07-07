<?php

class Banco
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

    /**
     * @param \Carteira $carteira
     */
    public function setCarteira($carteira)
    {
        $this->carteira = $carteira;
    }

    /**
     * @return \Carteira
     */
    public function getCarteira()
    {
        return $this->carteira;
    }

    /**
     * @param \Especie $especie
     */
    public function setEspecie($especie)
    {
        $this->especie = $especie;
    }

    /**
     * @return \Especie
     */
    public function getEspecie()
    {
        return $this->especie;
    }

    /**
     * @param \Especie $especieDocumento
     */
    public function setEspecieDocumento($especieDocumento)
    {
        $this->especieDocumento = $especieDocumento;
    }

    /**
     * @return \Especie
     */
    public function getEspecieDocumento()
    {
        return $this->especieDocumento;
    }

    /**
     * @param \Local $localPagamento
     */
    public function setLocalPagamento($localPagamento)
    {
        $this->localPagamento = $localPagamento;
    }

    /**
     * @return \Local
     */
    public function getLocalPagamento()
    {
        return $this->localPagamento;
    }

    /**
     * @param \Logomarca $logomarca
     */
    public function setLogomarca($logomarca)
    {
        $this->logomarca = $logomarca;
    }

    /**
     * @return \Logomarca
     */
    public function getLogomarca()
    {
        return $this->logomarca;
    }

    /**
     * @param \Nome $nome
     */
    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    /**
     * @return \Nome
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * @param \Código $codigo
     */
    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;
    }

    /**
     * @return \Código
     */
    public function getCodigo()
    {
        return $this->codigo;
    }

    /**
     * @param \Dígito $digitoVerificador
     */
    public function setDigitoVerificador($digitoVerificador)
    {
        $this->digitoVerificador = $digitoVerificador;
    }

    /**
     * @return \Dígito
     */
    public function getDigitoVerificador()
    {
        return $this->digitoVerificador;
    }

    /**
     * @return \ Codigo com Dígito
     */
    public function getCodigoComDigitoVerificador()
    {
        return $this->geraCodigoBanco();
    }

    function geraCodigoBanco() {
        $parte1 = substr($this->codigo, 0, 3);
        $parte2 = modulo_11($parte1);
        return $parte1 . "-" . $parte2;
    }






}