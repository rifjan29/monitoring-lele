<?php

namespace App\Http\Controllers;

use App\Models\Arduino;
use App\Models\Aturan;
use App\Models\HasilAnalisa as ModelsHasilAnalisa;
use App\Models\Kriteria;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class ArduinoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $param;
    public function index()
    {
        $data = Arduino::orderBy('id','DESC')->get();
        return DataTables::of($data)->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request;
        // $addData = new Arduino;
        // $addData->suhu = $request->suhu;
        // $addData->ph = $request->ph;
        // $addData->save();
        // return $addData;
        $validator  = Validator::make($request->all(),[
            'suhu' => 'required',
            'ph' => 'required',
        ]);
        if ($validator->fails()) {
         return response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);

        }
        try {
            // $addData = Arduino::create($request->all());
            // return $request->all();
            $aturan = Aturan::select('keterangan')->get();
            $addData = new Arduino;
            $addData->suhu = $request->suhu;
            $addData->ph = $request->ph;
            $addData->save();
            $lasId = $addData->id;
            $response = [
                'message' => 'Berhasil Input data',
                'data' => $addData
            ];

            $data = Arduino::select('*')->where('id',$lasId)->first();
            $dataNilaiph = Kriteria::select('*')->where('nama_kriteria','ph')->first();

            $ph = $data->ph;
            $suhu = $data->suhu;
            // return $ph;
            $nama_kriteria = '';
            // ----Fungsi keanggotaan ph-----
            // jika asam
            if ($ph <= 5) {
                $miu1 = 1;
            }elseif ($ph < 5 && $ph < 5.5) {
                $miu1 = (5.5 - $ph) / 0.5;
            }elseif($ph >= 5.5){
                $miu1 = 0;
            }
            // end asam
            // jika netral
            if ($ph <= 5 || $ph >= 9) {
                $miu2 = 0;
            }elseif ( 5 <= $ph  && $ph <= 6) {
                $miu2 = ($ph-5)/1;
                $miu2 =  round($miu2,0,PHP_ROUND_HALF_UP);
            }elseif(6 < $ph && $ph < 9) {
                $miu2 = (9 - $ph) / 3;
            }
            // end netral
            // jika basa
            if ($ph <= 7.5) {
                $miu3 = 0;
            }elseif (7.5 <= $ph && $ph <= 9) {
                $miu3 = ($ph-7.5)/1.5;
            }elseif($ph >= 9) {
                $miu3 = 1;
            }
            // ----end Fungsi keanggotaan ph-----

            // ----Fungsi keanggotaan suhu-----
            // jika rendah
            if ($suhu <= 15) {
                $miu11 = 1;
            }elseif ($suhu < 15 && $suhu < 16 ) {
                $miu11 = (16 - $suhu) / 1;
            }elseif($suhu >= 16){
                $miu11 = 0;
            }
            // end jika rendah

            // jika tinggi
            if ($suhu <= 31.5) {
                $miu22 = 0;
            } elseif ($suhu < 31.5 && $suhu < 32) {
                $miu22 = ($suhu - 31.5) / 0.5;
            }elseif($suhu >= 32){
                $miu22 = 1;
            }
            // end jika tinggi

            // jika normal
            if ($suhu <= 15 || $suhu >= 32) {
                $miu33 = 0;
            } elseif ($suhu < 15 && $suhu < 16) {
                $miu33 = ($suhu - 15) / 1;
            } elseif ( 16 < $suhu && $suhu < 31.5) {
                $miu33 =  1;
            }elseif($suhu < 31.5 && $suhu < 32){
                $miu33 =  17 / $suhu;
            }

            // end jika normal
            // end fungsi kenaggotaan

            // Fungsi Pembentukan Basis Pengetahuan Fuzzy
            $z1 =0;
            $z2 =0;
            $z3 =0;
            $z4 =0;
            $z5 =0;
            $z6 =0;
            $z7 =0;
            $z8 =0;
            $z9 =0;
            $keterangan = '';
            $keterangan = $aturan[0]->keterangan;

            // rule 1
            $a1 = min($miu2,$miu11);
            if ($a1 == 1) {
                $z1 = 7;
            }elseif ($a1 == 0) {
                $z1 = 0;
            }else{
                $z1 = $a1 - ( 7 * 2);
            }
            if ($z1 > 0) {
                $keterangan = $aturan[0]->keterangan;
            }
            // rule 2
            $a2 = min($miu2, $miu33);
            if ($a2 == 0) {
                $z2 = 0;
            }else{
                $z2 = 16 - ($a2 * 7);
            }
            if ($z2 > 0) {
                $keterangan = $aturan[1]->keterangan;

            }
            // rule 3
            $a3 = min($miu2, $miu22);
            if ($a3 == 1) {
                $z3 = ($a3 + 7 ) / 2;
            }elseif ($a3 == 0) {
                $z3 = 0;
            }else{
                $z3 = ($a3 + 7 ) / 2;
            }
            if ($z3 > 0) {
                $keterangan = $aturan[2]->keterangan;

            }
            // rule 4
            $a4 = min($miu1, $miu11);
            if ($a4 == 0) {
                $z4 = 0;
            }else{
                $z4 = 32 - $a4;
            }
            if ($z4 > 0) {
                $keterangan = $aturan[3]->keterangan;

            }
            // rule 5
            $a5 = min($miu1, $miu33);
            if ($a5 == 1) {
                $z5 = 7;
            }elseif ($a5 == 0) {
                $z5 = 0;
            }else{
                $z5 = ($a5 + 7 ) / 2;
            }
            if ($z5 > 0) {
                $keterangan = $aturan[4]->keterangan;

            }
            // rule 6
            $a6 = min($miu1, $miu22);
            if ($a6 == 0) {
                $z6 = 0;
            }else{
                $z6 = 32 - $a6;
            }
            if ($z6 > 0) {
                $keterangan = $aturan[5]->keterangan;

            }
            // rule 7
            $a7 = min($miu3, $miu11);
            if ($a7 == 0) {
                $z7 = 0;
            }else{
                $z7 = 32 - $a7;
            }
            if ($z7 > 0) {
            $keterangan = $aturan[6]->keterangan;

            }
            // rule 8
            $a8 = min($miu3, $miu33);
            if ($a8 == 0) {
                $z8 = 0;
            }else{
                $z5 = ($a5 + 7 ) / 2;
            }
            if ($z8 > 0) {
                $keterangan = $aturan[7]->keterangan;

            }
            // rule 9
            $a9 = min($miu3, $miu22);
            if ($a9 == 0) {
                $z9 = 0;
            }else{
                // $a9 = 0;
                $z9 = 32 - $a9;
            }
            if ($z9 > 0) {
                $keterangan = $aturan[8]->keterangan;

            }
            // return $z9;
            //end Fungsi Pembentukan Basis Pengetahuan Fuzzy

            // start Defuzzykasi
            $hasilZ = ($a1 * $z1) + ($a2 * $z2) + ($a3 * $z3) + ($a4 * $z4) + ($a5 * $z5) + ($a6 * $z6) + ($a7 * $z7) + ($a8 * $z8) + ($a9 * $z9);
            $hasilApred = $a1 + $a2 + $a3 + $a4 + $a5 + $a6 + $a7 + $a8 + $a9;
            $totalRata = $hasilZ/$hasilApred;
            // end Defuzzykasi

            $dataKeanggotaan = compact('miu1','miu2','miu3','miu11','miu22','miu33');
            // $dataApred = compact('z1','z2','z3','z4','z5','z6','z7','z8','z9');
            $dataApred = compact('a1','a2','a3','a4','a5','a6','a7','a8','a9');
            $tambahAnalisa = new ModelsHasilAnalisa;
            $tambahAnalisa->nilai_asam = $miu1;
            $tambahAnalisa->nilai_netral = $miu2;
            $tambahAnalisa->nilai_basa = $miu3;
            $tambahAnalisa->nilai_rendah = $miu11;
            $tambahAnalisa->nilai_normal = $miu33;
            $tambahAnalisa->nilai_tinggi = $miu22;
            $tambahAnalisa->rata_rata = $totalRata;
            $tambahAnalisa->keterangan = $keterangan;
            $tambahAnalisa->save();
            return response()->json($response, Response::HTTP_OK);
        } catch (QueryException $e) {
            return $e;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    // tampil data
    public function tampiData()
    {
        $data = Arduino::orderBy('id','DESC')->get();
        $response = [
            'message' => 'Data seluruh arduino',
            'data' => $data,
        ];
        return response()->json($data);
    }
}
