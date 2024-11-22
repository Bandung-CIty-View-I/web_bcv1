<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use App\Models\User;
use Hash;
use Exception;

class UserImportController extends Controller
{
    public function showForm()
    {
        return view('import', [
            "title" => "Import Excel"
        ]); // Menampilkan form untuk upload file Excel

    }

    public function downloadTemplate()
    {
        // Buat spreadsheet baru
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Definisikan header kolom
        $sheet->setCellValue('A1', 'Nama');
        $sheet->setCellValue('B1', 'Email');
        $sheet->setCellValue('C1', 'Blok / Cluster');
        $sheet->setCellValue('D1', 'Nomor Kavling');
        $sheet->setCellValue('E1', 'No. HP');
        $sheet->setCellValue('F1', 'RT');
        $sheet->setCellValue('G1', 'IPL');
        $sheet->setCellValue('H1', 'ID Pelanggan Online');

        // Membuat writer dan simpan ke file
        $writer = new Xlsx($spreadsheet);

        // Set nama file yang akan didownload
        $fileName = 'template_import.xlsx';

        // Buat response untuk mengunduh file
        return response()->stream(
            function() use ($writer) {
                $writer->save('php://output');
            },
            200,
            [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'Content-Disposition' => 'attachment; filename="template_import.xlsx"',
            ]
        );
    }

    public function import(Request $request)
    {
        // Validasi file yang diupload
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:2048',
        ]);

        try {
            $file = $request->file('file');
            $spreadsheet = IOFactory::load($file);
            $sheet = $spreadsheet->getActiveSheet();
            $data = $sheet->toArray(null, true, true, true);

            // Proses data, misalnya mengimport ke database
            foreach ($data as $row) {
                // Menyaring dan memetakan data berdasarkan kolom yang diperlukan
                $normalizedPhoneNumber = $this->normalizePhoneNumber($row['E']); // Normalisasi nomor HP
                $password = $this->generatePassword($normalizedPhoneNumber, $row['H']); // Generate password berdasarkan nomor HP yang sudah dinormalisasi dan id_pelanggan_online

                // Pastikan tidak ada duplikasi berdasarkan nomor HP atau ID Pelanggan Online
                $existingUser = User::where('no_hp', $normalizedPhoneNumber)
                                    ->orWhere('id_pelanggan_online', $row['H'])
                                    ->first();

                if ($existingUser) {
                    continue; // Jika sudah ada, lewati baris ini
                }

                User::create([
                    'nama' => $row['A'], // Kolom nama
                    'email' => $row['B'] ?? null, // Kolom email, bisa null
                    'blok_cluster' => $row['C'] ?? null, // Kolom blok/cluster, bisa null
                    'nomor_kavling' => $row['D'], // Kolom nomor kavling
                    'no_hp' => $normalizedPhoneNumber, // Kolom nomor HP, yang sudah dinormalisasi
                    'rt' => $row['F'], // Kolom RT
                    'ipl' => $row['G'], // Kolom IPL
                    'password' => Hash::make($password), // Password default gabungan nomor HP yang sudah dinormalisasi dan id_pelanggan_online
                    'role' => 'warga', // Set role default 'warga'
                    'id_pelanggan_online' => $row['H'], // Kolom ID Pelanggan Online
                ]);
            }

            return back()->with('success', 'Data berhasil diimport!');
        } catch (Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // Fungsi untuk menormalisasi nomor HP agar diawali dengan '08'
    private function normalizePhoneNumber($phoneNumber)
    {
        // Menghapus karakter non-numerik
        $phoneNumber = preg_replace('/\D/', '', $phoneNumber);

        // Mengubah awalan nomor HP
        if (substr($phoneNumber, 0, 2) == '62') {
            $phoneNumber = '08' . substr($phoneNumber, 2); // Mengubah awalan 62 menjadi 08
        } elseif (substr($phoneNumber, 0, 1) == '8') {
            $phoneNumber = '08' . substr($phoneNumber, 1); // Menambahkan awalan 08 jika dimulai dengan 8
        }

        return $phoneNumber;
    }

    // Fungsi untuk membuat password dari gabungan no_hp yang sudah dinormalisasi dan id_pelanggan_online
    private function generatePassword($normalizedPhoneNumber, $idPelangganOnline)
    {
        // Gabungkan nomor HP yang sudah dinormalisasi dan ID Pelanggan Online untuk password
        return $normalizedPhoneNumber . $idPelangganOnline;
    }
}
