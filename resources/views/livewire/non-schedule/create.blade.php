<div>
    <div class="row">
        <div class="col-sm-12 col-lg-12" x-data="{
            formData:{itemDesc:'',unit:'',qty:0,rate:0},
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
                if(!data.qty)
                {
                    this.errors.qty = 'This field is required';
                }
                if(!data.rate)
                {
                    this.errors.rate = ' This field is required';
                }
                return this.errors;
            },
            resetForm:function(){
                this.quill.setContents([]);
                this.formData.itemDesc = '';
                this.formData.unit = '';
                this.formData.qty = '';
                this.formData.rate = '';
            },
             get totalPrice() {
                    return this.formData.qty * this.formData.rate;
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
                                    qty:this.formData.qty,
                                    rate:this.formData.rate,
                                    totalAmount:this.totalPrice

                                };
                                this.NonScheduleList.push({...addFormData});
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
            get totalAmount() {
                 return this.NonScheduleList.reduce((sum, row) => sum + row.totalAmount, 0);
            },
            removeItem(index)
            {
                this.NonScheduleList.splice(index, 1);
{{--                totalAmount();--}}
            }
            Dear Madam/Sir,
        I'n Really interested for Lamp Stack Developer. Your Company need also Laravel developer for 2 year of experience and fluent english communication skills but I'n not good to communicate fluent  english. but i'm commicate team in engish not fluent. Can possible without fluent only communicate team or another persons. This is my big opportunity for better career goals change my life. Please change this opportunity

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
                        <div class="col-lg-3 col-sm-3 col-md-3">
                            <x-form-level>Unit</x-form-level>
                            <select x-model="formData.unit" class="form-control">
                                <option value="" disabled>Select Unit</option>
                                <template x-for="(unit,index) in Units" :key="index">
                                    <option :value="unit.unit_name" x-text="unit.unit_name"></option>
                                </template>
                            </select>
                            <small x-text="errors.unit" class="text-danger"
                                   x-show="errors.unit"></small>
                        </div>
                        <div class="col-lg-3 col-sm-3 col-md-3">
                            <div class="form-group">
                                <x-form-level>Quantity</x-form-level>
                                <input type="text" min="1"
                                       x-model="formData.qty" class="form-control"
                                       x-on:input="formData.qty=validateDecimal(formData.qty)" />
                                <small x-text="errors.qty" class="text-danger"
                                       x-show="errors.qty"></small>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-3 col-md-3">
                            <div class="form-group">
                                <x-form-level>Price</x-form-level>
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
                                    Add
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
                                            <th class="text-dark text-end" width="8%">Quantity</th>
                                            <th class="text-dark text-end" width="15%">Rate</th>
                                            <th class="text-dark text-end" width="15%">Total Amount</th>
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
                                                <td class='text-wrap text-dark text-end' x-text="item.qty"></td>
                                                <td class='text-wrap text-dark text-end' x-text="item.rate"></td>
                                                <td class='text-wrap text-dark text-end'   x-text="Number(item.totalAmount).toFixed(2)"></td>
                                                <td>
                                                    <x-action-button class="btn-soft-danger"
                                                                     @click=removeItem(index)>
                                                        <x-lucide-trash class="w-4 h-4 text-gray-500" />
                                                        {{ trans('global.delete_btn') }}
                                                    </x-action-button>
                                                </td>
                                            </tr>
                                    </template>
                                    <tr>
                                        <td colspan="5" class="text-end">
                                            Total Amount =
                                        </td>
                                        <td class="text-wrap" style='text-align:end;'
                                            x-text='totalAmount.toFixed(2)'>

                                        </td>
                                        <td></td>
                                    </tr>
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
            <div class="col-md-12 col-lg-12 col-sm-6">

            </div>
        </div>
    </div>
</div>
