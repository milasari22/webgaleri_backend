<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penduduk;
use Illuminate\Support\Facades\Validator;

class PendudukController extends Controller
{
    public function index()
    {
        $query = Penduduk::latest();
        $penduduk = $query->get();

        return response()->json($penduduk, 200);
    }

    public function store(Request $request)
    {
        $rules = [
            'nama_penduduk' => 'required|string|max:258',
            'jenis_kelamin' => 'required|string|max:258',
            'umur' => 'required|string|max:258'
        ];
        
        $messages = [
            'nama_penduduk.required' => 'Nama Penduduk is required',
            'jenis_kelamin.required' => 'Jenis kelamin is required',
            'umur.required' => 'Umur is required'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json( $validator->errors(), 400);
        }

        try {

            Penduduk::create([
                'nama_penduduk' => $request->input('nama_penduduk'),
                'jenis_kelamin' => $request->input('jenis_kelamin'),
                'umur' => $request->input('umur'),
            ]);

            return response()->json([
                'message' => "Penduduk successfully created."
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => "Something went really wrong!",
                'details' => $e->getMessage()
            ], 500);
        }
    }

    public function show(string $id)
    {
        $penduduk = Penduduk::where('id_penduduk',$id)->first();

        if (!$penduduk) {
            return response()->json([
                'message' => "penduduk Not Found"
            ], 404);
        }

        return response()->json($penduduk, 200);
    }


    public function update(Request $request, string $id)
    {
        $rules = [
            'nama_penduduk' => 'required|string|max:258',
            'jenis_kelamin' => 'required|string|max:258',
            'umur' => 'required|string|max:258',
        ];

        $messages = [
            'nama_penduduk.required' => 'Nama penduduk is required',
            'jenis_kelamin.required' => 'Jenis kelamin is required',
            'umur.required' => 'umur is required',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json( $validator->errors(), 400);
        }

        try {
            $penduduk = Penduduk::where('id_penduduk', $id)->first();

            if (!$penduduk) {
                return response()->json([
                    'message' => "penduduk Not Found"
                ], 404);
            }

            $updatedData = [
                'nama_penduduk' => $request->input('nama_penduduk'),
                'jenis_kelamin' => $request->input('jenis_kelamin'),
                'umur' => $request->input('umur'),
            ];


            Penduduk::where('id_penduduk', $id)->update($updatedData);

            return response()->json([
                'message' => "penduduk successfully updated."
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => "Something went really wrong"
            ], 500);
        }
    }


    public function destroy(string $id)
    {
        $penduduk = Penduduk::where('id_penduduk', $id)->first();

        if (!$penduduk) {
            return response()->json([
                'message' => "penduduk Not Found"
            ], 404);
        }

        Penduduk::where('id_penduduk', $id)->delete();

        return response()->json([
            'message' => "penduduk successfully deleted."
        ], 200);
    }
}
