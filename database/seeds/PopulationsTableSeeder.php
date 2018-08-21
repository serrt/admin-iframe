<?php

use Illuminate\Database\Seeder;

class PopulationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $file = public_path('population.xls');
        config(['excel.import.heading'=>'true']);
        $data = \Maatwebsite\Excel\Facades\Excel::load($file)->all();
        $insert = [];
        foreach ($data as $item) {
            $array_item = $item->toArray();
            array_push($insert, [
                'number' => $array_item[0],
                'master' => 0,
                'name' => $array_item[6],
                'avatar' => '',
                'relation' => '户主',
                'old_name' => $array_item[5],
                'id_number' => $array_item[8],
                'sex' => $array_item[9] == '男' ? 1 : 0,
                'birthday' => $array_item[10],
                'birth_place' => $array_item[12],
                'place' => $array_item[11],
                'type' => 46,
                'community' => 1,
                'nation' => 58,
                'benefit' => $array_item[2] == '是' ? 1 : 0,
            ]);
        }
        DB::table('population')->insert($insert);
    }
}
