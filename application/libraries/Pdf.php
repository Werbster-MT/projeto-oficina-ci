<?php
use Dompdf\Dompdf;

class Pdf {
    private $dompdf;

    public function __construct() {
        // Use o autoload do Composer
        require_once APPPATH . '../vendor/autoload.php';
        $this->dompdf = new Dompdf();
    }

    public function loadHtml($html) {
        $this->dompdf->loadHtml($html);
    }

    public function setPaper($size, $orientation) {
        $this->dompdf->setPaper($size, $orientation);
    }

    public function render() {
        $this->dompdf->render();
    }

    public function stream($filename, $options = array()) {
        $this->dompdf->stream($filename, $options);
    }
}
?>