<style>
    .error {
        border-color: red;
    }
</style>
<div max-width="5xl" class="modal" id="unit-popup-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="MIN-WIDTH: FIT-CONTENT;">
        <div class="modal-content">
            <div class="modal-header unit-modal-popup" style="background: #1d2b74;">
                <h5 class="modal-title" id="unitModalLabel" style="font-weight: bold;color: white;">
                    {{ ucfirst($sendArrayDesc) }}</h5>
                <button type="button" id="closeBtn" aria-label="Close">
                    <span class="cross-btn" aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <table class="table">
                    <span class="error-message-input" style="color: red;font-size: inherit;"></span>
                    <thead class="headattr" style="text-align: center;">
                        <tr>
                            <th>Sl.no</th>
                            <th>Member</th>
                            <th>Number</th>
                            <th>Height</th>
                            <th>Breadth</th>
                            <th>Length</th>
                            <th>Unit</th>
                            <th></th>
                            <th>Total</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="inputRows">
                        @php
                            $sessionData = Session()->get('modalData');
                            //@dd($sessionData);
                            $index = 1;
                        @endphp
                        @if (isset($sessionData[$unit_id]))
                            @foreach ($sessionData[$unit_id] as $item)
                                <tr>
                                    <td class="rowLabel">{{ $index }}</td>
                                    <td><input type="text" class="form-control required-field" name="member[]"
                                            value="{{ $item['member'] }}" data-toggle="tooltip" data-placement="top"
                                            title="This field is required"> <span class="error-message"
                                            style="color: red;font-size: small;"></span></td>
                                    <td><input type="text" class="form-control required-field" name="number[]"
                                            value="{{ $item['number'] }}" data-toggle="tooltip" data-placement="top"
                                            title="This field is required"><span class="error-message"
                                            style="color: red; font-size: small;"></span></td>
                                    <td><input type="text" class="form-control required-field" name="height[]"
                                            value="{{ $item['height'] }}" data-toggle="tooltip" data-placement="top"
                                            title="This field is required"><span class="error-message"
                                            style="color: red; font-size: small;"></span></td>
                                    <td><input type="text" class="form-control required-field" name="breadth[]"
                                            value="{{ $item['breadth'] }}" data-toggle="tooltip" data-placement="top"
                                            title="This field is required"><span class="error-message"
                                            style="color: red; font-size: small;"></span></td>
                                    <td><input type="text" class="form-control required-field" name="length[]"
                                            value="{{ $item['length'] }}" data-toggle="tooltip" data-placement="top"
                                            title="This field is required"><span class="error-message"
                                            style="color: red; font-size: small;"></span></td>
                                    <td>
                                        <select class="form-control required-field" name="unit[]" data-toggle="tooltip"
                                            data-placement="top" title="This field is required">
                                            <option value="" {{ $item['unit'] == '' ? 'selected' : '' }}>
                                                Select</option>
                                            @foreach ($unitMaster as $unit)
                                                <option value="{{ $unit['id'] }}"
                                                    {{ $item['unit'] == $unit['id'] ? 'selected' : '' }}>
                                                    {{ $unit['short_name'] }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>=</td>
                                    <td><input type="text" class="form-control total-input" name="total[]"
                                            placeholder="0" value="{{ $item['total'] }}"></td>
                                    <td>
                                        @if ($index > 0)
                                            <button type="button" class="btn btn-success addRowBtn"
                                                style="color: #fff;padding:0px;width: 22px;">+</button>
                                            <button type="button" class="btn btn-danger deleteRowBtn"
                                                style="color: #fff; padding: 0px;width: 22px; display: none;">X</button>
                                        @else
                                            <button type="button" class="btn btn-success addRowBtn"
                                                style="color: #fff;padding:0px;width: 22px ">+</button>
                                            <button type="button" class="btn btn-danger deleteRowBtn"
                                                style="color: #fff; padding: 0px;width: 22px ">Xxx</button>
                                        @endif
                                        <input type="hidden" name="child_id[]" value="{{ $item['child_id'] }}">
                                    </td>
                                </tr>
                                @php $index++; @endphp
                            @endforeach
                        @else
                            <tr>
                                <td class="rowLabel">1</td>

                                <td><input type="text" class="form-control required-field" name="member[]"
                                        data-toggle="tooltip" data-placement="top" title="This field is required">
                                    <span class="error-message" style="color: red;font-size: small;"></span>
                                </td>
                                <td><input type="text" class="form-control required-field" name="number[]"
                                        data-toggle="tooltip" data-placement="top" title="This field is required">
                                    <span class="error-message" style="color: red;font-size: small;"></span>
                                </td>
                                <td><input type="text" class="form-control required-field" name="height[]"
                                        data-toggle="tooltip" data-placement="top" title="This field is required">
                                    <span class="error-message" style="color: red;font-size: small;"></span>
                                </td>
                                <td><input type="text" class="form-control required-field" name="breadth[]"
                                        data-toggle="tooltip" data-placement="top" title="This field is required">
                                    <span class="error-message" style="color: red;font-size: small;"></span>
                                </td>
                                <td><input type="text" class="form-control required-field" name="length[]"
                                        data-toggle="tooltip" data-placement="top" title="This field is required">
                                    <span class="error-message" style="color: red;font-size: small;"></span>
                                </td>

                                <td>
                                    <select class="form-control required-field" name="unit[]" data-toggle="tooltip"
                                        data-placement="top" title="This field is required">
                                        <option value="" selected>Select</option>
                                        @if (isset($unitMaster) && !empty($unitMaster))
                                            @foreach ($unitMaster as $unit)
                                                <option value="{{ $unit['id'] }}">{{ $unit['short_name'] }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </td>
                                <td>=</td>
                                <td>
                                    <input type="text" class="form-control total-input" name="total[]"
                                        placeholder="0">
                                </td>
                                <td>
                                    <button type="button" class="btn btn-success addRowBtn"
                                        style="color: #fff;padding:0px;width: 22px ">+</button>
                                    <button type="button" class="btn btn-danger deleteRowBtn"
                                        style="color: #fff;display: none; padding: 0px;width: 22px ">X</button>
                                    <input type="hidden" name="child_id[]" value="child_1">
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>

                <div class="overttl" style="float: right;margin-right: 0%;">
                    <span class="ovral-txt" style="font-weight: 600;">Overall Total</span>
                    <input type="text" class="form-control overallTotal" placeholder="Overall Total" readonly>
                    <button type="button" id="submitBtn" class="btn btn-success rounded-pill"
                        onclick="submitData()" style="margin-top: 14px; float: inline-end;">Submit</button>
                </div>

                <div id="example-table"></div>
            </div>

            <div class="modal-footer">
                <button type="button" id="closeBtn" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    $(document).ready(function() {

        $("#unit-popup-modal").modal({
            backdrop: 'static',
            keyboard: false
        });

        $(document).off("click", "#closeBtn");
        $(document).on("click", "#closeBtn", function() {
            closeModal();

        });

        function closeModal() {
            $("#unit-popup-modal").modal('hide');
            window.Livewire.emit('closeUnitModal');
        }
        $("#unit-popup-modal").modal("show");





        var uniqueChildIdCounter = 0;
        var overallTotal = 0;

        function calculateTotalAndOverall() {
            overallTotal = 0;

            $("#inputRows tr").each(function(index, element) {
                var row = $(this);
                var number = parseFloat(row.find("input[name='number[]']").val()) || '';
                var height = parseFloat(row.find("input[name='height[]']").val()) || '';
                var breadth = parseFloat(row.find("input[name='breadth[]']").val()) || '';
                var length = parseFloat(row.find("input[name='length[]']").val()) || '';

                if (number === 0 || height === 0 || breadth === 0 || length === 0) {
                    alert("Please enter valid non-zero numeric values");
                    row.find("input[name='total[]']").val("");
                } else {
                    var total_val = (number * height * breadth * length).toFixed(3);
                    row.find("input[name='total[]']").val(total_val);
                }
            });

            $(".total-input").each(function() {
                overallTotal += parseFloat($(this).val()) || '';
            });

            $(".overallTotal").val(overallTotal);
        }
        window.submitData = function() {
            var isEmpty = false;
            $("#inputRows input.required-field").each(function() {
                $(this).removeClass("error").tooltip("dispose");
                if ($(this).val().trim() === '') {
                    isEmpty = true;
                    $(this).addClass("error").tooltip({
                        title: "This field is required",
                        placement: "top"
                    });
                    return false;
                } else {

                    $(this).removeClass("error").tooltip("dispose");
                }
            });
            $("#inputRows select[name='unit[]']").each(function() {
                if ($(this).val() === '') {
                    isEmpty = true;
                    $(this).addClass("error");
                    $(this).tooltip({
                        title: "Please select a unit",
                        placement: "top"
                    });
                }
            });
            if (isEmpty) {
                event.preventDefault();
            } else {
                var data = [];
                $("#inputRows tr").each(function(index, element) {
                    var childId = 'child_' + (index);
                    var rowData = {
                        child_id: childId,
                        parent_id: '{!! $unit_id !!}',
                        member: $(this).find("input[name='member[]']").val(),
                        number: $(this).find("input[name='number[]']").val(),
                        height: $(this).find("input[name='height[]']").val(),
                        breadth: $(this).find("input[name='breadth[]']").val(),
                        length: $(this).find("input[name='length[]']").val(),
                        unit: $(this).find("select[name='unit[]']").val(),
                        total: $(this).find("input[name='total[]']").val() || '',
                    };
                    data.push(rowData);
                    console.log(data);
                });
                window.Livewire.emit('unitQtyAdded', data, overallTotal);
                closeModal();
            }


        };
        $(document).off("input",
            "input[name='number[]'], input[name='height[]'], input[name='breadth[]'], input[name='length[]']"
        );
        $(document).on("input",
            "input[name='number[]'], input[name='height[]'], input[name='breadth[]'], input[name='length[]']",
            function() {
                calculateTotalAndOverall();
            });
        $(document).off("input",
            "input[name='number[]'], input[name='height[]'], input[name='breadth[]'], input[name='length[]']"
        );
        $(document).on("input",
            "input[name='number[]'], input[name='height[]'], input[name='breadth[]'], input[name='length[]']",
            function() {
                var inputVal = $(this).val().trim();
                var errorMessageSpan = $(this).closest('td').find('.error-message');

                if (inputVal === '' || isNaN(inputVal) || parseFloat(inputVal) <= 0) {
                    errorMessageSpan.text("Please enter a valid non-zero value");
                    if (parseFloat(inputVal) === 0) {
                        $(this).val(""); // Clear the input value
                    }
                } else {
                    errorMessageSpan.text("");
                }

                calculateTotalAndOverall();
            });

        function checkEmptyInput() {
            var isEmpty = false;
            $("#inputRows input[name='member[]'], #inputRows input[name='number[]'], #inputRows input[name='height[]'], #inputRows input[name='breadth[]'], #inputRows input[name='length[]']")
                .each(function() {
                    if ($(this).val().trim() === '') {
                        isEmpty = true;
                        return false;
                    }
                });

            return isEmpty;
        }


        $(document).off("click", "#inputRows .addRowBtn");
        $(document).on("click", "#inputRows .addRowBtn", function() {
            var newRow = $("#inputRows tr:last").clone();
            var currentSerial = parseInt(newRow.find(".rowLabel").text());
            newRow.find(".rowLabel").text(currentSerial + 1 + ".");
            newRow.find("input").val("");
            newRow.find("select[name='unit[]']").val(newRow.find("select[name='unit[]'] option:first")
                .val());
            newRow.find(".deleteRowBtn").show();
            newRow.find(".addRowBtn").show();
            $("#inputRows tr:last").find(".addRowBtn, .deleteRowBtn").hide();
            $("#inputRows").append(newRow);

            uniqueChildIdCounter++;
        });

        $(document).on("click", "#inputRows .deleteRowBtn", function() {
            var rowCount = $("#inputRows tr").length;
            if (rowCount > 1) {
                $(this).closest("tr").remove();
                $("#inputRows tr:last").find(".addRowBtn").show();
                $("#inputRows tr:last").find(".deleteRowBtn").hide();
            } else {
                $(this).closest("tr").find("input").val("");
                $(this).closest("tr").find("select[name='unit[]']").val(
                    $(this).closest("tr").find("select[name='unit[]'] option:first").val()
                );
            }

            calculateTotalAndOverall();

        });

        calculateTotalAndOverall();

        function showAddDeleteButtons() {
            var rowCount = $("#inputRows tr").length;
            $("#inputRows tr").each(function(index) {
                if (index === rowCount - 1) {
                    $(this).find(".addRowBtn, .deleteRowBtn").show();
                } else {
                    $(this).find(".addRowBtn, .deleteRowBtn").hide();
                }
            });
        }
        showAddDeleteButtons();

        function addNewRow() {
            var newRow = $("#inputRows tr:last").clone();
            var currentSerial = parseInt(newRow.find(".rowLabel").text());
            newRow.find(".rowLabel").text(currentSerial + 1 + ".");
            newRow.find("input").val("");

            newRow.find("select[name='unit[]']").val(newRow.find("select[name='unit[]'] option:first").val());

            $("#inputRows").append(newRow);
            calculateTotalAndOverall();
            showAddDeleteButtons();
            uniqueChildIdCounter++;

        }

        function deleteRow() {
            var rowCount = $("#inputRows tr").length;
            if (rowCount > 1) {
                $("#inputRows tr:last").remove();
                showAddDeleteButtons();

            }
            calculateTotalAndOverall();

        }
        $(document).off("click", "#inputRows .addRowBtn");
        $(document).on("click", "#inputRows .addRowBtn", function() {
            addNewRow();
        });
        $(document).off("click", "#inputRows .deleteRowBtn");
        $(document).on("click", "#inputRows .deleteRowBtn", function() {
            deleteRow();
        });
    });
</script>
