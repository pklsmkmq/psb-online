@extends('email/template')

@section('content')
    <h1>بِسْمِ اللَّهِ الرَّحْمَنِ الرَّحِيم</h1>
    <br>
    <p>Anda telah melakukan permintaan untuk mereset password Akun PPDB SMK Madinatul Qur'an. Untuk melanjutkan prosesnya, <a style="color: rgb(79, 79, 235);" href="https://ppdb.smkmadinatulquran.sch.id/reset/{{$details['id']}}/{{$details['randomToken']}}"><b>silahkan mengikuti link ini</b></a></p>
    <p>Namun apabila anda tidak pernah meminta proses ini, maka kami harap Anda untuk mengabaikan email ini</p>
@endsection