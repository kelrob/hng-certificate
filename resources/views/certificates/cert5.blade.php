<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel = "shortcut icon" href= "https://res.cloudinary.com/dafsch2zs/image/upload/v1594246923/Favicon_uwanbc.png"> 
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,600;0,700;0,800;1,300;1,400;1,600;1,700;1,800&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;600&display=swap" rel="stylesheet">
        <!-- <link rel="stylesheet" href="index.css"> -->
        <title>HNG | CERTIFICATE</title>

        <style>
            @font-face {
  font-family: 'Windsong';
  src: url("https://res.cloudinary.com/dafsch2zs/raw/upload/v1594246379/Windsong_g2ci9z.ttff");
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
  background-image: url("https://res.cloudinary.com/dafsch2zs/image/upload/v1594247502/Certificate_5_ltzx9y.png");
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
  font-family: "Windsong", sans-serif;
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