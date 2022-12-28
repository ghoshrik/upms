<div>
    <x-form-section submit='store'>
        <x-slot name='form'>
            <div class="iq-timeline0 m-0 d-flex align-items-center justify-content-between position-relative">
                <ul class="list-inline p-0 m-0 w-100">
                    <li>
                        <div class="timeline-dots1 border-primary text-primary">
                            <svg width="20" height="20" viewBox="0 0 24 24">
                                <path fill="currentColor"
                                    d="M19,3H5C3.89,3 3,3.89 3,5V9H5V5H19V19H5V15H3V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19V5C21,3.89 20.1,3 19,3M10.08,15.58L11.5,17L16.5,12L11.5,7L10.08,8.41L12.67,11H3V13H12.67L10.08,15.58Z">
                                </path>
                            </svg>
                        </div>

                        <div class="row">
                            <div class="col-md-4 col-lg-4 col-sm-3">
                                <x-input label="Project Id" wire:model="projectId" placeholder="Enter Project No." />

                            </div>
                            <div class="col-md-4 col-lg-4 col-sm-3">
                                <x-textarea wire:model="description" rows="2" label="description"
                                    placeholder="Your description" />
                            </div>
                            <div class="col-md-4 col-lg-4 col-sm-3">
                                <button type="button" wire:click="addMilestone({{$Index}})"
                                    class="btn btn-soft-success rounded-pill mt-3">Add</button>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-12 col-lg-12 col-sm-6">
                                <div class="iq-timeline1 m-0 d-flex align-items-center justify-content-between position-relative">
                                    <ul class="list-inline p-0 m-0 w-100 mt-2 mb-2 ml-2">
                                        @dd($mileStoneData);
                                        @foreach($mileStoneData as $key => $mileStone)
                                        <li>
                                            <div class="row">
                                                <div class="col-md-2 col-lg-2 col-sm-3">
                                                    <x-input label="milestone_1" wire:key="inputsData.{{$key}}.milestone_1" wire:model="mileStoneData.{{$key}}.m1" placeholder="your Milestone_1{{$key}}" />
                                                </div>
                                                <div class="col-md-3 col-lg-3 col-sm-3">
                                                    <x-input label="milestone_2" wire:key="inputsData.{{$key}}.milestone_2"  wire:model="mileStoneData.{{$key}}.m2" placeholder="your Milestone_2{{$key}}" />
                                                </div>
                                                <div class="col-md-2 col-lg-2 col-sm-3">
                                                    <x-input label="milestone_3" wire:key="inputsData.{{$key}}.milestone_3"  wire:model="mileStoneData.{{$key}}.m3" placeholder="your Milestone_3{{$key}}" />
                                                </div>
                                                <div class="col-md-3 col-lg-3 col-sm-3">
                                                    <x-input label="milestone_4" wire:key="inputsData.{{$key}}.milestone_4"  wire:model="mileStoneData.{{$key}}.m4" placeholder="your Milestone_4{{$key}}" />
                                                </div>
                                                <div class="col-md-2 col-lg-2 col-sm-3">
                                                    <div class="row">
                                                        <div class="col-md-8 col-lg-8 col-sm-6">
                                                            <button type="button" wire:click="addSubMilestone({{$Index}})"
                                                                class="btn btn-soft-success rounded-pill mt-3 w-100">Add Sub</button>
                                                        </div>
                                                        {{-- <div class="col-md-2 col-lg-2 col-sm-6">
                                                            <button type="button" wire:click="removeMileStep({{$key}})"
                                                            class="btn btn-soft-danger rounded-pill mt-3 {{ count($inputData) < 2 ? 'disabled' : '' }}">
                                                            <x-lucide-trash-2 class="w-4 h-4 text-denger-500" /></button>
                                                        </div> --}}
                                                    </div>
                                                </div>
                                            </div>
                                            @isset($subMileData[$Index])
                                                @foreach($subMileData[$Index] as $k => $submileStone)
                                            {{-- @dd($mileStone[$Index]); --}}
                                            {{-- @dd($submileStone) --}}
                                            @if ($subMileData[$Index] == $mileStoneData[$Index])
                                               <div class="row">
                                                <div class="col-md-12 col-lg-12 col-sm-6">
                                                    <div class="iq-timeline1 m-0 d-flex align-items-center justify-content-between position-relative">
                                                        <ul class="list-inline p-0 m-0 w-100 mt-2 mb-2 ml-2">
                                                            <li>
                                                                <div class="row">
                                                                    <div class="col-md-2 col-lg-2 col-sm-3">
                                                                        <x-input label="milestone_4"  wire:model="mileStoneData.{{$k}}.m1" placeholder="your Milestone_1{{$Index}}" />
                                                                    </div>
                                                                    <div class="col-md-3 col-lg-3 col-sm-3">
                                                                        <x-input label="milestone_5"  wire:model="mileStoneData.{{$k}}.m2" placeholder="your Milestone_1{{$Index}}" />
                                                                    </div>
                                                                    <div class="col-md-2 col-lg-2 col-sm-3">
                                                                        <x-input label="milestone_6"  wire:model="mileStoneData.{{$k}}.m3" placeholder="your Milestone_1{{$Index}}" />
                                                                    </div>
                                                                    <div class="col-md-3 col-lg-3 col-sm-3">
                                                                        <x-input label="milestone_7"  wire:model="mileStoneData.{{$k}}.m4" placeholder="your Milestone_1{{$Index}}" />
                                                                    </div>
                                                                    <div class="col-md-2 col-lg-2 col-sm-3">
                                                                        <div class="row">
                                                                            <div class="col-md-8 col-lg-8 col-sm-6">
                                                                                <button type="button" wire:click="addSubMileStep({{$Index}})"
                                                                                    class="btn btn-soft-success rounded-pill mt-3 w-100">Add Sub</button>
                                                                            </div>
                                                                            {{-- <div class="col-md-2 col-lg-2 col-sm-6">
                                                                                <button type="button" wire:click="removeSubMileStep({{$key.' '.$Index}})"
                                                                class="btn btn-soft-danger rounded-pill mt-3 {{ count($inputsubData) < 2 ? 'disabled' : '' }}">
                                                                <x-lucide-trash-2 class="w-4 h-4 text-denger-500" /></button> --}}
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif

                                            @endforeach
                                            @endisset

                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <button type="submit"
                                    class="btn btn-success rounded-pill float-right">Save</button>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </x-slot>
    </x-form-section>
</div>


"//How to Dynamically nested Add and Remove input fields in PHP with livewire?"
@foreach ($inputs as $key => $value)
<hr>
<div wire:key="opsi-key-{{ $key }}" // or some unique identifier
    <div class="d-flex mx-auto">
            <label><strong>Opsi {{ $value }}</strong></label>
        </div>
        <div class="col-md-6">
            <label for="nama_perusahaan" class="form-label">Nama Perusahaan</label>
            <input type="text" wire:model="nama_perusahaan.{{ $value }}" class="form-control @error('nama_perusahaan.'.$value) is-invalid @enderror" id="nama_perusahaan" placeholder="Nama Perusahaan">
            @error('nama_perusahaan.'.$value)
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
        //.......
</div>




public function mount()
{
    $this->tests = Test::all(); // <-- returns a collection of Test models
}


/*
 * This declares $tests to be an array
 * but this becomes a Collection due to your mount method
 */
public $tests = [''];


public function add()
{
    $this->tests[] = '';
}


public function add()
{
    $this->tests->push(Test::make());
}


<?php

namespace App\Http\Livewire;

use Illuminate\Support\Collection;
use Livewire\Component;

class Test extends Component
{
    // A collection of your models from the database
    public Collection $tests;

    // A conditional variable that we use to show/hide the add new model inputs
    public bool $isAdding = false;

    // A variable to hold our new empty model during creation
    public \App\Models\Test $toAdd;

    // Validation rules
    // These are required in order for Livewire to successfull bind to model properties using wire:model
    // Add any other validation requirements for your other model properties that you bind to
    protected $rules = [
        'tests.*.title' => ['required'],
        'toAdd.title' => ['required']
    ];

    // Livewires implementation of a constructor
    public function mount()
    {
        // Set some default values for the component
        $this->prepare();
    }

    public function render()
    {
        return view('livewire.test');
    }

    //
    public function add()
    {
        // Set the show/hide variable to true so that the new inputs section is shown
        $this->isAdding = true;
    }

    // Save the new model data
    public function save()
    {
        // Save the model to the database
        $this->toAdd->save();
        // Clean things up
        $this->prepare();
    }

    // Just a helper method for performing repeated functionality
    public function prepare()
    {
        // Get all the required models from the database and assign our local variable
        $this->tests = \App\Models\Test::all();
        // Assign an empty model to the toAdd variable
        $this->toAdd = \App\Models\Test::make();
        // Set the isAdding show/hide property to false, which will hide the new model inputs
        $this->isAdding = false;
    }
}


<div>
    <!-- loop over all your test models -->
    @foreach ($tests as $index => $test)
        <!-- the :key attribute is essential in loops so that livewire doesnt run into DOM diffing issues -->
        <div :key="tests_{{ $index }}">
            <label for="tests_{{ $index }}_title">Title {{ $index }}
                <input type="text" id="tests_{{ $index }}_title" name="tests_{{ $index }}_title"
                    wire:model="tests.{{ $index }}.title" :key="tests_{{ $index }}_title" />
            </label>
        </div>
    @endforeach

    <!-- Only show the new model inputs if isAdding is true -->
    @if ($isAdding)
        <!-- this doesnt need a :key as its not in a loop -->
        <div>
            <label for="title">Title
                <input type="text" id="title" name="title" wire:model="toAdd.title" />
            </label>
            <!-- triggers the save function on the component -->
            <button type="button" wire:click="save">Save</button>
        </div>
    @endif

    <!-- triggers the add function on the component -->
    <button type="button" wire:click="add">Add More</button>
</div>


<?php

namespace App\Http\Livewire;

use Illuminate\Support\Collection;
use Livewire\Component;

class Test extends Component
{
    // A collection of your models from the database
    public Collection $tests;

    // A conditional variable that we use to show/hide the add new model inputs
    public bool $isAdding = false;

    // A variable to hold our new empty models during creation
    public Collection $toAdd;

    // Validation rules
    // These are required in order for Livewire to successfull bind to model properties using wire:model
    // Add any other validation requirements for your other model properties that you bind to
    protected $rules = [
        'tests.*.title' => ['required'],
        'toAdd.*.title' => ['required']
    ];

    // Livewires implementation of a constructor
    public function mount()
    {
        $this->cleanUp(true);
    }

    public function hydrate()
    {
        // Get our stored Test model data from the session
        // The reason for this is explained further down
        $this->toAdd = session()->get('toAdd', collect());
    }

    public function render()
    {
        return view('livewire.test');
    }

    public function add()
    {
        $this->isAdding = true;

        // Push (add) a new empty Test model to the collection
        $this->toAdd->push(\App\Models\Test::make());

        // Save the value of the toAdd collection to a session
        // This is required because Livewire doesnt understand how to hydrate an empty model
        // So simply adding a model results in the previous elements being converted to an array
        session()->put('toAdd', $this->toAdd);
    }

    public function save($key)
    {
        // Save the model to the database
        $this->toAdd->first(function ($item, $k) use ($key) {
            return $key == $k;
        })->save();

        // Remove it from the toAdd collection so that it is removed from the Add More list
        $this->toAdd->forget($key);

        // Clean things up
        $this->cleanUp(!$this->toAdd->count());
    }

    public function saveAll()
    {
        $this->toAdd->each(function ($item) {
            $item->save();
        });

        $this->cleanUp(true);
    }

    // Just a helper method for performing repeated functionality
    public function cleanUp(bool $reset = false)
    {
        // Get all the required models from the database and assign our local variable
        $this->tests = \App\Models\Test::all();

        // If there are no items in the toAdd collection, do some cleanup
        // This will reset things on page refresh, although you might not want that to happen
        // If not, consider what you want to happen and change accordingly
        if ($reset) {
            $this->toAdd = collect();
            $this->isAdding = false;
            session()->forget('toAdd');
        }
    }
}


<div>
    <!-- loop over all your test models -->
    @foreach ($tests as $index => $test)
        <!-- the :key attribute is essential in loops so that livewire doesnt run into DOM diffing issues -->
        <div :key="tests_{{ $index }}">
            <label for="tests_{{ $index }}_title">Title {{ $index }}
                <input type="text" id="tests_{{ $index }}_title" name="tests_{{ $index }}_title"
                    wire:model="tests.{{ $index }}.title" :key="tests_{{ $index }}_title" />
            </label>
        </div>
    @endforeach
    <!-- Only show the new model inputs if isAdding is true -->
    @if ($isAdding)
        <div>
            @foreach ($toAdd as $index => $value)
                <div :key="toAdd_{{ $index }}">
                    <label for="toAdd_{{ $index }}_title">New Title {{ $index }}
                        <input type="text" id="toAdd_{{ $index }}_title"
                            name="toAdd_{{ $index }}_title" wire:model="toAdd.{{ $index }}.title"
                            :key="toAdd_{{ $index }}_title" />
                    </label>
                    <!-- triggers the save function on the component -->
                    <button type="button" wire:click="save({{ $index }})" :key="toAdd_{{ $index }}_save">Save</button>
                </div>
            @endforeach
            <button type="button" wire:click="saveAll">Save All</button>
        </div>
    @endif
    <!-- triggers the add function on the component -->
    <button type="button" wire:click="add">Add More</button>
</div>



$(document).on('click','.add',function(){
        var clonned = $(this).parents('.clonable:last-child').clone();
        parentId = clonned.attr('parentId');
        clonned.attr('parentId',parseInt(parentId)+1);
        clonned.find('input[type="text"]').each(function(){
            return $(this).val('');
        })
        $('.clonable').parents('tbody').append(clonned);
    });
    $(document).on('click','.remove',function(){
        $(this).parents('.clonable').remove();
    });

   $(document).on('change', '.nama', function(){
        var staffID = $(this).val();
        var parentId = $(this).parents('.clonable').attr('parentId');
        if(staffID){
            jQuery.ajax({
                url : 'add_demo/get_staff/'+staffID,
                type : "GET",
                dataType : "json",
                success:function(data){
                    console.log(data);
                    $('tr[parentId="'+parentId+'"] input[name="no_personal[]"]').val(data.Nobadan);
                    $('tr[parentId="'+parentId+'"] input[name="jabatan[]"]').val(data.SectionID);
                    $('tr[parentId="'+parentId+'"] input[name="telefon[]"]').val(data.notelttp);
                    $('tr[parentId="'+parentId+'"] input[name="ext[]"]').val(data.ext);
                }
            });
        }else{
            $('tr[parentId="'+parentId+'"] input[name="no_personal[]"]').val('');
            $('tr[parentId="'+parentId+'"] input[name="jabatan[]"]').val('');
            $('tr[parentId="'+parentId+'"] input[name="telefon[]"]').val('');
            $('tr[parentId="'+parentId+'"] input[name="ext[]"]').val('');
        }
    });

.clonable .add{
  display: none;
}
.clonable:last-child .add{
  display: inline-block !important;
}
.clonable:only-child .remove{
  display: none !important;
}

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<div class="container table-responsive col-lg-10">
        <form method="post" id="dynamic_form">
            <span id="result"></span>
            <table class="table table-hover table-responsive table-bordered" id="user_table">
                <thead>
                    <tr>
                        <th class="text-center col-lg-3">Nama</th>
                        <th class="text-center col-lg-2">No Personal</th>
                        <th class="text-center col-lg-1">Jabatan</th>
                        <th class="text-center col-lg-1">Telefon</th>
                        <th class="text-center col-lg-1">Ext</th>
                        <th class="text-center col-lg-1">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="clonable" parentId="1">
                        <td>
                            <select id="nama" name="nama[]" class="form-control nama">
                                <option value="">--Pilih--</option>
                                <?php foreach($staff as $key => $value){?>
                                    <option value="<?=$key?>"><?=addslashes($value)?></option>
                                <?php }?>
                            </select>
                        </td>
                        <td><input type="text" id="no_personal" name="no_personal[]" class="form-control" /></td>
                        <td><input type="text" id="jabatan" name="jabatan[]" class="form-control" /></td>
                        <td><input type="text" id="telefon" name="telefon[]" class="form-control" /></td>
                        <td><input type="text" id="ext" name="ext[]" class="form-control" /></td>
                        <td class="text-center">
                            <button type="button" name="remove" id="" class="btn btn-danger remove">Batal</button>
                            <button type="button" name="add" id="add" class="btn btn-success add">Tambah Pegawai</button>
                        </td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="6" align="right">&nbsp;</td>
                    </tr>
                </tfoot>
            </table>
        </form>
    </div>

//
<html>
      <head>
           <title>Dynamically Add or Remove input fields in PHP with JQuery</title>
           <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
           <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
           <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
      </head>
      <body>
           <div class="container">
                <br />
                <br />
                <h2 align="center">Dynamically Add or Remove input fields in PHP with JQuery</h2>
                <div class="form-group">
                     <form name="add_name" id="add_name">
                          <div class="table-responsive">
                               <table class="table table-bordered" id="dynamic_field">
                                    <tr>
                                         <td><input type="text" name="name[]" placeholder="Enter your Name" class="form-control name_list" /></td>
                                         <td><button type="button" name="add" id="add" class="btn btn-success">Add More</button></td>
                                    </tr>
                               </table>
                               <input type="button" name="submit" id="submit" class="btn btn-info" value="Submit" />
                          </div>
                     </form>
                </div>
           </div>
      </body>
 </html>
 <script>
 $(document).ready(function(){
      var i=1;
      $('#add').click(function(){
           i++;
           $('#dynamic_field').append('<tr id="row'+i+'"><td><input type="text" name="name[]" placeholder="Enter your Name" class="form-control name_list" /></td><td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></td></tr>');
      });
      $(document).on('click', '.btn_remove', function(){
           var button_id = $(this).attr("id");
           $('#row'+button_id+'').remove();
      });
      $('#submit').click(function(){
           $.ajax({
                url:"name.php",
                method:"POST",
                data:$('#add_name').serialize(),
                success:function(data)
                {
                     alert(data);
                     $('#add_name')[0].reset();
                }
           });
      });
 });
 </script>

<?php
 $connect = mysqli_connect("localhost", "root", "", "test_db");
 $number = count($_POST["name"]);
 if($number > 0)
 {
      for($i=0; $i<$number; $i++)
      {
           if(trim($_POST["name"][$i] != ''))
           {
                $sql = "INSERT INTO tbl_name(name) VALUES('".mysqli_real_escape_string($connect, $_POST["name"][$i])."')";
                mysqli_query($connect, $sql);
           }
      }
      echo "Data Inserted";
 }
 else
 {
      echo "Please Enter Name";
 }
 ?>
