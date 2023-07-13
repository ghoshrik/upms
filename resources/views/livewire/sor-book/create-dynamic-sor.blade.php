<div>
    <div id="example-table"></div>
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
