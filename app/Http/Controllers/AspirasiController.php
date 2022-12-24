<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AspirationController extends Controller
{
    function store(Request $request)
    {
        $payload = $request->all();
        
        $columns = ["aspirator", "nik", "story", "photo", "is_read"];
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

        $payload['photo'] = $request->file("photo")->store("images", "public");
        
        $author = Aspirasi::create($payload);
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
