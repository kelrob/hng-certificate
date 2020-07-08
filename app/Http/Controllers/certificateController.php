<?php

namespace App\Http\Controllers;

use App\Certificate;
use Illuminate\Http\Request;
use Keygen;
use Validator;
class certificateController extends Controller
{
    //
    public function logRequest(Request $request)
    {

        $validator = Validator::make($request->all(),
            [
                'certificate_style' => 'required',
                'email' => 'required|email',
                'owner' => 'required',
                'track' => 'required',
            ]);
        if ($validator->fails()) {
            return redirect()->back()->with('error','filling required info');
        }else {
            $check_email = Certificate::where(['email' => $request->input('email')])->first();
            if ($check_email) {
                $certificate_id = $check_email['id'];
                if($request->input('send_email')){
                    $send_to_mail = $request->input('send_email');
                }else{
                    $send_to_mail = null;
                }
                Certificate::query()->where('id',$certificate_id)->update(['owner'=>$request->input('owner'),'track'=>$request->input('track'),'certificate_style'=>$request->input('certificate_style'),'send_mail'=>$send_to_mail]);
                return redirect()->action(
                    'PDFgenerator@generate', ['id' => $certificate_id]
                );
            } else {
                $input = $request->input();
                $send_to_mail = $input['send_to_mail'];
                unset($input['send_to_mail']);
                $input['unique_code'] = $this->generateID();
                $certificate = Certificate::create($input);
            }
        }
    }

    public function generateUniqueKey(){
        $id = $this->generateID();
        // Ensure ID does not exist
        // Generate new one if ID already exists
        while (Certificate::whereUnique_code($id)->count() > 0) {
            $id = $this->generateID();
        }

        return $id;
    }
    public function generateID()
    {
        return Keygen::numeric(7)->prefix(mt_rand(1, 9))->generate(true);
    }
}
