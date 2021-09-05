@extends('email/template')

@section('content')
	<h1>بِسْمِ اللَّهِ الرَّحْمَنِ الرَّحِيم</h1>
	<h3>Hallo Admin,</h3>
	<p>server ingin memberitahukan bahwa ada pembayaran pendaftaran yang masuk berikut detailnya</p>
	<table>
        <tr>
            <td>Nama</td>
            <td>:</td>
            <td><b>{{ $details['name'] }}</b></td>
        </tr>
        <tr>
            <td>Lihat Bukti</td>
            <td>:</td>
            <td><a href="{{ $details['bukti'] }}">Klik Disini</a></td>
        </tr>
        <tr>
            <td>WhatsApp</td>
            <td>:</td>
            <td><a href="https://api.whatsapp.com/send/?phone={{ $details['telepon'] }}">Klik Disini</a></td>
        </tr>
    </table>
@endsection