<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
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
