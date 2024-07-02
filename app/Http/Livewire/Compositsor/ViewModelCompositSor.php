<?php

namespace App\Http\Livewire\Compositsor;

use App\Models\SOR;
use Livewire\Component;

class ViewModelCompositSor extends Component
{
    public $listeners = ["viewModal" => "ViewProcess"];
    public $viewVerifyModal = false, $viewCompositSOR,$sor_itemno_parent_index,$sor_itemno_parent_id;

    public function ViewProcess($data)
    {
        // dd($data);
        $this->sor_itemno_parent_id = $data[0]['sor_itemno_parent_id'];
        $this->sor_itemno_parent_index = $data[0]['sor_itemno_parent_index'];
        $this->viewCompositSOR = $data;
        // dd($this->viewCompositSOR);
        // dd($parent_id, $child_id);
        $this->viewVerifyModal = !$this->viewVerifyModal;
        // $this->viewCompositSOR['parent'] = SOR::select('s_o_r_s.id', 's_o_r_s.Item_details', 's_o_r_s.description')
        //     ->where('s_o_r_s.id', $parent_id)
        //     ->join('composit_sors', 's_o_r_s.id', '=', 'composit_sors.sor_itemno_parent_id')->groupBy('s_o_r_s.id')->get();

        // $this->viewCompositSOR['child'] = SOR::select('s_o_r_s.id', 's_o_r_s.Item_details', 's_o_r_s.description')->where('s_o_r_s.id', $child_id)
        //     ->join('composit_sors', 's_o_r_s.id', '=', 'composit_sors.sor_itemno_parent_id')->get();
        // $this->viewCompositSOR['child'] = SOR::select('s_o_r_s.id', 's_o_r_s.Item_details', 's_o_r_s.description')->where('s_o_r_s.id', $parent_id)
        //     ->join('composit_sors', 's_o_r_s.id', '=', 'composit_sors.sor_itemno_parent_id')->groupBy('s_o_r_s.id')->get();


        // dd($this->viewCompositSOR['child']);
    }
    public function render()
    {
        return view('livewire.compositsor.view-model-composit-sor');
    }
}
