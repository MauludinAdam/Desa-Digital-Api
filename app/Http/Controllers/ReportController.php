<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\ResponseHelper;
use App\Models\Citizen;
use App\Models\FamilyCard;
use App\Models\Complaint;
use App\Models\SosialAssistanceApplicant;

class ReportController extends Controller
{
    public function citizen(Request $request)
    {
        $query = Citizen::query();

        if($request->filled('status')){
            $query->where('status', $request->status);
        }

        if($request->filled('gender')){
            $query->where('gender', $request->gender);
        }

        if($request->filled('marital_status')){
            $query->where('marital_status', $request->marital_status);
        }

        $citizen = $query->with([
            'familyCard',
            'occupation',
            'education',
            'religion',
        ])->latest()->get();

        return ResponseHelper::jsonResponse(true, 'Report Data penduduk berhasil diambil', $citizen, 200);
    }

    public function familyCard(Request $request)
    {
        $query = FamilyCard::query();

        $familyCard = $query
        ->with('headOfFamily')
        ->latest()
        ->get();

        return ResponseHelper::jsonResponse(true, 'Data kartu keluarga berhasil diambil', $familyCard, 200);
    }

    public function complaint(Request $request)
    {
        $query = Complaint::query();

       if($request->filled('status')){
        $query->where('status', $request->status);
       }

       $complaint = $query
       ->with([
        'citizen',
        'respondedBy',
       ])
       ->latest()
       ->get();

       return ResponseHelper::jsonResponse(true, 'Data pengaduan berhasil diambil', $complaint, 200);
    }

    public function sosialAssistanceApplicant(Request $request)
    {
        $query = SosialAssistanceApplicant::query();

        if($request->filled('status')){
            $query->where('status', $request->status);
        }

        $sosialAssistanceApplicant = $query
        ->with([
            'sosialassistance',
            'citizen',
        ])->latest()->get();

        return ResponseHelper::jsonResponse(true, 'Data penerima bantuan sosial berhasil diambil', $sosialAssistanceApplicant, 200);
    }
}
