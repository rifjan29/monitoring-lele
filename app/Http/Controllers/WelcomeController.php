<?php

namespace App\Http\Controllers;

use App\Models\Arduino;
use App\Models\HasilAnalisa;
use App\Models\Kriteria;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    private $param;
    public function index()
    {
        $data = HasilAnalisa::orderBy('id','DESC')->first();
        $data_arduino = Arduino::orderBy('id','DESC')->first();
        $data_hasil = compact('data','data_arduino');
        return response()->json($data_hasil);

        // return view('welcome');

    }
    public function getData()
    {
        $data = HasilAnalisa::orderBy('id','DESC')->get();
        return response()->json($data);
    }
    public function getDataChart()
    {
        $data_banyak = Arduino::orderBy('id','ASC')->get();
        $data_update = Arduino::orderBy('id','DESC')->first();
        $data = compact('data_banyak','data_update');
        // $response = [
        //     'message' => 'data sukses',
        //     'data' => $data
        // ]
        return response()->json($data);
    }
}
