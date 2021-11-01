<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;

class TugasPakNurExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return User::with('calonSiswa')
        ->with('pendidikanSebelumnya')
        ->with('dataAyah')
        ->with('dataIbu')
        ->with('dataWali')
        ->with('prestasiBelajar')
        ->with('prestasiSmp')
        ->with('bukti')
        ->get();
    }
}
