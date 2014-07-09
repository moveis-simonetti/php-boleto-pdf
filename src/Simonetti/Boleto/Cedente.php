<?php

namespace Simonetti\Boleto;

use Simonetti\Boleto\Util\Numero;

class Cedente
{
    /**
     * @var Nome
     */
    private $nome;

    /**
     * @var Cpf/Cnpj
     */
    private $cpfCnpj;

    /**
     * @var Endereço
     */
    private $endereco;

    /**
     * @var Cidade
     */
    private $cidade;

    /**
     * @var UF
     */
    private $uf;

    /**
     * @var Agência
     */
    private $agencia;

    /**
     * @var Dígito Verificador Agência
     */
    private $dvAgencia;

    /**
     * @var Conta
     */
    private $conta;

    /**
     * @var Dígito Verificador Conta
     */
    private $dvConta;

    /**
     * @param \Agência $agencia
     */
    public function setAgencia($agencia)
    {
        $this->agencia = $agencia;
    }

    /**
     * @return \Agência
     */
    public function getAgencia()
    {
        return $this->agencia;
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
     * @param \Conta $conta
     */
    public function setConta($conta)
    {
        $this->conta = $conta;
    }

    /**
     * @return \Conta
     */
    public function getConta()
    {
        return $this->conta;
    }

    /**
     * @param \Cpf $cpfCnpj
     */
    public function setCpfCnpj($cpfCnpj)
    {
        $this->cpfCnpj = $cpfCnpj;
    }

    /**
     * @return \Cpf
     */
    public function getCpfCnpj()
    {
        return $this->cpfCnpj;
    }

    /**
     * @param \Dígito $dvAgencia
     */
    public function setDvAgencia($dvAgencia)
    {
        $this->dvAgencia = $dvAgencia;
    }

    /**
     * @return \Dígito
     */
    public function getDvAgencia()
    {
        return $this->dvAgencia;
    }

    /**
     * @param \Dígito $dvConta
     */
    public function setDvConta($dvConta)
    {
        $this->dvConta = $dvConta;
    }

    /**
     * @return \Dígito
     */
    public function getDvConta()
    {
        return $this->dvConta;
    }

    /**
     * @param \Endereço $endereco
     */
    public function setEndereco($endereco)
    {
        $this->endereco = $endereco;
    }

    /**
     * @return \Endereço
     */
    public function getEndereco()
    {
        return $this->endereco;
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
     * @return Agência com Dv
     */
    public function getAgenciaComDv()
    {
        return $this->agencia."-".$this->dvAgencia;
    }

    /**
     * @return Conta com Dv
     */
    public function getContaComDv()
    {
        $conta = Numero::formataNumero($this->getConta(),7,0);
        $dv = Numero::formataNumero($this->dvConta,1,0);
        return $conta."-".$dv;
    }



}