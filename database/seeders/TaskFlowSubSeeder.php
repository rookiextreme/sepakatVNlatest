<?php

namespace Database\Seeders;

use App\Models\TaskFlow;
use App\Models\TaskFlowSub;
use Illuminate\Database\Seeder;

class TaskFlowSubSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $taskflowCode01 = TaskFlow::where('code', '01')->first();
        $taskflowCode02 = TaskFlow::where('code', '02')->first();
        $taskflowCode03 = TaskFlow::where('code', '03')->first();
        $taskflowCode04 = TaskFlow::where('code', '04')->first();

        $data = [
            [
                'taskflow_id' => $taskflowCode01->id,
                'code' => '01',
                'name_bm' => 'Maklumat Kenderaan',
                'is_multi' => true,
                'created_by' => 1
            ],
            [
                'taskflow_id' => $taskflowCode01->id,
                'code' => '02',
                'name_bm' => 'Maklumat Pembayaran Saman',
                'is_multi' => true,
                'created_by' => 1
            ],

            [
                'taskflow_id' => $taskflowCode02->id,
                'code' => '01',
                'name_bm' => 'Kenderaan Baharu',
                'is_multi' => true,
                'created_by' => 1
            ],
            [
                'taskflow_id' => $taskflowCode02->id,
                'code' => '02',
                'name_bm' => 'Keselamatan dan Prestasi',
                'is_multi' => true,
                'created_by' => 1
            ],
            [
                'taskflow_id' => $taskflowCode02->id,
                'code' => '03',
                'name_bm' => 'Nilaian Semasa',
                'is_multi' => true,
                'created_by' => 1
            ],
            [
                'taskflow_id' => $taskflowCode02->id,
                'code' => '04',
                'name_bm' => 'Kemalangan',
                'is_multi' => true,
                'created_by' => 1
            ],
            [
                'taskflow_id' => $taskflowCode02->id,
                'code' => '05',
                'name_bm' => 'Pelupusan',
                'is_multi' => true,
                'created_by' => 1
            ],
            [
                'taskflow_id' => $taskflowCode02->id,
                'code' => '06',
                'name_bm' => 'Pinjaman',
                'is_multi' => true,
                'created_by' => 1
            ],

            [
                'taskflow_id' => $taskflowCode03->id,
                'code' => '01',
                'name_bm' => 'Pengagihan Waran',
                'is_multi' => true,
                'created_by' => 1
            ],
            [
                'taskflow_id' => $taskflowCode03->id,
                'code' => '02',
                'name_bm' => 'Penyenggaraan',
                'is_multi' => true,
                'created_by' => 1
            ],

            [
                'taskflow_id' => $taskflowCode04->id,
                'code' => '01',
                'name_bm' => 'Tempahan Kenderaan',
                'is_multi' => true,
                'created_by' => 1
            ],
            [
                'taskflow_id' => $taskflowCode04->id,
                'code' => '02',
                'name_bm' => 'Siap Siaga Bencana',
                'is_multi' => true,
                'created_by' => 1
            ],

        ];

        TaskFlowSub::insert($data);
    }
}
