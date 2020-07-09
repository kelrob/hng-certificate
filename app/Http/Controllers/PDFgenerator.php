<?php

namespace App\Http\Controllers;

use App\Certificate;
use Illuminate\Http\Request;
use PDF2;
use PDF;
use PDF3;

class PDFgenerator extends Controller
{
    //
    public function generate($id){
        $certificate = Certificate::whereId($id)->first();
        $certificate_route = route('certView',['unique_key' => $certificate['unique_code']]);
        $storage_name = storage_path().'/pdfs/'.$certificate['unique_code'].'.pdf';
        $command = 'wkhtmltopdf -s Folio -O landscape -T 5mm -B 5mm -R 5mm -L 5mm --disable-smart-shrinking  '. $certificate_route.'  '.$storage_name;

        $test = shell_exec($command);

        return 'Done';
        //return $pdf = PDF3::loadView('Cert2.index')->download('test.pdf');
//        dd($pdf);
        // If you want to store the generated pdf to the server then you can use the store function
//        $pdf->save(storage_path().'_filename.pdf');
        // Finally, you can download the file using download function
        //return $pdf->download('customers.pdf');
    }


}
