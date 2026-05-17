<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
 * CodeIgniter DomPDF Library
 *
 * Generate PDF's from HTML in CodeIgniter
 *
 * @packge        CodeIgniter
 * @subpackage        Libraries
 * @category        Libraries
 * @author        Ardianta Pargo
 * @license        MIT License
 * @link        https://github.com/ardianta/codeigniter-dompdf
 */

use Dompdf\Dompdf;
use Dompdf\Options;

class Pdf extends Dompdf
{
    /**
     * PDF filename
     * @var String
     */
    // public $filename;

    /**
     * Get an instance of CodeIgniter
     *
     * @access    protected
     * @return    void
     */
    protected function ci()
    {
        return get_instance();
    }
    /**
     * Load a CodeIgniter view into domPDF
     *
     * @access    public
     * @param    string    $view The view to load
     * @param    array    $data The view data
     * @return    void
     */
    public function load_view($filename, $size, $paper, $view, $data = array())
    {
        $options = new Options();

        $options->set('isRemoteEnabled', true);
        $options->setIsRemoteEnabled(true);

        // $options->setChroot(__DIR__ . './assets/images/');
        $dompdf = new Dompdf($options);
        // $dompdf->setBasePath('./assets/images/');
        $options->set('defaultFont', 'Courier');
        // $dompdf->setChroot(FCPATH);
        // $dompdf->setDefaultFont('courier');
        $ci = get_instance();
        $html = $ci->load->view($view, $data, TRUE);
        // $html = ob_get_contents($html);
        $dompdf->loadhtml($html);
        // $dompdf->loadhtml($html);
        $dompdf->setPaper($size, $paper);
        // $dompdf->filename('asdkaj');
        // Render the PDF
        $dompdf->render();
        ob_get_clean();
        // Output the generated PDF to Browser
        $dompdf->stream($filename, array("Attachment" => false));
    }
}
