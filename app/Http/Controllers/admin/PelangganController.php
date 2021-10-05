<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\DB;
class PelangganController extends Controller
{
    public function index()
    {
        //ambil data pelanggan yang di join dengan table alamat, city,dan province
        $data = array(
            'pelanggan' => DB::table('users')
                        ->join('alamat','alamat.user_id','=','users.id')
                        ->join('kota','kota.kota_id','=','alamat.kota_id')
                        ->join('provinsi','provinsi.provinsi_id','=','kota.provinsi_id')
                        ->select('users.*','alamat.detail','kota.nama as kota','provinsi.nama as prov')
                        ->where('users.role','=','customer')->get()
        );
        return view('admin.pelanggan.index',$data);
    }

    public function delete($id)
    {
        // dd($id);
        //mengahapus user
        $pel = User::findOrFail($id);
        $pel->delete();
        return redirect()->route('admin.pelanggan')->with('status','Berhasil Mengahapus pelanggan');
    }
}
