<?php

namespace App\Http\Livewire\TestALL;

use App\Models\SOR;
use Livewire\Component;

class TestSearch extends Component
{
    public $search_query="",$searchResult = [],$desc,$qty,$cost,$searchData,$total_amount=0;
    public function render()
    {
        return view('livewire.test-a-l-l.test-search');
    }
    public $resetExcept;
    public function resetValus($resetAll = false)
    {
        if($resetAll)
        {
            $this->search_query = "";
        }
        $this->resetExcept(['search_query']);
    }
    public $dataStyle = 'none',$dataCount;
    public function searchWord()
    {
        // if($this->search_query!="")
        // {

            // $this->searchResult = SOR::where('Item_details',$this->search_query)->get();
            // dd($this->searchResult);
            $this->searchResult = SOR::where('Item_details','like',$this->search_query.'%')->get();
            $this->dataCount = (count($this->searchResult)>0);
            $this->dataStyle= 'block';
            // if($this->dataStyle)
            // dd($this->searchResult);
            // if(count($this->searchResult)>0){
            //     foreach($this->searchResult as $val)
            //     {
            //         $this->desc = $val['description'];
            //         $this->search_query = $val['Item_details'];
            //     }
            // }
            // else
            // {
            //     $this->resetValus($this->search_query);
            //     // dd("Query not found");
            // }

        // }
        // else
        // {
        //     dd("not value");
        // }
    }
    public function calculateValue()
    {
        if (floatval($this->qty) >= 0 && floatval($this->cost) >= 0) {
            $this->total_amount = floatval($this->qty) * floatval($this->cost);
        }
    }
    public function SearchFetch($id)
    {

        // dd($this->search_query,$id);

        $this->searchData = SOR::where('id',$id)->get();

        $this->dataCount = count($this->searchData)>0;
        $this->dataStyle = 'none';
        foreach($this->searchData as $list)
        {
            $this->desc = $list['description'];
            $this->qty = $list['unit'];
            $this->cost = $list['cost'];
            $this->search_query = $list['Item_details'];
        }


        if (floatval($this->qty) >= 0 && floatval($this->cost) >= 0) {
                    $this->total_amount = floatval($this->qty) * floatval($this->cost);
                }

        // if($this->search_query)
        // {
        //     $this->searchData = SOR::where('Item_details',$this->search_query)->get();

        //     foreach($this->searchData as $list)
        //     {
        //         $this->desc = $list['description'];
        //         $this->qty = $list['unit'];
        //         $this->cost = $list['cost'];
        //     }
        //     if (floatval($this->qty) >= 0 && floatval($this->cost) >= 0) {
        //         $this->total_amount = floatval($this->qty) * floatval($this->cost);
        //     }
        // }
        // else
        // {
        //     dd("not select Item Details");
        // }s
    }
}