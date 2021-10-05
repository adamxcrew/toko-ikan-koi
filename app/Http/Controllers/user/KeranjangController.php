<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Keranjang;
use Illuminate\Support\Facades\DB;
class KeranjangController extends Controller
{

    public function index()
    {

        $id_user = \Auth::user()->id;
        $keranjangs = DB::table('keranjang')
                            ->join('users','users.id','=','keranjang.user_id')
                            ->join('produk','produk.id','=','keranjang.produk_id')
                            ->select('produk.nama as nama_produk','produk.gambar','users.name','keranjang.*','produk.harga')
                            ->where('keranjang.user_id','=',$id_user)
                            ->get();
        $cekalamat = DB::table('alamat')->where('user_id',$id_user)->count();
        $data = [
            'keranjangs' => $keranjangs,
            'cekalamat'  => $cekalamat
        ];
        return view('user.keranjang',$data);
    }

    public function simpan(Request $request)
    {
        Keranjang::create([
            'user_id' => $request->user_id,
            'produk_id' => $request->produk_id,
            'jumlah' => $request->jumlah
        ]);

        return redirect()->route('user.keranjang');
    }

    function show_Names($n, $m)
    {
    return("The name is $n and email is $m, thank you");
    }
    public function update(Request $request)
    {
        $index = 0;
        foreach($request->id as $id){
            $keranjang = Keranjang::findOrFail($id);
            $keranjang->jumlah = $request->jumlah[$index];
            $keranjang->save();
            $index++;
        }

        return redirect()->route('user.keranjang');
    }

    public function delete($id)
    {

        Keranjang::destroy($id);

        return redirect()->route('user.keranjang');
    }
}
