<div>
    <div class="row">
        <div class="col-sm-12 col-lg-12" x-data="{
            formData:{itemDesc:'',unit:'',rate:0},
            errors: {},
            quill: null,
            NonScheduleList:[],
            Units: @js($units),
            validateDecimal: function(value) {
                let regex = /^\d*\.?\d*$/;
                return regex.test(value) ? value : value.slice(0, -1);
            },
            validateAddForm:function(data){
                this.errors={};
                if(!data.itemDesc)
                {
                   this.errors.itemDesc = 'Project title is required';
                }
                if(!data.unit)
                {
                    this.errors.unit = 'Unit Name is required';
                }
                if(!data.rate)
                {
                    this.errors.rate = ' This field is required';
                }
                return this.errors;
            },
            resetForm:function(){
                this.quill.setText('');
                this.formData.itemDesc = '';
                this.formData.unit = '';
                this.formData.rate = '';
            },

            addData:function(){
                this.errors = {};
                this.errors = this.validateAddForm(this.formData);
                if (Object.keys(this.errors).length===0)
                {
                        console.log(this.formData);
                     let addFormData = {
                        Desc:this.formData.itemDesc,
                        unit: this.formData.unit,
                        rate:this.formData.rate
                     };
{{--                                this.NonScheduleList.push({...addFormData});--}}
                    Livewire.emit('storeNonSchedule', addFormData);
                    this.resetForm();

             console.log('add Abstract data list',this.NonScheduleList);
        }
        else
        {
            Object.keys(this.errors).forEach(field => {
               const errorMessage = this.errors[field];
               const errorField = document.getElementById(`error-${field}`);
               if(errorField)
               {
                    errorField.innerText = errorMessage;
               }
            });

        }
    },
    removeItem(index)
    {
        this.NonScheduleList.splice(index, 1);
{{--                totalAmount();--}}
            }

        }">
            <div class="card">
                <div wire:loading.delay.longest>
                    <div class="spinner-border text-primary loader-position" role="status"></div>
                </div>
                <div wire:loading.delay.longest.class="loading" class="card-body">
                    <div class="row">
                        <div class="col-lg-12 col-sm-6 col-md-12">
                            <div class="form-group">
                                <x-form-level> Title</x-form-level>
                                <div id="editor" x-init="() => {
                                    quill = new Quill('#editor', {
                                        theme: 'snow',
                                        placeholder: 'Enter your text here...',
                                        modules: {
                                            toolbar: [
                                                [{ 'header': [1, 2, false] }],
                                                ['bold', 'italic', 'underline'],
                                                [{ 'list': 'ordered' }, { 'list': 'bullet' }],
                                                ['clean']
                                            ]
                                        }
                                    });
                                    quill.on('text-change', function() {
                                        formData.itemDesc = quill.root.innerHTML;
                                    });
                                }"
                                     x-model="formData.itemDesc"></div>
                                <small x-text="errors.itemDesc" class="text-danger"
                                       x-show="errors.itemDesc"></small>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-4 col-md-4">
                            <x-form-level>Unit</x-form-level>
                            <select x-model="formData.unit" class="form-control">
                                <option value="" disabled>Select Unit</option>
                                <template x-for="(unit,index) in Units" :key="index">
                                    <option :value="unit.id" x-text="unit.unit_name"></option>
                                </template>
                            </select>
                            <small x-text="errors.unit" class="text-danger"
                                   x-show="errors.unit"></small>
                        </div>

                        <div class="col-lg-4 col-sm-4 col-md-4">
                            <div class="form-group">
                                <x-form-level>Rate</x-form-level>
                                <input type="text" min="1"
                                       x-model="formData.rate" class="form-control"
                                       x-on:input="formData.rate=validateDecimal(formData.rate)" />
                                <small x-text="errors.rate" class="text-danger"
                                       x-show="errors.rate"></small>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group float-right">
                                <x-action-button class="btn-soft-success mt-4 px-5 py-2 rounded-pill" @click="addData">
                                    Save
                                </x-action-button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 col-lg-12 col-sm-6">
                    <template x-if="NonScheduleList.length>0">
                    <div class="card">
                        <div class="card-body overflow-auto">
                            <div class="table-left-bordered table-responsive mt-4">
                                <table class="table mb-0" role="grid">
                                    <thead>
                                        <tr class="bg-white">
                                            <th class="text-dark text-left" width="5%">Sl.No</th>
                                            <th class="text-dark text-left" width="50%">Item Description</th>
                                            <th class="text-dark text-center" width="10%">Unit</th>
                                            <th class="text-dark text-end" width="15%">Rate</th>
                                            <th class="text-dark text-center" width="10%" data-exclude="false">
                                                {{ trans('cruds.abstract.fields.actions') }}</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                    <template x-for="(item,index) in NonScheduleList"
                                              :key="Date.now() + Math.floor(Math.random() * 100000)">
                                            <tr>
                                                <td class="text-dark text-left" x-text="index+1"></td>
                                                <td class='text-wrap text-dark text-left' x-html="item.Desc"></td>
                                                <td class='text-wrap text-dark text-center' x-text="item.unit"></td>
                                                <td class='text-wrap text-dark text-end' x-text="item.rate"></td>
                                                <td>
                                                    <x-action-button class="btn-soft-danger"
                                                                     @click=removeItem(index)>
                                                        <x-lucide-trash class="w-4 h-4 text-gray-500" />
                                                        {{ trans('global.delete_btn') }}
                                                    </x-action-button>
                                                </td>
                                            </tr>
                                    </template>
                                    </tbody>
                                </table>
                            </div>
                            <div class="form-group float-right">
                                <x-action-button class="btn-success mt-4 px-5 py-2 rounded-pill" @click="Savedata">
                                    Save
                                </x-action-button>
                            </div>
                        </div>
                    </div>

                    </template>
                    <template x-if="!NonScheduleList">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-left-bordered table-responsive mt-4">
                                    <table class="table mb-0" role="grid">
                                        <tbody>
                                            <tr>
                                                <td colspan="6">No Data Found</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </div>
</div>
