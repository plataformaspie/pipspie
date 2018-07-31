<?php

use Illuminate\Database\Seeder;

class DepartamentosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       for($i=1;$i<4;$i++){
            DB::table('sp_pt_departamentos')->insert([
                'descripcion_departamento' => 'nombre '.$i,
            ]);
        }
    }
}
