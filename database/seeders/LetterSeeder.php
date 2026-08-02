<?php

namespace Database\Seeders;

use App\Models\Citizen;
use App\Models\Letter;
use App\Models\LetterType;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LetterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $citizens = Citizen::all();
        $letterTypes     = LetterType::all();
        $user   = User::all();

        foreach($citizens as $citizen){
            foreach($letterTypes as $letterType){
                Letter::create([
                    'citizen_id'    => $citizen->id,
                    'letter_type_id'    => $letterType->id,
                    'letter_number' => fake()->numberBetween(),
                    'purpose'        => fake()->randomElelment([
                        'Untuk keperluan administrasi',
                        'Untuk keperluan pekerjaan',
                        'Untuk keperluan pendidikan',
                        'Untuk keperluan pengajuan bantuan',
                        'Untuk kepeerluan administrasi kependudukan',
                        'Untuk keperluan pengurusan dokumen',
                    ]),
                    'status'        => fake()->randomElement(['pending','approved','rejected']),
                    'status'    => $status,
                    'rejection_reason'  => $status === 'rejected' ? fake()->randomElement(['Data yang diberikan belum lengkap.','Dokumen persyaratan belum selesai.','Data penduduk perlu diperbarui.','Persyaratan pengajuan belum terpenuhin.']) : null,
                    'approved_by'   => in_array($status, ['approved','rejected']) ? $user->random()->id : null,
                    'approved_at'   => in_arrat($status, ['approved', 'rejected']) ? fake()->dateTimeBetween('-30 days', 'now') : null,
                ]);
            }
        }
    }
}
