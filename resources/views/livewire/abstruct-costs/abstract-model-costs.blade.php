<div>
    <div x-data="{
        tableContent: {},
        get totalAmount() {
            return this.tableContent.total_amount;
        },
        showModal: false,
        init() {
            Livewire.on('ListAbs', (data) => {
                if (!this.showModal) {
                    this.showModal = true;
                    this.tableContent = data;
                    console.log(this.tableContent);
                }
            });
        }
    }" x-init="init" :class="{ 'overflow-hidden': showModal }">
        <style>
            .total-amount-box {
                border: 1px solid #000;
                padding: 10px;
                margin-top: 10px;
                text-align: center;
                font-weight: bold;
                text-align: end;
            }
        </style>
        <!-- Background Overlay with Blur Effect -->
        <div x-show="showModal" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-300"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-40 bg-black bg-opacity-50 backdrop-blur"></div>
        <!--Modal Properties -->

        <!-- Custom Responsive Modal -->
        <div x-show="showModal" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform scale-90"
            x-transition:enter-end="opacity-100 transform scale-100"
            x-transition:leave="transition ease-in duration-300"
            x-transition:leave-start="opacity-100 transform scale-100"
            x-transition:leave-end="opacity-0 transform scale-90"
            class="fixed inset-0 z-50 flex items-center justify-center bg-gray-800 bg-opacity-75">
            <div class="bg-white p-6 rounded-lg shadow-lg max-w-lg w-full mx-2 sm:mx-4 md:mx-6 lg:mx-8">
                <div class="flex justify-between items-center" style="padding:5px 15px 0px 15px;font-size:30px;">
                    <h5 class="text-lg font-bold" x-html="tableContent.description"></h5>
                    <button @click="showModal = false" class="text-gray-500 hover:text-gray-700">&times;</button>
                </div>
                <div class="mt-4">
                    <div class="table-left-bordered table-responsive mt-4" style="padding:0 15px 15px 15px">
                        <table class="table mb-0" role="grid">
                            <thead>
                                <tr class="bg-white">
                                    <template x-for="(header,index) in tableContent.tableHeader" :key="index">
                                        <template x-if="header.field !== 'ACTIONS'">
                                            <th class="bg-white" x-text="header.title"></th>
                                        </template>
                                    </template>
                                </tr>
                            </thead>
                            <tbody>
                                <template x-for='(data,Index) in tableContent.tableData' :key='Index'>
                                    <tr>
                                        <template x-for="(header,key) in tableContent.tableHeader"
                                            :key="key">
                                            <template x-if="header.field !== 'ACTIONS'">
                                                <td
                                                    :class="{ 'text-end': key === tableContent.tableHeader.length - 2 }">
                                                    <span x-text="data[header.field]"></span>
                                                </td>
                                            </template>
                                        </template>
                                    </tr>
                                </template>
                                <tr>
                                    <td colspan="3">
                                        <div class="total-amount-box"
                                            x-text="'('+convertNumberToWords(totalAmount)+')'">
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
        <!--Modal Properties -->
    </div>
</div>
