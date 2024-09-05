<?php

namespace Database\Seeders;

use App\Models\UnitMaster;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class NonSor extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
            $units = UnitMaster::orderBy('id','asc')->pluck('unit_name')->toArray();

        $nonSors = [
            [
                'item_name'=>'Supplying,fitting fixing submercible pump of make Crompton/kirloskar/BE pump or equivalent reputed manufactures as approved by the Engineer in charge . Therate includes the cost of the pump including Tranportation charges ,Lowering charges & all taxes complete in all respect. 7.5 H.P (For water supply)',
                'qty'=>1,
                'price'=>15,
            ],
            [
                'item_name'=>'Supplying, fitting, fixing Mono-Block Pump of make Crompton/Kirlosker/ BE Pump or equivalent eputed manufactures as approved by the Engineer-in-Charge. The rate includes the cost of the Pump including Transportation Charges, Lowering Charges & all Taxes complete in all respect. 10 H.P. (For water supply)',
                'qty'=>2,
                'price'=>30,
            ],
            [
                'item_name'=>'Supplying & fittings of 440 volts star /Delta M.I 15F fully autimatic starter relay range 9-14 make LT/LK including M.S iron structure for grounding wall etc (For water supply)',
                'qty'=>3,
                'price'=>55,
            ],
        ];

        foreach($nonSors as $sors)
        {
            $sors['unit'] = $units[array_rand($units)];
            $sors['total'] = $sors['qty'] * $sors['price'];
            Nonsor::create($sors);
        }
    }
}
