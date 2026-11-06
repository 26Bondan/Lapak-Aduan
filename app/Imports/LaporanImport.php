<?php

namespace App\Imports;

use App\Models\Laporan;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class LaporanImport implements ToCollection, WithHeadingRow
{
    /**
     * Baris header Excel ada di baris ke-4.
     * Karena WithHeadingRow menggunakan nomor baris mulai dari 1,
     * maka header Excel kita berada di row 4.
     */
    public function headingRow(): int
    {
        return 4;
    }

    /**
     * Membaca semua baris Excel dan menyimpannya ke database.
     */
    public function collection(Collection $rows): void
    {
        foreach ($rows as $row) {

            // Lewati baris kosong
            if (
                empty($row['no_tiket']) &&
                empty($row['isi_aduan'])
            ) {
                continue;
            }

            // Ambil nomor tiket
            $ticket = trim((string) ($row['no_tiket'] ?? ''));

            // Kalau nomor tiket kosong, jangan dimasukkan
            if ($ticket === '') {
                continue;
            }

            // Cegah data duplikat berdasarkan nomor tiket
            if (
                Laporan::where('ticket_number', $ticket)->exists()
            ) {
                continue;
            }

            // Isi aduan
            $isiAduan = trim(
                (string) ($row['isi_aduan'] ?? '')
            );

            // Kategori
            $kategori = trim(
                (string) ($row['kategori'] ?? '')
            );

            // Excel tidak memiliki kolom judul khusus.
            // Kita gunakan kategori sebagai judul.
            $judul = $kategori !== ''
                ? $kategori
                : 'Aduan Tahun 2022';

            // Excel tidak memiliki lokasi khusus.
            // Jangan mengarang lokasi.
            $lokasi = 'Data historis 2022';

            // Simpan data
            Laporan::create([

                // Data historis tidak memiliki akun user
                'user_id' => null,

                // Nomor tiket dari Excel
                'ticket_number' => $ticket,

                // Semua data ini dianggap sebagai aduan
                'jenis_layanan' => 'aduan',

                // Judul menggunakan kategori
                'judul' => $judul,

                // Isi laporan
                'deskripsi' => $isiAduan,

                // Lokasi default untuk data historis
                'lokasi' => $lokasi,

                // Status
                'status' => $this->normalizeStatus(
                    $row['status'] ?? 'pending'
                ),

                // Tanggal aduan
                'tgl_aduan' => $this->parseDate(
                    $row['tgl_aduan'] ?? null
                ),

                // Data Excel lainnya
                'kategori' => $kategori !== ''
                    ? $kategori
                    : null,

                'media' => $this->nullableString(
                    $row['media'] ?? null
                ),

                'opd' => $this->nullableString(
                    $row['opd'] ?? null
                ),

                'balasan' => $this->nullableString(
                    $row['balasan'] ?? null
                ),

                'tgl_balasan' => $this->parseDate(
                    $row['tgl_balasan'] ?? null
                ),

                'tindak_lanjut' => $this->nullableString(
                    $row['tindak_lanjut'] ?? null
                ),

                'tanggal_tindak_lanjut' => $this->parseDate(
                    $row['tanggal_tindak_lanjut'] ?? null
                ),

                'bintang' => $this->parseRating(
                    $row['bintang'] ?? null
                ),
            ]);
        }
    }

    /**
     * Mengubah status Excel menjadi status yang digunakan aplikasi.
     */
    private function normalizeStatus($status): string
    {
        $status = strtolower(
            trim((string) $status)
        );

        return match ($status) {

            'selesai' => 'selesai',

            'diproses',
            'proses',
            'sedang diproses' => 'diproses',

            'pending',
            'menunggu' => 'pending',

            default => 'pending',
        };
    }

    /**
     * Mengubah nilai kosong menjadi NULL.
     */
    private function nullableString($value): ?string
    {
        if ($value === null) {
            return null;
        }

        $value = trim((string) $value);

        return $value === ''
            ? null
            : $value;
    }

    /**
     * Membaca nilai bintang dari Excel.
     */
    private function parseRating($value): ?int
    {
        if ($value === null || $value === '') {
            return null;
        }

        $rating = (int) $value;

        return ($rating >= 1 && $rating <= 5)
            ? $rating
            : null;
    }

    /**
     * Mengubah tanggal Excel menjadi Carbon.
     */
    private function parseDate($value): ?Carbon
    {
        if ($value === null || $value === '') {
            return null;
        }

        try {

            // Jika Excel menyimpan tanggal sebagai angka serial
            if (is_numeric($value)) {

                return Carbon::instance(
                    \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject(
                        $value
                    )
                );
            }

            // Jika tanggal berupa teks
            return Carbon::parse($value);

        } catch (\Throwable $e) {

            // Jika tanggal tidak bisa dibaca,
            // simpan sebagai NULL agar import tidak berhenti.
            return null;
        }
    }
}