<?php

namespace PhpSigep\Pdf;

use PhpSigep\Bootstrap;
use PhpSigep\Model\ObjetoPostal;
use PhpSigep\Model\ServicoDePostagem;
use PhpSigep\Model\ServicoAdicional;

class CartaoDePostagem2018
{

	/**
	 * @var \PhpSigep\Pdf\ImprovedFPDF
	 */
	public $pdf;
	/**
	 * @var \PhpSigep\Model\PreListaDePostagem
	 */
	private $plp;
	/**
	 * Uma imagem com tamanho 120 x 140
	 * @var string
	 */
	private $logoFile;
	
	/**
	 * Volume do pacote
	 * @var string
	 */
	public $_volume;
	/**
	 * Identificacao do pedido
	 * @var string
	 */ 
	public $_pedido;
	/**
	 * Observações da encomenda
	 * @var string
	 */
	public $_obs;
	/**
	 * @param \PhpSigep\Model\PreListaDePostagem $plp
	 * @param string $logoFile
	 * @throws InvalidArgument
	 *      Se o arquivo $logoFile não existir.
	 */
	public function __construct($plp, $logoFile)
	{
		if ($logoFile && !@getimagesize($logoFile)) {
			throw new InvalidArgument('O arquivo "' . $logoFile . '" não existe.');
		}

		$this->plp = $plp;
		$this->logoFile = $logoFile;

		$this->init();
	}

	public function render($dest='', $filename = '')
	{
		$cacheKey = md5(serialize($this->plp) . get_class($this));
		if ($pdfContent = Bootstrap::getConfig()->getCacheInstance()->getItem($cacheKey)) {
			header('Content-Type: application/pdf');
			header('Content-Disposition: inline; filename="doc.pdf"');
			header('Cache-Control: private, max-age=0, must-revalidate');
			header('Pragma: public');
			echo $pdfContent;
		} else {
			if($dest == 'S'){
				return $this->_render($dest, $filename);
			}
			else{
				$this->_render($dest, $filename);
				Bootstrap::getConfig()->getCacheInstance()->setItem($cacheKey, $this->pdf->buffer);
			}
		}
	}

	/**
	 * @param string $dest
	 * @param string $fileName
	 * @return mixed
	 */
	private function _render ($dest='', $fileName= '')
	{
		$un = 72 / 25.4;
		$wFourAreas = $this->pdf->w;
		$hFourAreas = $this->pdf->h; //-Menos 1.5CM porque algumas impressoras não conseguem imprimir nos ultimos 1cm da página
		$tMarginFourAreas = 0;
		$rMarginFourAreas = 0;
		$bMarginFourAreas = 0;
		$lMarginFourAreas = 0;
		$wInnerFourAreas = $wFourAreas - $lMarginFourAreas - $rMarginFourAreas;
		$hInnerFourAreas = 0;
		
		$margins = array(
			array(
				'l' => $lMarginFourAreas,
				'r' => $wFourAreas - $rMarginFourAreas,
				't' => $tMarginFourAreas,
				'b' => $hFourAreas - $bMarginFourAreas
			),
			array(
				'l' => $wFourAreas + $lMarginFourAreas,
				'r' => $wFourAreas * 2 - $rMarginFourAreas,
				't' => $tMarginFourAreas,
				'b' => $hFourAreas - $bMarginFourAreas,
			),
			array(
				'l' => $lMarginFourAreas,
				'r' => $wFourAreas - $rMarginFourAreas,
				't' => $hFourAreas + $tMarginFourAreas,
				'b' => $hFourAreas * 2 - $bMarginFourAreas,
			),
			array(
				'l' => $wFourAreas + $lMarginFourAreas,
				'r' => $wFourAreas * 2 - $rMarginFourAreas,
				't' => $hFourAreas + $tMarginFourAreas,
				'b' => $hFourAreas * 2 - $bMarginFourAreas,
			),
		);

		$objetosPostais = $this->plp->getEncomendas();
		$total = count($objetosPostais);
		while (count($objetosPostais)) {
			$this->pdf->AddPage();
			
			if (Bootstrap::getConfig()->getSimular()) {
				$this->pdf->SetFont('Arial', 'B', 50);
				$this->pdf->SetTextColor(240, 240, 240);
				$this->pdf->SetXY($lMarginFourAreas, $hFourAreas - $this->pdf->getLineHeigth());
				$this->pdf->MultiCellXp(
					$this->pdf->w - $this->pdf->lMargin - $this->pdf->rMargin,
					"Simulação Documento sem valor",
					null,
					0,
					'C'
				);
				$this->pdf->SetXY(
					$lMarginFourAreas,
					$margins[2]['t'] + $hFourAreas - $this->pdf->getLineHeigth()
				);
				$this->pdf->MultiCellXp(
					$this->pdf->w - $this->pdf->lMargin - $this->pdf->rMargin,
					"Simulação Documento sem valor",
					null,
					0,
					'C'
				);
				$this->pdf->SetTextColor(0, 0, 0);
			}
			
			$this->pdf->SetDrawColor(0, 0, 0);
			for ($area = 0; $area < 1; $area++) {
				if (!count($objetosPostais)) {
					break;
				}
				/** @var $objetoPostal ObjetoPostal */
				$objetoPostal = array_shift($objetosPostais);

				$lPosFourAreas = $margins[$area]['l'];
				$rPosFourAreas = $margins[$area]['r'];
				$tPosFourAreas = $margins[$area]['t'];
				$bPosFourAreas = $margins[$area]['b'];
				
				
				
				// Logo
				$this->pdf->SetXY($lPosFourAreas, $tPosFourAreas);
				$this->setFillColor(222, 222, 222);
				$headerColWidth = $wInnerFourAreas / 3;
				$headerHeigth = 106;
				if ($this->logoFile) {
					$this->pdf->Image($this->logoFile, 5, ($this->pdf->GetY() + 2), 25, 25);
				}


				$this->setFillColor(150, 150, 200);

				$servicoDePostagem = $objetoPostal->getServicoDePostagem();
				$nomeRemetente = $this->plp->getRemetente()->getNome();
				$accessData = $this->plp->getAccessData();

				switch ($servicoDePostagem->getCodigo()) {
					case ServicoDePostagem::SERVICE_PAC_41068:
					case ServicoDePostagem::SERVICE_PAC_04510:
					case ServicoDePostagem::SERVICE_PAC_CONTRATO_41211:
					case ServicoDePostagem::SERVICE_PAC_CONTRATO_AGENCIA:
					case ServicoDePostagem::SERVICE_PAC_GRANDES_FORMATOS:
					case ServicoDePostagem::SERVICE_PAC_REMESSA_AGRUPADA:
					case ServicoDePostagem::SERVICE_PAC_CONTRATO_UO:
						$simbolo_de_encaminhamento = realpath(dirname(__FILE__)) . '/pac.png';
						$_texto = 'PAC';
						break;
					case ServicoDePostagem::SERVICE_E_SEDEX_STANDARD:
						$simbolo_de_encaminhamento = realpath(dirname(__FILE__)) . '/e-sedex.png';
						$_texto = 'e-SEDEX';
						break;					
					case ServicoDePostagem::SERVICE_SEDEX_40096:
					case ServicoDePostagem::SERVICE_SEDEX_40436:
					case ServicoDePostagem::SERVICE_SEDEX_40444:
					case ServicoDePostagem::SERVICE_SEDEX_A_VISTA:
					case ServicoDePostagem::SERVICE_SEDEX_VAREJO_A_COBRAR:
					case ServicoDePostagem::SERVICE_SEDEX_PAGAMENTO_NA_ENTREGA:
					case ServicoDePostagem::SERVICE_SEDEX_AGRUPADO:
					case ServicoDePostagem::SERVICE_SEDEX_CONTRATO_AGENCIA:
					case ServicoDePostagem::SERVICE_SEDEX_CONTRATO_UO:
						$simbolo_de_encaminhamento = realpath(dirname(__FILE__)) . '/sedex.png';
						$_texto = 'SEDEX';
						break;	
					case ServicoDePostagem::SERVICE_SEDEX_12:
						$simbolo_de_encaminhamento = realpath(dirname(__FILE__)) . '/e-sedex.png';
						$_texto = 'SEDEX 12';
						break;
					case ServicoDePostagem::SERVICE_SEDEX_10:
					case ServicoDePostagem::SERVICE_SEDEX_10_PACOTE:
						$simbolo_de_encaminhamento = realpath(dirname(__FILE__)) . '/e-sedex.png';
						$_texto = 'SEDEX 10';
						break;
					case ServicoDePostagem::SERVICE_SEDEX_HOJE_40290:
					case ServicoDePostagem::SERVICE_SEDEX_HOJE_40878:
						$simbolo_de_encaminhamento = realpath(dirname(__FILE__)) . '/e-sedex.png';
						$_texto = 'SEDEX Hoje';
						break;
					case ServicoDePostagem::SERVICE_CARTA_COMERCIAL_A_FATURAR:
					case ServicoDePostagem::SERVICE_CARTA_REGISTRADA:
					case ServicoDePostagem::SERVICE_CARTA_COMERCIAL_REGISTRADA_CTR_EP_MAQ_FRAN:
						$simbolo_de_encaminhamento = realpath(dirname(__FILE__)) . '/simbolo-sem-especificacao.png';
						$_texto = 'Carta';
						break;
					case ServicoDePostagem::SERVICE_SEDEX_REVERSO:
						$simbolo_de_encaminhamento = realpath(dirname(__FILE__)) . '/sedex.png';
						$_texto = 'SEDEX';
						break;
					default:
						$simbolo_de_encaminhamento = null;
						break;
				}

				if ($simbolo_de_encaminhamento) {
					$this->pdf->Image($simbolo_de_encaminhamento, 81, $this->pdf->GetY() + 2, 20, 20);
				}
				
				
				$this->setFillColor(100, 150, 200);
				// nota fiscal
				$this->pdf->SetXY(5, 27);
				$this->pdf->SetFontSize(9);
				//$this->pdf->SetTextColor(51,51,51);
				$nf = (int)$objetoPostal->getDestino()->getNumeroNotaFiscal();
				$str = $nf > 0 ?  'NF: '. $nf : ' ';
				$this->t(15, $str, 1, 'L',  null);
				
				// Contrato
				$AccessData = $this->plp->getAccessData();
				$ncontrato = (int) $AccessData->getNumeroContrato() > 0 ? $AccessData->getNumeroContrato() : '';
				
				$this->pdf->SetXY(35, 27);
				$this->t(15, 'Contrato:', 1, 'L',  null);
				
				$this->pdf->SetFont('', 'B');
				$this->pdf->SetXY(50, 27);
				$this->t(15, $ncontrato, 1, 'L',  null);
				$this->pdf->SetFont('');
				
				// Volume             
				$this->pdf->SetXY(81, 27);
				$str = $this->_volume != "" ?  'Volume: '. $this->_volume : ' ';
				$this->t(15, $str, 1, 'L',  null);
				
				// Pedido
				$this->pdf->SetXY(5, 31);
				//$this->pdf->SetTextColor(51,51,51);
				$str = $this->_pedido != "" ?  'Pedido: '. $this->_pedido : ' ';
				$this->pdf->SetFontSize(9);
				$this->t(15, $str, 1, 'L',  null);
				
				$this->pdf->SetFont('', 'B');
				$this->pdf->SetXY(35, 31);
				$this->t(40, $_texto, 1, 'C',  null);
				$this->pdf->SetFont('');
				
				// Peso             
				$this->pdf->SetXY(81, 31);
				$this->t(15, 'Peso (g):', 1, 'L',  null);
				$this->pdf->SetFont('', 'B');
				$this->pdf->SetXY(95, 31);
				$this->t(15, round($objetoPostal->getPeso()*1000), 1, 'L',  null);
				$this->pdf->SetFont('');
				
				// Número da etiqueta
				$Yetiqueta = $this->pdf->GetY() + 1;
				$this->setFillColor(100, 100, 200);
				$this->pdf->SetXY(0, $Yetiqueta);
				$this->pdf->SetFontSize(11);
				$this->pdf->SetFont('', 'B');
				$etiquetaComDv = $objetoPostal->getEtiqueta()->getEtiquetaComDv();
				$Formatetiqueta = substr($etiquetaComDv, 0, 2) . ' ' . substr($etiquetaComDv, 2, 3) . ' ' . substr($etiquetaComDv, 5, 3) . ' ' . substr($etiquetaComDv, 8, 3) . ' ' . substr($etiquetaComDv, 11, 2);
				$this->t(85, $Formatetiqueta, 2, 'C');
				
				// Código de barras da etiqueta
				$this->setFillColor(0, 0, 0);
				$tPosEtiquetaBarCode = $this->pdf->GetY();

				$hEtiquetaBarCode = 18;
				$wEtiquetaBarCode = 80;

				$code128 = new \PhpSigep\Pdf\Script\BarCode128();
				$code128->draw(
					$this->pdf,
					5,
					$tPosEtiquetaBarCode,
					$etiquetaComDv,
					$wEtiquetaBarCode,
					$hEtiquetaBarCode
				);
				
				$_siglaAdicinal = array();
                foreach ($objetoPostal->getServicosAdicionais() as $servicoAdicional) {
                    if ($servicoAdicional->is(ServicoAdicional::SERVICE_AVISO_DE_RECEBIMENTO)) {
                        $temAr = true;
                        $sSer = $sSer . "01";
                        $_siglaAdicinal[] = "AR";
                    } else if ($servicoAdicional->is(ServicoAdicional::SERVICE_MAO_PROPRIA)) {
                        $temMp = true;
                        $sSer = $sSer . "02";
                        $_siglaAdicinal[] = "MP";
                    } else if ($servicoAdicional->is(ServicoAdicional::SERVICE_VALOR_DECLARADO)) {
                        $temVd = true;
                        $sSer = $sSer . "19";
                        $_siglaAdicinal[] = "VD";
                        $valorDeclarado = $servicoAdicional->getValorDeclarado();
                    } else if ($servicoAdicional->is(ServicoAdicional::SERVICE_REGISTRO)) {
                        $temRe = true;
                        $sSer = $sSer . "25";
                    }
                }

				$_ctadc = 1;
				$_winit = 90;
				$_hinit = $this->pdf->GetY() - 1;
				$_hupdate = $_hinit;		

				
				if(isset($_siglaAdicinal[0])) {
					foreach($_siglaAdicinal as $_key => $_sigla) {
						if($_ctadc <= 4 && $_ctadc > 1) {
							$_hupdate += 5;
						} 
						if($_ctadc >= 6) {
							$_hupdate += 5;
						}
						if($_ctadc == 5) {
							$_hupdate = $_hinit;
							$_winit = 98;
						}
						
						// Siglas Serviços Adicionais             
						$this->pdf->SetXY($_winit, $_hupdate);
						$this->pdf->SetFont('Arial', 'B', 11);
						$this->t(10, $_sigla, 1, 'L',  null);

						$_ctadc++;
					}
				} 
				
				$this->pdf->SetFont('');
				// Nome legivel, doc e rubrica
				$this->pdf->SetFontSize(9);
				$this->pdf->SetXY(5, $this->pdf->GetY() + 20);
				$this->t(0, 'Recebedor: _____________________________________________', 1, 'L',  null);
				$this->pdf->SetXY(5, $this->pdf->GetY() + 2);
				$this->t(0, 'Assinatura: ______________________ Documento: ____________', 1, 'L',  null);
				$this->t(0, '', 1, 'L',  null);
				
				// Destinatário
				$wAddressLeftCol = $this->pdf->w - 5;

				$tPosAfterNameBlock = 71;

				$destinatario = $objetoPostal->getDestinatario();
				$t = $this->writeDestinatario(
					$lPosFourAreas,
					$tPosAfterNameBlock,
					$wAddressLeftCol,
					$objetoPostal
				);

				$destino = $objetoPostal->getDestino();

				// Número do CEP
				$cep = $destino->getCep();
				$cep = preg_replace('/[^\d]/', '', $cep);

				$tPosCepBarCode = $t + 1;

				// Etiqueta do CEP
				$hCepBarCode = 18;
				$wCepBarCode = 40;
				$this->setFillColor(0, 0, 0);
				$code128 = new \PhpSigep\Pdf\Script\BarCode128();
				$code128->draw(
					$this->pdf,
					6,
					$tPosCepBarCode,
					$cep,
					$wCepBarCode,
					$hCepBarCode
				);

				$valorDeclarado = null;
				$sSer = "";


				while (strlen($sSer) < 12) {
					$sSer = $sSer . "00";
				}

				$sM2Dtext = $this->getM2Dstr(
					$cep,
					$objetoPostal->getDestinatario()->getNumero(),
					$this->plp->getRemetente()->getCep(),
					$this->plp->getRemetente()->getNumero(),
					$etiquetaComDv,
					$sSer,
					$this->plp->getAccessData()->getCartaoPostagem(),
					$objetoPostal->getServicoDePostagem()->getCodigo(),
					$valorDeclarado,
					$objetoPostal->getDestinatario()->getTelefone()
					// $objetoPostal->getDestinatario()->getComplemento()
				);

				require_once  'Semacode.php';
				$semacode = new \Semacode();

				$semaCodeGD = $semacode->asGDImage($sM2Dtext);

				$this->setFillColor(222, 222, 222);
				$this->pdf->gdImage($semaCodeGD, 40, 2, 25, 25);
				imagedestroy($semaCodeGD);
				
				$this->pdf->SetFont('');
				// Nome legivel, doc e rubrica
				$this->pdf->SetFontSize(10);
				$this->pdf->SetXY(55, $this->pdf->GetY()+2);
				$str = $this->_obs != "" ?  'Obs: '. $this->_obs : ' ';
				$this->t(0, $str, 1, 'L',  null);
				
			}
			
			$this->writeRemetente(0,  $this->pdf->GetY() + $hCepBarCode - 2, $wAddressLeftCol, $this->plp->getRemetente());
		}
		
		
		
		$this->pdf->SetXY(0, 0);
		$this->pdf->SetDrawColor(0,0,0);
		$this->pdf->Rect(0, 0, 106.36, 140);
		
		return $this->pdf->Output($fileName, $dest);
	}

	private function _($str)
	{
		$replaces = array(
			'ā' => 'a',
		);
		$str = str_replace(array_keys($replaces), array_values($replaces), $str);
		if (extension_loaded('iconv')) {
			return iconv('UTF-8', 'ISO-8859-1', $str);
		} else {
			return utf8_decode($str);
		}
	}

	private function init()
	{
		$this->pdf = new \PhpSigep\Pdf\ImprovedFPDF('P', 'mm', array(106.36, 140));
		$this->pdf->SetFont('Arial', '', 10);
	}

	/**
	 * @param $l
	 * @param $t
	 * @param $w
	 * @param $objetoPostal
	 * @return
	 * @internal param $tPosEtiquetaBarCode
	 * @internal param $hEtiquetaBarCode
	 * @internal param $lineHeigth
	 * @internal param \Sigep\Cliente $destinatario
	 */
	private function writeDestinatario ($l, $t, $w, $objetoPostal)
	{
		$l = $this->pdf->GetX();
		$t1 = $this->pdf->GetY();
		$l = 0;
		
		$titulo = 'DESTINATÁRIO';
		$nomeDestinatario = $objetoPostal->getDestinatario()->getNome();
		$logradouro = $objetoPostal->getDestinatario()->getLogradouro();
		$numero = $objetoPostal->getDestinatario()->getNumero();
		$complemento = $objetoPostal->getDestinatario()->getComplemento();
		$bairro = '';
		$cidade = '';
		$uf = '';
		$cep = '';
		$destino = $objetoPostal->getDestino();

		if ($destino instanceof \PhpSigep\Model\DestinoNacional) {
			$bairro = $destino->getBairro();
			$cidade = $destino->getCidade();
			$uf = $destino->getUf();
			$cep = $destino->getCep();
		}

		$cep = preg_replace('/(\d{5})-{0,1}(\d{3})/', '$1-$2', $cep);

		$t = $this->writeEndereco(
			$t1,
			$l,
			$w,
			$titulo,
			$nomeDestinatario,
			$logradouro,
			$numero,
			$complemento,
			$bairro,
			$cidade,
			$uf,
			$cep,
			true
		);
		

		//$this->pdf->SetDrawColor(0,0,0);
		//$this->pdf->Rect(0, $t1, 106.36, $t - $t1 + 25);
		
		return $t;
	}

	private function writeRemetente ($l, $t, $w, \PhpSigep\Model\Remetente $remetente)
	{
		$titulo = 'Remetente:';
		$nomeDestinatario = $remetente->getNome();
		$logradouro = $remetente->getLogradouro();
		$numero = $remetente->getNumero();
		$complemento = $remetente->getComplemento();
		$bairro = $remetente->getBairro();
		$cidade = $remetente->getCidade();
		$uf = $remetente->getUf();
		$cep = $remetente->getCep();

		$cep = preg_replace('/(\d{5})-{0,1}(\d{3})/', '$1-$2', $cep);

		return $this->writeEndereco(
			$t,
			$l,
			$w,
			$titulo,
			$nomeDestinatario,
			$logradouro,
			$numero,
			$complemento,
			$bairro,
			$cidade,
			$uf,
			$cep
		);
	}

	/**
	 * @param $t
	 * @param $l
	 * @param $w
	 * @param $titulo
	 * @param $nomeDestinatario
	 * @param $logradouro
	 * @param $numero1
	 * @param $complemento
	 * @param $bairro
	 * @param $cidade
	 * @param $uf
	 * @param $cep
	 *
	 * @internal param $lineHeigth
	 * @internal param $objetoPostal
	 */
	private function writeEndereco (
		$t, $l, $w, $titulo, $nomeDestinatario, $logradouro, $numero1, $complemento, $bairro,
		$cidade, $uf, $cep = null, $destinatario = false
	) {
		//$this->pdf->SetTextColor(51,51,51);
		if($destinatario) {
			$t = $t-2;
			$this->pdf->SetDrawColor(0,0,0);
			$this->pdf->Line(0, $t, 106.36, $t);
		
			// Titulo do bloco: destinatario
			$this->pdf->setFillColor(0,0,0);
			$this->pdf->SetDrawColor(0,0,0);
			$this->pdf->Rect(0, $t, 36, 5, 'F');
			
			$this->pdf->SetFont('', 'B');
			$this->setFillColor(60, 60, 60);
			$this->pdf->SetFontSize(11);
			$this->pdf->SetTextColor(225,225,225);
			$this->pdf->SetXY($l + 3, $t);
			$this->t($w, $titulo, 2, '');
			
			$this->pdf->SetTextColor(0,0,0);
			
			$this->pdf->Image(realpath(dirname(__FILE__)) . '/correios-logo.png', 86, $t+1);
			
			$addressPadding = 5;
			$w = $w - $addressPadding;
			$l = $l + $addressPadding;

			// Nome da pessoa
			$this->pdf->SetFont('', '', 11);
			$this->setFillColor(190, 190, 190);
			$this->pdf->SetX($l);
			$this->multiLines($w, $nomeDestinatario, 'L');

			//Primeria parte do endereco
			$address1 = $logradouro;
			$numero = $numero1;
			if (!$numero || strtolower($numero) == 'sn') {
				$address1 .= ', s/ nº';
			} else {
				$address1 .= ', ' . $numero;
			}
			if ($complemento) {
				$complemento = $complemento . ' ';
			}
			$this->setFillColor(100, 190, 190);
			$this->pdf->SetX($l);
			$this->multiLines($w, $address1, 'L');

			//Segunda parte do endereco
			$this->pdf->SetX($l);
			
			$this->setFillColor(100, 130, 190);
			$this->multiLines($w, $complemento . $bairro, 'L');
			
			$this->setFillColor(100, 30, 210);
			$this->pdf->SetX($l);
			$this->pdf->SetFont('', 'B');
			$this->t($l, ($cep ? $cep . '  ' : ''), 0, 'L');
			
			$this->pdf->SetFont('');
			$this->pdf->SetX($l + 20);
			$this->t(15, ucfirst(trim($cidade)) . '/' . strtoupper(trim($uf)), 2, 'L');
		} else {
			$t = $t -1;
			$this->pdf->SetDrawColor(0,0,0);
			$this->pdf->Line(0, $t, 106.36, $t);
			
			$t++;
			
			// Titulo do bloco: destinatario ou remetente
			$this->pdf->SetFont('', 'B');
			$this->setFillColor(60, 60, 60);
			$this->pdf->SetFontSize(10);
			$this->pdf->SetXY(2, $t);
			$this->t($w, $titulo, 2, '');
			
			$addressPadding = 5;
			$w = $w - $addressPadding;
			$l = $l + $addressPadding;

			// Nome da pessoa
			$this->pdf->SetFont('', '', 10);
			$this->setFillColor(190, 190, 190);
			$this->pdf->SetXY(22, $t);
			$this->multiLines($w, trim($nomeDestinatario), 'L');

			//Primeria parte do endereco
			$address1 = $logradouro;
			$numero = $numero1;
			if (!$numero || strtolower($numero) == 'sn') {
				$address1 .= ', s/ nº';
			} else {
				$address1 .= ', ' . $numero;
			}
			if ($complemento) {
				$complemento = $complemento . ' ';
			}
			$this->setFillColor(100, 190, 190);
			$this->pdf->SetX(2);
			$this->multiLines($w, $address1, 'L');

			//Segunda parte do endereco
			$this->pdf->SetX(2);
			$this->setFillColor(100, 130, 190);
			$this->multiLines($w, $complemento . $bairro, 'L');
			$this->setFillColor(100, 30, 210);
			$this->pdf->SetX(2);
			$this->pdf->SetFont('', 'B');
			$this->t($l, ($cep ? $cep . '  ' : ''), 0, 'L');
			
			$this->pdf->SetFont('');
			$this->pdf->SetX(21);
			$this->t(15, ucfirst(trim($cidade)) . '-' . strtoupper(trim($uf)), 2, 'L');
		}

		return $this->pdf->GetY();
	}
	
	private function setFillColor ($r, $g, $b)
	{
		$this->pdf->SetFillColor ($r, $g, $b);
	}

	private function t ($w, $txt, $ln, $align, $h = null, $multiLines = false, $utf8 = true)
	{
		if ($utf8) {
			$txt = $this->_($txt);
		}
		
		$border = 0;
		$fill = false;

		if ($h === null) {
			$h = $this->pdf->getLineHeigth();
		}

		if ($multiLines) {
			$this->pdf->MultiCell($w, $h, $txt, $border, $align, $fill);
		} else {
			$this->pdf->Cell($w, $h, $txt, $border, $ln, $align, $fill);
		}
	}

	private function multiLines ($w, $txt, $align, $h = null, $utf8 = true)
	{
		$this->t($w, $txt, null, $align, $h, true, $utf8);
	}

	private function CalcDigCep ($cep)
	{
		$str = str_split($cep);
		$sum = 0;
		for ($i = 0; $i <= 7; $i++) {
			$sum = $sum + intval($str[$i]);
		}
		$mul = $sum - $sum % 10 + 10;
		return $mul - $sum;
	}

	private function getM2Dstr ($cepD, $numD, $cepO, $numO, $etq, $srvA, $carP, $codS, $valD, $telD, $msg='')
	{
		$str = '';
		$str .= str_replace('-', '', $cepD);
		$str .= sprintf('%05d', $numD);
		$str .= str_replace('-', '', $cepO);
		$str .= sprintf('%05d', $numO);
		$str .= intval($this->CalcDigCep(str_replace('-', '', $cepD)));
		$str .= '51';
		$str .= $etq;
		$str .= $srvA;
		$str .= $carP;
		$str .= sprintf('%05d', $codS);
		$str .= '01';
		$str .= sprintf('%05d', $numD);
		// $str .= str_pad($cplD, 20, ' ');
		$str .= sprintf('%05d', (int)$valD);
		$str .= $telD;
		$str .= '-00.000000';
		$str .= '-00.000000';
		$str .= '|';
		$str .= str_pad($msg, 30, ' ');
		return $str;
	}
}