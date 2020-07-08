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
    <form>
        <h2>Get a HNG Certificate</h2>

        <div class="row">
            <div class="design">
                <label name="design" class="design-text">Select preferred certificate design*</label>
                <aside>
                    <div class="design-wrapper">
                        <input type="radio" id="design1" name="design" value="design1">
                        <div for="design1" class="image-design">
                            <img src="{{ url('/images/design1.png') }}" for="design1" alt="design1" />
                        </div>
                    </div>

                    <div class="design-wrapper">
                        <input type="radio" id="design2" name="design" value="design2">
                        <div for="design2" class="image-design">
                            <img src="{{ url('images/design2.png') }}" for="design2" alt="design2" />
                        </div>
                    </div>

                    <div class="design-wrapper">
                        <input type="radio" id="design3" name="design" value="design3">
                        <div for="design3" class="image-design">
                            <img src="{{ url('images/design3.png') }}" for="design3" alt="design3" />
                        </div>
                    </div>

                    <div class="design-wrapper">
                        <input type="radio" id="design4" name="design" value="design4">
                        <div for="design4" class="image-design">
                            <img src="{{ url('images/design4.png') }}" for="design4" alt="design4" />
                        </div>
                    </div>

                    <div class="design-wrapper">
                        <input type="radio" id="design5" name="design" value="design5">
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
                        <input type="text" id="name" placeholder="Enter your name..." />
                    </div>

                    <div class="form-group">
                        <label for="track">Track*</label>
                        <select>
                            <option>Frontend Developer</option>
                            <option>Backend Developer</option>
                            <option>Mobile Developer</option>
                            <option>UI/UX Developer</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="email">Email*</label>
                        <input type="email" id="email" placeholder="Enter your email..." />
                    </div>

                    <div class="form-group check">
                        <input type="checkbox" id="send-email" />
                        <label for="send-email">Send certificate to my email</label>
                    </div>

                    <button type="submit">Get Certificate</button>
                </div>
            </main>
        </div>
    </form>
</section>
</body>
</html>
