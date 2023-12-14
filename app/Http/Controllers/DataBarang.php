<?php

namespace App\Http\Controllers;

class DataBarang extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function index(){

        $response = [
            "success" => true,
            "message" => "List Poli",
            "data" => [
                "data",
                "barang"
            ],
        ];

        return response()->json($response, 200);
    }
}
