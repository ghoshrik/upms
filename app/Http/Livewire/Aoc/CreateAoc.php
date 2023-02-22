<?php

namespace App\Http\Livewire\Aoc;

use App\Models\AOC;
use Livewire\Component;

use Illuminate\Support\Carbon;
use App\Models\SorMaster;
class CreateAoc extends Component
{
    public $title,$refcNo,$category,$projId,$fetchData;
    public function store()
    {
        try{
            //$year = Carbon::now();

            // dd($this->projId,$this->title,$this->refcNo,$this->category);
            $insert = [
                'tender_id'=>$this->projId.'-'.Carbon::now()->year,
                'tender_title'=>$this->title,
                'project_no'=>$this->refcNo,
                'tender_category'=>$this->category
            ];
            // dd($insert);
            AOC::create($insert);
            $this->notification()->success(
                $title = trans('cruds.aoc.create_msg')
            );
            $this->reset();
            $this->emit('openForm');
        }
        catch(\Throwable $th)
        {
            $this->emit('showError', $th->getMessage());
        }
    }
    public function render()
    {
        $this->fetchData['project_number'] = SorMaster::where('is_verified','=',1)->get();
        $assets = ['chart', 'animation'];
        return view('livewire.aoc.create-aoc',compact('assets'));
    }
}
