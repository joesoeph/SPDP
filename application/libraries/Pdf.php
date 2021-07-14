<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require('fpdf.php');
class Pdf extends FPDF{

  function __construct($orientation='L', $unit='mm', $size='A4')
  {
      parent::__construct($orientation,$unit,$size);
  }
  function Footer()
  {
      // Go to 1.5 cm from bottom
      $this->SetY(15.5);
      // Select Arial italic 8
      $this->SetFont('Arial','I',8);
      // Print centered page number
      //$this->Cell(0,10,'Halaman '.$this->PageNo(),0,0,'C');

  }
}
