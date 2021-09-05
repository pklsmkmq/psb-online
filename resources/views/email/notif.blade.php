@extends('email/template')

@section('content')
	<h1>بِسْمِ اللَّهِ الرَّحْمَنِ الرَّحِيم</h1>
	<h3>Hallo Admin,</h3>
	<p>server ingin memberitahukan bahwa ada pendaftaran baru masuk di website yang datanya adalah sebagai berikut</p>
	<table>
		<tr>
			<td>Nama</td>
			<td>:</td>
			<td><b>{{ $details['nama'] }}</b></td>
		</tr>
		<tr>
			<td>Email</td>
			<td>:</td>
			<td><b>{{ $details['email'] }}</b></td>
		</tr>
		<tr>
			<td>Nomor HP</td>
			<td>:</td>
			<td><b>{{ $details['hp'] }}</b></td>
		</tr>
	</table>
@endsection