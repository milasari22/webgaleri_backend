<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use Illuminate\Support\Facades\Validator;

class MenuController extends Controller
{
    
    public function index()
    {
        $query = Menu::latest();
        $menu = $query->get();

        return response()->json($menu, 200);
    }

    public function store(Request $request)
    {
        $rules = [
            'nama_menu' => 'required|string|max:258',
            'jenis_menu' => 'required|string|max:258',
            'urutan' => 'required|string|max:258',
        ];
        
        $messages = [
            'nama_menu.required' => 'nama menu is required',
            'jenis_menu.required' => 'Jenis menu is required',
            'urutan.required' => 'urutan is required',
        ];

        $messages = [
            'nama_menu.required' => 'nama menu is required',
            'jenis_menu.required' => 'jenis_menu menu is required',
            'urutan.required' => 'urutan menu is required',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json( $validator->errors(), 400);
        }

        try {

            Menu::create([
                'nama_menu' => $request->input('nama_menu'),
                'jenis_menu' => $request->input('jenis_menu'),
                'urutan' => $request->input('urutan'),
            ]);

            return response()->json([
                'message' => "menu successfully created."
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
        $menu = Menu::where('id_menu',$id)->first();

        if (!$menu) {
            return response()->json([
                'message' => "menu Not Found"
            ], 404);
        }

        return response()->json($menu, 200);
    }


    public function update(Request $request, string $id)
    {
        $rules = [
            'nama_menu' => 'required|string|max:258',
            'jenis_menu' => 'required|string|max:258',
            'urutan' => 'required|string|max:258',
        ];

        $messages = [
            'nama_menu.required' => 'Nama menu is required',
            'jenis_menu.required' => 'Jenis menu is required',
            'urutan.required' => 'urutan menu is required',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json( $validator->errors(), 400);
        }

        try {
            $menu = Menu::where('id_menu', $id)->first();

            if (!$menu) {
                return response()->json([
                    'message' => "menu Not Found"
                ], 404);
            }

            $updatedData = [
                'nama_menu' => $request->input('nama_menu'),
                'jenis_menu' => $request->input('jenis_menu'),
                'urutan' => $request->input('urutan'),
            ];


            Menu::where('id_menu', $id)->update($updatedData);

            return response()->json([
                'message' => "menu successfully updated."
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => "Something went really wrong"
            ], 500);
        }
    }


    public function destroy(string $id)
    {
        $menu = menu::where('id_menu', $id)->first();

        if (!$menu) {
            return response()->json([
                'message' => "menu Not Found"
            ], 404);
        }

        menu::where('id_menu', $id)->delete();

        return response()->json([
            'message' => "menu successfully deleted."
        ], 200);
    }
}
