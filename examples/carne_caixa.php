<?php

require __DIR__ . '/../vendor/autoload.php';

$oCedente = new \Simonetti\Boleto\Cedente();
$oCedente->setNome("Loja Moveis Mix");
$oCedente->setAgencia("3366");
$oCedente->setDvAgencia("9");
$oCedente->setConta("443459");
$oCedente->setDvConta("5");
$oCedente->setEndereco("Rua Carlos Castro, Nº. 245, Centro");
$oCedente->setCidade("Pinheiros");
$oCedente->setUf("ES");
$oCedente->setCpfCnpj("25.328.654/0001-70");

$oSacado = new \Simonetti\Boleto\Sacado();
$oSacado->setNome("Nome Completo do Sacado");
$oSacado->setCpfCnpj("133.555.999-75");
$oSacado->setTipoLogradouro("Rua");
$oSacado->setEnderecoLogradouro("Bartolomeu da Gama");
$oSacado->setNumeroLogradouro("100");
$oSacado->setCidade("São Mateus");
$oSacado->setBairro("Centro");
$oSacado->setUf("ES");
$oSacado->setCep("29980-000");


$oAvalista = new \Simonetti\Boleto\Avalista('FRANK BRUNO', '133.555.999-75');

$banco = new \Simonetti\Boleto\Banco\Caixa();
$banco->setCarteiraModalidade('1');
$banco->setCarteira('RG');

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
$carne->addInstrucao("- Sr. Caixa, não receber após o vencimento");
$carne->addInstrucao(" ");
$carne->addInstrucao("- Pedido cancelado após o vencimento");
$carne->addInstrucao("- Em caso de dúvidas entre em contato conosco: www.moveissimonetti.com.br");

$parcela = new \Simonetti\Boleto\Carne\Parcela();
$parcela->setValorBoleto('216,30');
$parcela->setDataVencimento(new \DateTime('2015-09-29'));
$parcela->setNossoNumero('1');
$parcela->setNumeroDocumento('50165755');
$carne->addParcela($parcela);

$loader = new Twig_Loader_Filesystem(\Simonetti\Boleto\Gerador::getDirImages() . '/../templates');
$twig = new Twig_Environment($loader);

$geradorCarne = new \Simonetti\Boleto\GeradorCarne($twig);
$geradorCarne->gerar($carne);