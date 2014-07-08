<?php

namespace Simonetti\Boleto\Banco;


use Simonetti\Boleto\Banco as BancoAbstract;

class Bradesco extends BancoAbstract
{
    protected function init()
    {
        $this->setCarteira("25");
        $this->setEspecie("R$");
        $this->setEspecieDocumento("DS");
        $this->setCodigo("237");
        $this->setNome("Bradesco");
        $this->setLogomarca("logobradesco.jpg");
        $this->setLocalPagamento("Pagável em qualquer Banco até o vencimento");
    }

}