<?php
//============================================================+
// File name   : example_051.php
// Begin       : 2009-04-16
// Last Update : 2013-05-14
//
// Description : Example 051 for TCPDF class
//               Full page background
//
// Author: Nicola Asuni
//
// (c) Copyright:
//               Nicola Asuni
//               Tecnick.com LTD
//               www.tecnick.com
//               info@tecnick.com
//============================================================+

/**
 * Creates an example PDF TEST document using TCPDF
 * @package com.tecnick.tcpdf
 * @abstract TCPDF - Example: Full page background
 * @author Nicola Asuni
 * @since 2009-04-16
 */

// Include the main TCPDF library (search for installation path).
require_once('tcpdf_include.php');


// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {
	//Page header
	public function Header() {
		// get the current page break margin
		$bMargin = $this->getBreakMargin();
		// get current auto-page-break mode
		$auto_page_break = $this->AutoPageBreak;
		// disable auto-page-break
		$this->SetAutoPageBreak(false, 0);
		// set bacground image
		$img_file = K_PATH_IMAGES.'THGFileCover.jpg';
		$this->Image($img_file, 0, 0, 210, 297, '', '', '', false, 300, '', false, false, 0);
		// restore auto-page-break status
		$this->SetAutoPageBreak($auto_page_break, $bMargin);
		// set the starting point for the page content
		$this->setPageMark();
	}
}

$fullName = $_POST['PtFullName'];

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('๋JIN WELLNESS REPORT of '.$fullName.' '.date('Y-m-d'));
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(0);
$pdf->SetFooterMargin(0);

// remove default footer
$pdf->setPrintFooter(false);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
	require_once(dirname(__FILE__).'/lang/eng.php');
	$pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
$pdf->SetFont('times', '', 48);

// add a page
$pdf->AddPage();

// Print a text
/*$html = '<span style="">&nbsp;PAGE 1&nbsp;</span>
<p stroke="0.2" fill="true" strokecolor="yellow" color="blue" style="font-family:helvetica;font-weight:bold;font-size:26pt;">You can set a full page background.</p>';
$pdf->writeHTML($html, true, false, true, false, '');*/

$pdf->SetFont('times', '', 16);
$pdf->SetXY(80, 240);
$pdf->Write(20, $_POST['PtFullName'], '', 0, 'L', true, 0, false, false, 0);
// add a page
//$pdf->AddPage();

// Print a text
//$html = '<span style="background-color:yellow;color:blue;">&nbsp;PAGE 2&nbsp;</span>';
//$pdf->writeHTML($html, true, false, true, false, '');

// --- example with background set on page ---

// remove default header
$pdf->setPrintHeader(false);
// -- set new background ---

// get the current page break margin
$bMargin = $pdf->getBreakMargin();
// get current auto-page-break mode
$auto_page_break = $pdf->getAutoPageBreak();
// disable auto-page-break
$pdf->SetAutoPageBreak(false, 0);
// set bacground image
$img_file = '';
$pdf->Image($img_file, 0, 0, 210, 297, '', '', '', false, 300, '', false, false, 0);
// restore auto-page-break status
$pdf->SetAutoPageBreak($auto_page_break, $bMargin);
// set the starting point for the page content
$pdf->setPageMark();

// add a page
$pdf->AddPage();

$pdf->Image('images/JinWellnessBanner.png', 20, 10, '', '', 'PNG', '', '', true, 150, '', false, false, 1, false, false, false);
				

$pdf->SetFont('freeserif', '', 20);
$pdf->SetXY(30, 20);
$pdf->Write(40, 'ORGAN INFO GRAPHIC', '', 0, 'L', true, 0, false, false, 0);

$im = LoadPNG('images/WholeBody.png');
imagepng($im, 'images/'.$_POST['PtFullName'].date("Y-m-d").'.png');

$x = 100; $y = 80; $w = ''; $h = '';
$pdf->SetXY(140, 80);
$pdf->SetLineStyle(array('width' => 0.0, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(255, 255, 255)));
//$pdf->Rect($x, $y, $w, $h, 'F', array(), array(255,255,255));
//$pdfRefer = 'https://www.venitaclinic.com/Qweb/site1_Wiztech/WiztechPartner/';
$pdf->Image('images/'.$_POST['PtFullName'].date("Y-m-d").'.png', 60, 80, '', '', 'PNG', pdfRefer, '', true, 150, '', false, false, 1, false, false, false);
//$html = '<img src="images/'.$_POST['PtFullName'].date("Y-m-d").'.png" style="left:100px;">';
//$pdf->writeHTML($html, true, false, true, false, '');

$pdf->SetAlpha(0.5);
$alertSystem = '<br>ALSO PAY ATTENTION ON<hr>';

unset($_POST['PtFullName']);

foreach($_POST as $key=>$value ){
	switch($key){
		case 'BloodQuality':

			break;
		case 'Heart':
				if($value != ''){
					$pdf->Image('images/Heart.png', 100, 130, '', '', 'PNG', '', '', true, 150, '', false, false, 1, false, false, false);
				}
				else{
					$pdf->Image('images/HeartCLEAR.png', 100, 130, '', '', 'PNG', '', '', true, 150, '', false, false, 1, false, false, false);
				}
			break;
		case 'Lung':
				if($value != ''){
					$pdf->Image('images/Lung.png', 93, 120, '', '', 'PNG', '', '', true, 150, '', false, false, 1, false, false, false);
				}
				else{
					$pdf->Image('images/LungCLEAR.png', 93, 120, '', '', 'PNG', '', '', true, 150, '', false, false, 1, false, false, false);
				}
			break;
		case 'Brain':
				if($value != ''){
					$pdf->Image('images/Brain.png', 99, 83, '', '', 'PNG', '', '', true, 150, '', false, false, 1, false, false, false);
				}
				else{
					$pdf->Image('images/BrainCLEAR.png', 99, 83, '', '', 'PNG', '', '', true, 150, '', false, false, 1, false, false, false);
				}
			break;
		case 'GI':
				if($value != ''){
					$pdf->Image('images/Stomach.png', 98, 144, '', '', 'PNG', '', '', true, 150, '', false, false, 1, false, false, false);
					$pdf->Image('images/GI.png', 95, 170, '', '', 'PNG', '', '', true, 150, '', false, false, 1, false, false, false);
				}
				else{
					$pdf->Image('images/StomachCLEAR.png', 98, 144, '', '', 'PNG', '', '', true, 150, '', false, false, 1, false, false, false);
					$pdf->Image('images/GICLEAR.png', 95, 170, '', '', 'PNG', '', '', true, 150, '', false, false, 1, false, false, false);
				}
			break;
		case 'Kidney':
				if($value != ''){
					$pdf->Image('images/KidneyLt.png', 113, 172, '', '', 'PNG', '', '', true, 150, '', false, false, 1, false, false, false);
					$pdf->Image('images/KidneyRt.png', 95, 170, '', '', 'PNG', '', '', true, 150, '', false, false, 1, false, false, false);
				}
				else{
					$pdf->Image('images/KidneyLtCLEAR.png', 113, 172, '', '', 'PNG', '', '', true, 150, '', false, false, 1, false, false, false);
					$pdf->Image('images/KidneyRtCLEAR.png', 93, 172, '', '', 'PNG', '', '', true, 150, '', false, false, 1, false, false, false);
				}
			break;
		case 'Liver':
				if($value != ''){
					$pdf->Image('images/Liver.png', 95, 149, '', '', 'PNG', '', '', true, 150, '', false, false, 1, false, false, false);
				}
				else{
					$pdf->Image('images/LiverCLEAR.png', 95, 149, '', '', 'PNG', '', '', true, 150, '', false, false, 1, false, false, false);

				}
			break;
		default:
			if($value != ''){
				$alertSystem .= str_replace("_"," ",$key).'<br>';
			}
			break;
	}
}

$pdf->SetAlpha(1);

$pdf->SetFont('freeserif', '', 16);
//$pdf->Cell(30, 0, 'Bottom-Bottom', 1, $ln=0, 'C', 0, '', 0, false, 'B', 'B');
$pdf->SetXY(100, 100);
$pdf->writeHTML($alertSystem, true, false, true, false, '');
//$pdf->Write(20, $alertSystem, '', 0, 'L', true, 0, false, false, 0);

$systemIcon = array(
	'Blood_Quality'=>array('BloodICON.png', 'BLOOD QUALIY ANALYSIS'),
	'Heart'=>array('HeartICON.png', 'HEART EVALUATION & ANALYSIS'),
	'Lung'=>array('LungICON.png','LUNG EVALUATION & ANALYSIS'),
	'Brain'=>array('BrainICON.png', 'BRAIN EVALUATION & ANALYSIS'),
	'Tumor_Marker' => array('tumorIcon.png','TUMOR MARKER ANALYSIS'),
	'Immunity_Profile' => array('immuneIcon.png', 'IMMUNITY STATUS'),
	'Ultrasound_and_Imaging' => array('medImageIcon.png','ULTRASOUND & MEDICAL IMAGING REMARKS'),
	'GI' => array('GIicon.png','GI & MICROBIOME REMARKS'),
	'Hematology' => array('hematoIcon.png','HEMATOLOGY REMARKS'),
	'Kidney' => array('kidneyIcon.png','KIDNEY & URINALAYSIS REMARKS'),
	'Lipid' => array('lipidIcon.png', 'LIPID METABOLISM PROFILE'),
	'Sugar_Metabolism' => array('sugarMetIcon.png', 'SUGAR METABOLISM'),
	'Thyroid_Hormone' => array('thyroidHormIcon.png', 'THYROID HORMONE EVALUATION'),
	'Sex_Hormone' => array('sexIcon.png','SEX HORMONE EVALUATION'),
	'Trace_Element' => array('tElemIcon.png', 'TRACE ELEMENTS & MICRO NUTRIENT'),
	'Vitamin_Level' => array('vitLevelIcon.png','VITAMIN EVALUTAION'),
	'Vascular_System' => array('vascularIcon.png','VASCULAR HEALTH EVALUATION'),
	'Toxicity_Test' => array('toxicIcon.png','TOXICITY PROFILE'),
	'Genetic_Screening' => array('GeneIcon.png','GENETIC PROFILE & COUNCELING'),
	'Liver' => array('LiverIcon.png','LIVER EVALUATION & ANALYSIS'),
	'ETC'=> array('ETC.png', 'OTHER REMARKS FROM DOCTORS')
);

foreach($_POST as $key=>$value ){
	if($value != ''){
		// remove default header
		$pdf->setPrintHeader(false);

		



		// -- set new background ---

		// get the current page break margin
		$bMargin = $pdf->getBreakMargin();
		// get current auto-page-break mode
		$auto_page_break = $pdf->getAutoPageBreak();
		// disable auto-page-break
		$pdf->SetAutoPageBreak(false, 0);
		// set bacground image
		$img_file = '';
		$pdf->Image($img_file, 0, 0, 210, 297, '', '', '', false, 300, '', false, false, 0);
		// restore auto-page-break status
		$pdf->SetAutoPageBreak($auto_page_break, $bMargin);
		// set the starting point for the page content
		$pdf->setPageMark();

		// add a page
		$pdf->AddPage();

		
		$pdf->Image('images/JinWellnessBanner.png', 20, 10, '', '', 'PNG', '', '', true, 150, '', false, false, 1, false, false, false);


		if(isset($systemIcon[$key])){
			$pdf->Image('images/'.$systemIcon[$key][0], 20, 40, '', '', 'PNG', '', '', true, 150, '', false, false, 1, false, false, false);
		}
		$pdf->SetFont('freeserif', '', 16);
		$pdf->SetXY(50, 40);
		//$pdf->Write(20, $value.' '.'images/'.$systemIcon[$key], '', 0, 'L', true, 0, false, false, 0);
		$pdf->Write(20, $systemIcon[$key][1], '', 0, 'L', true, 0, false, false, 0);

		$pdf->SetXY(20, 70);
		$pdf->writeHTML($value, true, false, true, false, '');
		// Create a blank image and add some text


		/* $im = imagecreatetruecolor(120, 20);
		$text_color = imagecolorallocate($im, 233, 14, 91);
		imagestring($im, 1, 5, 5,  'A Simple Text String', $text_color);



		// Save the image as 'simpletext.jpg'
		imagejpeg($im, 'images/'.$_POST['PtFullName'].date("Y-m-d").'.jpg'); */




		// Free up memory
		//imagedestroy($im);
	}
}

unset($_POST['PtFullName']);
// Print a text
//$html = '<span style="color:white;text-align:center;font-weight:bold;font-size:80pt;">PAGE 3</span>';
//$pdf->writeHTML($html, true, false, true, false, '');

// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('REPORT of '.$fullName.' '.date('Y-m-d').'.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+

function LoadJpeg($imgname)
{
    /* Attempt to open */
    $im = @imagecreatefromjpeg($imgname);

    /* See if it failed */
    if(!$im)
    {
        /* Create a black image */
        $im  = imagecreatetruecolor(150, 30);
        $bgc = imagecolorallocate($im, 255, 255, 255);
        $tc  = imagecolorallocate($im, 0, 0, 0);

        imagefilledrectangle($im, 0, 0, 150, 30, $bgc);

        /* Output an error message */
        imagestring($im, 1, 5, 5, 'Error loading ' . $imgname, $tc);
    }

    return $im;
}

function LoadPNG($imgname)
{
    /* Attempt to open */
    $im = @imagecreatefrompng($imgname);

    /* See if it failed */
    if(!$im)
    {
        /* Create a blank image */
        $im  = imagecreatetruecolor(150, 30);
        $bgc = imagecolorallocate($im, 255, 255, 255);
        $tc  = imagecolorallocate($im, 0, 0, 0);

        imagefilledrectangle($im, 0, 0, 150, 30, $bgc);

        /* Output an error message */
        imagestring($im, 1, 5, 5, 'Error loading ' . $imgname, $tc);
    }

    return $im;
}