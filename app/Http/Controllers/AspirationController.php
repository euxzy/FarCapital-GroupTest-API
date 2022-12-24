<?php

namespace App\Http\Controllers;

use App\Models\Aspiration;
use Illuminate\Http\Request;

class AspirationController extends Controller
{
    public function index()
    {
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

        // memeriksa apakah terdapat aspirasi dengan id sesuai yang diberikan
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

        $aspirations = Aspiration::query()->where('is_read', $statusId)->get();

        if ($statusId == 0) {
            return response()->json([
                'status' => true,
                'message' => 'Daftar aspirasi yang belum dibaca!',
                'data' => $aspirations->makeHidden([
                    'updated_at',
                ])
            ]);
        }

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
        $payload = $request->all();

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
        $payload = [
            'is_read' => 1
        ];

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
