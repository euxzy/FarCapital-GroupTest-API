<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    function index()
    {
        $aspirations = Aspiration::orderBy('id', 'ASC')->get();
        return response()->json([
            "status" => true,
            "message" => "",
            "data" => $aspirations
        ]);
    }

    function detail($id)
    {
        $aspiration = Aspiration::find($id);

        // memeriksa apakah terdapat author dengan id sesuai yang diberikan
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

    function store(Request $request)
    {
        $payload = $request->all();
        
        $columns = ["email", "password"];
        foreach($columns as $col) {
            if (!isset($payload[$col])) {
                $message = "{$col} tidak boleh kosong";
                return response()->json([
                    "status" => false,
                    "message" => $message,
                    "data" => null
                ]);
            }
        }

        $admin = Admin::create($payload);
        return response()->json([
            "status" => true,
            "message" => "Admin berhasil ditambahkan",
            "data" => $admin->makeHidden([
                "id",
                "created_at",
                "updated_at"
            ])
        ]);
    }
}
