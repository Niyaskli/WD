<?php

	require('fpdf.php');
	//require('extern/pdf/makefont/makefont.php');  			//font editing
class Pdfcreator extends FPDF
	{			
	var $B;
	var $I;
	var $U;
	var $HREF;
		private $registry;
		public function __construct(){
			
				
				//$this->FPDF($orientation,$unit,$size);
				// Initialization
				$this->B = 0;
				$this->I = 0;
				$this->U = 0;
				$this->HREF = '';
				
			}
			// Page header
			public function Header()
			{
				// Logo
			   //$this->Image('C:\Documents and Settings\shifu\Desktop/logo.png',6,6,30);
				// Arial bold 15
				$this->SetFont('Arial','B',15);
				// Move to the right
				$this->Cell(80);
				// Title
				$this->Cell(50,10,'STR SCREEN',1,0,'C');
				// Line break
				$this->Ln(20);
			}

					// Page footer
					public function Footer()
					{
						// Position at 1.5 cm from bottom
						$this->SetY(-15);
						// Arial italic 8
						$this->SetFont('Arial','I',8);
						// Page number
						$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
					}

					public function ChapterTitle($num, $label)
					{
						// Arial 12
						$this->SetFont('Arial','',14);
						// Background color
						$this->SetFillColor(200,220,255);
						// Title
						
						$this->Cell(0,8," $label",0,1,'L',true);
						// Line break
						$this->Ln();
					}



					public function PrintChapter($num, $title)
					{
					   // $this->AddPage();
						$this->ChapterTitle($num,$title);
					   
					}

					// Better table
					public function ImprovedTable($data, $head)
					{
						// Column widths
						$w = array(70, 120);
					  
						$this->Ln();
						$this->PrintChapter(1,$head);
						// Data
						foreach($data as $row => $key)
						{
							
										$this->SetFont('Arial','B',11);
										$this->SetDrawColor(100,120,120);
										$this->Cell($w[0],10,$row,1,0,'L');
										$this->Cell($w[1],10,$key,1,0,'d');
										 $this->Ln();
							   
							
						}
					 $this->Ln();

						// Closing line
						$this->Cell(array_sum($w),0,'','T');
						
					}
					// Better table
					public function personTable($data, $head)
					{
						// Column widths
						$w = array(70, 120);
					  
						$this->Ln();
						$this->PrintChapter(1,$head);
						// Data
						foreach($data as $row1 => $key1)
						{		$person  ="";
										$this->SetFont('Arial','B',11);
										$this->SetDrawColor(100,120,120);
										$this->Cell($w[0],10,$row1,1,0,'L');
									foreach($key1 as $row => $key)
						{
											$person .= 	ucfirst($key).",   ";				
										
								}
								$this->Cell($w[1],10,$person,1,0,'d');
										 $this->Ln();
							   
							
						}
					 $this->Ln();

						// Closing line
						$this->Cell(array_sum($w),0,'','T');
						
					}
			public function attachemntView($data, $head)
			{
				// Column widths
				$w = array(70, 120);
			  
				$this->Ln();
				$this->PrintChapter(1,$head);
				// Data
				if(empty($data))
				{
								$this->SetFont('Arial','B',11);
								$this->SetDrawColor(255,255,255);
								$this->WriteHTML("no attachemntView");
								$this->Ln();
				}else{
				foreach($data as $row => $key)
				{
					
								$html= "<a href='".$key[0]."' target ='_blank'>Attachment</a>";
								
								$this->SetFont('Arial','B',11);
								$this->SetDrawColor(255,255,255);
								$this->WriteHTML($html);
								//$this->Cell($w[0],10,$this->WriteHTML($html),1,0,'L');
								
							
								 $this->Ln();
					   
					
				}
				}
			 $this->Ln();

				// Closing line
				$this->Cell(array_sum($w),0,'','T');
				
			}
			
			function WriteHTML($html)
{
    // HTML parser
    $html = str_replace("\n",' ',$html);
    $a = preg_split('/<(.*)>/U',$html,-1,PREG_SPLIT_DELIM_CAPTURE);
    foreach($a as $i=>$e)
    {
        if($i%2==0)
        {
            // Text
            if($this->HREF)
                $this->PutLink($this->HREF,$e);
            else
                $this->Write(5,$e);
        }
        else
        {
            // Tag
            if($e[0]=='/')
                $this->CloseTag(strtoupper(substr($e,1)));
            else
            {
                // Extract attributes
                $a2 = explode(' ',$e);
                $tag = strtoupper(array_shift($a2));
                $attr = array();
                foreach($a2 as $v)
                {
                    if(preg_match('/([^=]*)=["\']?([^"\']*)/',$v,$a3))
                        $attr[strtoupper($a3[1])] = $a3[2];
                }
                $this->OpenTag($tag,$attr);
            }
        }
    }
}


function OpenTag($tag, $attr)
{
    // Opening tag
    if($tag=='B' || $tag=='I' || $tag=='U')
        $this->SetStyle($tag,true);
    if($tag=='A')
        $this->HREF = $attr['HREF'];
    if($tag=='BR')
        $this->Ln(5);
}

function CloseTag($tag)
{
    // Closing tag
    if($tag=='B' || $tag=='I' || $tag=='U')
        $this->SetStyle($tag,false);
    if($tag=='A')
        $this->HREF = '';
}
function PutLink($URL, $txt)
{
    // Put a hyperlink
    $this->SetTextColor(0,0,255);
    $this->SetStyle('U',true);
    $this->Write(5,$txt,$URL);
    $this->SetStyle('U',false);
    $this->SetTextColor(0);
}
function SetStyle($tag, $enable)
{
    // Modify style and select corresponding font
    $this->$tag += ($enable ? 1 : -1);
    $style = '';
    foreach(array('B', 'I', 'U') as $s)
    {
        if($this->$s>0)
            $style .= $s;
    }
    $this->SetFont('',$style);
}

}



	
	

?>
