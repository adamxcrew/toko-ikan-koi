<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Kavist\RajaOngkir\Facades\RajaOngkir;
class CheckoutController extends Controller
{
    public function index()
    {
        //ambil session user id
        $id_user = \Auth::user()->id;
        //ambil produk apa saja yang akan dibeli user dari table keranjang
        $keranjangs = DB::table('keranjang')
                            ->join('users','users.id','=','keranjang.user_id')
                            ->join('produk','produk.id','=','keranjang.produk_id')
                            ->select('produk.nama as nama_produk','produk.gambar','produk.weigth','users.name','keranjang.*','produk.harga')
                            ->where('keranjang.user_id','=',$id_user)
                            ->get();

        //lalu hitung jumlah berat total dari semua produk yang akan di beli
        $berattotal = 0;
        foreach($keranjangs as $k){
            $berat = $k->weigth * $k->jumlah;
            $berattotal = $berattotal + $berat;
        }
        //lalu ambil id kota si pelanngan
        $city = DB::table('alamat')->where('user_id',$id_user)->get();
        $city_destination =  $city[0]->kota_id;
        //ambil id kota toko
        $alamat_toko = DB::table('alamat_toko')->first();

        //lalu hitung ongkirnya
        $cost = RajaOngkir::ongkosKirim([
            'origin'  => $alamat_toko->id,
            'destination' => $city_destination,
            'weight' => $berattotal,
            'courier' => 'jne'
        ])->get();
        // dd($cost);
        //ambil hasil nya
        $ongkir =  $cost[0]['costs'][0]['cost'][0]['value'];

        //lalu ambil alamat user untuk ditampilkan di view
        $alamat_user = DB::table('alamat')
        ->join('kota','kota.kota_id','=','alamat.kota_id')
        ->join('provinsi','provinsi.provinsi_id','=','kota.provinsi_id')
        ->select('alamat.*','kota.nama as kota','provinsi.nama as prov')
        ->where('alamat.user_id',$id_user)
        ->first();

        //buat kode invoice sesua tanggalbulantahun dan jam
        $data = [
            'invoice' => 'ALV'.Date('Ymdhi'),
            'keranjangs' => $keranjangs,
            'ongkir' => $ongkir,
            'alamat' => $alamat_user
        ];
        return view('user.checkout',$data);
    }
}
