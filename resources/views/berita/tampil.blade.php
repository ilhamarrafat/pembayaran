<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Pembayaran</title>
    <meta content="" name="description">
    <meta content="" name="keywords">
    {{--css--}}
    @include('include.style')
    {{--endcss--}}
</head>

<body class="index-page">
    {{--header--}}
    @include('include.header')
    {{--endheader--}}

    <main class="main">
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card shadow-sm">
                        @if ($berita->gambar)
                        <img src="{{ url('gambar/' . $berita->gambar) }}" alt="{{ $berita->judul }}" class="card-img-top" style="height: 300px; object-fit: cover;">
                        @endif
                        <div class="card-body">
                            <h3 class="card-title">{{ $berita->judul }}</h3>
                            <p class="text-muted">Diposting pada {{ $berita->created_at->format('d M Y') }}</p>
                            <div class="card-text">{!! nl2br(e($berita->isi)) !!}</div>
                            <a href="{{ route('index') }}" class="btn btn-secondary mt-3">Kembali</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    {{--footer--}}
    @include('include.footer')
    {{--endfooter--}}

    <!-- Scroll Top -->
    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    {{--javascript--}}
    @include('include.script')
    {{--endjavacript--}}
</body>

</html>