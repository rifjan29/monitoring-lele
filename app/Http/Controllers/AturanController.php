<?php

namespace App\Http\Controllers;

use App\Models\Aturan;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Contracts\DataTable;

class AturanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {

        return view('pages.aturan.index');
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
            'nm_rule' => 'required',
            'rule_ph' => 'required',
            'rule_suhu' => 'required',
            'keterangan' => 'required',

        ],
        [
            'required' => ':attribute data harus terisi'
        ],
        [
            'nm_rule' => 'nama rule',
            'rule_ph' => 'rule ph',
            'rule_suhu' => 'rule suhu',
            'keterangan' => 'keterangan',
        ]);

        try {
            $tambahdata = new Aturan;
            $tambahdata->nama_rule = $request->get('nm_rule');
            $tambahdata->ph = $request->get('rule_ph');
            $tambahdata->suhu = $request->get('rule_suhu');
            $tambahdata->keterangan = $request->get('keterangan');
            $tambahdata->save();
            return redirect()->route('aturan.index')->withStatus('Berhasil menyimpan data');
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
        $data = Aturan::find($id);
        return response()->json($data);
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
        // $request->validate([
        //     'nm_rule' => 'required',
        //     'rule_ph' => 'required',
        //     'rule_suhu' => 'required',
        //     'keterangan' => 'required',

        // ],
        // [
        //     'required' => ':attribute data harus terisi'
        // ],
        // [
        //     'nm_rule' => 'nama rule',
        //     'rule_ph' => 'rule ph',
        //     'rule_suhu' => 'rule suhu',
        //     'keterangan' => 'keterangan',
        // ]);

        try {
            $tambahdata = Aturan::find($id);
            $tambahdata->nama_rule = $request->get('nm_rule');
            $tambahdata->ph = $request->get('rule_ph');
            $tambahdata->suhu = $request->get('rule_suhu');
            $tambahdata->keterangan = $request->get('keterangan');
            $tambahdata->save();
            return response()->json(['success'=>'Aturan updated successfully']);

        } catch (Exception $e) {
            return redirect()->back()->withErrors('Terdapat kesalahan', $e);

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
            $delete = Aturan::find($id);
            $delete->delete();
            return response()->json(['success'],Response::HTTP_OK);
        } catch (Exception $e) {
            return response()->json($e, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    public function getData()
    {
        $data = Aturan::get();
        if (request()->ajax()) {
            return datatables()->of($data)
            ->addColumn('Action',function($data){
                return '<button type="button" class="btn btn-success btn-sm" id="getEditAturanData" data-id="'.$data->id.'">Edit</button>
                <button type="button" data-id="'.$data->id.'" class="btn btn-danger btn-sm" id="getDeleteId">Delete</button>';
            })
            ->rawColumns(['Action'])
            ->make(true);
        }
    }

}
