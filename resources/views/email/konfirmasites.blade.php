@extends('email/template')

@section('content')
	<h1>بِسْمِ اللَّهِ الرَّحْمَنِ الرَّحِيم</h1>
	<p>Alhamdulillah Wa Sholatu wa salamu a'la Rasulillah Ama ba'ad</p>
    <br>
	<p>Untuk Tes Online Telah Kami Jadwalkan Dengan Rincian Sebagai Berikut.</p>
	<br>
	<table style="font-weight: bold">
		<tr>
			<td>Nama Siswa</td>
			<td>:</td>
			<td>{{ $details['name'] }}</td>
		</tr>
		<tr>
			<td>Tanggal Tes</td>
			<td>:</td>
			<td>{{ $details['tanggal'] }}</td>
		</tr>
		<tr>
			<td>Jam Tes</td>
			<td>:</td>
			<td>{{ $details['jam_tes'] }}</td>
		
		</tr>
	</table>
	<br>
	<p>Adapun tempat pelaksanaan tes akan di infokan oleh panitia 10 menit sebelum tes dilakukan</p>
@endsection