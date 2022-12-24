<?php

namespace App\Http\Controllers;

use App\Models\Aspiration;
use Illuminate\Http\Request;

class AspirationController extends Controller
{
    public function index()
    {
        /**
         * Mengambil semua data yang diurutkan dari yang terbaru
         */
        $aspirations = Aspiration::latest()->get();

        return response()->json([
            'status' => true,
            'message' => 'Mengambil semua data aspirasi berhasil!',
            'data' => $aspirations->makeHidden([
                'updated_at',
            ])
        ]);
    }

    public function show($id)
    {
        $aspiration = Aspiration::find($id);

        /**
         * Memeriksa apakah terdapat aspirasi dengan id sesuai yang diberikan
         */
        if (!isset($aspiration)) {
            return response()->json([
                "status" => false,
                "message" => "Aspirasi tidak ditemukan",
                "data" => null
            ]);
        }

        return response()->json([
            "status" => true,
            "message" => "Detail Aspirasi",
            "data" => $aspiration->makeHidden([
                "updated_at",
            ])
        ]);
    }

    public function showByStatus($status)
    {
        /**
         * Jika parameter yang dikirim dibaca, maka statusId akan
         * di set ke 1, jika 0 maka statusId akan di set ke 0,
         * dan jika bukan keduanya, maka akan return false
         */
        if ($status == 'dibaca') {
            $statusId = 1;
        } else if ($status == 'belum') {
            $statusId = 0;
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Input yang kamu masukkan salah!',
                'data' => null
            ]);
        }

        /**
         * Mengambil data berdasarkan status is_read dan diurutkan berdasarkan data terbaru
         */
        $aspirations = Aspiration::query()->where('is_read', $statusId)->latest()->get();

        /**
         * Jika statusId 0, maka akan retun data yang belum dibaca
         */
        if ($statusId == 0) {
            return response()->json([
                'status' => true,
                'message' => 'Daftar aspirasi yang belum dibaca!',
                'data' => $aspirations->makeHidden([
                    'updated_at',
                ])
            ]);
        }

        /**
         * Return data yang sudah dibaca
         */
        return response()->json([
            'status' => true,
            'message' => 'Daftar aspirasi yang sudah dibaca!',
            'data' => $aspirations->makeHidden([
                'updated_at',
            ])
        ]);
    }

    public function store(Request $request)
    {
        /**
         * Mengambil semua requst yang dikirim
         */
        $payload = $request->all();

        /**
         * Memeriksa apakah ada data yang belum diisi
         * Jika ada data kyang belum diisi, maka
         * akan return false
         */
        $columns = ["aspirator", "nik", "story", "photo"];
        foreach ($columns as $col) {
            if (!isset($payload[$col])) {
                $message = "{$col} tidak boleh kosong";
                return response()->json([
                    "status" => false,
                    "message" => $message,
                    "data" => null
                ]);
            }
        }


        /**
         * Menyimpan file gambar ke public
         */
        $payload['photo'] = $request->file("photo")->store("images", "public");

        $aspiration = Aspiration::create($payload);
        return response()->json([
            "status" => true,
            "message" => "Aspirasi berhasil ditambahkan",
            "data" => $aspiration->makeHidden([
                "updated_at",
            ])
        ]);
    }

    public function update($id)
    {
        /**
         * Mengubah status is_read jika terdapat
         * trigger dari frontend
         */
        $payload = [
            'is_read' => 1
        ];

        /**
         * Cek apakah data yang dikirim ada atau tidak di database
         */
        $aspiration = Aspiration::query()->where('id', $id)->first();
        if (!$aspiration) {
            return response()->json([
                'status' => false,
                'message' => 'Aspirasi Tidak Ditemukan!',
                'data' => null
            ]);
        }

        $aspiration->update($payload);
        return response()->json([
            'status' => true,
            'message' => 'Aspirasi Sudah Dibaca',
            'data' => $aspiration->makeHidden([
                'updated_at',
            ])
        ]);
    }
}
