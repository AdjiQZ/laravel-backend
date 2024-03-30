<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ProductModels;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProdukController extends Controller
{
    public function getProduk(){
        $data = ProductModels::get();

        return response()->json([
            'status' => true,
            'message' => 'data produk',
            'data' => $data
        ], 200);
    }
    public function createProduk(Request $request){
        $validator = Validator::make($request->all(), [
            'nama_produk' => 'required',
            'deskripsi_produk' => 'required',
            'jumlah_produk' => 'required',
            'harga_produk' => 'required',
            'kategori' => 'required',
            'status' => 'required'
        ]);
        
        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }
        $produk = ProductModels::create([
            'nama_produk' => $request->nama_produk,
            'deskripsi_produk' => $request->deskripsi_produk,
            'jumlah_produk' => $request->jumlah_produk,
            'harga_produk' => $request->harga_produk,
            'kategori' => $request->kategori,
            'status' => $request->status,
        ]);

        if($produk){
            return response()->json([
                'status' => true,
                'message' => 'data produk berhasil ditambahkan',
            ], 201);
        }

        return response()->json([
            'status' => true,
            'message' => 'gagal menambah data produk',
        ], 409);
    }

    public function editProduk(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'nama_produk' => 'required',
            'deskripsi_produk' => 'required',
            'jumlah_produk' => 'required',
            'harga_produk' => 'required',
            'kategori' => 'required',
            'status' => 'required'
        ]);
        
        if($validator->fails()){
            return response()->json($validator->errors(), 422);
        }
        $produk = ProductModels::where('id', $id)->update([
            'nama_produk' => $request->nama_produk,
            'deskripsi_produk' => $request->deskripsi_produk,
            'jumlah_produk' => $request->jumlah_produk,
            'harga_produk' => $request->harga_produk,
            'kategori' => $request->kategori,
            'status' => $request->status,
        ]);

        if($produk){
            return response()->json([
                'status' => true,
                'message' => 'data produk berhasil diedit',
            ], 201);
        }

        return response()->json([
            'status' => true,
            'message' => 'gagal mengubah data produk',
        ], 409);
    }

    public function deleteProduk($id){
        $produk = ProductModels::find($id);

        if(!$produk){
            return response()->json([
                'status' => false,
                'message' => 'Produk tidak berhasil ditemukan'
            ], 404);
        }

        $produk->delete();

        return response()->json([
            'status' => true,
            'message' => 'Produk berhasil di hapus'
        ], 200);
    }

}
