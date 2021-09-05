@extends('email/template')

@section('content')
    <h1>بِسْمِ اللَّهِ الرَّحْمَنِ الرَّحِيم</h1>
    <br>
    <h3>Ahlan Wa Sahlan {{ $details['nama'] }}</h3>
    <br>
    <p>Alhamdulillah akun telah berhasil terbuat, Silahkan lengkapi data di website untuk melanjutkan ke proses selanjutnya</p>
    <b>Gunakan Data Ini Untuk Login Ke Dalam Website</b>
    <br>
    <table>
        <tr>
            <td>Email</td>
            <td>:</td>
            <td>{{ $details['email'] }}</td>
        </tr>
        <tr>
            <td>Password</td>
            <td>:</td>
            <td>{{ $details['password'] }}</td>
        </tr>
    </table>
@endsection