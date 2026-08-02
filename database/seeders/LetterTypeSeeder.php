<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\LetterType;

class LetterTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $letterTypes = [
            [

                'name'          => "Surat keterangan domisili",
                'code'          => 'SKM',
                'description'   => 'Surat keterangan yang menerangkan domisili',
            ],
            [
                'name'          => 'Surat keterangan tidak mampu',
                'code'          => 'SKTM',
                'description'   => 'Surat keterangan yang menerangkan kondisi ekonomi',
            ],
            [
                'name'          => 'Surat keterangan usah',
                'code'          => 'SKU',
                'description'   => 'Surat keterangan yang menerangkan bahwa penduduk memiliki usaha',
            ],
            [
                'name'          => 'Surat pengantar',
                'code'          => 'Sp',
                'description'   => 'Surat pengantar untuk keperluan administrasi penduduk',
            ],
            [
                'name'          => 'Surat kelahiran',
                'code'          => 'SK',
                'description'   => 'Surat keterangan yang menerangkan peristiwa kelahiran penduduk',
            ],
        ];

       
        foreach($letterTypes as $letterType){
            letterType::create($letterType);
        }
        
    }
}
