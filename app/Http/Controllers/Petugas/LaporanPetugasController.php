<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LaporanTransaksiExport;

class LaporanPetugasController extends Controller
{
    /**
     * Menampilkan halaman laporan
     */
    public function index()
    {
        // Statistik sederhana untuk hari ini
        $hariIni = Carbon::today();
        
        $totalTransaksiHariIni = Peminjaman::whereDate('created_at', $hariIni)->count();
        $dikembalikanHariIni = Peminjaman::where('status', 'dikembalikan')
            ->whereDate('updated_at', $hariIni)
            ->count();
        $totalDendaHariIni = Peminjaman::whereDate('updated_at', $hariIni)
            ->sum('denda');
        
        return view('petugas.laporan.index', compact(
            'totalTransaksiHariIni',
            'dikembalikanHariIni',
            'totalDendaHariIni'
        ));
    }

    /**
     * Generate laporan transaksi
     */
    public function generate(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'format' => 'required|in:pdf,excel,print'
        ]);

        $startDate = Carbon::parse($request->start_date)->startOfDay();
        $endDate = Carbon::parse($request->end_date)->endOfDay();

        // Ambil data transaksi
        $transaksi = Peminjaman::with(['user', 'barang', 'barang.kategori'])
            ->whereBetween('created_at', [$startDate, $endDate])
            ->orderBy('created_at', 'desc')
            ->get();

        // Hitung statistik
        $statistik = [
            'total' => $transaksi->count(),
            'menunggu' => $transaksi->where('status', 'menunggu')->count(),
            'disetujui' => $transaksi->where('status', 'disetujui')->count(),
            'dipinjam' => $transaksi->where('status', 'dipinjam')->count(),
            'dikembalikan' => $transaksi->where('status', 'dikembalikan')->count(),
            'ditolak' => $transaksi->where('status', 'ditolak')->count(),
            'total_denda' => $transaksi->sum('denda'),
        ];

        $periode = Carbon::parse($request->start_date)->format('d/m/Y') . ' - ' . 
                   Carbon::parse($request->end_date)->format('d/m/Y');

        // Handle format output
        switch ($request->format) {
            case 'pdf':
                $pdf = Pdf::loadView('petugas.laporan.pdf', compact('transaksi', 'statistik', 'periode'));
                return $pdf->download('laporan-transaksi-' . Carbon::now()->format('Y-m-d') . '.pdf');
            
            case 'excel':
                return Excel::download(
                    new LaporanTransaksiExport($transaksi, $statistik, $periode),
                    'laporan-transaksi-' . Carbon::now()->format('Y-m-d') . '.xlsx'
                );
            
            case 'print':
                return view('petugas.laporan.print', compact('transaksi', 'statistik', 'periode'));
        }
    }
}