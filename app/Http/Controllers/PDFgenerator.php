<?php

namespace App\Http\Controllers;

use App\Certificate;
use Illuminate\Http\Request;
use PDF;

class PDFgenerator extends Controller
{
    //
    public function generate($cert_id)
    {
        $cert_details = Certificate::where('unique_code', $cert_id)->first();
        $cert_style = $cert_details->certificate_style;
        $cert_id = $cert_details->unique_code;

        switch ($cert_style) {
            case 1:
                $template = 'certificates.cert1';
                break;

            case 2:
                $template = 'certificates.cert2';
                break;

            case 3:
                $template = 'certificates.cert3';
                break;

            case 4:
                $template = 'certificates.cert4';
                break;

            case 1:
                $template = 'certificates.cert5';
                break;
        }
        $filename = $cert_id . '.pdf';

        $pdf = PDF::loadView($template, [
            'owner' => $cert_details['owner'],
            'track' => $cert_details['track'],
            'cert_id' => $cert_details['unique_code'],
            'date_created' => $cert_details['date_created'],
        ]);

/*         $pdf->setOptions([
            'orientation' => 'landscape'
        ]);
 */        return $pdf->stream($filename);
    }
}
