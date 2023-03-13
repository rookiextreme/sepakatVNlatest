<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class JabatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'kementerian_id' => 1,
                'jabatan' => 'Lembaga Pembangunan Pelaburan Malaysia (MIDA)'
            ],
            [
                'kementerian_id' => 1,
                'jabatan' => 'Perbadanan Pembangunan Perdagangan Luar Malaysia (MATRADE)'
            ],
            [
                'kementerian_id' => 1,
                'jabatan' => 'Perbadanan Produktiviti Malaysia (MPC)'
            ],
            [
                'kementerian_id' => 1,
                'jabatan' => 'Malaysian Industrial Development Finance (MIDF)'
            ],
            [
                'kementerian_id' => 1,
                'jabatan' => 'Institut Automotif Robotik dan IoT Malaysia (MARii)'
            ],
            [
                'kementerian_id' => 1,
                'jabatan' => 'Institut Besi Malaysia (MSI)'
            ],
            [
                'kementerian_id' => 1,
                'jabatan' => 'SIRIM Berhad'
            ],
            [
                'kementerian_id' => 1,
                'jabatan' => 'Export-Import Bank of Malaysia Berhad (EXIM Bank)'
            ],
            [
                'kementerian_id' => 1,
                'jabatan' => 'Jabatan Standard Malaysia (JSM)'
            ],
            [
                'kementerian_id' => 1,
                'jabatan' => 'Perbadanan InvestKL (InvestKL)'
            ],
            [
                'kementerian_id' => 1,
                'jabatan' => 'Perbadanan Pembangunan Halal (HDC)'
            ],
            [
                'kementerian_id' => 1,
                'jabatan' => 'Majlis Rekabentuk Malaysia (MRM)'
            ],
            [
                'kementerian_id' => 1,
                'jabatan' => 'Majlis Pengukuran Kebangsaan (MPK)'
            ],
        ];

        \App\Models\Identifier\Jabatan::insert($data);
    }
}
