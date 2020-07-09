@include('cert_layout.header')
<body style="height: 100%; width: 100%; border-bottom: 0">
<section class="certificate-wrapper" style="margin:0;" >
    <aside>
        <div>
            <img src="{{asset('images/cert1/images/logo.svg')}}" />
            <h2>HNG Internship</h2>
        </div>
    </aside>

    <main>
        <div class="certificate">
            <div class="user-wrapper">
                <h4>This is to certify that</h4>
                <h2 class="name">{{$certificate_details['owner'] ?? ''}}</h2>
                <p>has successfully completed HNGi 7.0 as a </p>
                <h2 class="track">{{$certificate_details['track'] ?? ''}}</h2>
            </div>

            <div class="ceo-wrapper">
                <p class="signature">Seyi Onifade</p>
                <h4>Seyi Onifade - CEO, HNG Internship</h4>
                <p>HNG Internship has confirmed the participation of this Individual in this program</p>
                <p>Confirm at: https://hng.tech/certificate/download/hng6268d0a</p>
                <p>Certificate Issued on: {{$certificate_details['created_at'] ?? ''}}</p>
            </div>
        </div>
    </main>
</section>
</body>
</html>
