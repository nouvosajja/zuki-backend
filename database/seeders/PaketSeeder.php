<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Paket;

class PaketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Paket::create([
            'nama_pkt' => 'Paket reguler',
        ]);

        Paket::create([
            'nama_pkt' => 'Paket kilat',
        ]);
    }
}
