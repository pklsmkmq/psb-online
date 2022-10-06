@extends('email/template')

@section('content')
    <h3 style="text-align: center; color: black;">Pengumuman PPDB SMK MADINATULQURAN</h3>
    <h4 style="text-align: center; color: black; font-weight: bold;">Tahun Pelajaran 2022/2023</h4>
    <br>
    <p style="text-align: justify">Berdasarkan Hasil tes dan wawancara yang telah dilaksanakan maka dengan ini kami menyatakan bahwa santri atas Nama <b>{{ $details['name'] }}</b> dinyatakan :</p>
    <h3 style="text-align: center; color: black;">LULUS</h3>
    <p style="text-align: justify">Untuk tahapan selanjutnya, wali santri bisa langsung melakukan pembayaran ke rekening di bawah ini sejumlah <b>Rp. 18.500.000,00</b> (Delapan Belas Juta Lima Ratus Ribu Rupiah). Berikut ini nomor rekeningnya:</p>
    <center>
        <table>
            <tr>
                <td><b>Nomor Rekening</b></td>
                <td><b>:</b></td>
                <td><b> 3310006100</b></td>
            </tr>
            <tr>
                <td><b>Kode Bank</b></td>
                <td><b>:</b></td>
                <td><b> (147) Bank Muamalat</b></td>
            </tr>
            <tr>
                <td><b>Atas Nama</b></td>
                <td><b>:</b></td>
                <td><b> Yayasan Wisata Al Islam</b></td>
            </tr>
        </table>
    </center>
    <p>Untuk pembayaran dapat di bayar secara tunai ataupun dicicil, berikut ini adalah tahapan pembayarannya:</p>
    <table style="width: 100%; text-align: center" border="1">
        <tr style="background: #076d42; color: white;">
            <td><center><b>Tahap</b></center></td>
            <td><center><b>Nominal</b></center></td>
            <td><center><b>Tenggang Waktu</b></center></td>
        </tr>
        <tr>
            <td>1</td>
            <td>Rp. 5.000.000,00</td>
            <td>31 Oktober 2022</td>
        </tr>
        <tr>
            <td>2</td>
            <td>Rp. 5.000.000,00</td>
            <td>31 Desember 2022</td>
        </tr>
        <tr>
            <td>3</td>
            <td>Rp. 5.000.000,00</td>
            <td>28 Februari 2023</td>
        </tr>
        <tr>
            <td>4</td>
            <td>Rp. 3.500.000,00</td>
            <td>31 Mei 2023</td>
        </tr>
    </table>
    <p>Jika sudah melakukan pembayaran silahkan mengupload bukti pembayaran di menu Pembayaran pada website atau bisa <a style="color: black; text-decoration: none;" href="https://ppdb.smkmadinatulquran.sch.id/ppdb/pembayaran"><b>KLIK DISINI</b></a></p>
    <p style="color: red; font-weight: bold"><i>Note :</i></p>
    <p style="color: red; font-weight: bold"><i>Mohon Perhatian - Biaya Tagihan Uang Masuk yang sudah dibayarkan tidak dapat dikembalikan</i></p>
    @endsection