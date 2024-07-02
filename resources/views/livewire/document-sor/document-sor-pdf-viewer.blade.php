<div>
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
                    @if($pdfContent)
                    <iframe id="pdfFrame" title="Document SOR" src="data:application/pdf;base64,{{base64_encode($pdfContent)}}" width="100%"
                        height="1000"></iframe>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" id="closeBtne" class="btn btn-secondary rounded btn-sm" data-dismiss="modal"
                        aria-label="Close">Close</button>
                </div>
            </div>
        </div>
    </div>
    <script>
	const pdfEncodeTitle = document.getElementById("pdfFrame").title;
	console.log(pdfEncodeTitle);
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