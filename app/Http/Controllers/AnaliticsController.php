<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\ResponseHelper;
use App\Models\Citizen;
use App\Models\Complaint;
use App\Models\SosialAssistanceApplicant;
use App\Models\User;

class AnaliticsController extends Controller
{
    public function index()
    {
        $data = [
            'citizens' => [
                'gender' => [
                    'male'      => Citizen::where('gender', 'male')->count(),
                    'female'      => Citizen::where('gender', 'female')->count(),
                ],

                'status' => [
                    'active'   => Citizen::where('status','active')->count(),
                    'moved'     => Citizen::where('status', 'moved')->count(),
                    'deceased'  => Citizen::where('status', 'decased')->count(),
                ],

                'marital_status'    => [
                    'single'     => Citizen::where('marital_status','single')->count(),
                    'married'   => Citizen::where('marital_status', 'married')->count(),
                ],

                ],
                'complaints' => [
                    'pending'   => Complaint::where('status', 'pending')->count(),
                    'process'  => Complaint::where('status','process')->count(),
                    'resolved'  => Complaint::where('status', 'resolved')->count(),
                    'rejected'  => Complaint::where('status', 'rejected')->count(),
                ],

                'sosial_assistance_applicant' => [
                    'pending'   => SosialAssistanceApplicant::where('status', 'pending')->count(),
                    'approved'  => SosialAssistanceApplicant::where('status', 'approved')->count(),
                    'rejected'  => SosialAssistanceApplicant::where('status', 'rejected')->count(),
                ],

                'users' => [
                    'admin'     => User::role('admin')->count(),
                    'headman'   => User::role('headman')->count(),
                ],
        ];

        return ResponseHelper::jsonResponse(true, 'Data analitik berhasil diambil', $data, 200);
    }
}
