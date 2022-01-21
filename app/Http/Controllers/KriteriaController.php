<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Contracts\DataTable;

class KriteriaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Kriteria::get();
        if (request()->ajax()) {
            return datatables()->of($data)
            ->addColumn('Action',function($data)
            {
                return '<button type="button" class="btn btn-success btn-sm" id="getEditKriteriaData" data-id="'.$data->id.'">Edit</button>
                <button type="button" data-id="'.$data->id.'" class="btn btn-danger btn-sm" id="getDeleteId">Delete</button>';
            })
            ->rawColumns(['Action'])
            ->make(true);
        }
        return view('pages.kriteria.index');
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
        $request->validate([
            'nl_bawah' => ['required','integer'],
            'nl_tengah' => ['required','integer'],
            'nl_atas' => ['required','integer'],
            'nm_kriteria' => 'required',
            'nm_bawah' => 'required',
            'nm_tengah' => 'required',
            'nm_atas' => 'required',
        ],[
            'required' => ':attribute  Data Harus Terisi'
        ],[
            'nl_bawah' => 'Nilai Bawah',
            'nl_tengah' => 'Nilai Tengah',
            'nl_atas' => 'Nilai Atas',
            'nm_kriteria' => 'Nama Kriteria',
            'nm_bawah' => 'Nama Bawah',
            'nm_tengah' => 'Nama Tengah',
            'nm_atas' => 'Nama Atas',
        ]);
        try {
            $tambahdata = new Kriteria;
            $tambahdata->nama_kriteria = $request->get('nm_kriteria');
            $tambahdata->nilai_bawah = $request->get('nl_bawah');
            $tambahdata->nilai_tengah = $request->get('nl_tengah');
            $tambahdata->nilai_atas = $request->get('nl_atas');
            $tambahdata->nama_bawah = $request->get('nm_bawah');
            $tambahdata->nama_tengah = $request->get('nm_tengah');
            $tambahdata->nama_atas = $request->get('nm_atas');
            $tambahdata->save();
            return redirect()->route('kriteria.index')->withStatus('Berhasil menyimpan data');
        } catch (Exception $e) {
            return redirect()->back()->withErrors('Terdapat kesalahan', $e);
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
        $data = Kriteria::find($id);
        // $data = $kriteria->findData($id);
        // return $data;
        // $html = '<div class="form-group">
        //         <label for="Title">Title:</label>
        //         <input type="text" class="form-control" name="title" id="editTitle" value="'.$data->title.'">
        //     </div>
        //     <div class="form-group">
        //         <label for="Name">Description:</label>
        //         <textarea class="form-control" name="description" id="editDescription">'.$data->description.'
        //         </textarea>
        //     </div>';
        $html = '<div class="row">
                <div class="col-lg-8">
                    <div class="mb-3">
                        <label for="nama_kriteria" class="form-label">Nama Kriteria</label>
                        <input type="text" name="nama_kriteria" id="id_nama_kriteria" class="form-control" value="'.$data->nama_kriteria.'" autofocus>
                    </div>
                </div>
                </div>
                <div class="form-group row">
                    <div class="col-lg-4">
                        <div class="mb-3">
                            <label for="nilai_bawah" class="form-label">Nilai Bawah</label>
                            <input type="number" name="nilai_bawah" class="form-control " id="id_nilai_bawah" value="'.$data->nilai_bawah.'" aria-describedby="emailHelp" autofocus>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="mb-3">
                            <label for="nilai_tengah" class="form-label">Nilai Tengah</label>
                            <input type="number" name="nilai_tengah" class="form-control" id="id_nilai_tengah" value="'.$data->nilai_tengah.'" aria-describedby="emailHelp">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="mb-3">
                            <label for="nilai_atas" class="form-label">Nilai Atas</label>
                            <input type="number" name="nilai_atas" class="form-control" id="id_nilai_atas" value="'.$data->nilai_atas.'" aria-describedby="emailHelp">
                        </div>
                    </div>
                </div>
                <div class="form-group row mt-3">
                    <div class="col-lg-4">
                        <div class="mb-3">
                            <label for="nama_bawah" class="form-label">Nama Bawah</label>
                            <input type="text" name="nama_bawah" class="form-control" id="id_nama_bawah" value="'.$data->nama_bawah.'" aria-describedby="emailHelp" autofocus>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="mb-3">
                            <label for="nama_tengah" class="form-label">Nama Tengah</label>
                            <input type="text" name="nama_tengah" class="form-control" id="id_nama_tengah" value="'.$data->nama_tengah.'" aria-describedby="emailHelp">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="mb-3">
                            <label for="nama_atas" class="form-label">nama Atas</label>
                            <input type="text" name="nama_atas" class="form-control" id="id_nama_atas" value="'.$data->nama_atas.'" aria-describedby="emailHelp">
                        </div>
                    </div>
                </div>';
        return response()->json(['html'=>$html]);
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
        // $validator = Validator::make($request->all(),[
        //     'nilai_bawah' => ['required','integer'],
        //     'nilai_tengah' => ['required','integer'],
        //     'nilai_atas' => ['required','integer'],
        //     'nama_kriteria' => 'required',
        //     'nama_bawah' => 'required',
        //     'nama_tengah' => 'required',
        //     'nama_atas' => 'required',
        // ]);
        $request->validate([
            'nilai_bawah' => ['required','integer'],
            'nilai_tengah' => ['required','integer'],
            'nilai_atas' => ['required','integer'],
            'nama_kriteria' => 'required',
            'nama_bawah' => 'required',
            'nama_tengah' => 'required',
            'nama_atas' => 'required',
        ],[
            'required' => ':attribute  Data Harus Terisi'
        ],[
            'nilai_bawah' => 'Nilai Bawah',
            'nilai_tengah' => 'Nilai Tengah',
            'nilai_atas' => 'Nilai Atas',
            'nama_kriteria' => 'Nama Kriteria',
            'nama_bawah' => 'Nama Bawah',
            'nama_tengah' => 'Nama Tengah',
            'nama_atas' => 'Nama Atas',
        ]);
        // if ($validator->fails()) {
        //     return response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        // }
        try {
            $updateData = Kriteria::find($id);
            $updateData->nama_kriteria = $request->get('nama_kriteria');
            $updateData->nilai_bawah = $request->get('nilai_bawah');
            $updateData->nilai_tengah = $request->get('nilai_tengah');
            $updateData->nilai_atas = $request->get('nilai_atas');
            $updateData->nama_bawah = $request->get('nama_bawah');
            $updateData->nama_tengah = $request->get('nama_tengah');
            $updateData->nama_atas = $request->get('nama_atas');
            $updateData->save();
            // return redirect()->route('kriteria.index')->withStatus('Berhasil menyimpan data');
            return response()->json(['success'=>'Kriteria updated successfully']);
        } catch (Exception $e) {
            return response()->json($e, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $delete = Kriteria::find($id);
            $delete->delete();
            return response()->json(['success'],Response::HTTP_OK);
        } catch (Exception $e) {
            return response()->json($e, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
