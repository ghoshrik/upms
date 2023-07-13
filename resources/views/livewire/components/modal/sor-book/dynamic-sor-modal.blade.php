<div>
    <x-modal max-width="5xl" blur wire:model.defer="viewModal">
        <x-card>
            <div class="p-0 text-center">
                <x-lucide-clipboard-list class="w-10 h-12 mx-auto text-success" />
                <div class="mt-5 text-3xl">SOR OF Table {{ $table_no }} Page {{ $table_no }}</div>
                <div class="mt-2 text-slate-500"> </div>

                <div id="example-table"></div>
                <div>
                    @php
                        print_r($header_data);
                    @endphp
                </div>
                <x-slot name="footer">
                    <div class="flex justify-between">
                        <div class="flex float-left">
                            <x-button class="btn btn-soft-danger" flat label="Cancel" x-on:click="close" />
                        </div>
                    </div>
                </x-slot>
            </div>
        </x-card>
    </x-modal>
</div>
<script>
    $(document).ready(function() {
        var headerData = @json($header_data);

        var table = new Tabulator("#example-table", {
            height: "311px",
            columns: headerData
        });
    });
</script>
