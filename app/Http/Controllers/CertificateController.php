<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class CertificateController extends Controller
{

    public function index()
    {
        return view('dashboard.sertifikasi.index');
    }

    /**
     * Handle the incoming request.
     */
    public function datatable($uuid)
    {
        $asesi = Asesi::firstWhere('uuid',$uuid);
        $data = KelompokAsesor::with(['skema','event','kelas','asesor.user'])
        ->where('kelas_id', $asesi['kelas_id'])
        ->latest()
        ->get();
        return response()->json(['status' => 'success', 'data' => $data], 200);
    }

    public function generateCertificate()
    {
        // Pastikan direktori 'certificates' ada
        $certificateDir = public_path('certificates');
        if (!File::exists($certificateDir)) {
            File::makeDirectory($certificateDir, 0755, true);
        }

        // Data untuk diisi pada view
        $data = [
            'name' => 'Moh. Ali Fikri',
            'noreg' => 'No. Reg. TIK 1565 04115 2024',
            'skill' => 'Pemasaran Digital',
            'skill2' => 'Social Media Marketing',
            'location' => 'Yogyakarta, 22 Februari 2024',
        ];

        // Temukan nomor urut yang belum ada
        $i = 1;
        do {
            $pdfFileName = sprintf('NAMADOKUMEN-%02d.pdf', $i);
            $pdfPath = $certificateDir . '/' . $pdfFileName;
            $i++;
        } while (File::exists($pdfPath));

        // Render tampilan HTML menjadi PDF
        $pdf = Pdf::loadView('certificate.index', $data)->setPaper('A4', 'portrait');

        // Simpan PDF ke dalam folder public/certificates
        $pdf->save($pdfPath);

        return response()->json(['message' => 'PDF has been generated successfully!', 'pdf_path' => $pdfPath]);
    }
}
