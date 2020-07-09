<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" href="https://res.cloudinary.com/dafsch2zs/image/upload/v1594246923/Favicon_uwanbc.png">
  <link
    href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,600;0,700;0,800;1,300;1,400;1,600;1,700;1,800&display=swap"
    rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;600&display=swap" rel="stylesheet">
  <title>HNG | CERTIFICATE</title>


  <style>
    @font-face {
      font-family: 'Windsong';
      src: url("https://res.cloudinary.com/dafsch2zs/raw/upload/v1594246379/Windsong_g2ci9z.ttff");
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
      background-image: url("https://res.cloudinary.com/dafsch2zs/image/upload/v1594247194/bg-image_grhjdr.png");
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
      font-family: "Windsong", sans-serif;
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
  <section class="certificate-wrapper">
    <aside>
      <div>
        <img src="https://res.cloudinary.com/dafsch2zs/image/upload/v1594246923/logo_wscqqj.png" />
        <h2>HNG Internship</h2>
      </div>
    </aside>

    <main>
      <div class="certificate">
                    <div class="user-wrapper">
                        <h4>This is to certify that</h4>
                        <h2 class="name">{{ $owner }}</h2>
                        <p>has successfully completed HNGi 7.0 as a </p>
                        <h2 class="track">{{ $track }}</h2>
                    </div>

                    <div class="ceo-wrapper">
                        <p class="signature">Seyi Onifade</p>
                        <h4>Seyi Onifade - CEO, HNG Internship</h4>
                        <p>HNG Internship has confirmed the participation of this Individual in this program</p>
                        <p>Confirm at: https://hng.tech/test{{ $cert_id }}}</p>
                        <p>Certificate Issued on: {{ $date_created }}</p>
                    </div>
                </div>
    </main>
  </section>
</body>

</html>