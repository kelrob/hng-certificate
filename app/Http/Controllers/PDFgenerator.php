<?php

namespace App\Http\Controllers;

use App\Certificate;
use Illuminate\Http\Request;
use PDF2;

class PDFgenerator extends Controller
{
    //
    public function generate($id){
//        $certificate = Certificate::with('id',$id)->first();
        $pdf = PDF2::loadView('certificates.cert1');
        // If you want to store the generated pdf to the server then you can use the store function
        $pdf->save(storage_path().'_filename.pdf');
        // Finally, you can download the file using download function
        return $pdf->download('customers.pdf');
    }


}
