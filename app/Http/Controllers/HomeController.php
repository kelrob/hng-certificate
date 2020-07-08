<?php

namespace App\Http\Controllers;

use App\Certificate;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $certificates = Certificate::all();
        return view('home', compact('certificates'));
    }

    public function changeDownloadStatus($id, $status) {
        $certificate = Certificate::find($id);

        $response = '';
        if ($status == 'block') {
            $certificate->blocked = 1;
            $response = 'Downloads blocked for this certificate';
        } else if ($status == 'allow'){
            $certificate->blocked = 0;
            $response = 'Downloads allowed for this certificate';
        }

        $certificate->save();
        return $response;
    }
}
