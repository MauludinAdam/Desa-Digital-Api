<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\ResponseHelper;
use App\Models\Citizen;
use App\Models\User;
use App\Models\FamilyCard;
use App\Models\Complaint;
use App\Models\SosialAssistanceApplicant;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [
            'user'                          => User::count(),
            'citizen'                       => Citizen::count(),
            'family_card'                   => FamilyCard::count(),
            'complaint'                     => Complaint::count(),
            'sosial_assistance_applicant'   => SosialAssistanceApplicant::count(),
        ];

        return ResponseHelper::jsonResponse(true, 'Data dashboard berhasil diambil', $data, 200);
    }
}
