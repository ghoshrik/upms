<div>
    <div class="table-responsive mt-4">
        <table id="basic-table" class="table table-striped mb-0" role="grid">
            <thead>
                <tr>
                    <th>Category Name</th>
                    <th>Volume No</th>
                    <th>Upload Type</th>
                    <th>Description</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>

                @forelse ($sorDocuments as $document)
                    @php
                        $category_name = DB::table('sor_category_types')
                            ->select('dept_category_name')
                            ->where('id', $document->dept_category_id)
                            ->first();
                    @endphp
                    <tr>
                        <td>
                            <div class="text-primary">{{ $category_name->dept_category_name }}</div>
                        </td>
                        <td>
                            <div class="text-primary">
                                @if ($document->volume_no == 1)
                                    Volume I
                                @elseif($document->volume_no == 2)
                                    Volume II
                                @else
                                    Volume III
                                @endif
                            </div>
                        </td>
                        <td>
                            <div class="text-primary">
                                @if ($document->upload_at == 0)
                                    Useful Tables
                                @elseif($document->upload_at == 1)
                                    Support Structure(Diagram)
                                @elseif($document->upload_at == 2)
                                    Formula
                                @elseif($document->upload_at == 3)
                                    Preface
                                @elseif($document->upload_at == 4)
                                    General Abstruct of Cost
                                @elseif($document->upload_at == 5)
                                    Contents
                                @elseif($document->upload_at == 6)
                                    General Conditions
                                @elseif($document->upload_at == 7)
                                    General Specification
                                @elseif($document->upload_at == 8)
                                    Others
                                @else
                                    Preamble
                                @endif
                            </div>
                        </td>
                        <td class="text-wrap">
                            <p>{{ base64_decode($document->desc) }}</p>
                        </td>
                        <td>
                            <button wire:click="pdfLink({{ $document->id }})" type="button"
                                class="btn btn-soft-primary btn-sm px-3 py-2.5 m-1 rounded"
                                wire:loading.attr="disabled">
                                <x-icon name="eye" class="w-5 h-5" />View
                            </button>
                            <x-edit-button wire:click="$emit('edit',{{ $document->id }})" id action />
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center"><strong>No Data Found</strong> </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        {{ $sorDocuments->links() }}
    </div>

    <div wire:loading.delay.long>
        <div class="spinner-border text-primary loader-position" role="status"></div>
    </div>
    <style>
        .custom-modal .modal-header .close {
            /* margin-top: -5px; */
            margin-top: 20px;
            position: absolute;
            /* right: -8px; */
            right: 21px;
            background-color: #000;
            opacity: 1;
            color: #fff;
            height: 25px;
            width: 25px;
            border-radius: 50%;
            top: -8px;
            z-index: 1;
        }
    </style>
    @if ($show)
        <div class="modal fade custom-modal" id="{{ $modalName }}" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalLabel" aria-hidden="true" style="background:#ffffff;">
            <div class="modal-dialog modal-fullscreen" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">{{ $title }}</h5>
                        <button type="button" class="close" id="closeBtn" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        @if ($pdfContent)
                            <iframe id="pdfFrame" title="Document SOR"
                                src="data:application/pdf;base64,{{ base64_encode($pdfContent) }}" width="100%"
                                height="1000"></iframe>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="closeBtne" class="btn btn-secondary rounded btn-sm"
                            data-dismiss="modal" aria-label="Close">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <script>
            document.getElementById("closeBtn").addEventListener("click", function() {
                closeModal();
            });
            document.getElementById("closeBtne").addEventListener("click", function() {
                closeModal();
            });

            function closeModal() {
                const mdlname = $('#' + @json($modalName)).modal('hide');
                //console.log(mdlname);
                window.Livewire.emit('closeModal');
            }
            $(document).ready(function() {
                $("#" + @json($modalName)).modal({
                    backdrop: "static",
                    keyboard: false
                });
                $("#" + @json($modalName)).modal("show");
            });
        </script>
    @endif

</div>
