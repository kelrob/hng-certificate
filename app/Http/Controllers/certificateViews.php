<?php

namespace App\Http\Controllers;

use App\Certificate;
use Illuminate\Http\Request;

class certificateViews extends Controller
{
    //
    public function index($uniqueKey)
    {
        $certificate_details = Certificate::whereUnique_code($uniqueKey)->first();
        return view('certificates.cert1',compact('certificate_details'));
//        switch ($certificate_details['certificate_style']){

    }
}
