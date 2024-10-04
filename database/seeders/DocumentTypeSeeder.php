<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
class DocumentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $doctypes = [
            'ADCP survey report',
            'Soil Testing report',
            'Photograph with geocoding',
            'Basic survey report',
            'Design philosophy',
            'Design document',
            'Meeting with citizen report',
            'GAD',
            'Pile data',
            'Land clearance',
            'Details of cross drainage structure',
        ];

        foreach ($doctypes as $doctype) {
            DB::table('document_types')->insert([
                'name' => $doctype,
                'created_by' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
