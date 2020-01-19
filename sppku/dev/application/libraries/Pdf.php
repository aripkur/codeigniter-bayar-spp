<?php

include_once APPPATH . '/third_party/TCPDF-master/tcpdf.php';
class Pdf extends TCPDF {
    function __construct()
    {
        parent::__construct();
    }
    public function Header() {
        // Logo
        $image_file = K_PATH_IMAGES.'logo.jpg';
        $this->Image($image_file, 10, 5, 40, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        $this->SetFont('times', 'B', 20);
        $this->Write(15, 'SMP N 1 CAWAS', '', 0, 'C', true, 0, false, false, 0);

        $this->SetFont('times', 'I', 12);
        $this->Write(2, 'Dk. Barepan, Kel. Barepan, Kec. Cawas, Kab. Klaten, 57463 ', '', 0, 'C', true, 0, false, false, 0);
        $this->Write(0, 'Telp. 0221000 | email. smp1cawas@gmail.com', '', 0, 'C', true, 0, false, false, 0);
        
        $this->writeHTML('<hr>');
        $this->SetHeaderMargin(PDF_MARGIN_HEADER);
    }
}