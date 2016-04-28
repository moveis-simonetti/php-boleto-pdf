<?php
namespace Simonetti\Boleto;

use Simonetti\Boleto\Carne\Parcela;

/**
 * Class Carne
 * @package Simonetti\Boleto
 */
class Carne
{

    /**
     * @var Banco
     */
    private $banco;

    /**
     * @var Cedente
     */
    private $cedente;

    /**
     * @var Sacado
     */
    private $sacado;

    /**
     * @var Avalista
     */
    private $avalista;

    /**
     * @var string
     */
    private $numeroMoeda;

    /**
     * @var \DateTime
     */
    private $dataDocumento;

    /**
     * @var \DateTime
     */
    private $dataProcessamento;

    /**
     * @var array
     */
    private $parcelas = [];

    /**
     * @var array
     */
    private $instrucoes = [];

    /**
     * @var array
     */
    private $demonstrativos = [];


    /**
     * Carne constructor.
     * @param Banco $banco
     * @param Cedente $cedente
     * @param Sacado $sacado
     * @param Avalista $avalista
     */
    public function __construct(Banco $banco, Cedente $cedente, Sacado $sacado, Avalista $avalista = null)
    {
        $this->banco = $banco;
        $this->cedente = $cedente;
        $this->sacado = $sacado;
        $this->avalista = $avalista;
    }

    /**
     * @param Banco $banco
     */
    public function setBanco($banco)
    {
        $this->banco = $banco;
    }

    /**
     * @param Cedente $cedente
     */
    public function setCedente($cedente)
    {
        $this->cedente = $cedente;
    }

    /**
     * @param Sacado $sacado
     */
    public function setSacado($sacado)
    {
        $this->sacado = $sacado;
    }

    /**
     * @param Avalista $avalista
     */
    public function setAvalista($avalista)
    {
        $this->avalista = $avalista;
    }

    /**
     * @param string $numeroMoeda
     */
    public function setNumeroMoeda($numeroMoeda)
    {
        $this->numeroMoeda = $numeroMoeda;
    }

    /**
     * @param \DateTime $dataDocumento
     */
    public function setDataDocumento($dataDocumento)
    {
        $this->dataDocumento = $dataDocumento;
    }

    /**
     * @param \DateTime $dataProcessamento
     */
    public function setDataProcessamento($dataProcessamento)
    {
        $this->dataProcessamento = $dataProcessamento;
    }

    public function addParcela(Parcela $parcela)
    {
        $this->parcelas[] = $parcela;
    }

    /**
     * @return Banco
     */
    public function getBanco()
    {
        return $this->banco;
    }

    /**
     * @return Cedente
     */
    public function getCedente()
    {
        return $this->cedente;
    }

    /**
     * @return Sacado
     */
    public function getSacado()
    {
        return $this->sacado;
    }

    /**
     * @return Avalista
     */
    public function getAvalista()
    {
        return $this->avalista;
    }

    /**
     * @return array
     */
    public function getParcelas()
    {
        return $this->parcelas;
    }

    /**
     * @return string
     */
    public function getNumeroMoeda()
    {
        return $this->numeroMoeda;
    }

    /**
     * @return \DateTime
     */
    public function getDataDocumento()
    {
        return $this->dataDocumento;
    }

    /**
     * @return \DateTime
     */
    public function getDataProcessamento()
    {
        return $this->dataProcessamento;
    }

    /**
     * @return array
     */
    public function getInstrucoes()
    {
        return $this->instrucoes;
    }

    /**
     * @return array
     */
    public function getDemonstrativos()
    {
        return $this->demonstrativos;
    }


    public function addDemonstrativo($demostrativo)
    {
        $this->demonstrativos[] = $demostrativo;
    }

    public function addInstrucao($instrucao)
    {
        $this->instrucoes[] = $instrucao;
    }


    /**
     * @return array
     */
    public function getBoletos()
    {

        $boletos = [];

        /**
         * @var $parcela Parcela
         */
        foreach($this->parcelas as $parcela) {
            $boleto = new Boleto();
            $boleto->setBanco($this->getBanco());
            $boleto->setCedente($this->getCedente());
            $boleto->setSacado($this->getSacado());
            $boleto->setAvalista($this->getAvalista());
            $boleto->setNumeroDocumento($parcela->getNumeroDocumento());
            $boleto->setNossoNumero($parcela->getNossoNumero());
            $boleto->setDataVencimento($parcela->getDataVencimento() );
            $boleto->setDataDocumento($this->dataDocumento);
            $boleto->setDataProcessamento($this->dataProcessamento);
            $boleto->setNumeroMoeda($this->numeroMoeda);
            $boleto->setValorBoleto($parcela->getValorBoleto());

            $boleto->setDemonstrativos($this->demonstrativos);
            $boleto->setInstrucoes($parcela->getInstrucoes());

            $boletos[] = $boleto;
        }

        return $boletos;
    }
}


