@extends('email/template')

@section('content')
    <h1>بِسْمِ اللَّهِ الرَّحْمَنِ الرَّحِيم</h1>
    <p>Alhamdulillah Wa Sholatu wa salamu a'la Rasulillah Ama ba'ad</p>
    <br>
    <p>Alhamdulilah pembayaran sebesar <b>Rp. {{ $details['nominal'] }}</b> atas nama <b>{{ $details['name'] }}</b> telah kami konfirmasi</p>
    <b>Jazakumullahu Khairan</b>
@endsection