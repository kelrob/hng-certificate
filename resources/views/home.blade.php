@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>S/N</th>
                                <th>Full Name</th>
                                <th>Owner Email</th>
                                <th>Downloads Count</th>
                                <th>Certificate Code</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($certificates as $certificate)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $certificate->owner }}</td>
                                    <td>{{ $certificate->email }}</td>
                                    <td>{{ $certificate->download_count }}</td>
                                    <td>{{ $certificate->unique_code }}</td>
                                    <td>
                                        @if ($certificate->blocked == false)
                                            <a onclick="blockDownload({{ $certificate->id }})" id="btn-block" class="btn btn-sm btn-danger text-white">
                                                <span id="default-text-block">Block Downloads</span>
                                                <span id="loader-text-block" style="display: none;"> Please wait</span>
                                            </a>
                                        @elseif ($certificate->blocked)
                                            <a onclick="allowDownload({{ $certificate->id }})" id="btn-allow" class="btn btn-sm btn-success text-white">
                                                <span id="default-text-allow">Allow Downloads</span>
                                                <span id="loader-text-allow" style="display: none;"> Please wait</span>
                                            </a>
                                        @endif

                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const allowDownload = (certId) => {
            $.ajax({
                type: "GET",
                url: `change-download-status/${certId}/allow`,
                beforeSend: function () {
                    $('#default-text-allow').hide();
                    $('#loader-text-allow').show();
                    $('#btn-allow').attr('disabled', 'disabled');
                },
                success: function (data) {
                    alert(data);
                    location.reload();
                },
            });
        }

        const blockDownload = (certId) => {
            $.ajax({
                type: "GET",
                url: `change-download-status/${certId}/block`,
                beforeSend: function () {
                    $('#default-text-block').hide();
                    $('#loader-text-block').show();
                    $('#btn-block').attr('disabled', 'disabled');
                },
                success: function (data) {
                    alert(data);
                    location.reload();
                },
            });
        }
    </script>
</div>
@endsection
