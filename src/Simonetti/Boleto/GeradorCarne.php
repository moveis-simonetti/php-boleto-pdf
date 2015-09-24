<?php
namespace Simonetti\Boleto;

use Picqer\Barcode\BarcodeGeneratorSVG;

/**
 * Class GeradorCarne
 * @package Simonetti\Boleto
 */
class GeradorCarne extends Gerador
{

    /**
     * @var \Twig_Environment
     */
    private $twig;

    /**
     * GeradorCarne constructor.
     * @param \Twig_Environment $twig
     */
    public function __construct(\Twig_Environment $twig)
    {
        $this->twig = $twig;
        $this->geradorCodigoBarras = new BarcodeGeneratorSVG();
    }

    /**
     * @param Carne $carne
     * @return \mPDF
     */
    public function gerar(Carne $carne)
    {
        $mpdf = new \mPDF("", 'A4');

        $mpdf->DeflMargin = 3;
        $mpdf->DefrMargin = 3;
        $mpdf->SetTopMargin(3);
        $mpdf->AddPage();
        /**
         * @var $boleto Boleto
         */
        foreach ($carne->getBoletos() as $boleto) {

            $codigoBarras = $this->geradorCodigoBarras->getBarcode(
                $boleto->getLinha(),
                BarcodeGeneratorSVG::TYPE_INTERLEAVED_2_5,
                1,
                40
            );

            $html = $this->twig->render(
                $carne->getBanco()->getLayoutCarne(),
                [
                    'boleto' => $boleto,
                    'codigoBarras' => base64_encode($codigoBarras),
                    'logoBanco' => base64_encode(file_get_contents(GeradorCarne::getDirImages() . 'logocaixa.jpg')),
                ]
            );
            $mpdf->WriteHTML($html);
            $mpdf->Ln(2);
        }
        return $mpdf;
    }

}