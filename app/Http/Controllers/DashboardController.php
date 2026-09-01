<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Models\Citizen;
use App\Models\User;
use App\Models\FamilyCard;
use App\Models\Letter;
use App\Models\SosialAssistanceApplicant;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $gender = Citizen::select('gender', DB::raw('COUNT(*) as total'))
        ->groupBy('gender')
        ->get();

        $education = Citizen::select('education_id', DB::raw('COUNT(*) as total'))
        ->with('education:id,name')
        ->groupBy('education_id')
        ->get();

        $age = [
            '0-5' => Citizen::whereRaw(
                'TIMESTAMPDIFF(YEAR, date_of_birth, CURDATE()) BETWEEN 0 AND 5'
            )->count(),

            '6-17' => Citizen::whereRaw(
                'TIMESTAMPDIFF(YEAR, date_of_birth, CURDATE()) BETWEEN 6 AND 17'
            )->count(),

            '18-35' => Citizen::whereRaw(
                'TIMESTAMPDIFF(YEAR, date_of_birth, CURDATE()) BETWEEN 18 AND 35'
            )->count(),

            '36-60' => Citizen::whereRaw(
                'TIMESTAMPDIFF(YEAR, date_of_birth, CURDATE()) BETWEEN 36 AND 60'
            )->count(),

            '>60' => Citizen::whereRaw(
                'TIMESTAMPDIFF(YEAR, date_of_birth, CURDATE()) > 60'
            )->count()
        ];

        $letter = [
            'pending' => Letter::where('status', 'pending')->count(),
            'success' => Letter::where('status', 'success')->count(),
            'reject'  => Letter::where('status', 'reject')->count(),  
        ];

        $data = [
            'user'                          => User::count(),
            'citizen'                       => Citizen::count(),
            'family_card'                   => FamilyCard::count(),
            'sosial_assistance_applicant'   => SosialAssistanceApplicant::count(),
            'gender'                        => $gender,
            'education'                     => $education,
            'age'                           => $age,
            'letter'                        => $letter,
        ];

        return ResponseHelper::jsonResponse(true, 'Data dashboard berhasil diambil', $data, 200);
    }
}
