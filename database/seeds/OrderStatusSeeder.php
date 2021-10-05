<?php

use Illuminate\Database\Seeder;
use App\Orderstatus;
class OrderStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['nama' => 'Belum Bayar'],
            ['nama' => 'Perlu Di Cek'],
            ['nama' => 'Telah Di Bayar'],
            ['nama' => 'Barang Di Kirim'],
            ['nama' => 'Barang Telah Sampai'],
            ['nama' => 'Pesanan Di Batalkan'],
        ];
        Orderstatus::insert($data);
    }
}
