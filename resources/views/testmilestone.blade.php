<x-app-layout :assets="$assets ?? []">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="header-title">
                            <h4 class="card-title">Milestone</h4>
                        </div>
                    </div>
                    <div class="card-body">

                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>

    <script>
        $(document).ready(function() {
            var html = $('.copy').css({
                "display": "none"
            });
            $('.add_more').click(function() {
                $(html).css({
                    'display': 'block'
                });
                $(html).after(html);
            });
        });
    </script>
</x-app-layout>
