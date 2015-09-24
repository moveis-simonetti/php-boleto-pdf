<?php

require __DIR__ . '/../vendor/autoload.php';

$oCedente = new \Simonetti\Boleto\Cedente();
$oCedente->setNome("LOJAS SIMONETTI LTDA");
$oCedente->setAgencia("3366");
$oCedente->setDvAgencia("9");
$oCedente->setConta("443459");
$oCedente->setDvConta("5");
$oCedente->setEndereco("RUA CARLOS CASTRO, 245 - CENTRO - PINHEIROS/ES - 29980000");
$oCedente->setCidade("PINHEIROS");
$oCedente->setUf("ES");
$oCedente->setCpfCnpj("31.743.818/0001-28");

$oSacado = new \Simonetti\Boleto\Sacado();
$oSacado->setNome("VINICIUS DE SÁ");
$oSacado->setCpfCnpj("144.840.167-45");
$oSacado->setTipoLogradouro("AVENIDA");
$oSacado->setEnderecoLogradouro("SETEMBIRNO PELISSARI");
$oSacado->setNumeroLogradouro("100");
$oSacado->setCidade("PINHEIROS");
$oSacado->setBairro("CENTRO");
$oSacado->setUf("ES");
$oSacado->setCep("29980-000");


$oAvalista = new \Simonetti\Boleto\Avalista('FRANK BRUNO', '133.567.677-55');

$banco = new \Simonetti\Boleto\Banco\Caixa();
$banco->setCarteiraModalidade('2');
$banco->setCarteira('SR');

$carne = new \Simonetti\Boleto\Carne(
    $banco,
    $oCedente,
    $oSacado,
    $oAvalista
);

$carne->setNumeroMoeda("9");
$carne->setDataDocumento(DateTime::createFromFormat('d/m/Y', "29/08/2015"));
$carne->setDataProcessamento(new DateTime('now'));
$carne->addDemonstrativo('Pagamento de Compra na Móveis Simonetti');
$carne->addInstrucao(" ");
$carne->addInstrucao("MULTA DE R$: 1,00 APÓS: 17/10/2015");
$carne->addInstrucao("JUROS DE R$: 0,09 AO DIA");
$carne->addInstrucao(" ");
$carne->addInstrucao("NÃO RECEBER APÓS 10 DIAS DO VENCIMENTO");

$dataInicial = new DateTime('2015-09-01');

$boletosValidacao = [];

$i = 1;

while(10 != count($boletosValidacao)) {

    $dataVenciemento = clone $dataInicial;

    $parcela = new \Simonetti\Boleto\Carne\Parcela();
    $parcela->setValorBoleto('10,00');
    $parcela->setDataVencimento($dataVenciemento);
    $parcela->setNossoNumero($i);
    $parcela->setNumeroDocumento(100+$i);

    $boletotmp = new \Simonetti\Boleto\Boleto();
    $boletotmp->setBanco($carne->getBanco());
    $boletotmp->setCedente($carne->getCedente());
    $boletotmp->setSacado($carne->getSacado());
    $boletotmp->setAvalista($carne->getAvalista());
    $boletotmp->setNumeroDocumento($parcela->getNumeroDocumento());
    $boletotmp->setNossoNumero($parcela->getNossoNumero());
    $boletotmp->setDataVencimento($parcela->getDataVencimento() );
    $boletotmp->setDataDocumento($carne->getDataDocumento());
    $boletotmp->setDataProcessamento($carne->getDataProcessamento());
    $boletotmp->setNumeroMoeda($carne->getNumeroMoeda());
    $boletotmp->setValorBoleto($parcela->getValorBoleto());

    $boletotmp->setDemonstrativos($carne->getDemonstrativos());
    $boletotmp->setInstrucoes($carne->getInstrucoes());

    $linha = substr($boletotmp->gerarLinhaDigitavel(), 35, 1);
    if(!in_array($linha, $boletosValidacao)) {
        $carne->addParcela($parcela);
        $dataInicial->modify('+1 days');
        $boletosValidacao[] = $linha;
    }

    $i++;
}

$loader = new Twig_Loader_Filesystem(\Simonetti\Boleto\Gerador::getDirImages() . '/../templates');
$twig = new Twig_Environment($loader);

$geradorCarne = new \Simonetti\Boleto\GeradorCarne($twig);
$boleto = $geradorCarne->gerar($carne);
$boleto->Output('boleto.pdf' , 'D');