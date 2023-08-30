<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Price;

class PriceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Price::create([
            'nama' => 'Cuci Setrika',
            'waktu' => '3 hari',
            'paket_id' => 1,
            'harga' => 12000,
            'deskripsi' => 'Pakaian dicuci, disetrika, dan dilipat rapi dalam 3 hari sebelum siap diambil.',
            'images' => 'cs.png',
        ]);

        Price::create([
            'nama' => 'Cuci',
            'waktu' => '3 hari',
            'paket_id' => 1,
            'harga' => 9000,
            'deskripsi' => 'Pakaian kotor dicuci tanpa setrika. Layanan ini memakan waktu 3 hari untuk mencuci dan mengeringkan pakaian.',
            'images' => 'cuci.png',
        ]);

        Price::create([
            'nama' => 'Setrika',
            'waktu' => '1 hari',
            'paket_id' => 1,
            'harga' => 10000,
            'deskripsi' => 'Pakaian dicuci terlebih dahulu dan kemudian disetrika. Layanan ini membutuhkan waktu 1 hari untuk menyelesaikannya.',
            'images' => 'setrika.png',
        ]);

        Price::create([
            'nama' => 'Sepatu',
            'waktu' => '3 hari',
            'paket_id' => 1,
            'harga' => 9000,
            'deskripsi' => 'Mencuci dan membersihkan sepatu anda dalam waktu 3 hari',
            'images' => 'sepatu.png',
        ]);

        Price::create([
            'nama' => 'Lainya',
            'waktu' => '3 hari',
            'paket_id' => 1,
            'harga' => 12000,
            'deskripsi' => 'Mencuci dan membersihkan barang tertentu anda dalam waktu 3 hari',
            'images' => 'cs.png',
        ]);

        Price::create([
            'nama' => 'Cuci Setrika',
            'waktu' => '12 jam',
            'paket_id' => 2,
            'harga' => 20000,
            'deskripsi' => 'Pakaian dicuci, disetrika, dan dilipat dengan cepat dalam waktu 12 jam. Layanan ini memprioritaskan kecepatan.',
            'images' => 'cs.png',
        ]);

        Price::create([
            'nama' => 'Cuci',
            'waktu' => '1 hari',
            'paket_id' => 2,
            'harga' => 17000,
            'deskripsi' => 'Pakaian kotor dicuci tanpa setrika dalam waktu 1 hari sebelum siap untuk diambil. Layanan ini 
            memberikan solusi yang lebih cepat dibandingkan dengan reguler 3 hari.',
            'images' => 'cuci.png',
        ]);

        Price::create([
            'nama' => 'Setrika',
            'waktu' => '12 jam',
            'paket_id' => 2,
            'harga' => 10000,
            'deskripsi' => 'Pakaian dicuci terlebih dahulu dan kemudian disetrika. dalam waktu 12 jam sebelum siap untuk diambil. Layanan ini 
            memberikan solusi yang lebih cepat dibandingkan dengan reguler 12 jam.',
            'images' => 'setrika.png',
        ]);

        Price::create([
            'nama' => 'Sepatu',
            'waktu' => '2 hari',
            'paket_id' => 2,
            'harga' => 17000,
            'deskripsi' => 'Mencuci dan membersihkan sepatu anda dalam waktu 2 hari',
            'images' => 'sepatu.png',
        ]);

        Price::create([
            'nama' => 'lainya',
            'waktu' => '1 hari',
            'paket_id' => 2,
            'harga' => 20000,
            'deskripsi' => 'Mencuci dan membersihkan sepatu anda dalam waktu 1 hari',
            'images' => 'cs.png',
        ]);
    }
}
