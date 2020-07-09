<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel = "shortcut icon" href= "{{ url('/images/Favicon.svg') }}">
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ url('/css/index.css') }}">
    <title>HNG | GET CERTIFICATE</title>
</head>
<body>
<section>
    <form action="{{route('certRequest')}}" method="post">
        @if($errors->any())
            <div class="alert alert-danger" style="padding: 2%; border-radius: 3px; margin-bottom: 2%; background-color: #f85d51; color: #fff;">
                <p>{{$errors->first()}}</p>
            </div>
        @endif
        @csrf
        <h2>Get a HNG Certificate</h2>

        <div class="row">
            <div class="design">
                <label name="certificate_style" class="design-text">Select preferred certificate design*</label>
                <aside>
                    <div class="design-wrapper">
                        <input type="radio" id="design1" name="certificate_style" value=1>
                        <div for="design1" class="image-design">
                            <img src="{{ url('/images/design1.png') }}" for="design1" alt="design1" />
                        </div>
                    </div>

                    <div class="design-wrapper">
                        <input type="radio" id="design2" name="certificate_style" value=2>
                        <div for="design2" class="image-design">
                            <img src="{{ url('images/design2.png') }}" for="design2" alt="design2" />
                        </div>
                    </div>

                    <div class="design-wrapper">
                        <input type="radio" id="design3" name="certificate_style" value=3>
                        <div for="design3" class="image-design">
                            <img src="{{ url('images/design3.png') }}" for="design3" alt="design3" />
                        </div>
                    </div>

                    <div class="design-wrapper">
                        <input type="radio" id="design4" name="certificate_style" value=4>
                        <div for="design4" class="image-design">
                            <img src="{{ url('images/design4.png') }}" for="design4" alt="design4" />
                        </div>
                    </div>

                    <div class="design-wrapper">
                        <input type="radio" id="design5" name="certificate_style" value=5>
                        <div for="design5" class="image-design">
                            <img src="{{ url('images/design5.png') }}" for="design5" alt="design5" />
                        </div>
                    </div>
                </aside>
            </div>

            <main>
                <div>
                    <div class="form-group">
                        <label for="name">Name*</label>
                        <input type="text" id="name" name="owner" required placeholder="Enter your name..." />
                    </div>

                    <div class="form-group">
                        <label for="track">Track*</label>
                        <select name="track" required>
                            <option value="Frontend Developer">Frontend Developer</option>
                            <option value="Backend Developer">Backend Developer</option>
                            <option value="Mobile Developer">Mobile Developer</option>
                            <option value="UI/UX Developer">UI/UX Developer</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="email">Email*</label>
                        <input type="email" id="email" required name="email" placeholder="Enter your email..." />
                    </div>

                    <div class="form-group check">
                        <input type="checkbox" name="send_to_mail" id="send-email" />
                        <label for="send-email">Send certificate to my email</label>
                    </div>

                    <button type="submit" class="btn btn-sm">Download</button>
                </div>
            </main>
        </div>
    </form>
</section>
</body>
</html>
