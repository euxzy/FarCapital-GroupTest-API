<?php

namespace App\Http\Controllers;

use App\Models\Aspiration;
use Illuminate\Http\Request;

class AspirationController extends Controller
{
    public function index()
    {
        $aspirations = Aspiration::query()->get();

        return response()->json([
            'status' => true,
            'message' => 'Get All Aspirations Success!',
            'data' => $aspirations
        ]);
    }

    function detail($id)
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
            "message" => "",
            "data" => $aspiration
        ]);
    }

    public function store(Request $request)
    {
        $payload = $request->all();

        $columns = ["aspirator", "nik", "story", "photo", "is_read"];
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

        $author = Aspiration::create($payload);
        return response()->json([
            "status" => true,
            "message" => "Aspirasi berhasil ditambahkan",
            "data" => $author->makeHidden([
                "id",
                "created_at",
                "updated_at"
            ])
        ]);
    }
}
