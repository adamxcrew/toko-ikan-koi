<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Product;
use App\Categories;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
class ProductController extends Controller
{
    public function index()
    {
        //membawa data produk yang di join dengan table kategori
        $produk = DB::table('produk')
                    ->join('kategori', 'kategori.id', '=', 'produk.kategori_id')
                    ->select('produk.*', 'kategori.nama as nama_kategori')
                    ->get();
        $data = array(
            'produk' => $produk
        );
        return view('admin.product.index',$data);
    }

    public function tambah()
    {
        //menampilkan form tambah kategori

        $data = array(
            'categories' => Categories::all(),
        );
        return view('admin.product.tambah',$data);
    }

    public function store(Request $request)
    {
        //menyimpan produk ke database
        if($request->file('image')){
            //simpan foto produk yang di upload ke direkteri public/storage/imageproduct
            $file = $request->file('image')->store('imageproduct','public');

            Product::create([
                'nama' => $request->name,
                'deskripsi' => $request->description,
                'harga' => $request->price,
                'stok' => $request->stok,
                'weigth' => $request->weigth,
                'kategori_id' => $request->categories_id,

                'gambar'          => $file

            ]);

            return redirect()->route('admin.product')->with('status','Berhasil Menambah Produk Baru');
        }
    }

    public function edit($id)
    {
        //menampilkan form edit
        //dan mengambil data produk sesuai id dari parameter
        $data = array(
            'product' => Product::findOrFail($id),
            'categories' => Categories::all(),
        );
        return view('admin.product.edit',$data);
    }

    public function update($id,Request $request)
    {
        //ambil data dulu sesuai parameter $Id
        $prod = Product::findOrFail($id);

        // Lalu update data nya ke database
        if( $request->file('image')){

            Storage::delete('public/'.$prod->image);
            $file = $request->file('image')->store('imageproduct','public');
            $prod->gambar = $file;
        }

        $prod->nama = $request->name;
        $prod->deskripsi = $request->description;
        $prod->harga = $request->price;
        $prod->weigth = $request->weigth;
        $prod->kategori_id = $request->categories_id;
        $prod->stok = $request->stok;


        $prod->save();

        return redirect()->route('admin.product')->with('status','Berhasil Mengubah Kategori');
    }

    public function delete($id)
    {
        //mengahapus produk
        $prod = Product::findOrFail($id);
        Product::destroy($id);
        Storage::delete('public/'.$prod->gambar);
        return redirect()->route('admin.product')->with('status','Berhasil Mengahapus Produk');
    }
}
