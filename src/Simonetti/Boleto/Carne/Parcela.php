<?php
namespace Simonetti\Boleto\Carne;

/**
 * Class Parcela
 * @package Simonetti\Boleto\Carne
 */
class Parcela
{

    /**
     * @var \DateTime
     */
    private $dataVencimento;

    /**
     * @var string
     */
    private $nossoNumero;

    /**
     * @var string
     */
    private $numeroDocumento;

    /**
     * @var float
     */
    private $valorBoleto;

    /**
     * @var array
     */
    private $instrucoes = [];

    /**
     * @return \DateTime
     */
    public function getDataVencimento()
    {
        return $this->dataVencimento;
    }

    /**
     * @param \DateTime $dataVencimento
     */
    public function setDataVencimento($dataVencimento)
    {
        $this->dataVencimento = $dataVencimento;
    }

    /**
     * @return string
     */
    public function getNossoNumero()
    {
        return $this->nossoNumero;
    }

    /**
     * @param string $nossoNumero
     */
    public function setNossoNumero($nossoNumero)
    {
        $this->nossoNumero = str_pad($nossoNumero, 15, 0, STR_PAD_LEFT);
    }

    /**
     * @return string
     */
    public function getNumeroDocumento()
    {
        return $this->numeroDocumento;
    }

    /**
     * @param string $numeroDocumento
     */
    public function setNumeroDocumento($numeroDocumento)
    {
        $this->numeroDocumento = $numeroDocumento;
    }

    /**
     * @return float
     */
    public function getValorBoleto()
    {
        return $this->valorBoleto;
    }

    /**
     * @param float $valorBoleto
     */
    public function setValorBoleto($valorBoleto)
    {
        $this->valorBoleto = $valorBoleto;
    }

    public function addInstrucoes(array $instrucoes)
    {
        $this->instrucoes = $instrucoes;
    }

    /**
     * @return array
     */
    public function getInstrucoes()
    {
        return $this->instrucoes;
    }
}