<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RefWorkshopSeeder extends Seeder
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
                'code' => '01',
                'desc' => 'JKR WOKSYOP PERSEKUTUAN',
                'code_warrant_ofs' => '050403100000',
                'ref_code' => 'W1',
                'state_id' => 14,
            ],
            [
                'code' => '02',
                'desc' => 'JKR CKM NEGERI JOHOR',
                'code_warrant_ofs' => '080112000000',
                'ref_code' => 'J1',
                'state_id' => 1,
            ],
            [
                'code' => '03',
                'desc' => 'JKR CKM NEGERI KEDAH',
                'code_warrant_ofs' => '080213000000',
                'ref_code' => 'K1',
                'state_id' => 2,
            ],
            [
                'code' => '04',
                'desc' => 'JKR CKM NEGERI KELANTAN',
                'code_warrant_ofs' => '080314000000',
                'ref_code' => 'D1',
                'state_id' => 3,
            ],
            [
                'code' => '05',
                'desc' => 'JKR CKM NEGERI MELAKA',
                'code_warrant_ofs' => '080404060000',
                'ref_code' => 'M1',
                'state_id' => 4,
            ],
            [
                'code' => '06',
                'desc' => 'JKR CKM NEGERI N.SEMBILAN',
                'code_warrant_ofs' => '080508040000',
                'ref_code' => 'N1',
                'state_id' => 5,
            ],
            [
                'code' => '07',
                'desc' => 'JKR CKM NEGERI PAHANG',
                'code_warrant_ofs' => '080614000000',
                'ref_code' => 'C1',
                'state_id' => 6,
            ],
            [
                'code' => '08',
                'desc' => 'JKR CKM NEGERI PULAU PINANG',
                'code_warrant_ofs' => '080708000000',
                'ref_code' => 'P1',
                'state_id' => 9,
            ],
            [
                'code' => '09',
                'desc' => 'JKR CKM NEGERI PERAK',
                'code_warrant_ofs' => '080813000000',
                'ref_code' => 'A1',
                'state_id' => 7,
            ],
            [
                'code' => '10',
                'desc' => 'JKR CKM NEGERI PERLIS',
                'code_warrant_ofs' => '080901000000',
                'ref_code' => 'R1',
                'state_id' => 8,
            ],
            [
                'code' => '11',
                'desc' => 'JKR CKM NEGERI SELANGOR',
                'code_warrant_ofs' => '081012000000',
                'ref_code' => 'B1',
                'state_id' => 12,
            ],
            [
                'code' => '12',
                'desc' => 'JKR CKM NEGERI TERENGGANU',
                'code_warrant_ofs' => '081110000000',
                'ref_code' => 'T1',
                'state_id' => 13,
            ],
            [
                'code' => '13',
                'desc' => 'JKR CKM WP LABUAN',
                'code_warrant_ofs' => '020707000000',
                'ref_code' => 'W2',
                'state_id' => 15,
            ]
        ];

        \App\Models\RefWorkshop::insert($data);
    }
}
