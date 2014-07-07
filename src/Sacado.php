<?php

class Sacado
{
    /**
     * @var Nome
     */
    private $nome;

    /**
     * @var Tipo Logradouro
     */
    private $tipoLogradouro;

    /**
     * @var Endereço
     */
    private $enderecoLogradouro;

    /**
     * @var Número
     */
    private $numeroLogradouro;

    /**
     * @var Cidade
     */
    private $cidade;

    /**
     * @var UF
     */
    private $uf;

    /**
     * @var Cep
     */
    private $cep;

    /**
     * @param \Cep $cep
     */
    public function setCep($cep)
    {
        $this->cep = $cep;
    }

    /**
     * @return \Cep
     */
    public function getCep()
    {
        return $this->cep;
    }

    /**
     * @param \Cidade $cidade
     */
    public function setCidade($cidade)
    {
        $this->cidade = $cidade;
    }

    /**
     * @return \Cidade
     */
    public function getCidade()
    {
        return $this->cidade;
    }

    /**
     * @param \Endereço $enderecoLogradouro
     */
    public function setEnderecoLogradouro($enderecoLogradouro)
    {
        $this->enderecoLogradouro = $enderecoLogradouro;
    }

    /**
     * @return \Endereço
     */
    public function getEnderecoLogradouro()
    {
        return $this->enderecoLogradouro;
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
     * @param \Número $numeroLogradouro
     */
    public function setNumeroLogradouro($numeroLogradouro)
    {
        $this->numeroLogradouro = $numeroLogradouro;
    }

    /**
     * @return \Número
     */
    public function getNumeroLogradouro()
    {
        return $this->numeroLogradouro;
    }

    /**
     * @param \Tipo $tipoLogradouro
     */
    public function setTipoLogradouro($tipoLogradouro)
    {
        $this->tipoLogradouro = $tipoLogradouro;
    }

    /**
     * @return \Tipo
     */
    public function getTipoLogradouro()
    {
        return $this->tipoLogradouro;
    }

    /**
     * @param \UF $uf
     */
    public function setUf($uf)
    {
        $this->uf = $uf;
    }

    /**
     * @return \UF
     */
    public function getUf()
    {
        return $this->uf;
    }

    /**
     * @return \UF
     */
    public function getEndereco()
    {
        return $this->uf;
    }




}