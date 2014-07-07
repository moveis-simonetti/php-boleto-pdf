<?php

class GeradorBoleto
{
    public function gerar(Boleto $boleto)
    {
        $PDF = new FPDF("P", 'mm', 'A4');

        $PDF->AddPage();
        $PDF->SetFont('Arial', '', 9);

        $PDF->Cell(50, 10, '', 'B', 0, 'L');
        $PDF->Image("../imagens/boleto_bradesco.png", 10, 43,40,10);
//Select Arial italic 8
        $PDF->SetFont('Arial','B',14);
        $PDF->Cell(20, 10, $boleto->getBanco()->getCodigoComDigitoVerificador(), 'LBR', 0, 'C');

        $PDF->SetFont('Arial', 'B', 9);
        $PDF->Cell(120, 10, $boleto->geraLinhaDigitavel(), 'B', 1,'R');

        $PDF->SetFont('Arial', '', 6);
        $PDF->Cell(85, 3, 'Cedente', 'LR', 0, 'L');
        $PDF->Cell(30, 3, 'Agência/Código do Cedente', 'R', 0, 'L');
        $PDF->Cell(15, 3, 'Espécie', 'R', 0, 'L');
        $PDF->Cell(20, 3, 'Quantidade', 'R', 0, 'L');
        $PDF->Cell(40, 3, 'Carteira/Nosso número', '', 1, 'L');

        $PDF->SetFont('Arial', '', 7);
        $PDF->Cell(85, 5, $boleto->getSacado()->getNome(), 'BLR', 0, 'L');
        $PDF->Cell(30, 5, $boleto->getCedente()->getAgencia(), 'BR', 0, 'L');
        $PDF->Cell(15, 5, $boleto->getBanco()->getEspecie(), 'BR', 0, 'L');
        $PDF->Cell(20, 5, "001", 'BR', 0, 'L');
        $PDF->Cell(40, 5, $boleto->getNossoNumeroComDigitoVerificador(), 'B', 1, 'R');

        $PDF->SetFont('Arial', '', 6);
        $PDF->Cell(60, 3, 'Número do Documento', 'LR', 0, 'L');
        $PDF->Cell(35, 3, 'CPF/CNPJ', 'R', 0, 'L');
        $PDF->Cell(35, 3, 'Vencimento', 'R', 0, 'L');
        $PDF->Cell(60, 3, 'Valor Documento', 'L', 1, 'L');

        $PDF->SetFont('Arial', '', 7);
        $PDF->Cell(60, 5, $boleto->getNossoNumeroComDigitoVerificador(), 'BLR', 0, 'L');
        $PDF->Cell(35, 5, $boleto->getCedente()->getCpfCnpj(), 'BR', 0, 'L');
        $PDF->Cell(35, 5, $boleto->getDataVencimento(), 'BR', 0, 'L');
        $PDF->Cell(60, 5, $boleto->getValorBoleto(), 'B', 1, 'R');

        $PDF->SetFont('Arial', '', 6);
        $PDF->Cell(33, 3, '(-)Desconto/Abatimentos', 'LR', 0, 'L');
        $PDF->Cell(32, 3, '(-)Outras deduções', 'R', 0, 'L');
        $PDF->Cell(32, 3, '(+)Mora/Multa', 'R', 0, 'L');
        $PDF->Cell(33, 3, 'Vencimetno', '', 0, 'L');
        $PDF->Cell(60, 3, '(*)Valor Cobrado', 'L', 1, 'L');

        $PDF->SetFont('Arial', '', 7);
        $PDF->Cell(33, 5, '', 'BLR', 0, 'L');
        $PDF->Cell(32, 5, '', 'BR', 0, 'L');
        $PDF->Cell(32, 5, '', 'BR', 0, 'L');
        $PDF->Cell(33, 5, '', 'BR', 0, 'L');
        $PDF->Cell(60, 5, '', 'B', 1, 'R');

        $PDF->SetFont('Arial', '', 6);
        $PDF->Cell(190, 3, 'Sacado', 'L', 1, 'L');

        $PDF->SetFont('Arial', '', 7);
        $PDF->Cell(190, 5, $boleto->getSacado()->getNome(), 'L', 1, 'L');
        $PDF->Cell(190, 5, $boleto->getSacado()->getTipoLogradouro()." ".$boleto->getSacado()->getEndereco().", ".$boleto->getSacado()->getNumeroLogradouro(), 'L', 1, 'L');
        $PDF->Cell(190, 5, $boleto->getSacado()->getCidade()." - ".$boleto->getSacado()->getUf()." - CEP: ".$boleto->getSacado()->getCep(), 'BL', 1, 'L');

        $PDF->SetFont('Arial', '', 6);
        $PDF->Cell(170, 3, 'Instruções', '', 0, 'L');
        $PDF->Cell(20, 3, 'Autênticação Mecânica', '', 1, 'R');

        $PDF->SetFont('Arial', '', 7);

        foreach($boleto->getInstrucoes() as $instrucao)
        {
            $PDF->Cell(190, 5, $instrucao, '', 1, 'L');
        }


        $PDF->Ln();
        $PDF->SetFont('Arial', 'B', 6);
        $PDF->Cell(190, 2, 'Corte na linha pontilhada', '', 1, 'R');
        $PDF->SetFont('Arial', '', 12);
        $PDF->Cell(190, 2, '--------------------------------------------------------------------------------------------------------------------------------------', '', 0, 'L');

        $PDF->Ln(10);


        $PDF->Cell(50, 10, '', 'B', 0, 'L');
        $PDF->Image("../imagens/boleto_bradesco.png", 10, 135,40,10);
//Select Arial italic 8
        $PDF->SetFont('Arial','B',14);
        $PDF->Cell(20, 10, $boleto->getBanco()->getCodigoComDigitoVerificador(), 'LBR', 0, 'C');

        $PDF->SetFont('Arial', 'B', 9);
        $PDF->Cell(120, 10, $boleto->gerarLinhaDigitavel(), 'B', 1,'R');

        $PDF->SetFont('Arial', '', 6);
        $PDF->Cell(130, 3, 'Local Pagamento', 'LR', 0, 'L');
        $PDF->Cell(60, 3, 'Vencimento', '', 1, 'L');

        $PDF->SetFont('Arial', '', 7);
        $PDF->Cell(130, 5, 'Pagável em qualquer Banco até o vencimento', 'BLR', 0, 'L');
        $PDF->Cell(60, 5, $boleto->getDataVencimento(), 'B', 1, 'R');

        $PDF->SetFont('Arial', '', 6);
        $PDF->Cell(130, 3, 'Cedente', 'LR', 0, 'L');
        $PDF->Cell(60, 3, 'Agência/Código cedente', '', 1, 'L');

        $PDF->SetFont('Arial', '', 7);
        $PDF->Cell(130, 5, $boleto->getCedente()->getNome(), 'BLR', 0, 'L');
        $PDF->Cell(60, 5, $boleto->getCedente()->getAgencia(), 'B', 1, 'R');

        $PDF->SetFont('Arial', '', 6);
        $PDF->Cell(28, 3, 'Data Documento', 'LR', 0, 'L');
        $PDF->Cell(40, 3, 'Número do Documento', 'R', 0, 'L');
        $PDF->Cell(20, 3, 'Espécie doc.', 'R', 0, 'L');
        $PDF->Cell(20, 3, 'Aceite', 'R', 0, 'L');
        $PDF->Cell(22, 3, 'Data processamento', '', 0, 'L');
        $PDF->Cell(60, 3, 'Carteira / Nosso número', 'L', 1, 'L');

        $PDF->SetFont('Arial', '', 7);
        $PDF->Cell(28, 5, $boleto->getDataDocumento(), 'BLR', 0, 'L');
        $PDF->Cell(40, 5, $boleto->getNumeroDocumento(), 'BR', 0, 'L');
        $PDF->Cell(20, 5, $boleto->getBanco()->getEspecieDocumento(), 'BR', 0, 'L');
        $PDF->Cell(20, 5, "", 'BR', 0, 'L');
        $PDF->Cell(22, 5, $boleto->getDataProcessamento(), 'BR', 0, 'L');
        $PDF->Cell(60, 5, $boleto->getNossoNumeroComDigitoVerificador(), 'B', 1, 'R');

        $PDF->SetFont('Arial', '', 6);
        $PDF->Cell(28, 3, 'Uso do Banco', 'LR', 0, 'L');
        $PDF->Cell(25, 3, 'Carteira', 'R', 0, 'L');
        $PDF->Cell(15, 3, 'Espécie', 'R', 0, 'L');
        $PDF->Cell(40, 3, 'Quantidade', 'R', 0, 'L');
        $PDF->Cell(22, 3, '(x)Valor', '', 0, 'L');
        $PDF->Cell(60, 3, '(=)Valor Documento', 'L', 1, 'L');

        $PDF->SetFont('Arial', '', 7);
        $PDF->Cell(28, 5, '05/05/2014', 'BLR', 0, 'L');
        $PDF->Cell(25, 5, $boleto->getBanco()->getCarteira(), 'BR', 0, 'L');
        $PDF->Cell(15, 5, $boleto->getBanco()->getEspecie(), 'BR', 0, 'L');
        $PDF->Cell(40, 5, "001", 'BR', 0, 'L');
        $PDF->Cell(22, 5, '', 'BR', 0, 'L');
        $PDF->Cell(60, 5, $boleto->getValorBoleto(), 'B', 1, 'R');

        $PDF->SetFont('Arial', '', 6);
        $PDF->Cell(130, 3, 'Instruções', 'L', 0, 'L');
        $PDF->Cell(60, 3, '(-)Desconto/Abatimentos', 'L', 1, 'L');

        $PDF = new modelo_pdf("P", 'mm', 'A4');

        $l = 0;
        foreach($boleto->getInstrucoes() as $instrucao)
        {
            $l ++;
            $PDF->Cell(130, 5, $instrucao, 'L', 0, 'L');
            if(1 == $l)
            {
                $PDF->Cell(60, 5, '', 'LB', 1, 'R');
            }
            elseif(2 == $l)
            {
                $PDF->SetFont('Arial', '', 6);
                $PDF->Cell(60, 3, '(-)Outras deduções', 'L', 1, 'L');
            }
            elseif(3 == $l)
            {
                $PDF->Cell(60, 5, '', 'LB', 1, 'R');
            }
            elseif(4 == $l)
            {
                $PDF->SetFont('Arial', '', 6);
                $PDF->Cell(60, 3, '(+)Mora/Multa', 'L', 1, 'L');
            }
        }

        $PDF->SetFont('Arial', '', 7);
        $PDF->Cell(130, 5, '', 'L', 0, 'L');
        $PDF->Cell(60, 5, '', 'LB', 1, 'R');

        $PDF->Cell(130, 3, '', 'L', 0, 'L');
        $PDF->SetFont('Arial', '', 6);
        $PDF->Cell(60, 3, '(+)Outros acréscimos', 'L', 1, 'L');

        $PDF->SetFont('Arial', '', 7);
        $PDF->Cell(130, 5, '', 'L', 0, 'L');
        $PDF->Cell(60, 5, '', 'LB', 1, 'R');

        $PDF->Cell(130, 3, '', 'L', 0, 'L');
        $PDF->SetFont('Arial', '', 6);
        $PDF->Cell(60, 3, '(=)Valor cobrado', 'L', 1, 'L');
        $PDF->SetFont('Arial', '', 7);
        $PDF->Cell(130, 5, '', 'LB', 0, 'L');
        $PDF->Cell(60, 5, '', 'LB', 1, 'R');

        $PDF->SetFont('Arial', '', 6);
        $PDF->Cell(190, 3, 'Sacado', 'L', 1, 'L');

        $PDF->SetFont('Arial', '', 7);
        $PDF->Cell(190, 5, $boleto->getSacado()->getNome(), 'L', 1, 'L');
        $PDF->Cell(190, 5, $boleto->getSacado()->getTipoLogradouro()." ".$boleto->getSacado()->getEndereco().", ".$boleto->getSacado()->getNumeroLogradouro(), 'L', 1, 'L');
        $PDF->Cell(190, 5, $boleto->getSacado()->getCidade()." - ".$boleto->getSacado()->getUf()." - CEP: ".$boleto->getSacado()->getCep(), 'BL', 1, 'L');

        $PDF->SetFont('Arial', '', 6);
        $PDF->Cell(170, 3, 'Sacador/Avalista', '', 0, 'L');
        $PDF->Cell(20, 3, 'Autênticação Mecânica - Ficha de Compensação', '', 1, 'R');

        fbarcode($boleto->gerarLinhaDigitavel());

        $PDF->Ln(10);
        $PDF->SetY(260);
        $PDF->SetFont('Arial', 'B', 6);
        $PDF->Cell(190, 2, 'Corte na linha pontilhada', '', 1, 'R');
        $PDF->SetFont('Arial', '', 12);
        $PDF->Cell(190, 2, '--------------------------------------------------------------------------------------------------------------------------------------', '', 0, 'L');

        //$PDF->;


    }

} 