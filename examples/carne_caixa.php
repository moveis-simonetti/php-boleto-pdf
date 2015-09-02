<?php

require __DIR__ . '/../vendor/autoload.php';

$oCedente = new \Simonetti\Boleto\Cedente();
$oCedente->setNome("Loja Moveis Mix");
$oCedente->setAgencia("1859");
$oCedente->setDvAgencia("7");
$oCedente->setConta("3176");
$oCedente->setDvConta("3");
$oCedente->setEndereco("Rua Carlos Castro, N&ordm; 245, Centro");
$oCedente->setCidade("Pinheiros");
$oCedente->setUf("ES");
$oCedente->setCpfCnpj("128.588.555-13");

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

$banco = new \Simonetti\Boleto\Banco\Caixa();
$banco->setCarteiraModalidade(1);

$carne = new \Simonetti\Boleto\Carne(
    $banco,
    $oCedente,
    $oSacado
);

$carne->setNumeroMoeda("9");
$carne->setDataDocumento(DateTime::createFromFormat('d/m/Y', "10/07/2014"));
$carne->setDataProcessamento(DateTime::createFromFormat('d/m/Y', "10/07/2014"));
$carne->addDemonstrativo('Pagamento de Compra na Móveis Simonetti');
$carne->addInstrucao("- Sr. Caixa, não receber após o vencimento");
$carne->addInstrucao("- Pedido cancelado após o vencimento");
$carne->addInstrucao("- Em caso de dúvidas entre em contato conosco: www.moveissimonetti.com.br");

$parcela = new \Simonetti\Boleto\Carne\Parcela();
$parcela->setValorBoleto('100,90');
$parcela->setDataVencimento(new \DateTime('+2days'));
$parcela->setNossoNumero('1001');
$parcela->setNumeroDocumento('100');
$carne->addParcela($parcela);

$loader = new Twig_Loader_Filesystem(\Simonetti\Boleto\Gerador::getDirImages() . '/../templates');
$twig = new Twig_Environment($loader);

$geradorCarne = new \Simonetti\Boleto\GeradorCarne($twig);
$geradorCarne->gerar($carne);