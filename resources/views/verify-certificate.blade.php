<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel = "shortcut icon" href= "{{ url('/images/Favicon.svg') }}">
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ url('/css/verify.css') }}">
    <title>HNG | CERTIFICATE DETAILS</title>
</head>
<body>
<section>
    <div>
        <h2>Certificate Details</h2>

        <h3>Name: <span id="name">{{ $certificate->owner }}</span></h3>
        <h3>Track: <span id="track">{{ $certificate->track }}</span></h3>
        <h3>Email: <span id="email">{{ $certificate->email }}</span></h3>
        <h3>Date Generated: <span id="email">{{ $certificate->created_at->format('l, M d, Y') }}</span></h3>
        <h3>Status: <span id="verified" class="verified">Verified</span></h3>
    </div>
</section>
</body>
</html>
