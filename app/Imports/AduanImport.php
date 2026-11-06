<?php

namespace App\Imports;

use App\Models\Aduan;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;
use Carbon\Carbon;

class AduanImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        $rawTanggal = $row['tanggal_aduan'] ?? $row['tanggal'] ?? null;
        $tanggalAduan = null;

        // 1. Ekstrak tarikh dari kolom Excel jika wujud
        if (!empty($rawTanggal)) {
            if (is_numeric($rawTanggal)) {
                $tanggalAduan = ExcelDate::excelToDateTimeObject($rawTanggal)->format('Y-m-d H:i:s');
            } else {
                try {
                    $tanggalAduan = Carbon::parse($rawTanggal)->format('Y-m-d H:i:s');
                } catch (\Exception $e) {
                    $tanggalAduan = null;
                }
            }
        }

        $tiket = $row['ticket_number'] ?? $row['ticket'] ?? $row['nomor_tiket'] ?? '';
        $lokasi = $row['lokasi'] ?? '';

        // 2. Jika tarikh kosong, kesan tahun dari nombor tiket (contoh f22...) atau teks lokasi
        if (!$tanggalAduan) {
            if (str_contains($tiket, 'f22') || str_contains($lokasi, '2022')) {
                $tanggalAduan = '2022-01-01 00:00:00';
            } elseif (str_contains($tiket, 'f23') || str_contains($lokasi, '2023')) {
                $tanggalAduan = '2023-01-01 00:00:00';
            } elseif (str_contains($tiket, 'f24') || str_contains($lokasi, '2024')) {
                $tanggalAduan = '2024-01-01 00:00:00';
            } elseif (str_contains($tiket, 'f25') || str_contains($lokasi, '2025')) {
                $tanggalAduan = '2025-01-01 00:00:00';
            } else {
                $tanggalAduan = now();
            }
        }

        return new Aduan([
            'user_id'       => auth()->id() ?? 1,
            'ticket_number' => !empty($tiket) ? $tiket : ('LAP-' . date('Ymd') . '-' . strtoupper(\Str::random(5))),
            'judul_aduan'   => $row['judul_aduan'] ?? $row['judul'] ?? 'Tanpa Judul',
            'isi_aduan'     => $row['isi_aduan'] ?? $row['isi'] ?? $row['deskripsi'] ?? '-',
            'kategori'      => $row['kategori'] ?? 'Bidang Jalan dan Drainase',
            'sub_kategori'  => $row['sub_kategori'] ?? null,
            'lokasi'        => $row['lokasi'] ?? 'Banyumas',
            'status'        => strtolower($row['status'] ?? 'pending'),
            'tanggal_aduan' => $tanggalAduan,
            'created_at'    => $tanggalAduan, // Disimpan mengikut tahun sebenar!
        ]);
    }
}