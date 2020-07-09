<?php

namespace App\Http\Controllers;

use App\Certificate;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Keygen;
use Keygen\Keygen as GenKey;
use Validator;
use App\Notifications\SendDownloadLink as Sendlink;

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
            return redirect()->back()->with('error', 'filling required info');
        } else {
            $check_email = Certificate::where(['email' => $request->input('email')])->first();

            if ($check_email) {
                $certificate_id = $check_email['id'];
                $downloadCounter = $check_email['download_count'];
                if ($request->input('send_email') !== "" ) {
                    $send_to_mail = $request->input('send_email');
                    $check_email->notify(new Sendlink("download-link/$request->email", $request->owner));
                } else {
                    $send_to_mail = null;
                }

                Certificate::query()->where('id', $certificate_id)->update(['owner' => $request->input('owner'), 'track' => $request->input('track'), 'certificate_style' => $request->input('certificate_style'), 'send_mail' => $send_to_mail, 'download_count' => $downloadCounter + 1]);

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

    public function saveCertificate(Request $request)
    {

        $date = date('l, M d, Y');
        $validator = Validator::make($request->all(), [
            'certificate_style' => 'required',
            'email' => 'required|email',
            'owner' => 'required',
            'track' => 'required',
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withErrors(['All fields are required', 'The Message']);
        } else {
            $certificate = new Certificate();

            $certificate->owner = $request->owner;
            $certificate->email = $request->email;
            $certificate->track = $request->track;
            $certificate->certificate_style = $request->certificate_style;
            $certificate->unique_code = $this->generateID();
            $code = $certificate->unique_code;
            $url = route('verify',['code'=>$code]);
            $countEmail = Certificate::where('email', $request->email)->count();

            if ($countEmail > 0) {
                return Redirect::back()->withErrors(['You have already downloaded your certificate', 'The Message']);
            } else {
                if ($certificate->save()) {
                  if ($request->input('send_email') !== "" ) {
                    //send link
                    $certificate->notify(new Sendlink("download-link/$request->email", $request->owner));
                  }
                    $certificateStyle1 = "<!DOCTYPE html>
<html lang=\"en\">

    <head>
        <meta charset=\"UTF-8\">
        <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
        <link rel = \"shortcut icon\" href= \"https://res.cloudinary.com/dafsch2zs/image/upload/v1594246923/Favicon_uwanbc.png\">
        <link href=\"https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,600;0,700;0,800;1,300;1,400;1,600;1,700;1,800&display=swap\" rel=\"stylesheet\">
        <link href=\"https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600&display=swap\" rel=\"stylesheet\">
        <link href=\"https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;600&display=swap\" rel=\"stylesheet\">
        <!-- <link rel=\"stylesheet\" href=\"index.css\"> -->
        <title>HNG | CERTIFICATE</title>


        <style>
            @font-face {
  font-family: 'Windsong';
  src: url(\"https://res.cloudinary.com/dafsch2zs/raw/upload/v1594246379/Windsong_g2ci9z.ttf\");
}

* {
  margin: 0;
  padding: 0;
}

body {
  background-color: #dedede;
}

.certificate-wrapper {
  width: 1152px;
  min-height: 100vh;
  height: 100%;
  margin: auto;
  display: -webkit-box;
  display: -ms-flexbox;
  display: flex;
}

.certificate-wrapper aside {
  background-image: url(\"https://res.cloudinary.com/dafsch2zs/image/upload/v1594246923/Group_11_j9fp5t.png\");
  width: 374px;
}

.certificate-wrapper aside div {
  padding-top: 44px;
  display: -webkit-box;
  display: -ms-flexbox;
  display: flex;
  -webkit-box-pack: center;
      -ms-flex-pack: center;
          justify-content: center;
  -webkit-box-align: center;
      -ms-flex-align: center;
          align-items: center;
}

.certificate-wrapper aside div h2 {
  font-family: 'Manrope', sans-serif;
  font-weight: 600;
  font-size: 1.875rem;
  line-height: 41px;
  color: white;
  margin-left: 15px;
}

.certificate-wrapper main {
  background-color: #ffffff;
  overflow: hidden;
}

.certificate-wrapper main .certificate {
  padding: 44px 80px 10px;
}

.certificate-wrapper main .certificate .user-wrapper {
  font-family: Manrope;
}

.certificate-wrapper main .certificate .user-wrapper h4 {
  font-weight: normal;
  font-size: 1.563rem;
  line-height: 34px;
}

.certificate-wrapper main .certificate .user-wrapper .name {
  font-family: Playfair Display;
  font-weight: normal;
  font-size: 5rem;
  line-height: 107px;
  margin-bottom: 15px;
}

.certificate-wrapper main .certificate .user-wrapper p {
  font-weight: normal;
  font-size: 1.38rem;
  line-height: 30px;
  margin-bottom: 20px;
}

.certificate-wrapper main .certificate .user-wrapper .track {
  font-weight: normal;
  font-size: 2.94rem;
  line-height: 64px;
}

.certificate-wrapper main .ceo-wrapper {
  margin-top: 95px;
  font-family: Manrope;
}

.certificate-wrapper main .ceo-wrapper .signature {
  font-family: \"Windsong\", sans-serif;
  font-weight: normal;
  font-size: 4.4rem;
  line-height: 50px;
  color: #170C0C;
  margin: 0;
}

.certificate-wrapper main .ceo-wrapper h4 {
  font-size: 1.56rem;
  font-weight: normal;
  line-height: 34px;
  margin-bottom: 30px;
}

.certificate-wrapper main .ceo-wrapper p {
  font-size: 1.063rem;
  font-weight: normal;
  line-height: 23px;
  margin-bottom: 6px;
}
/*# sourceMappingURL=index.css.map */
        </style>
    </head>
    <body>
        <section class=\"certificate-wrapper\">
            <aside>
                <div>
                    <img src=\"https://res.cloudinary.com/dafsch2zs/image/upload/v1594246923/logo_wscqqj.png\" />
                    <h2>HNG Internship</h2>
                </div>
            </aside>

            <main>
                <div class=\"certificate\">
                    <div class=\"user-wrapper\">
                        <h4>This is to certify that</h4>
                        <h2 class=\"name\">$certificate->owner</h2>
                        <p>has successfully completed HNGi 7.0 as a </p>
                        <h2 class=\"track\">$certificate->track</h2>
                    </div>

                    <div class=\"ceo-wrapper\">
                        <p class=\"signature\">Seyi Onifade</p>
                        <h4>Seyi Onifade - CEO, HNG Internship</h4>
                        <p>HNG Internship has confirmed the participation of this Individual in this program</p>
                        <p>Confirm at: {$url}</p>
                        <p>Certificate Issued on: $date</p>
                    </div>
                </div>
            </main>
        </section>
    </body>
</html>";

                    $certificateStyle2 = "<!DOCTYPE html>
<html lang=\"en\">

<head>
  <meta charset=\"UTF-8\">
  <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
  <link rel=\"shortcut icon\" href=\"https://res.cloudinary.com/dafsch2zs/image/upload/v1594246923/Favicon_uwanbc.png\">
  <link
    href=\"https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,600;0,700;0,800;1,300;1,400;1,600;1,700;1,800&display=swap\"
    rel=\"stylesheet\">
  <link href=\"https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600&display=swap\" rel=\"stylesheet\">
  <link href=\"https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;600&display=swap\" rel=\"stylesheet\">
  <title>HNG | CERTIFICATE</title>


  <style>
    @font-face {
      font-family: 'Windsong';
      src: url(\"https://res.cloudinary.com/dafsch2zs/raw/upload/v1594246379/Windsong_g2ci9z.ttf\");
    }

    * {
      margin: 0;
      padding: 0;
    }

    body {
      background-color: #dedede;
    }

    .certificate-wrapper {
      width: 1152px;
      min-height: 100vh;
      height: 100%;
      margin: auto;
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
    }

    .certificate-wrapper aside {
      background-image: url(\"https://res.cloudinary.com/dafsch2zs/image/upload/v1594247194/bg-image_grhjdr.png\");
      width: 374px;
    }

    .certificate-wrapper aside div {
      padding-top: 44px;
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      -webkit-box-pack: center;
      -ms-flex-pack: center;
      justify-content: center;
      -webkit-box-align: center;
      -ms-flex-align: center;
      align-items: center;
    }

    .certificate-wrapper aside div h2 {
      font-family: 'Manrope', sans-serif;
      font-weight: 600;
      font-size: 1.875rem;
      line-height: 41px;
      color: white;
      margin-left: 15px;
    }

    .certificate-wrapper main {
      background-color: #ffffff;
      overflow: hidden;
    }

    .certificate-wrapper main .certificate {
      padding: 44px 80px 10px;
    }

    .certificate-wrapper main .certificate .user-wrapper {
      font-family: Manrope;
    }

    .certificate-wrapper main .certificate .user-wrapper h4 {
      font-weight: normal;
      font-size: 1.563rem;
      line-height: 34px;
    }

    .certificate-wrapper main .certificate .user-wrapper .name {
      font-family: Playfair Display;
      font-weight: normal;
      font-size: 5rem;
      line-height: 107px;
      margin-bottom: 15px;
    }

    .certificate-wrapper main .certificate .user-wrapper p {
      font-weight: normal;
      font-size: 1.38rem;
      line-height: 30px;
      margin-bottom: 20px;
    }

    .certificate-wrapper main .certificate .user-wrapper .track {
      font-weight: normal;
      font-size: 2.94rem;
      line-height: 64px;
    }

    .certificate-wrapper main .ceo-wrapper {
      margin-top: 95px;
      font-family: Manrope;
    }

    .certificate-wrapper main .ceo-wrapper .signature {
      font-family: \"Windsong\", sans-serif;
      font-weight: normal;
      font-size: 4.4rem;
      line-height: 50px;
      color: #170C0C;
      margin: 0;
    }

    .certificate-wrapper main .ceo-wrapper h4 {
      font-size: 1.56rem;
      font-weight: normal;
      line-height: 34px;
      margin-bottom: 30px;
    }

    .certificate-wrapper main .ceo-wrapper p {
      font-size: 1.063rem;
      font-weight: normal;
      line-height: 23px;
      margin-bottom: 6px;
    }

  </style>
</head>

<body>
  <section class=\"certificate-wrapper\">
    <aside>
      <div>
        <img src=\"https://res.cloudinary.com/dafsch2zs/image/upload/v1594246923/logo_wscqqj.png\" />
        <h2>HNG Internship</h2>
      </div>
    </aside>

    <main>
      <div class=\"certificate\">
        <div class=\"user-wrapper\">
          <h4>This is to certify that</h4>
          <h2 class=\"name\">$certificate->owner</h2>
          <p>has successfully completed HNGi 7.0 as a </p>
          <h2 class=\"track\">$certificate->track</h2>
        </div>

        <div class=\"ceo-wrapper\">
          <p class=\"signature\">Seyi Onifade</p>
          <h4>Seyi Onifade - CEO, HNG Internship</h4>
          <p>HNG Internship has confirmed the participation of this Individual in this program</p>
          <p>Confirm at: {$url}</p>
          <p>Certificate Issued on: $date</p>
        </div>
      </div>
    </main>
  </section>
</body>

</html>";

                    $certificateStyle3 = "<!DOCTYPE html>
<html lang=\"en\">
    <head>
        <meta charset=\"UTF-8\">
        <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
        <link rel = \"shortcut icon\" href= \"https://res.cloudinary.com/dafsch2zs/image/upload/v1594246923/Favicon_uwanbc.png\">
        <link href=\"https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,600;0,700;0,800;1,300;1,400;1,600;1,700;1,800&display=swap\" rel=\"stylesheet\">
        <link href=\"https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600&display=swap\" rel=\"stylesheet\">
        <link href=\"https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;600&display=swap\" rel=\"stylesheet\">
        <!-- <link rel=\"stylesheet\" href=\"index.css\"> -->
        <title>HNG | CERTIFICATE</title>

        <style>
            @font-face {
  font-family: 'Windsong';
  src: url(\"https://res.cloudinary.com/dafsch2zs/raw/upload/v1594246379/Windsong_g2ci9z.ttf\");
}

* {
  margin: 0;
  padding: 0;
  -webkit-box-sizing: border-box;
          box-sizing: border-box;
}

body {
  background-color: #dedede;
}

section {
  width: 1152px;
  min-height: 100vh;
  height: 100%;
  margin: auto;
  background-image: url(\"https://res.cloudinary.com/dafsch2zs/image/upload/v1594247461/Certificate_3_1_orqrfs.png\");
  background-size: contain;
  background-position: center center;
  background-repeat: no-repeat;
  display: -webkit-box;
  display: -ms-flexbox;
  display: flex;
  -webkit-box-align: center;
      -ms-flex-align: center;
          align-items: center;
  -webkit-box-pack: center;
      -ms-flex-pack: center;
          justify-content: center;
}

section main .certificate,
section main .ceo-wrapper {
  display: -webkit-box;
  display: -ms-flexbox;
  display: flex;
  -webkit-box-orient: vertical;
  -webkit-box-direction: normal;
      -ms-flex-direction: column;
          flex-direction: column;
  -webkit-box-align: center;
      -ms-flex-align: center;
          align-items: center;
  -webkit-box-pack: center;
      -ms-flex-pack: center;
          justify-content: center;
  text-align: center;
}

section main .certificate .user-wrapper {
  font-family: Manrope;
}

section main .certificate .user-wrapper h4 {
  font-weight: normal;
  font-size: 1.563rem;
  line-height: 24px;
}

section main .certificate .user-wrapper .name {
  font-family: Playfair Display;
  font-weight: normal;
  font-size: 5rem;
  line-height: 107px;
  margin-bottom: 15px;
}

section main .certificate .user-wrapper p {
  font-weight: normal;
  font-size: 1.38rem;
  line-height: 30px;
  margin-bottom: 20px;
}

section main .certificate .user-wrapper .track {
  font-weight: normal;
  font-size: 2.94rem;
  line-height: 44px;
}

section main .ceo-wrapper {
  margin-top: 90px;
  font-family: Manrope;
}

section main .ceo-wrapper .signature {
  font-family: \"Windsong\", sans-serif;
  font-weight: normal;
  font-size: 4.4rem;
  line-height: 50px;
  color: #170C0C;
  margin: 0;
}

section main .ceo-wrapper h4 {
  font-size: 1.56rem;
  font-weight: normal;
  line-height: 34px;
  margin-bottom: 30px;
}

section main .ceo-wrapper p {
  font-size: 1.063rem;
  font-weight: normal;
  line-height: 23px;
  margin-bottom: 6px;
}
/*# sourceMappingURL=index.css.map */
        </style>
    </head>
    <body>
        <section>
            <main>
                <div class=\"certificate\">
                    <div class=\"user-wrapper\">
                        <h4>This is to certify that</h4>
                        <h2 class=\"name\">$certificate->owner</h2>
                        <p>has successfully completed HNGi 7.0 as a </p>
                        <h2 class=\"track\">$certificate->track</h2>
                    </div>

                    <div class=\"ceo-wrapper\">
                        <p class=\"signature\">Seyi Onifade</p>
                        <h4>Seyi Onifade - CEO, HNG Internship</h4>
                        <p>HNG Internship has confirmed the participation of this Individual in this program</p>
                        <p>Confirm at: {$url}</p>
                        <p>Certificate Issued on: $date</p>
                    </div>
                </div>
            </main>
        </section>
    </body>
</html>";

                    $certificateStyle4 = "<!DOCTYPE html>
<html lang=\"en\">
    <head>
        <meta charset=\"UTF-8\">
        <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
        <link rel = \"shortcut icon\" href= \"https://res.cloudinary.com/dafsch2zs/image/upload/v1594246923/Favicon_uwanbc.png\">
        <link href=\"https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,600;0,700;0,800;1,300;1,400;1,600;1,700;1,800&display=swap\" rel=\"stylesheet\">
        <link href=\"https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600&display=swap\" rel=\"stylesheet\">
        <link href=\"https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;600&display=swap\" rel=\"stylesheet\">
        <!-- <link rel=\"stylesheet\" href=\"index.css\"> -->
        <title>HNG | CERTIFICATE</title>

        <style>
            @font-face {
  font-family: 'Windsong';
  src: url(\"https://res.cloudinary.com/dafsch2zs/raw/upload/v1594246379/Windsong_g2ci9z.ttf\");
}

* {
  margin: 0;
  padding: 0;
  -webkit-box-sizing: border-box;
          box-sizing: border-box;
}

body {
  background-color: #dedede;
}

section {
  width: 1152px;
  min-height: 100vh;
  height: 100%;
  margin: auto;
  background-image: url(\"https://res.cloudinary.com/dafsch2zs/image/upload/v1594247482/Certificate_4_ly2h9d.png\");
  background-size: contain;
  background-position: center center;
  background-repeat: no-repeat;
  display: -webkit-box;
  display: -ms-flexbox;
  display: flex;
  -webkit-box-align: center;
      -ms-flex-align: center;
          align-items: center;
  -webkit-box-pack: center;
      -ms-flex-pack: center;
          justify-content: center;
}

section main .certificate,
section main .ceo-wrapper {
  display: -webkit-box;
  display: -ms-flexbox;
  display: flex;
  -webkit-box-orient: vertical;
  -webkit-box-direction: normal;
      -ms-flex-direction: column;
          flex-direction: column;
  -webkit-box-align: center;
      -ms-flex-align: center;
          align-items: center;
  -webkit-box-pack: center;
      -ms-flex-pack: center;
          justify-content: center;
  text-align: center;
}

section main .certificate .user-wrapper {
  font-family: Manrope;
}

section main .certificate .user-wrapper h4 {
  font-weight: normal;
  font-size: 1.563rem;
  line-height: 24px;
}

section main .certificate .user-wrapper .name {
  font-family: Playfair Display;
  font-weight: normal;
  font-size: 5rem;
  line-height: 107px;
  margin-bottom: 15px;
}

section main .certificate .user-wrapper p {
  font-weight: normal;
  font-size: 1.38rem;
  line-height: 30px;
  margin-bottom: 20px;
}

section main .certificate .user-wrapper .track {
  font-weight: normal;
  font-size: 2.94rem;
  line-height: 44px;
}

section main .ceo-wrapper {
  margin-top: 90px;
  font-family: Manrope;
}

section main .ceo-wrapper .signature {
  font-family: \"Windsong\", sans-serif;
  font-weight: normal;
  font-size: 4.4rem;
  line-height: 50px;
  color: #170C0C;
  margin: 0;
}

section main .ceo-wrapper h4 {
  font-size: 1.56rem;
  font-weight: normal;
  line-height: 34px;
  margin-bottom: 30px;
}

section main .ceo-wrapper p {
  font-size: 1.063rem;
  font-weight: normal;
  line-height: 23px;
  margin-bottom: 6px;
}
/*# sourceMappingURL=index.css.map */
        </style>
    </head>
    <body>
        <section>
            <main>
                <div class=\"certificate\">
                    <div class=\"user-wrapper\">
                        <h4>This is to certify that</h4>
                        <h2 class=\"name\">$certificate->owner</h2>
                        <p>has successfully completed HNGi 7.0 as a </p>
                        <h2 class=\"track\">$certificate->track</h2>
                    </div>

                    <div class=\"ceo-wrapper\">
                        <p class=\"signature\">Seyi Onifade</p>
                        <h4>Seyi Onifade - CEO, HNG Internship</h4>
                        <p>HNG Internship has confirmed the participation of this Individual in this program</p>
                        <p>Confirm at: {$url}</p>
                        <p>Certificate Issued on: $date</p>
                    </div>
                </div>
            </main>
        </section>
    </body>
</html>";

                    $certificateStyle5 = "<!DOCTYPE html>
<html lang=\"en\">
    <head>
        <meta charset=\"UTF-8\">
        <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
        <link rel = \"shortcut icon\" href= \"https://res.cloudinary.com/dafsch2zs/image/upload/v1594246923/Favicon_uwanbc.png\">
        <link href=\"https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,600;0,700;0,800;1,300;1,400;1,600;1,700;1,800&display=swap\" rel=\"stylesheet\">
        <link href=\"https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600&display=swap\" rel=\"stylesheet\">
        <link href=\"https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;600&display=swap\" rel=\"stylesheet\">
        <!-- <link rel=\"stylesheet\" href=\"index.css\"> -->
        <title>HNG | CERTIFICATE</title>

        <style>
            @font-face {
  font-family: 'Windsong';
  src: url(\"https://res.cloudinary.com/dafsch2zs/raw/upload/v1594246379/Windsong_g2ci9z.ttf\");
}

* {
  margin: 0;
  padding: 0;
  -webkit-box-sizing: border-box;
          box-sizing: border-box;
}

body {
  background-color: #dedede;
}

section {
  width: 1152px;
  min-height: 100vh;
  height: 100%;
  margin: auto;
  background-image: url(\"https://res.cloudinary.com/dafsch2zs/image/upload/v1594247502/Certificate_5_ltzx9y.png\");
  background-size: contain;
  background-position: center center;
  background-repeat: no-repeat;
  display: -webkit-box;
  display: -ms-flexbox;
  display: flex;
  -webkit-box-align: center;
      -ms-flex-align: center;
          align-items: center;
  -webkit-box-pack: center;
      -ms-flex-pack: center;
          justify-content: center;
}

section main .certificate,
section main .ceo-wrapper {
  display: -webkit-box;
  display: -ms-flexbox;
  display: flex;
  -webkit-box-orient: vertical;
  -webkit-box-direction: normal;
      -ms-flex-direction: column;
          flex-direction: column;
  -webkit-box-align: center;
      -ms-flex-align: center;
          align-items: center;
  -webkit-box-pack: center;
      -ms-flex-pack: center;
          justify-content: center;
  text-align: center;
}

section main .certificate .user-wrapper {
  font-family: Manrope;
}

section main .certificate .user-wrapper h4 {
  font-weight: normal;
  font-size: 1.563rem;
  line-height: 24px;
}

section main .certificate .user-wrapper .name {
  font-family: Playfair Display;
  font-weight: normal;
  font-size: 5rem;
  line-height: 107px;
  margin-bottom: 15px;
}

section main .certificate .user-wrapper p {
  font-weight: normal;
  font-size: 1.38rem;
  line-height: 30px;
  margin-bottom: 20px;
}

section main .certificate .user-wrapper .track {
  font-weight: normal;
  font-size: 2.94rem;
  line-height: 44px;
}

section main .ceo-wrapper {
  margin-top: 90px;
  font-family: Manrope;
}

section main .ceo-wrapper .signature {
  font-family: \"Windsong\", sans-serif;
  font-weight: normal;
  font-size: 4.4rem;
  line-height: 50px;
  color: #170C0C;
  margin: 0;
}

section main .ceo-wrapper h4 {
  font-size: 1.56rem;
  font-weight: normal;
  line-height: 34px;
  margin-bottom: 30px;
}

section main .ceo-wrapper p {
  font-size: 1.063rem;
  font-weight: normal;
  line-height: 23px;
  margin-bottom: 6px;
}
/*# sourceMappingURL=index.css.map */
        </style>
    </head>
    <body>
        <section>
            <main>
                <div class=\"certificate\">
                    <div class=\"user-wrapper\">
                        <h4>This is to certify that</h4>
                        <h2 class=\"name\">$certificate->owner</h2>
                        <p>has successfully completed HNGi 7.0 as a </p>
                        <h2 class=\"track\">$certificate->track</h2>
                    </div>

                    <div class=\"ceo-wrapper\">
                        <p class=\"signature\">Seyi Onifade</p>
                        <h4>Seyi Onifade - CEO, HNG Internship</h4>
                        <p>HNG Internship has confirmed the participation of this Individual in this program</p>
                        <p>Confirm at: {$url}</p>
                        <p>Certificate Issued on: $date</p>
                    </div>
                </div>
            </main>
        </section>
    </body>
</html>";

                    if ($certificate->certificate_style == 1) {
                        $displayCertificate = $certificateStyle1;
                    } else if ($certificate->certificate_style == 2) {
                        $displayCertificate = $certificateStyle2;
                    } else if ($certificate->certificate_style == 3) {
                        $displayCertificate = $certificateStyle3;
                    } else if ($certificate->certificate_style == 4) {
                        $displayCertificate = $certificateStyle4;
                    } else if ($certificate->certificate_style == 5) {
                        $displayCertificate = $certificateStyle5;
                    }

                    try {
                        // create the API client instance
                        $client = new \Pdfcrowd\HtmlToPdfClient("kelrob", "fa3c506937b9a51b2be94cdc66605830");

                        // configure the conversion
                        $client->setPageSize("A4");
                        $client->setOrientation("landscape");

                        // run the conversion and store the result into the "pdf" variable
                        $pdf = $client->convertString("$displayCertificate");

                        // send the result and set HTTP response headers
                        return response($pdf)
                            ->header('Content-Type', 'application/pdf')
                            ->header('Cache-Control', 'no-cache')
                            ->header('Accept-Ranges', 'none')
                            ->header('Content-Disposition', 'attachment; filename="result.pdf"');
                    } catch (\Pdfcrowd\Error $why) {
                        // send the error in the HTTP response
                        return response($why->getMessage(), $why->getCode())
                            ->header('Content-Type', 'text/plain');
                    }
                }
            }

        }


    }

    public function generateUniqueKey()
    {
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
        return GenKey::numeric(7)->prefix(mt_rand(1, 9))->generate(true);
    }

    public function downloadPDF($email) {
        $certificate = Certificate::where('email', $email)->first();

        $date = Carbon::parse($certificate->created_at)->format('l, M d, Y');
        $code = $certificate->unique_code;
        $url = route('verify',['code'=>$code]);
        if ($certificate->count() > 0) {
            if ($certificate->blocked == 1) {
                return 'You can no longer download this certificate. Contact Admin';
            } else {
                $certificate->download_count = $certificate->download_count + 1;
                if ($certificate->save()) {

                    $certificateStyle1 = "<!DOCTYPE html>
<html lang=\"en\">

    <head>
        <meta charset=\"UTF-8\">
        <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
        <link rel = \"shortcut icon\" href= \"https://res.cloudinary.com/dafsch2zs/image/upload/v1594246923/Favicon_uwanbc.png\">
        <link href=\"https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,600;0,700;0,800;1,300;1,400;1,600;1,700;1,800&display=swap\" rel=\"stylesheet\">
        <link href=\"https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600&display=swap\" rel=\"stylesheet\">
        <link href=\"https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;600&display=swap\" rel=\"stylesheet\">
        <!-- <link rel=\"stylesheet\" href=\"index.css\"> -->
        <title>HNG | CERTIFICATE</title>


        <style>
            @font-face {
  font-family: 'Windsong';
  src: url(\"https://res.cloudinary.com/dafsch2zs/raw/upload/v1594246379/Windsong_g2ci9z.ttf\");
}

* {
  margin: 0;
  padding: 0;
}

body {
  background-color: #dedede;
}

.certificate-wrapper {
  width: 1152px;
  min-height: 100vh;
  height: 100%;
  margin: auto;
  display: -webkit-box;
  display: -ms-flexbox;
  display: flex;
}

.certificate-wrapper aside {
  background-image: url(\"https://res.cloudinary.com/dafsch2zs/image/upload/v1594246923/Group_11_j9fp5t.png\");
  width: 374px;
}

.certificate-wrapper aside div {
  padding-top: 44px;
  display: -webkit-box;
  display: -ms-flexbox;
  display: flex;
  -webkit-box-pack: center;
      -ms-flex-pack: center;
          justify-content: center;
  -webkit-box-align: center;
      -ms-flex-align: center;
          align-items: center;
}

.certificate-wrapper aside div h2 {
  font-family: 'Manrope', sans-serif;
  font-weight: 600;
  font-size: 1.875rem;
  line-height: 41px;
  color: white;
  margin-left: 15px;
}

.certificate-wrapper main {
  background-color: #ffffff;
  overflow: hidden;
}

.certificate-wrapper main .certificate {
  padding: 44px 80px 10px;
}

.certificate-wrapper main .certificate .user-wrapper {
  font-family: Manrope;
}

.certificate-wrapper main .certificate .user-wrapper h4 {
  font-weight: normal;
  font-size: 1.563rem;
  line-height: 34px;
}

.certificate-wrapper main .certificate .user-wrapper .name {
  font-family: Playfair Display;
  font-weight: normal;
  font-size: 5rem;
  line-height: 107px;
  margin-bottom: 15px;
}

.certificate-wrapper main .certificate .user-wrapper p {
  font-weight: normal;
  font-size: 1.38rem;
  line-height: 30px;
  margin-bottom: 20px;
}

.certificate-wrapper main .certificate .user-wrapper .track {
  font-weight: normal;
  font-size: 2.94rem;
  line-height: 64px;
}

.certificate-wrapper main .ceo-wrapper {
  margin-top: 95px;
  font-family: Manrope;
}

.certificate-wrapper main .ceo-wrapper .signature {
  font-family: \"Windsong\", sans-serif;
  font-weight: normal;
  font-size: 4.4rem;
  line-height: 50px;
  color: #170C0C;
  margin: 0;
}

.certificate-wrapper main .ceo-wrapper h4 {
  font-size: 1.56rem;
  font-weight: normal;
  line-height: 34px;
  margin-bottom: 30px;
}

.certificate-wrapper main .ceo-wrapper p {
  font-size: 1.063rem;
  font-weight: normal;
  line-height: 23px;
  margin-bottom: 6px;
}
/*# sourceMappingURL=index.css.map */
        </style>
    </head>
    <body>
        <section class=\"certificate-wrapper\">
            <aside>
                <div>
                    <img src=\"https://res.cloudinary.com/dafsch2zs/image/upload/v1594246923/logo_wscqqj.png\" />
                    <h2>HNG Internship</h2>
                </div>
            </aside>

            <main>
                <div class=\"certificate\">
                    <div class=\"user-wrapper\">
                        <h4>This is to certify that</h4>
                        <h2 class=\"name\">$certificate->owner</h2>
                        <p>has successfully completed HNGi 7.0 as a </p>
                        <h2 class=\"track\">$certificate->track</h2>
                    </div>

                    <div class=\"ceo-wrapper\">
                        <p class=\"signature\">Seyi Onifade</p>
                        <h4>Seyi Onifade - CEO, HNG Internship</h4>
                        <p>HNG Internship has confirmed the participation of this Individual in this program</p>
                        <p>Confirm at: {$url}</p>
                        <p>Certificate Issued on: $date</p>
                    </div>
                </div>
            </main>
        </section>
    </body>
</html>";

                    $certificateStyle2 = "<!DOCTYPE html>
<html lang=\"en\">

<head>
  <meta charset=\"UTF-8\">
  <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
  <link rel=\"shortcut icon\" href=\"https://res.cloudinary.com/dafsch2zs/image/upload/v1594246923/Favicon_uwanbc.png\">
  <link
    href=\"https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,600;0,700;0,800;1,300;1,400;1,600;1,700;1,800&display=swap\"
    rel=\"stylesheet\">
  <link href=\"https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600&display=swap\" rel=\"stylesheet\">
  <link href=\"https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;600&display=swap\" rel=\"stylesheet\">
  <title>HNG | CERTIFICATE</title>


  <style>
    @font-face {
      font-family: 'Windsong';
      src: url(\"https://res.cloudinary.com/dafsch2zs/raw/upload/v1594246379/Windsong_g2ci9z.ttf\");
    }

    * {
      margin: 0;
      padding: 0;
    }

    body {
      background-color: #dedede;
    }

    .certificate-wrapper {
      width: 1152px;
      min-height: 100vh;
      height: 100%;
      margin: auto;
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
    }

    .certificate-wrapper aside {
      background-image: url(\"https://res.cloudinary.com/dafsch2zs/image/upload/v1594247194/bg-image_grhjdr.png\");
      width: 374px;
    }

    .certificate-wrapper aside div {
      padding-top: 44px;
      display: -webkit-box;
      display: -ms-flexbox;
      display: flex;
      -webkit-box-pack: center;
      -ms-flex-pack: center;
      justify-content: center;
      -webkit-box-align: center;
      -ms-flex-align: center;
      align-items: center;
    }

    .certificate-wrapper aside div h2 {
      font-family: 'Manrope', sans-serif;
      font-weight: 600;
      font-size: 1.875rem;
      line-height: 41px;
      color: white;
      margin-left: 15px;
    }

    .certificate-wrapper main {
      background-color: #ffffff;
      overflow: hidden;
    }

    .certificate-wrapper main .certificate {
      padding: 44px 80px 10px;
    }

    .certificate-wrapper main .certificate .user-wrapper {
      font-family: Manrope;
    }

    .certificate-wrapper main .certificate .user-wrapper h4 {
      font-weight: normal;
      font-size: 1.563rem;
      line-height: 34px;
    }

    .certificate-wrapper main .certificate .user-wrapper .name {
      font-family: Playfair Display;
      font-weight: normal;
      font-size: 5rem;
      line-height: 107px;
      margin-bottom: 15px;
    }

    .certificate-wrapper main .certificate .user-wrapper p {
      font-weight: normal;
      font-size: 1.38rem;
      line-height: 30px;
      margin-bottom: 20px;
    }

    .certificate-wrapper main .certificate .user-wrapper .track {
      font-weight: normal;
      font-size: 2.94rem;
      line-height: 64px;
    }

    .certificate-wrapper main .ceo-wrapper {
      margin-top: 95px;
      font-family: Manrope;
    }

    .certificate-wrapper main .ceo-wrapper .signature {
      font-family: \"Windsong\", sans-serif;
      font-weight: normal;
      font-size: 4.4rem;
      line-height: 50px;
      color: #170C0C;
      margin: 0;
    }

    .certificate-wrapper main .ceo-wrapper h4 {
      font-size: 1.56rem;
      font-weight: normal;
      line-height: 34px;
      margin-bottom: 30px;
    }

    .certificate-wrapper main .ceo-wrapper p {
      font-size: 1.063rem;
      font-weight: normal;
      line-height: 23px;
      margin-bottom: 6px;
    }

  </style>
</head>

<body>
  <section class=\"certificate-wrapper\">
    <aside>
      <div>
        <img src=\"https://res.cloudinary.com/dafsch2zs/image/upload/v1594246923/logo_wscqqj.png\" />
        <h2>HNG Internship</h2>
      </div>
    </aside>

    <main>
      <div class=\"certificate\">
        <div class=\"user-wrapper\">
          <h4>This is to certify that</h4>
          <h2 class=\"name\">$certificate->owner</h2>
          <p>has successfully completed HNGi 7.0 as a </p>
          <h2 class=\"track\">$certificate->track</h2>
        </div>

        <div class=\"ceo-wrapper\">
          <p class=\"signature\">Seyi Onifade</p>
          <h4>Seyi Onifade - CEO, HNG Internship</h4>
          <p>HNG Internship has confirmed the participation of this Individual in this program</p>
          <p>Confirm at: {$url}</p>
          <p>Certificate Issued on: $date</p>
        </div>
      </div>
    </main>
  </section>
</body>

</html>";

                    $certificateStyle3 = "<!DOCTYPE html>
<html lang=\"en\">
    <head>
        <meta charset=\"UTF-8\">
        <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
        <link rel = \"shortcut icon\" href= \"https://res.cloudinary.com/dafsch2zs/image/upload/v1594246923/Favicon_uwanbc.png\">
        <link href=\"https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,600;0,700;0,800;1,300;1,400;1,600;1,700;1,800&display=swap\" rel=\"stylesheet\">
        <link href=\"https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600&display=swap\" rel=\"stylesheet\">
        <link href=\"https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;600&display=swap\" rel=\"stylesheet\">
        <!-- <link rel=\"stylesheet\" href=\"index.css\"> -->
        <title>HNG | CERTIFICATE</title>

        <style>
            @font-face {
  font-family: 'Windsong';
  src: url(\"https://res.cloudinary.com/dafsch2zs/raw/upload/v1594246379/Windsong_g2ci9z.ttf\");
}

* {
  margin: 0;
  padding: 0;
  -webkit-box-sizing: border-box;
          box-sizing: border-box;
}

body {
  background-color: #dedede;
}

section {
  width: 1152px;
  min-height: 100vh;
  height: 100%;
  margin: auto;
  background-image: url(\"https://res.cloudinary.com/dafsch2zs/image/upload/v1594247461/Certificate_3_1_orqrfs.png\");
  background-size: contain;
  background-position: center center;
  background-repeat: no-repeat;
  display: -webkit-box;
  display: -ms-flexbox;
  display: flex;
  -webkit-box-align: center;
      -ms-flex-align: center;
          align-items: center;
  -webkit-box-pack: center;
      -ms-flex-pack: center;
          justify-content: center;
}

section main .certificate,
section main .ceo-wrapper {
  display: -webkit-box;
  display: -ms-flexbox;
  display: flex;
  -webkit-box-orient: vertical;
  -webkit-box-direction: normal;
      -ms-flex-direction: column;
          flex-direction: column;
  -webkit-box-align: center;
      -ms-flex-align: center;
          align-items: center;
  -webkit-box-pack: center;
      -ms-flex-pack: center;
          justify-content: center;
  text-align: center;
}

section main .certificate .user-wrapper {
  font-family: Manrope;
}

section main .certificate .user-wrapper h4 {
  font-weight: normal;
  font-size: 1.563rem;
  line-height: 24px;
}

section main .certificate .user-wrapper .name {
  font-family: Playfair Display;
  font-weight: normal;
  font-size: 5rem;
  line-height: 107px;
  margin-bottom: 15px;
}

section main .certificate .user-wrapper p {
  font-weight: normal;
  font-size: 1.38rem;
  line-height: 30px;
  margin-bottom: 20px;
}

section main .certificate .user-wrapper .track {
  font-weight: normal;
  font-size: 2.94rem;
  line-height: 44px;
}

section main .ceo-wrapper {
  margin-top: 90px;
  font-family: Manrope;
}

section main .ceo-wrapper .signature {
  font-family: \"Windsong\", sans-serif;
  font-weight: normal;
  font-size: 4.4rem;
  line-height: 50px;
  color: #170C0C;
  margin: 0;
}

section main .ceo-wrapper h4 {
  font-size: 1.56rem;
  font-weight: normal;
  line-height: 34px;
  margin-bottom: 30px;
}

section main .ceo-wrapper p {
  font-size: 1.063rem;
  font-weight: normal;
  line-height: 23px;
  margin-bottom: 6px;
}
/*# sourceMappingURL=index.css.map */
        </style>
    </head>
    <body>
        <section>
            <main>
                <div class=\"certificate\">
                    <div class=\"user-wrapper\">
                        <h4>This is to certify that</h4>
                        <h2 class=\"name\">$certificate->owner</h2>
                        <p>has successfully completed HNGi 7.0 as a </p>
                        <h2 class=\"track\">$certificate->track</h2>
                    </div>

                    <div class=\"ceo-wrapper\">
                        <p class=\"signature\">Seyi Onifade</p>
                        <h4>Seyi Onifade - CEO, HNG Internship</h4>
                        <p>HNG Internship has confirmed the participation of this Individual in this program</p>
                        <p>Confirm at: {$url}</p>
                        <p>Certificate Issued on: $date</p>
                    </div>
                </div>
            </main>
        </section>
    </body>
</html>";

                    $certificateStyle4 = "<!DOCTYPE html>
<html lang=\"en\">
    <head>
        <meta charset=\"UTF-8\">
        <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
        <link rel = \"shortcut icon\" href= \"https://res.cloudinary.com/dafsch2zs/image/upload/v1594246923/Favicon_uwanbc.png\">
        <link href=\"https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,600;0,700;0,800;1,300;1,400;1,600;1,700;1,800&display=swap\" rel=\"stylesheet\">
        <link href=\"https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600&display=swap\" rel=\"stylesheet\">
        <link href=\"https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;600&display=swap\" rel=\"stylesheet\">
        <!-- <link rel=\"stylesheet\" href=\"index.css\"> -->
        <title>HNG | CERTIFICATE</title>

        <style>
            @font-face {
  font-family: 'Windsong';
  src: url(\"https://res.cloudinary.com/dafsch2zs/raw/upload/v1594246379/Windsong_g2ci9z.ttf\");
}

* {
  margin: 0;
  padding: 0;
  -webkit-box-sizing: border-box;
          box-sizing: border-box;
}

body {
  background-color: #dedede;
}

section {
  width: 1152px;
  min-height: 100vh;
  height: 100%;
  margin: auto;
  background-image: url(\"https://res.cloudinary.com/dafsch2zs/image/upload/v1594247482/Certificate_4_ly2h9d.png\");
  background-size: contain;
  background-position: center center;
  background-repeat: no-repeat;
  display: -webkit-box;
  display: -ms-flexbox;
  display: flex;
  -webkit-box-align: center;
      -ms-flex-align: center;
          align-items: center;
  -webkit-box-pack: center;
      -ms-flex-pack: center;
          justify-content: center;
}

section main .certificate,
section main .ceo-wrapper {
  display: -webkit-box;
  display: -ms-flexbox;
  display: flex;
  -webkit-box-orient: vertical;
  -webkit-box-direction: normal;
      -ms-flex-direction: column;
          flex-direction: column;
  -webkit-box-align: center;
      -ms-flex-align: center;
          align-items: center;
  -webkit-box-pack: center;
      -ms-flex-pack: center;
          justify-content: center;
  text-align: center;
}

section main .certificate .user-wrapper {
  font-family: Manrope;
}

section main .certificate .user-wrapper h4 {
  font-weight: normal;
  font-size: 1.563rem;
  line-height: 24px;
}

section main .certificate .user-wrapper .name {
  font-family: Playfair Display;
  font-weight: normal;
  font-size: 5rem;
  line-height: 107px;
  margin-bottom: 15px;
}

section main .certificate .user-wrapper p {
  font-weight: normal;
  font-size: 1.38rem;
  line-height: 30px;
  margin-bottom: 20px;
}

section main .certificate .user-wrapper .track {
  font-weight: normal;
  font-size: 2.94rem;
  line-height: 44px;
}

section main .ceo-wrapper {
  margin-top: 90px;
  font-family: Manrope;
}

section main .ceo-wrapper .signature {
  font-family: \"Windsong\", sans-serif;
  font-weight: normal;
  font-size: 4.4rem;
  line-height: 50px;
  color: #170C0C;
  margin: 0;
}

section main .ceo-wrapper h4 {
  font-size: 1.56rem;
  font-weight: normal;
  line-height: 34px;
  margin-bottom: 30px;
}

section main .ceo-wrapper p {
  font-size: 1.063rem;
  font-weight: normal;
  line-height: 23px;
  margin-bottom: 6px;
}
/*# sourceMappingURL=index.css.map */
        </style>
    </head>
    <body>
        <section>
            <main>
                <div class=\"certificate\">
                    <div class=\"user-wrapper\">
                        <h4>This is to certify that</h4>
                        <h2 class=\"name\">$certificate->owner</h2>
                        <p>has successfully completed HNGi 7.0 as a </p>
                        <h2 class=\"track\">$certificate->track</h2>
                    </div>

                    <div class=\"ceo-wrapper\">
                        <p class=\"signature\">Seyi Onifade</p>
                        <h4>Seyi Onifade - CEO, HNG Internship</h4>
                        <p>HNG Internship has confirmed the participation of this Individual in this program</p>
                        <p>Confirm at: {$url}</p>
                        <p>Certificate Issued on: $date</p>
                    </div>
                </div>
            </main>
        </section>
    </body>
</html>";

                    $certificateStyle5 = "<!DOCTYPE html>
<html lang=\"en\">
    <head>
        <meta charset=\"UTF-8\">
        <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
        <link rel = \"shortcut icon\" href= \"https://res.cloudinary.com/dafsch2zs/image/upload/v1594246923/Favicon_uwanbc.png\">
        <link href=\"https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,600;0,700;0,800;1,300;1,400;1,600;1,700;1,800&display=swap\" rel=\"stylesheet\">
        <link href=\"https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600&display=swap\" rel=\"stylesheet\">
        <link href=\"https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;600&display=swap\" rel=\"stylesheet\">
        <!-- <link rel=\"stylesheet\" href=\"index.css\"> -->
        <title>HNG | CERTIFICATE</title>

        <style>
            @font-face {
  font-family: 'Windsong';
  src: url(\"https://res.cloudinary.com/dafsch2zs/raw/upload/v1594246379/Windsong_g2ci9z.ttf\");
}

* {
  margin: 0;
  padding: 0;
  -webkit-box-sizing: border-box;
          box-sizing: border-box;
}

body {
  background-color: #dedede;
}

section {
  width: 1152px;
  min-height: 100vh;
  height: 100%;
  margin: auto;
  background-image: url(\"https://res.cloudinary.com/dafsch2zs/image/upload/v1594247502/Certificate_5_ltzx9y.png\");
  background-size: contain;
  background-position: center center;
  background-repeat: no-repeat;
  display: -webkit-box;
  display: -ms-flexbox;
  display: flex;
  -webkit-box-align: center;
      -ms-flex-align: center;
          align-items: center;
  -webkit-box-pack: center;
      -ms-flex-pack: center;
          justify-content: center;
}

section main .certificate,
section main .ceo-wrapper {
  display: -webkit-box;
  display: -ms-flexbox;
  display: flex;
  -webkit-box-orient: vertical;
  -webkit-box-direction: normal;
      -ms-flex-direction: column;
          flex-direction: column;
  -webkit-box-align: center;
      -ms-flex-align: center;
          align-items: center;
  -webkit-box-pack: center;
      -ms-flex-pack: center;
          justify-content: center;
  text-align: center;
}

section main .certificate .user-wrapper {
  font-family: Manrope;
}

section main .certificate .user-wrapper h4 {
  font-weight: normal;
  font-size: 1.563rem;
  line-height: 24px;
}

section main .certificate .user-wrapper .name {
  font-family: Playfair Display;
  font-weight: normal;
  font-size: 5rem;
  line-height: 107px;
  margin-bottom: 15px;
}

section main .certificate .user-wrapper p {
  font-weight: normal;
  font-size: 1.38rem;
  line-height: 30px;
  margin-bottom: 20px;
}

section main .certificate .user-wrapper .track {
  font-weight: normal;
  font-size: 2.94rem;
  line-height: 44px;
}

section main .ceo-wrapper {
  margin-top: 90px;
  font-family: Manrope;
}

section main .ceo-wrapper .signature {
  font-family: \"Windsong\", sans-serif;
  font-weight: normal;
  font-size: 4.4rem;
  line-height: 50px;
  color: #170C0C;
  margin: 0;
}

section main .ceo-wrapper h4 {
  font-size: 1.56rem;
  font-weight: normal;
  line-height: 34px;
  margin-bottom: 30px;
}

section main .ceo-wrapper p {
  font-size: 1.063rem;
  font-weight: normal;
  line-height: 23px;
  margin-bottom: 6px;
}
/*# sourceMappingURL=index.css.map */
        </style>
    </head>
    <body>
        <section>
            <main>
                <div class=\"certificate\">
                    <div class=\"user-wrapper\">
                        <h4>This is to certify that</h4>
                        <h2 class=\"name\">$certificate->owner</h2>
                        <p>has successfully completed HNGi 7.0 as a </p>
                        <h2 class=\"track\">$certificate->track</h2>
                    </div>

                    <div class=\"ceo-wrapper\">
                        <p class=\"signature\">Seyi Onifade</p>
                        <h4>Seyi Onifade - CEO, HNG Internship</h4>
                        <p>HNG Internship has confirmed the participation of this Individual in this program</p>
                        <p>Confirm at: {$url}</p>
                        <p>Certificate Issued on: $date</p>
                    </div>
                </div>
            </main>
        </section>
    </body>
</html>";

                    if ($certificate->certificate_style == 1) {
                        $displayCertificate = $certificateStyle1;
                    } else if ($certificate->certificate_style == 2) {
                        $displayCertificate = $certificateStyle2;
                    } else if ($certificate->certificate_style == 3) {
                        $displayCertificate = $certificateStyle3;
                    } else if ($certificate->certificate_style == 4) {
                        $displayCertificate = $certificateStyle4;
                    } else if ($certificate->certificate_style == 5) {
                        $displayCertificate = $certificateStyle5;
                    }

                    try {
                        // create the API client instance
                        $client = new \Pdfcrowd\HtmlToPdfClient("kelrob", "fa3c506937b9a51b2be94cdc66605830");

                        // configure the conversion
                        $client->setPageSize("A4");
                        $client->setOrientation("landscape");

                        // run the conversion and store the result into the "pdf" variable
                        $pdf = $client->convertString("$displayCertificate");

                        // send the result and set HTTP response headers
                        return response($pdf)
                            ->header('Content-Type', 'application/pdf')
                            ->header('Cache-Control', 'no-cache')
                            ->header('Accept-Ranges', 'none')
                            ->header('Content-Disposition', 'attachment; filename="result.pdf"');
                    } catch (\Pdfcrowd\Error $why) {
                        // send the error in the HTTP response
                        return response($why->getMessage(), $why->getCode())
                            ->header('Content-Type', 'text/plain');
                    }
                }
            }
        }
    }

    public function verify($code)
    {
        $certificate = Certificate::where('unique_code', $code)->first();

        if ($certificate) {
            return view('verify-certificate', compact('certificate'));
        } else {
            return view('unverify-certificate');
        }
    }
}
