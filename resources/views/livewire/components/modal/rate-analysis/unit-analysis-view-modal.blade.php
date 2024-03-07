<style>
    .error {
        color: red;
        font-size: small;
    }

    div#rowMessage {
        width: max-content;
    }

    select#selectOption {
        width: 10%;
        background: #1d2b74;
        color: white;
        text-align: center;
    }

    .active {
        margin-top: 0px;
    }

    div.dataTables_wrapper div.dataTables_paginate {
        display: none;
    }

    .col-sm-12.col-md-7 {
        display: none;
    }

    .col-sm-12.col-md-5 {
        display: none;
    }

    .actionbuttons {
        margin-top: 84px;
    }

    .prevdata {
        margin-bottom: 24px;
        margin-right: 21%;
    }


    .button-cell {
        white-space: nowrap;

    }

    .addbtn {
        margin-left: 5px;
    }

    div.dataTables_wrapper div.dataTables_filter input {
        margin-left: 0.5em;
        display: inline-block;
        width: auto;
        border-radius: 50rem;
    }

    div.dataTables_wrapper div.dataTables_length select {
        width: auto;
        display: inline-block;
        border-radius: 50rem;
    }

    .card.input-fields {
        border-bottom-width: 1px;
    }

    .firstinput {
        background-color: #aaaaaa17;
    }

    .lastinput {
        background-color: #aaaaaa17;
    }

    button.btn.btn-primary.calc {
        width: auto;
        float: inline-end;
    }



    span.ovral-txt {
        margin-top: 2px;
    }

    .col-md-12.calculation-result {
        background: honeydew;
        width: 21%;
    }

    .col-md-12.calculation-result.p {
        font-style: italic;
        font-weight: 600;
    }



    .row.formulae {
        width: fit-content;
    }

    span.formula {
        /* FONT-SIZE: inherit; */
        FONT-WEIGHT: 800;
        margin-bottom: 23px;
        text-decoration-line: underline;
        color: #000000a8;
    }

    button.btn-close.delete-row-btn {
        background: #c03221;
        color: white;
        padding-top: 0px;
        padding-bottom: 8px;
    }

    button.btn-add.addbtn {
        background: darkgray;
        width: 22px;
        border-radius: 3px;
        color: white;
    }



    table {
        font-family: arial, sans-serif;
        border-collapse: collapse;
        width: 100%;
    }

    .modal-footer.rate-analysis {
        background: #f7f7f7;
        margin-top: 31px;
    }

    .modal-header.rate-analysis {
        background: #f7f7f7;
    }




    button.btn.rounded-pill.editBtn.delBtn {
        font-size: x-small;
    }



    .col-md-3.optionDropdown{
        flex: 0 0 auto;
        width: 20%;
    }

    .card.input-fields {

        width: 100%;
    }

    #more {
        display: none;
    }

    p.desp {
        margin-top: 0;
        margin-bottom: 0rem;
        color: black;
    }

    button#myBtn {
        color: blue;
        font-size: revert;
    }


    button.btn.btn-soft-primary.calc {
        float: inline-end;
    }

    /* new css 25-02-2024 */

    .table-unit.thead {
        white-space: nowrap;
        text-align: center;
    }

    /* .totalSum {
        width: auto;
        float: right;
    } */

    .row.submitBtn {
        margin-top: 2%;
        margin-right: 35px;
    }

    #datatable1.table tbody tr td {
        vertical-align: middle;
    }

    input.form-control.m-input.empty-field:not(.total),
    select.form-control.m-input.empty-field {
        border-color: red;
    }


    a.selectOption {
        color: #212529ba;
        margin-left: 14PX;
    }

    a.prev-data {
        color: #212529ba;
        margin-left: 14PX;
    }

    .box-border {
        box-shadow: 1px 1px 5px;
    }

    .dropdown-menu li:hover {
        background-color: #3a57e8;
        color: #f7f7f7
    }

    .dropdown-menu li a {
        display: block;
        padding: 1px 10px;
        color: inherit;
        text-decoration: none;
    }

    ul.dropdown-menu.show {
        box-shadow: 0px 0px 5px;
    }

    button.btn.relative.rounded-md.shadow-sm.dropdown-toggle.box-border.show {
        background-color: #3a57e8;
        color: white;
    }

    #rulesDropdown {
        display: none;
        position: absolute;
        top: 0;
        left: 100%;
        margin-top: -1px;
        box-shadow: 0px 0px 5px;
    }

    .dropdown-item:hover {
        background-color: #3a57e8;
        color: white;
        box-shadow: 0px 0px 5px;
        /* Change to the desired background color */
    }

    /* .form-control {
        text-align: center;
    } */

    .table-container {
        position: relative;
    }

    table#dataTable {
        margin-top: 3%;
    }

    div#additionalFields {
        margin-top: 7%;
    }

    .grandTotalInput.box-border {
        background-color: #e9ecef;
        width: 20%;
    }

    .col-md-9.ttlll {
        text-align: end;
        margin-top: 8px;
        font-size: larger;
    }

    .row-table thead tr {
        background-color: #F5F6FA;
        text-align: center;
    }

    .unit {
        padding: 5px;
        padding-top: 1px;
        padding-bottom: 1px;
        width: auto;
        height: 42px;

    }

    div#rowMessage {
        width: max-content;
        background: none;
        border: none;
        padding: 0px;
    }

    .card.input-fields {
        height: 300px;
        /* Set the height of the card */
        overflow-y: auto;
        /* Enable vertical scrolling */
    }

    .card.input-fields .card-body {
        overflow-y: auto;
    }

    div#successAlert {
        width: max-content;
        background: none;
        border: none;
        padding: 0px;
        float: inline-end;
    }
</style>

<div class="modal" id="myInput" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"
    data-bs-backdrop="static">
    <div class="modal-dialog modal-xl modal-dialog-scrollable " role="document">
        <div class="modal-content rate-analysis">
            <?php
            // Assuming $sendArrayDesc is defined and contains the description
            $inputstring = ucfirst($sendArrayDesc);
            $pieces = explode(' ', $inputstring);
            $first_part = implode(' ', array_splice($pieces, 0, 5));
            $other_part = implode(' ', $pieces);
            ?>

            <div class="modal-header rate-analysis">
                <p class="desp">
                    <span id="dots"><?php echo $first_part; ?> ...</span>
                    <span id="more" style="display:none;"><?php echo $first_part . ' ' . $other_part; ?></span>
                    <button id="myBtn">Read more</button>
                </p>
            </div>



            <div class="modal-body">
                <div style="width:100%;">
                    <div id="successAlert" class="alert" role="alert" style="display: none;"></div>
                    <div class="prevdata row align-items-center">
                        <div class="col-md-3 optionDropdown">
                            <div class="dropdown">
                                <button class="btn relative rounded-md  dropdown-toggle box-border" type="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    Select Option
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="selectOption" href="#" data-value="RULE">RULE</a></li>
                                    <div id="rulesDropdown" style="display: none;" class="dropdown-menu"
                                        aria-labelledby="dropdownMenuButton">

                                    </div>
                                    <li><a class="selectOption" href="#" data-value="OTHER">OTHER</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-3 pre">
                            @if ($arrayCount > 1)
                                @if (!empty($dropdownData))
                                    <div class="dropdown">
                                        <button class="btn relative rounded-md  dropdown-toggle box-border"
                                            id="mySelect" type="button" data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                            Select Previous Data
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end" style="width: calc(100% + 4.5rem);">
                                            <!-- Adjust the width as needed -->
                                            @isset($dropdownData)
                                                @foreach ($dropdownData as $listData)
                                                    <li><a class="prev-data" href="#">{{ $listData }}</a></li>
                                                @endforeach
                                            @endisset
                                        </ul>
                                    </div>
                                @endif
                            @endif
                        </div>
                        <div class="col-md-6"></div>
                    </div>

                    <div class="table-container" style="height: 100px; overflow-y: auto;">
                        <table id="dataTable1" class="table mt-2 table-unit">
                            <thead>
                                <tr>
                                    <th class="whitespace-nowrap" style="text-align:center;">Sl.no</th>
                                    <th class="whitespace-nowrap" style="text-align:center;">Option</th>
                                    <th class="whitespace-nowrap" style="text-align:center;">Total</th>
                                    <th class="whitespace-nowrap" style="text-align:center;">UNIT NAME</th>
                                    <th class="whitespace-nowrap" style="text-align:center;">Action</th>
                                </tr>
                            </thead>

                            <tbody class="metatable" style="overflow-y:auto;">
                                @if (isset($rateAnalysisArray[$unit_id]) && isset($rateAnalysisArray[$unit_id]['metadata']))
                                    <?php foreach ($rateAnalysisArray[$unit_id]['metadata'] as $index => $metadata): ?>
                                    <tr>
                                        <td style="text-align:center;">A<?php echo $index + 1; ?></td>
                                        <td style="text-align:center;"><?php echo $metadata['type']; ?></td>
                                        <td style="text-align:center;"><?php echo $metadata['overallTotal']; ?></td>
                                        <td style="text-align:center;">
                                            {{ !empty($metadata['unit']) ? $metadata['unit'] : null }}</td>
                                        <td style="text-align:center;">
                                            <a type="button"
                                                class="btn btn-soft-secondary btn-sm mr-2 {{ $metadata['type'] === 'rule' ? 'editBtnrule' : 'editBtn' }}"
                                                data-id="{{ $metadata['currentId'] }}">
                                                Edit
                                            </a>
                                            <a type="button" class="btn btn-soft-danger btn-sm delBtn"
                                                data-id="{{ $metadata['currentId'] }}">
                                                Delete
                                            </a>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                @endif

                            </tbody>
                        </table>


                    </div>

                    <div class="row" id="metagrandtotal" style="overflow-y: auto;margin-top: 26px;">
                        <div class="col-md-9 ttlll">
                            Grand Total:
                        </div>
                        <div class="col-md-3  grandTotalInput" style="width:20%;">
                            <input type="text" id="grandTotalInput" class="form-control" readonly>
                        </div>
                    </div>



                    <form id="myForm" style="display:none;">
                        <div class="alert alert-danger" role="alert" id="emptyFieldsAlert" style="display: none;">
                            Please fill in all fields before submitting.
                        </div>

                        <div class="">
                            <div class="col-lg-12">
                                <div class="table-container">
                                    <table id="dataTable" class="table row-table">
                                        <thead>
                                            <tr class="thead">
                                                <th>Sl.no</th>
                                                <th>Member</th>
                                                <th>Number</th>
                                                <th>Height</th>
                                                <th>Breadth</th>
                                                <th>Length</th>
                                                <th>Unit</th>
                                                <th>Total</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="newinput">
                                            <!-- Table rows will be populated dynamically -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="row" style="margin-top: 16px;">
                            <div class="col-md-9 ttlll">
                                Rows Total:
                            </div>
                            <div class="col-md-3 grandTotalInput">
                                <input type="text" id="totalSum" class="form-control m-input" value="0.00"
                                    readonly>
                            </div>
                        </div>
                        <div class="row submitBtn">
                            <div class="col">
                                <button id="submitBtn" type="button" class="btn btn-soft-primary"
                                    style="float:right;">Save</button>
                            </div>
                        </div>
                    </form>

                    <div id="additionalFields" style="display: none;">

                        <div class="card input-fields overflow-auto">
                            <div class="card-body overflow-auto">
                                <div id="simpson" class="row formulae">
                                    <span class="formula">Simpson rule:-Area=(w/3)[yfirst + 4(yodd) + 2(yeven) +
                                        ylast]</span>
                                </div>
                                <div id="rowMessage" class="alert alert-info" style="display: none;"></div>

                                <form id="simpsonsRuleForm" class="row g-3 align-items-center">
                                    <div class="col-md-6">
                                        <label for="floatingInput">Enter Number of 'Y' Input </label>
                                        <input type="number" class="form-control" id="Input_for_Y_def"
                                            placeholder="Enter number of 'Y'" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="floatingInput">Enter value of 'W' </label>
                                        <input type="number" class="form-control" id="Input_for_W"
                                            placeholder="Enter number of 'W'" required>
                                    </div>
                                    <div class="col-md-12">
                                        <div id="error_message" class="text-danger"></div>
                                    </div>

                                </form>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer rate-analysis" style="display: flex; justify-content: space-between;">
                <button type="button" id="closeBtn" class="btn btn-soft-danger rounded-pill "
                    data-dismiss="modal">Close</button>
                <button id="finalSubmitBtn" type="button" class="btn btn-success rounded-pill " disabled>Submit</button>
            </div>
        </div>
    </div>
</div>
<script>
    var currentId = null;
    var currentruleId = null;
    var type;

    $(document).ready(function() {
        var unitId = @json($unit_id);
        var editEstimate_Id = @json($editEstimate_id);
        var arrayCount = @json($arrayCount);
        var myModal = new bootstrap.Modal(document.getElementById('myInput'), {
            backdrop: 'static'
        });
        myModal.show();
        $(document).off("click", "#closeBtn");
        $(document).on("click", "#closeBtn", function() {
            closeModal();

        });

        function closeModal() {
            $("#myInput").modal('hide');
            window.Livewire.emit('closeUnitModal');
        }

        $('#finalSubmitBtn').click(function() {
            var grandTotal = 0;
            $('.metatable td:nth-child(3)').each(function() {
                grandTotal += parseFloat($(this).text());
            });

            window.Livewire.emit('submitGrandTotal', grandTotal, unitId);
            closeModal();
            //alert('Grand Total: ' + grandTotal);
        });

        function updateGrandTotal() {
            var grandTotal = 0;
            $('.metatable td:nth-child(3)').each(function() {
                grandTotal += parseFloat($(this).text());
            });
            if (arrayCount == 0) {
                 grandTotal = 0;
            } else {
                $('#grandTotalInput').val(grandTotal);
            }
            var tableHeight = $('#dataTable1').height();
            var tableOffsetTop = $('#dataTable1').offset().top;
            var grandTotalInputHeight = $('.grandTotalInput').height();
            var newPositionTop = tableHeight + tableOffsetTop + 20; // Adjust margin as needed
            $('.grandTotalInput').css('top', newPositionTop + 'px');
        }

        // Update grand total whenever tbody content changes
        $('.metatable').on('DOMSubtreeModified', function() {
            updateGrandTotal();
        });

        // Trigger initial calculation when the document is ready

        updateGrandTotal();

        //rule code

        var rules = ["Simpson-rule", "Rule1", "Rule2", "Rule3", "Rule4"];

        function populateRulesDropdown() {
            var dropdownContent = "";
            rules.forEach(function(rule) {
                dropdownContent += `<a class="dropdown-item rule-item" href="#">${rule}</a>`;
            });
            $('#rulesDropdown').html(dropdownContent);
        }

        $('.dropdown-menu').on('mouseover', '.selectOption[data-value="RULE"]', function() {
            $('#rulesDropdown').show();
            populateRulesDropdown();
        });

        $('.dropdown-menu').on('click', '.selectOption[data-value="RULE"]', function() {
            var form = document.getElementById("simpsonsRuleForm");
            form.reset();
            currentId = null;
            currentruleId = null;
            type = "";
            $('#rulesDropdown').show();
            populateRulesDropdown();
        });

        $('.dropdown-menu').on('mouseover', '.selectOption[data-value="OTHER"]', function() {
            $('#rulesDropdown').hide();
        });
        $('.dropdown-menu').on('click', '.selectOption[data-value="OTHER"]', function() {
            $('#rulesDropdown').hide();
            currentId = null;
            currentruleId = null;
            type = "";
            var tableBody = $("#dataTable tbody");
            tableBody.empty();
            addNewRow();
            updateTotalSum();
        });

        $('.dropdown').on('mouseleave', function() {
            $('#rulesDropdown').hide();
        });

        $('#rulesDropdown').on('click', '.rule-item', function() {
            var type = $(this).text().trim();
            if (type === "Simpson-rule") {
                $('#additionalFields').show();
                $('#myForm').hide();
                var form = document.getElementById("simpsonsRuleForm");
                form.reset();
                currentId = null;
                currentruleId = null;
                type = "";
            } else {
                $('#additionalFields').hide();
                alert("OOPS! Nothing Found for " + type);
                var form = document.getElementById("simpsonsRuleForm");
                form.reset();
                currentId = null;
                currentruleId = null;
                type = "";
            }
        });




        $('#myBtn').click(function() {
            var dots = document.getElementById("dots");
            var moreText = document.getElementById("more");
            var btnText = document.getElementById("myBtn");

            if (dots.style.display === "none") {
                dots.style.display = "inline";
                btnText.innerHTML = "Read more";
                moreText.style.display = "none";
            } else {
                dots.style.display = "none";
                btnText.innerHTML = "... Read less";
                moreText.style.display = "inline";
            }
        });



        var numberOfY = 0;
        var firstInputResult, lastInputResult, oddSumResult, evenSumResult, areaResult;
        document.getElementById("Input_for_Y_def").addEventListener("input", function() {
            handleInputChanges();
            resetResults();
        });

        function handleInputChanges() {
            var numberOfY = parseInt(document.getElementById("Input_for_Y_def").value);
            var form = document.getElementById("simpsonsRuleForm");
            var errorMessage = document.getElementById("error_message");
            errorMessage.textContent = "";
            var existingYInputs = form.querySelectorAll("input[name^='Input_for_Y']");
            for (var i = 0; i < existingYInputs.length; i++) {
                existingYInputs[i].parentNode.remove();
            }
            var calculateButton = form.querySelector(".calc");
            if (calculateButton) {
                calculateButton.parentNode.remove();
            }
            if (numberOfY % 2 !== 0) {
                errorMessage.textContent = "Please enter even numbers for 'Y'";
                return;
            }
            var inputForW = document.getElementById("Input_for_W").parentNode;
            for (var i = numberOfY; i >= 1; i--) {
                var label = document.createElement("label");
                label.textContent = "Input for Y" + i;
                var input = document.createElement("input");
                input.type = "number";
                input.className = "form-control";
                input.placeholder = i === 1 ? "Enter value for Y1" : (i === numberOfY ? "Enter value for Y" +
                    numberOfY : "Enter value for Y");
                input.required = true;
                input.name = "Input_for_Y" + i;

                if (i === 1) {
                    input.classList.add("firstinput");
                }

                // Add class to the last input
                if (i === numberOfY) {
                    input.classList.add("lastinput");
                }

                var div = document.createElement("div");
                div.className = "col-md-4";
                div.appendChild(label);
                div.appendChild(input);
                form.insertBefore(div, inputForW.nextSibling);
            }


            var calculateRow = document.createElement("div");
            calculateRow.className = "row";
            var calculateCol = document.createElement("div");
            calculateCol.className = "col-md-12";
            var calculateButton = document.createElement("button");
            calculateButton.type = "button";
            calculateButton.className = "btn btn-soft-primary calc";
            calculateButton.textContent = "Calculate";
            calculateButton.addEventListener("click", calculate);
            calculateCol.appendChild(calculateButton);
            calculateRow.appendChild(calculateCol);
            form.appendChild(calculateRow);

            document.getElementById("rowMessage").innerText = "Total number of  'Y' Inputs: " + numberOfY;
            document.getElementById("rowMessage").style.display = "block";
            setTimeout(function() {
                document.getElementById("rowMessage").style.display = "none";
            }, 1000);
        }


        function calculate() {
            //alert(type);
            var existingResults = document.querySelectorAll(".calculation-result");
            existingResults.forEach(function(result) {
                result.remove();
            });

            var inputs = document.querySelectorAll("input[name^='Input_for_Y'], input#Input_for_W");

            // console.log(inputs);
            var oddSum = 0;
            var evenSum = 0;
            var firstInputValue = null;
            var lastInputValue = null;
            var hasEmptyField = false;
            inputs.forEach(function(input, index) {
                var value = parseFloat(input.value);
                if (!isNaN(value)) {

                    if (input.id === "Input_for_W") {
                        if (value === 0) {
                            hasEmptyField = true;
                        }
                    } else {

                        if (index === 1) {
                            firstInputValue = value;
                        } else if (index === inputs.length - 1) {
                            lastInputValue = value;
                        } else {
                            if (index % 2 === 0) {
                                evenSum += value;
                            } else {
                                oddSum += value;
                            }
                        }
                    }
                } else {

                    hasEmptyField = true;
                }
            });



            if (hasEmptyField) {
                var rowMessage = document.getElementById("rowMessage");
                rowMessage.textContent = "Please fill in all input fields (including 'W') before calculating.";
                rowMessage.style.display = "block";
                rowMessage.classList.add("alert-danger");
                setTimeout(function() {
                    document.getElementById("rowMessage").style.display = "none";
                }, 1000);
                return;
            } else {

                document.getElementById("rowMessage").classList.add("alert-success");
            }
            var odd = 4 * evenSum;
            var even = 2 * oddSum;
            var sum = (firstInputValue + lastInputValue);
            var area = (document.getElementById("Input_for_W").value / 3) * (firstInputValue + lastInputValue +
                odd + even);

            var resultContainer = document.createElement("div");
            resultContainer.className = "col-md-12 calculation-result";

            var firstInputResult = document.createElement("p");
            firstInputResult.textContent = "First Input: " + (firstInputValue !== null ? firstInputValue :
                "N/A");

            var lastInputResult = document.createElement("p");
            lastInputResult.textContent = "Last Input: " + (lastInputValue !== null ? lastInputValue : "N/A");

            var oddSumResult = document.createElement("p");
            oddSumResult.textContent = "Sum of Even Inputs: " + oddSum;

            var evenSumResult = document.createElement("p");
            evenSumResult.textContent = "Sum of Odd Inputs: " + evenSum;

            var areaResult = document.createElement("p");
            var areaRounded = area.toFixed(2);

            var inputValues = {}; // Array to store input values

            inputs.forEach(function(input, index) {
                var value = parseFloat(input.value);
                if (!isNaN(value)) {
                    var name = input.name === "" ? "Input_for_W" : input.name;
                    inputValues[input.name] = value; // Push value to inputValues array
                }
            });
            if (typeof inputValues["Input_for_W"] === "undefined") {
                inputValues["Input_for_W"] = inputValues[""]; // Set Input_for_W to the value of ""
                delete inputValues[""]; // Remove the empty string key
            }
            var inputForYDefValue = parseInt($("#Input_for_Y_def").val());
            //var numberOfY = parseInt($("#Input_for_Y_def").val());

            // Include the value of Input_for_def_Y in the inputValues object
            inputValues["Input_for_def_Y"] = parseFloat(inputForYDefValue);
            // Prepare ruledata object with input values
            inputValues["parent_id"] = '{!! $unit_id !!}'; // Append parent_id
            inputValues["currentruleId"] = currentruleId; // Append currentruleId
            //inputValues["type"] = type; // Append type
            inputValues["type"] = "rule";
            inputValues["unit"] = "Cum";
            inputValues["overallTotal"] = areaRounded;
            inputValues["editEstimate_id"] = editEstimate_Id;

            // Prepare ruledata object with input values
            var ruledata = {
                input_values: inputValues // Include input values in the ruledata object
            };
            // console.log(ruledata);
            $.ajax({
                url: '/store-unit-modal-rule-data',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                contentType: 'application/json',
                data: JSON.stringify({
                    data: ruledata
                }),
                success: function(response) {
                    var form = document.getElementById("simpsonsRuleForm");
                    form.reset();
                    var tableBody1 = $("#dataTable tbody");
                    tableBody1.empty();
                    var rateAnalysisArray1 = response.rateAnalysisArray[unitId]['metadata'];
                    var tableBody = $("#dataTable1 tbody");
                    tableBody.empty(); // Clear existing rows before appending new ones
                    var sno = 0;
                    type = null;
                    // Iterate over the rateAnalysisArray to create new table rows
                    $.each(rateAnalysisArray1, function(index, metadata) {
                        var newRow = $("<tr>");
                        newRow.append('<td style="text-align:center;">A' + (sno +
                            1) + '</td>');
                        newRow.append('<td style="text-align:center;">' + metadata
                            .type + '</td>');
                        newRow.append('<td style="text-align:center;">' + metadata
                            .overallTotal + '</td>');
                        newRow.append('<td style="text-align:center;">' + metadata
                            .unit + '</td>');

                        var editButton = $('<a>').attr({
                            'type': 'button',
                            'class': 'btn btn-soft-secondary btn-sm mr-2 ' + (
                                metadata.type === 'rule' ?
                                'editBtnrule' : 'editBtn'),
                            'data-id': metadata.currentId
                        }).text('edit');

                        var deleteButton = $('<a>').attr({
                            'type': 'button',
                            'class': 'btn btn-soft-danger btn-sm delBtn',
                            'data-id': metadata.currentId
                        }).text('Delete');

                        var buttonCell = $('<td>').css('text-align', 'center')
                            .append(editButton).append(' ').append(deleteButton);
                        newRow.append(buttonCell);

                        // Append the new row to the table body
                        tableBody.append(newRow);
                        sno++;
                    });
                    if (tableBody.find('tr').length > 0) {
                        $('#mySelect').hide();
                        $('#metagrandtotal').show();
                    } else {
                        $('#mySelect').show();
                        $('#metagrandtotal').hide(); // Hide your div
                    }
                    $('#successAlert').text('Rule Added successfully');
                    $('#successAlert').addClass('alert-success').removeClass('alert-danger')
                        .show();
                        $("#closeBtn").prop("disabled", true);
                        $("#finalSubmitBtn").prop("disabled", false);
                    // Optionally, you can hide the alert after a certain duration
                    setTimeout(function() {
                        $('#successAlert').hide();
                    }, 3000); // 3000 milliseconds (5 seconds) example
                },
                error: function(xhr, status, error) {
                    console.error('Error occurred:', xhr.responseText);
                }
            });
            //  window.Livewire.emit('unitQtyAddedrule', ruledata, areaRounded);

            areaResult.textContent = "Area: " + areaRounded + " cm^3";

            resultContainer.appendChild(firstInputResult);
            resultContainer.appendChild(lastInputResult);
            resultContainer.appendChild(oddSumResult);
            resultContainer.appendChild(evenSumResult);
            resultContainer.appendChild(areaResult);
            var form = document.getElementById("simpsonsRuleForm");
            // form.appendChild(resultContainer);
        }

        $(document).on("click", ".editBtnrule", function() {
            currentruleId = this.getAttribute("data-id");

            // Make an AJAX request to fetch data
            $.ajax({
                url: '/get-modal-rule-data',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                contentType: 'application/json',
                data: JSON.stringify({
                    unitId: unitId,
                    ruleId: currentruleId,
                    editEstimate_id: editEstimate_Id
                }),
                success: function(response) {
                    if (response.status) {
                        $('#additionalFields').show();
                        $('#myForm').hide();
                        $("#closeBtn").prop("disabled", true);
                        $("#finalSubmitBtn").prop("disabled", false);
                        var sessionData = response.rateAnalysisArray;
                        // console.log(sessionData);

                        // Populate data into form fields
                        document.getElementById("Input_for_W").value = sessionData[
                            'input_values']['Input_for_W'];
                        document.getElementById("Input_for_Y_def").value = sessionData[
                            'input_values']['Input_for_def_Y'];

                        // Remove existing Y input fields
                        var existingYInputs = document.querySelectorAll(
                            "input[name^='Input_for_Y']");
                        existingYInputs.forEach(function(input) {
                            input.parentNode.remove();
                        });

                        // Append Y input fields from session data
                        var numberOfYInputs = Object.keys(sessionData['input_values'])
                            .filter(
                                key => key.startsWith("Input_for_Y")).length;
                        for (var i = numberOfYInputs; i >= 1; i--) {
                            var label = document.createElement("label");
                            label.textContent = "Input for Y" + i;
                            var input = document.createElement("input");
                            input.type = "number";
                            input.className = "form-control";
                            input.placeholder = "Enter value for Y" + i;
                            input.required = true;
                            input.name = "Input_for_Y" + i;
                            if (sessionData['input_values']["Input_for_Y" + i]) {
                                input.value = sessionData['input_values']["Input_for_Y" +
                                    i
                                ];
                            }
                            var div = document.createElement("div");
                            div.className = "col-md-6";
                            div.appendChild(label);
                            div.appendChild(input);
                            document.getElementById("simpsonsRuleForm").insertBefore(div,
                                document
                                .getElementById("Input_for_W").parentNode.nextSibling);
                        }

                        var existingCalculateButton = document.querySelector(".calc");
                        if (existingCalculateButton) {
                            existingCalculateButton.parentNode.remove();
                        }
                        // Add the "Calculate" button
                        var calculateRow = document.createElement("div");
                        calculateRow.className = "row";
                        var calculateCol = document.createElement("div");
                        calculateCol.className = "col-md-12";
                        var calculateButton = document.createElement("button");
                        calculateButton.type = "button";
                        calculateButton.className = "btn btn-soft-primary  calc";
                        calculateButton.textContent = "Calculate";
                        calculateButton.addEventListener("click", calculate);
                        calculateCol.appendChild(calculateButton);
                        calculateRow.appendChild(calculateCol);
                        document.getElementById("simpsonsRuleForm").appendChild(
                            calculateRow);

                    } else {
                        console.error('Error:', response.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error occurred:', xhr.responseText);
                }
            });
        });


        // Function to reset the result variables
        function resetResults() {
            if (firstInputResult) firstInputResult.textContent = '';
            if (lastInputResult) lastInputResult.textContent = '';
            if (oddSumResult) oddSumResult.textContent = '';
            if (evenSumResult) evenSumResult.textContent = '';
            if (areaResult) areaResult.textContent = '';
        }



        //table code ***********************************************************************************

        function calculateTotal(row) {
            var length = parseFloat(row.find('.length').val()) || '';
            var breadth = parseFloat(row.find('.breadth').val()) || '';
            var height = parseFloat(row.find('.height').val()) || '';
            var number = parseFloat(row.find('.number').val()) || '';
            if (length === 0 || breadth === 0 || height === 0 || number === 0) {
                alert('Input values cannot be 0.');
                return;
            }

            var total = length * breadth * height * number;
            row.find('.total').val(total.toFixed(2));
        }

        function updateTotalSum() {
            var sum = 0;
            $("#dataTable tbody tr").each(function() {
                var total = parseFloat($(this).find('.total').val()) || 0;
                sum += total;
            });
            $("#totalSum").val(sum.toFixed(3));
        }
        // Bind input event to input fields in each row
        $(document).delegate(
            "input[name='length'], input[name='breadth'], input[name='height'], input[name='number']",
            "input",
            function() {
                var row = $(this).closest("tr");
                calculateTotal(row);
                updateTotalSum();
            });

        // Function to add new row
        function addNewRow() {

            var unitOptions = '<option value="">Select Unit</option>';
            <?php foreach ($unitMaster as $unit): ?>
            unitOptions += '<option value="<?php echo $unit['short_name']; ?>"><?php echo $unit['short_name']; ?></option>';
            <?php endforeach; ?>
            var newRow = $('<tr>' +
                '<td>' + ($("#dataTable tbody tr").length + 1) + '</td>' +
                '<td><input type="text" class="form-control m-input member" name="member" placeholder="Member" /></td>' +
                '<td><input type="number" class="form-control m-input number" name="number" placeholder="Number" /></td>' +
                '<td><input type="number" class="form-control m-input height" name="height" placeholder="Height" /></td>' +
                '<td><input type="number" class="form-control m-input breadth" name="breadth" placeholder="Breadth" /></td>' +
                '<td><input type="number" class="form-control m-input length" name="length" placeholder="Length" /></td>' +
                '<td><select class="form-control m-input unit" name="unit">' + unitOptions +
                '</select></td>' +
                '<td><input type="text" class="form-control m-input total" name="total" placeholder="Total" readonly/></td>' +
                '<td class="button-cell">' +
                '<button type="button" class="btn-close delete-row-btn">x</button>' +
                '<button type="button" class="btn-add addbtn">+</button>' +
                '</td>' +
                '</tr>');

            $("#dataTable tbody").append(newRow);
            updateButtons();
            updateTotalSum();
        }
        function updateButtons() {
            var tableRows = $("#dataTable tbody tr");
            tableRows.find(".delete-row-btn").hide();
            tableRows.last().find(".delete-row-btn").show();
            tableRows.find(".addbtn").hide();
            tableRows.last().find(".addbtn").show();
            if (tableRows.length === 1) {
                tableRows.find(".delete-row-btn").hide();
            }
        }
        $(document).off("click", ".addbtn").on("click", ".addbtn", function() {
            addNewRow();
            updateTotalSum();
            $("#closeBtn").prop("disabled", true);
        });
        $(document).on("click", ".delete-row-btn", function() {
            if ($("#dataTable tbody tr").length > 1) {
                $(this).closest("tr").remove();
                updateRowNumbers();
                updateButtons();
                updateTotalSum();
            }
        });
        function updateRowNumbers() {
            $("#dataTable tbody tr").each(function(index) {
                $(this).find("td:first").text(index + 1);
            });
        }
        $("#myForm").submit(function(event) {
            event.preventDefault();
            $(".empty-field").tooltip("dispose");
            var isEmpty = false;
            var hasZeroValue = false;
            $("#dataTable tbody tr").each(function() {
                var row = $(this);
                var emptyFields = [];
                row.find("input, select").each(function() {
                    var field = $(this);
                    if (!field.val()) {
                        if (!field.hasClass("total")) {
                            isEmpty = true;
                            emptyFields.push(field);
                            field.tooltip({
                                title: "Required field and cannot be Zero(0)",
                                placement: "bottom",
                                trigger: "manual"
                            });
                            // Show tooltip on hover
                            field.hover(function() {
                                $(this).tooltip("show");
                            }, function() {
                                $(this).tooltip("hide");
                            });
                        }
                    } else if (parseFloat(field.val()) === 0) {
                        hasZeroValue = true;
                    } else {
                        field.removeClass("empty-field");
                        field.tooltip("dispose");
                    }
                });
                if (emptyFields.length > 0) {
                    row.addClass("has-empty-field");
                    emptyFields.forEach(function(field) {
                        field.addClass("empty-field");
                    });
                } else {
                    row.removeClass("has-empty-field");
                }
            });

            if (isEmpty || hasZeroValue) {
                if (hasZeroValue) {
                    alert("Input values cannot be 0.");
                }
                return;
            }
            var form = this;
            var rowData = [];
            var totalSum = parseFloat($("#totalSum").val()) || 0;
            $("#dataTable tbody tr").each(function() {
                var row = {};
                $(this).find("input,select").each(function() {
                    var name = $(this).attr("name");
                    var value = $(this).val();
                    row[name] = value;
                });

                row['type'] = "other";
                row['parent_id'] = unitId;
                row['currentId'] = currentId !== undefined && currentId !== null ?
                    currentId : currentId === '' ? '' : null;
                row['overallTotal'] = totalSum;

                row['editEstimate_id'] = editEstimate_Id;

                rowData.push(row);
            });
            $.ajax({
                url: '/store-dynamic-unit-modal-data',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                contentType: 'application/json',
                data: JSON.stringify({
                    data: rowData,
                }),
                success: function(response) {

                    var tableBody1 = $("#dataTable tbody");
                    tableBody1.empty();
                    var rateAnalysisArray1 = response.rateAnalysisArray[unitId]['metadata'];

                    var tableBody = $("#dataTable1 tbody");
                    tableBody.empty();
                    var sno = 0;
                    $.each(rateAnalysisArray1, function(index, metadata) {
                        var newRow = $("<tr>");
                        newRow.append('<td style="text-align:center;">A' + (sno +
                            1) + '</td>');
                        newRow.append('<td style="text-align:center;">' + metadata
                            .type + '</td>');
                        newRow.append('<td style="text-align:center;">' + metadata
                            .overallTotal + '</td>');
                        newRow.append('<td style="text-align:center;">' + metadata
                            .unit + '</td>');
                        var editButton = $('<a>').attr({
                            'type': 'button',
                            'class': 'btn btn-soft-secondary btn-sm mr-2 ' +
                                (metadata.type === 'rule' ?
                                    'editBtnrule' : 'editBtn'),
                            'data-id': metadata.currentId
                        }).text('edit');

                        var deleteButton = $('<a>').attr({
                            'type': 'button',
                            'class': 'btn btn-soft-danger btn-sm delBtn',
                            'data-id': metadata.currentId
                        }).text('Delete');

                        var buttonCell = $('<td>').css('text-align', 'center')
                            .append(editButton).append(' ').append(deleteButton);
                        newRow.append(buttonCell);
                        tableBody.append(newRow);
                        sno++;
                    });
                    currentId = null;
                    addNewRow();
                    updateTotalSum();
                    if (tableBody.find('tr').length > 0) {
                        $('#mySelect').hide();
                        $('#metagrandtotal').show();
                    } else {
                        $('#mySelect').show();
                        $('#metagrandtotal').hide();
                    }
                    $('#successAlert').text('Row Added successfully');
                    $('#successAlert').addClass('alert-success').removeClass('alert-danger')
                        .show();
                    setTimeout(function() {
                        $('#successAlert').hide();
                    }, 3000);
                    $("#closeBtn").prop("disabled", true);
                        $("#finalSubmitBtn").prop("disabled", false);
                },

                error: function(xhr, status, error) {
                    console.error('Error occurred:', xhr.responseText);
                }
            });

        });
        $(document).off("click", "#submitBtn").on("click", "#submitBtn", function() {
            $("#myForm").submit();
            $("#finalSubmitBtn").prop("disabled", false);
            $("#closeBtn").prop("disabled", true);
        });
        $(document).on("click", ".editBtn", function() {
            $("#closeBtn").prop("disabled", true);
            $("#finalSubmitBtn").prop("disabled", false);
            $('#additionalFields').hide();
            $('#myForm').show();
            var metadataId = $(this).data("id");
            editRow(metadataId);
        });

        $(document).off("click", ".delBtn").on("click", ".delBtn", function() {
            var confirmed = confirm("Are you sure you want to delete this row?");
            if (confirmed) {
                $('#additionalFields').hide();
                $('#myForm').hide();
                var metadataId = $(this).data("id");
                $("#closeBtn").prop("disabled", true);
                deleteRow(metadataId);
            }
        });


        function deleteRow(rowId) {
            $.ajax({
                url: '/delete-unit-modal-data',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                contentType: 'application/json',
                data: JSON.stringify({
                    rowId: rowId,
                    parent_id: unitId,
                    editEstimate_id: editEstimate_Id
                }),
                success: function(response) {
                    var tableBody1 = $("#dataTable tbody");
                    tableBody1.empty();
                    var rateAnalysisArray1 = response.rateAnalysisArray[unitId]['metadata'];
                    console.log(rateAnalysisArray1);
                    var tableBody = $("#dataTable1 tbody");
                    tableBody.empty();
                    var sno = 0;
                    $.each(rateAnalysisArray1, function(index, metadata) {
                        var newRow = $("<tr>");
                        newRow.append('<td style="text-align:center;">A' + (sno +
                            1) + '</td>');
                        newRow.append('<td style="text-align:center;">' + metadata
                            .type + '</td>');
                        newRow.append('<td style="text-align:center;">' + metadata
                            .overallTotal + '</td>');
                        newRow.append('<td style="text-align:center;">' + metadata
                            .unit + '</td>');

                        var editButton = $('<a>').attr({
                            'type': 'button',
                            'class': 'btn btn-soft-secondary btn-sm mr-2 ' + (
                                metadata.type === 'rule' ?
                                'editBtnrule' : 'editBtn'),
                            'data-id': metadata.currentId
                        }).text('edit');

                        var deleteButton = $('<a>').attr({
                            'type': 'button',
                            'class': 'btn btn-soft-danger btn-sm delBtn',
                            'data-id': metadata.currentId
                        }).text('Delete');

                        var buttonCell = $('<td>').css('text-align', 'center')
                            .append(editButton).append(' ').append(deleteButton);
                        newRow.append(buttonCell);
                        tableBody.append(newRow);
                        sno++;
                    });
                    addNewRow();
                    updateTotalSum();
                    if (tableBody.find('tr').length > 0) {
                        $('#mySelect').hide();
                        $('#metagrandtotal').show();
                    } else {
                        $('#mySelect').show();
                        $('#metagrandtotal').hide();
                    }

                    $('#successAlert').text('Row deleted successfully');
                    $('#successAlert').addClass('alert-danger').removeClass('alert-success')
                        .show();
                        $("#finalSubmitBtn").prop("disabled", false);
                    // Optionally, you can hide the alert after a certain duration
                    setTimeout(function() {
                        $('#successAlert').hide();
                    }, 3000); // 3000 milliseconds (5 seconds) example
                },
                error: function(xhr, status, error) {
                    console.error('Error occurred:', xhr.responseText);
                }
            });
        }

        function editRow(rowId) {
            currentId = rowId;
            $.ajax({
                url: '/unit-modal-updated-data',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                contentType: 'application/json',
                data: JSON.stringify({
                    rowId: rowId,
                    parent_id: unitId,
                    editEstimate_id: editEstimate_Id
                }),
                success: function(response) {
                    var tableBody1 = $("#dataTable tbody");
                    tableBody1.empty();
                    var rateAnalysisArray = response.rateAnalysisArray;
                    rateAnalysisArray.forEach(function(rowData, index) {
                        //console.log(rowData);
                        var unitOptions = '<option value="">Select Unit</option>';
                        <?php foreach ($unitMaster as $unit): ?>
                        var selected = (rowData && rowData.unit === "<?php echo $unit['short_name']; ?>");
                        unitOptions += '<option value="<?php echo $unit['short_name']; ?>"' + (selected ?
                                ' selected' : '') +
                            '><?php echo $unit['short_name']; ?></option>';
                        <?php endforeach; ?>
                        var newRow = $('<tr>' +
                            '<td>' + (index + 1) + '</td>' +
                            '<td><input type="text" class="form-control m-input member" name="member" value="' +
                            (rowData && rowData.member ? rowData.member : '') +
                            '" placeholder="Member" required/></td>' +
                            '<td><input type="number" class="form-control m-input number" name="number" value="' +
                            (rowData && rowData.number ? rowData.number : '') +
                            '" placeholder="Number" required/></td>' +
                            '<td><input type="number" class="form-control m-input height" name="height" value="' +
                            (rowData && rowData.height ? rowData.height : '') +
                            '" placeholder="Height" required/></td>' +
                            '<td><input type="number" class="form-control m-input breadth" name="breadth" value="' +
                            (rowData && rowData.breadth ? rowData.breadth : '') +
                            '" placeholder="Breadth" required/></td>' +
                            '<td><input type="number" class="form-control m-input length" name="length" value="' +
                            (rowData && rowData.length ? rowData.length : '') +
                            '" placeholder="Length" required/></td>' +
                            '<td><select class="form-control m-input unit" name="unit">' +
                            unitOptions + '</select></td>' +
                            '<td><input type="text" class="form-control m-input total" name="total" value="' +
                            (rowData && rowData.total ? rowData.total : '') +
                            '" placeholder="Total" readonly/></td>' +
                            '<td class="button-cell">' +
                            '<button type="button" class="btn-close delete-row-btn">x</button>' +
                            '<button type="button" class="btn-add addbtn">+</button>' +
                            '</td>' +
                            '</tr>');
                        tableBody1.append(newRow);
                        updateTotalSum();
                        updateButtons();
                    });
                    $("#finalSubmitBtn").prop("disabled", false);
                },
                error: function(xhr, status, error) {
                    console.error('Error occurred:', xhr.responseText);
                }
            });
        }


        $('.dropdown').on('click', '.prev-data', function(event) {
            event.preventDefault();
            var selected_parent_id = $(this).text();
            if (editEstimate_Id) {
                var modalData = {!! json_encode(session('editModalData')) !!};
            } else {
                var modalData = {!! json_encode(session('modalData')) !!};
            }
            var selected_parent_id_Data = modalData[selected_parent_id];
            $.ajax({
                url: '/unit-modal-prev-data',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                contentType: 'application/json',
                data: JSON.stringify({
                    data: selected_parent_id_Data,
                    parent_id: unitId,
                    editEstimate_id: editEstimate_Id
                }),
                success: function(response) {
                    var rateAnalysisArray2 = response.rateAnalysisArray[unitId]['metadata'];
                    var tableBody = $("#dataTable1 tbody");
                    tableBody.empty();
                    var sno = 0;
                    var grandTotal = 0;
                    $.each(rateAnalysisArray2, function(index, metadata) {
                        var newRow = $("<tr>");
                        newRow.append('<td style="text-align:center;">A' + (sno +
                            1) + '</td>');
                        newRow.append('<td style="text-align:center;">' + metadata
                            .type + '</td>');
                        newRow.append('<td style="text-align:center;">' + metadata
                            .overallTotal + '</td>');
                        newRow.append('<td style="text-align:center;">' + metadata
                            .unit + '</td>');
                        var editButton = $('<a>').attr({
                            'type': 'button',
                            'class': 'btn btn-soft-secondary btn-sm mr-2 ' +
                                (metadata.type === 'rule' ?
                                    'editBtnrule' : 'editBtn'),
                            'data-id': metadata.currentId
                        }).text('edit');

                        var deleteButton = $('<a>').attr({
                            'type': 'button',
                            'class': 'btn btn-soft-danger btn-sm delBtn',
                            'data-id': metadata.currentId
                        }).text('Delete');

                        var buttonCell = $('<td>').css('text-align', 'center')
                            .append(editButton).append(' ').append(deleteButton);
                        newRow.append(buttonCell);
                        tableBody.append(newRow);
                        sno++;
                    });
                    if (tableBody.find('tr').length > 0) {
                        $('#mySelect').hide();
                        $('#metagrandtotal').show();
                    } else {
                        $('#mySelect').show();
                        $('#metagrandtotal').hide();
                    }
                    $('#successAlert').text('Previous Data Copied successfully');
                    $('#successAlert').addClass('alert-success').removeClass('alert-danger')
                        .show();
                        $("#closeBtn").prop("disabled", true);
                        $("#finalSubmitBtn").prop("disabled", false);
                    // Optionally, you can hide the alert after a certain duration
                    setTimeout(function() {
                        $('#successAlert').hide();
                    }, 3000); // 3000 milliseconds (5 seconds) example
                },
                error: function(xhr, status, error) {
                    console.error('Error occurred:', xhr.responseText);
                }
            });
        });

        function checkTableEmpty() {
            var tableBody = $("#dataTable1 tbody");
            if (tableBody.find('tr').length > 0) {
                $('#mySelect').hide();
                $('#metagrandtotal').show();
            } else {
                $('#mySelect').show();
                $('#metagrandtotal').hide();


            }
        }
        checkTableEmpty();
        $('.selectOption').click(function() {
            var selectedOption = $(this).data('value');
            $('#selectOptionButton').addClass('btn-clicked');
            if (selectedOption === "RULE") {

            } else if (selectedOption === "OTHER") {
                // $("#closeBtn").prop("disabled", true);
                $('#additionalFields').hide();
                $('#myForm').show();
            }
        });
        addNewRow();
        updateTotalSum();
    });
</script>
