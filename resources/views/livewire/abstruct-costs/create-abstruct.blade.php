<div>
    <div x-data="{
        formData: { projectDesc: '', selecteddepartment: '', deptCategory: '', selectEstimate: '', sorEstimateList: '', sorDepartment: '', sorQty: '' },
        errors: {},
        category: [],
        estimates: [],
        departments: [],
        label: 'Select',
        absCategory: ['Sor', 'Other', 'Rate', 'Estimate'],
        estimateList: [],
        masterSOR: [],
        AbstructList: [],
        taxData: [],
        estimateItemList: [],
        estimateItemSelectitem: [],
        sorSelectedItem: [],
        showModal: false,
        modalData: [],
        fetchData: [],
        SelectDeptCategory: @entangle('selectCategory'),
        selectauthCategory: @entangle('selectDeptCategory'),
        fetchdepartments: function() {
            fetch('{{ route('dept') }}')
                .then(response => response.json())
                .then(data => {
                    this.departments = data;
                })
                .catch(error => {
                    console.error('Error fetching department:', error);
                });
        },
        fetchdeptcategories: function() {
            {{-- console.log(this.formData.selecteddepartment); --}}
            if (this.formData.selecteddepartment) {
                const apiUrl = '{{ route('deptCategory') }}';
                const params = {
                    departmentID: this.formData.selecteddepartment
                };
                const urlWithParams = new URL(apiUrl);
                urlWithParams.search = new URLSearchParams(params).toString();
                fetch(urlWithParams).then(response =>
                        response.json())
                    .then(data => {
                        this.category = data;
                    })
                    .catch(error => {
                        console.error('Error fetching department:', error);
                    });
            }
        },
        fetchdeptEstimate: function() {
            if (this.formData.sorDepartment) {
                const apiUrl = '{{ route('deptEstimate') }}';
                const params = {
                    departmentID: this.formData.sorDepartment
                };
                const urlWithParams = new URL(apiUrl);
                urlWithParams.search = new URLSearchParams(params).toString();
                fetch(urlWithParams).then(response =>
                        response.json())
                    .then(data => {
                        this.estimates = data;
                    })
                    .catch(error => {
                        console.error('Error fetching department:', error);
                    });
            }
        },
        fetchEstimate() {
            this.label = this.SelectDeptCategory ? `Select ${this.SelectDeptCategory}` : 'Select';
            const categoryFetchFunctions = {
                'Schedule of Rates': this.fetchSorData,
                'Estimates Lists': this.fetchEstimateData
            };
            const fetchDataFunction = categoryFetchFunctions[this.SelectDeptCategory];
            if (fetchDataFunction) {
                fetchDataFunction.call(this)
                    .then(data => {
                        this.fetchData = data;
                        console.log(this.fetchData);
                    })
                    .catch(error => {
                        console.error('Error fetching data:', error);
                    })
            } else {
                console.error('No data-fetching function found for category:', this.SelectDeptCategory);
            }
        },
        async fetchSorData() {
            console.log('fdsdf SOR');
            try {
                const apiUrl = '{{ route('estimates') }}';
                const params = {
                    departmentId: this.formData.selecteddepartment,
                    deptCategoryId: this.formData.deptCategory
                };
                const urlWithParams = new URL(apiUrl);
                urlWithParams.search = new URLSearchParams(params).toString();
                const response = await fetch(urlWithParams);
                if (!response.ok) {
                    throw new Error('Failed to fetch data');
                }
                const data = await response.json();
                {{-- console.log(data); --}}
                // Return the fetched data
                return data;
            } catch (error) {
                throw error;
            }
        },
        async fetchEstimateData() {
            try {
                const apiUrl = '{{ route('estimates') }}';
                const params = {
                    deptID: this.formData.selecteddepartment,
                    deptCateID: this.formData.deptCategory
                };
                const urlWithParams = new URL(apiUrl);
                urlWithParams.search = new URLSearchParams(params).toString();
                const response = await fetch(urlWithParams);
                if (!response.ok) {
                    throw new Error('Failed to fetch data');
                }
                const data = await response.json();
                {{-- console.log(data); --}}
                // Return the fetched data
                return data;
            } catch (error) {
                // If an error occurs, throw it
                throw error;
            }
        },
        fetchSelectCategory: function() {
            const apiUrl = '{{ route('estimates') }}';
            const params = {
                itemsID: this.formData.selectEstimate,
            };
            const urlWithParams = new URL(apiUrl);
            urlWithParams.search = new URLSearchParams(params).toString();
            fetch(urlWithParams).then(response =>
                    response.json())
                .then(data => {
    
                    {{-- console.log(data.estimateItemDtls); --}}
                    this.estimateItemList = data.estimateItemDtls;
                    {{-- console.log(this.estimateItemList) --}}
                })
                .catch(error => {
                    console.error('Error fetching department:', error);
                });
        },
        fetchEstimateItem: async function() {
            console.log(this.formData.sorEstimateList);
            try {
                const apiUrl = '{{ route('estimates') }}';
                const params = {
                    estimateIdDtls: this.formData.sorEstimateList,
                };
                const urlWithParams = new URL(apiUrl);
                urlWithParams.search = new URLSearchParams(params).toString();
                const response = await fetch(urlWithParams);
                if (!response.ok) {
                    throw new Error('Failed to fetch data');
                }
                const data = await response.json();
                {{-- //console.log(data); --}}
                this.estimateItemList = data.estimateItemDtls;
            } catch (error) {
                // If an error occurs, throw it
                throw error;
            }
        },
        fetchSorEstimateList: function() {
            {{-- console.log('list onchange'); --}}
            {{-- console.log(this.formData.sorDepartment); --}}
            {{-- console.log(this.formData.sordeptCategory); --}}
            const apiUrl = '{{ route('estimates') }}';
            const params = {
                sorDeptCategoryId: this.formData.sorDepartment,
                cateID: this.formData.sordeptCategory
            };
            const urlWithParams = new URL(apiUrl);
            urlWithParams.search = new URLSearchParams(params).toString();
            fetch(urlWithParams).then(response =>
                    response.json())
                .then(data => {
                    {{-- console.log(data); --}}
                    {{-- console.log(data.data); --}}
                    this.sorEstimateItem = data.data;
                    {{-- console.log(this.sorEstimateItem); --}}
                    {{-- console.log(data.estimateItemDtls);
                    this.estimateItemList = data.estimateItemDtls;
                    console.log(this.estimateItemList)   --}}
                })
                .catch(error => {
                    console.error('Error fetching department:', error);
                });
        },
        validateAddForm: function(data) {
            this.errors = {};
            if (!data.projectDesc) {
                this.errors.projectDesc = 'Project title is required';
            }
            if (!data.selecteddepartment) {
                this.errors.selecteddepartment = 'Please select department';
            }
            if (!data.deptCategory) {
                this.errors.deptCategory = 'Please select department category';
            }
            if (!data.selectEstimate) {
                this.errors.selectErrorEstimate = 'This field is required';
            }
            return this.errors;
        },
        deptCategoryId: this.selectauthCategory,
        gstPercentage: function() {
            console.log('auth category', this.selectauthCategory);
            switch (this.selectauthCategory) {
                case 6:
                    return 12;
                    break;
                case 7:
                    return 12;
                    break;
                default:
                    return 18;
    
            }
        },
        fetchTaxses: function() {
            fetch('{{ route('getTax') }}')
                .then(response => response.json())
                .then(data => {
                    this.taxData = data.map(item => {
                        return {
                            taxName: item.tax_name,
                            category: item.category_id,
                            taxPrec: item.tax_percentage
                        };
                    });
                })
                .catch(error => {
                    console.error('fetching data:', error);
                });
        },
        calculateTotal: function() {
            let total = 0,
                gstAmount = 0,
                grand = 0,
                taxs = 0,
                i, j;
            if (this.SelectDeptCategory === 'Schedule of Rates') {
                for (i = 0; i < this.AbstructList.length; i++) {
                    finalTotal = 0;
                    total += Math.floor(parseFloat(this.AbstructList[i].totalAmount));
                    taxs = Math.floor(total / 1.01);
                    grand = Math.floor(parseFloat(taxs) * parseFloat(0.03));
                    finalTotal += Math.floor(parseFloat(total) + parseFloat(grand));
                }
                console.log(total, taxs, grand, finalTotal);
                return {
                    subtotal: total.toFixed(2),
                    excludeCess: taxs.toFixed(2),
                    contigencyTax: grand.toFixed(2),
                    grandVal: finalTotal.toFixed(2),
                    costInWords: convertNumberToWords(finalTotal),
                    index: i
                };
            } else {
                for (i = 0; i < this.AbstructList.length; i++) {
                    grand = 0;
                    taxs = 0;
                    finalTotal = 0;
                    total += Math.floor(parseFloat(this.AbstructList[i].totalAmount));
                    gstAmount += Math.floor(parseFloat(this.AbstructList[i].totalAmount) * (this.gstPercentage() / 100));
                    grand += Math.floor(parseFloat(total) + parseFloat(gstAmount));
                    for (j = 0; j < this.taxData.length; j++) {
                        let taxprce = parseFloat(this.taxData[j].taxPrec / 100);
                        let taxWithTotal = parseFloat(grand) * parseFloat(taxprce);
                        taxs += Math.floor(taxWithTotal);
                    }
                    finalTotal = Math.floor((parseFloat(grand)) + (parseFloat(taxs)));
                }
                return {
                    subtotal: total.toFixed(2),
                    gstValue: gstAmount.toFixed(2),
                    grandTotal: grand.toFixed(2),
                    grandVal: finalTotal.toFixed(2),
                    costInWords: convertNumberToWords(finalTotal),
                    index: i
                };
            }
        },
        sorEstimateItem: [],
        showSORModal: false,
        SorList: [],
        closeSORModal: function() {
            this.showSORModal = false;
        },
        fetchSelectSOR: async function() {
            console.log(this.formData.selectEstimate);
            this.showSORModal = !this.showSORModal;
            const ModalTitle = this.$refs.modalSORTitle;
            {{-- ModalTitle.innerHTML = 'Lists Data'; --}}
            console.log(ModalTitle);
            let SorListData = [];
            {{-- ModalTitle.innerHTML = 'Test Data'; --}}
            try {
                const apiUrl = '{{ route('estimates') }}';
                const params = {
                    sorId: this.formData.selectEstimate,
                };
                const urlWithParams = new URL(apiUrl);
                urlWithParams.search = new URLSearchParams(params).toString();
                const response = await fetch(urlWithParams);
                if (!response.ok) {
                    throw new Error('Failed to fetch data');
                }
                const data = await response.json();
                let dept = data.estimateItemDtls.SOR.department_name;
                let deptCategory = data.estimateItemDtls.SOR.category_name;
                let headerData = JSON.parse(data.estimateItemDtls.SOR.header_data);
                let rowData = JSON.parse(data.estimateItemDtls.SOR.row_data);
                let title = data.estimateItemDtls.SOR.title;
                {{-- ModalTitle.innerHTML = data.estimateItemDtls.SOR.title; --}}
                let tableNo = data.estimateItemDtls.SOR.table_no;
                let pageNo = data.estimateItemDtls.SOR.page_no;
                console.log('modal title', this.$refs.modalSORTitle);
                {{-- console.log('sorList', SorList); --}}
    
                {{-- ModalTitle.innerHTML = title; --}}
                console.log(dept, deptCategory, title, tableNo, pageNo);
    
    
                headerData.forEach(function(column) {
                    var fun;
                    delete column.editor;
                    if (column.field === 'desc_of_item') {
                        column.frozen = true;
                    }
                    if (column.field === 'item_no') {
                        column.frozen = true;
                    }
                    if (column.field === 'unit') {
                        column.frozen = true;
                    }
                    if (column.isClick) {
                        column.isClick = eval('(' + column.isClick + ')');
                        fun = column.isClick;
                    }
                    if (column.cellClick) {
                        column.cellClick = eval('(' + column.isClick + ')');
                        fun = column.cellClick;
                    }
    
                    if (typeof fun === 'function') {
                        column.cellClick = function(e, cell) {
                            var getData = cell.getRow().getData();
                            var colId = cell.getField();
                            var allColumn = cell.getTable().columnManager.getColumns();
                            var colIdx = -1;
                            var colName;
    
                            for (var i = 0; i < allColumn.length; i++) {
                                if (allColumn[i]['columns'] && allColumn[i]['columns'].length > 0) {
                                    var allGroupCol = allColumn[i]['columns'];
                                    for (var j = 0; j < allGroupCol.length; j++) {
                                        if (allGroupCol[j].getField() === colId) {
                                            colIdx = i + j;
                                            colName = allGroupCol[j].getField();
                                            colName = colName.replace(/_/g, ' ');
                                            break;
                                        }
                                    }
                                } else {
                                    if (allColumn[i].getField() === colId) {
                                        colIdx = i;
                                        colName = column.title;
                                        break;
                                    }
                                }
                            }
    
    
                            {{-- const { parent, children } = findParentAndChildrenByItemNo(rowData, cell.getRow().getIndex());
                            console.log('Parent:', parent);
                            console.log('Children:', children); --}}
    
                            {{-- const details = findDetailsById(rowData, cell.getRow().getIndex());
                            console.log('Details:', details); --}}
    
    
                            var getRowData = {
                                id: getData['id'],
                                desc: (getData['desc_of_item']) ? getData['desc_of_item'] : '',
                                unit: (getData['unit']) ? getData['unit'] : '',
                                rowValue: cell.getValue(),
                                itemNo: cell.getRow().getIndex(),
                                colPosition: colIdx,
                                introText: dept + '/' + deptCategory + '/' + tableNo + '/' + ' Page No :' + pageNo
                            };
                            var cnf = confirm('Are you sure to select ' + colName +
                                ' Value = ' + cell.getValue() + '?');
                            if (cnf) {
                                {{-- console.log('get Row Data', getRowData);
                                Livewire.emit('getRowValue', getRowData); --}}
                                SorList.push(getRowData);
                                {{-- setTimeout(() => {
                                    // Create and dispatch the custom event
                                    this.$el.dispatchEvent(new CustomEvent('close-sor-modal', { bubbles: true }));
                                    this.$dispatch('close-sor-modal');
                                }, 1000); --}}
                            } else {
                                console.log('No Data Found');
                                {{-- Livewire.emit('getRowValue', getRowData); --}}
                            }
    
                        }
                    }
    
                    if (column.columns) {
                        column.columns.forEach(function(subColumn) {
                            var subFun;
                            delete subColumn.editor;
                            subColumn.formatter = 'textarea';
                            subColumn.variableHeight = true;
                            if (column.field == 'desc_of_item') {
                                column.isClick = function(e, cell) {};
                            }
                            if (subColumn.isClick) {
                                subFun = subColumn.isClick = eval('(' + subColumn.isClick + ')');
                            }
                            if (subColumn.cellClick) {
                                subFun = subColumn.cellClick = eval('(' + subColumn.cellClick + ')');
                            }
    
                            if (typeof subFun === 'function') {
                                subColumn.cellClick = function(e, cell) {
                                    var subrowIndex = cell.getRow().getIndex();
                                    var getData = cell.getRow().getData();
                                    var colId = cell.getField();
                                    var allColumn = cell.getTable().columnManager.getColumns();
                                    var colIdx = -1;
                                    var colName;
                                    var colTitle = column.title;
                                    for (var i = 0; i < allColumn.length; i++) {
                                        if (allColumn[i]['columns'] && allColumn[i]['columns']
                                            .length > 0) {
                                            var allGroupCol = allColumn[i]['columns'];
                                            for (var j = 0; j < allGroupCol.length; j++) {
                                                if (allGroupCol[j].getField() === colId) {
                                                    colIdx = i + j;
                                                    colName = allGroupCol[j].getField();
                                                    colName = colName.replace(/_/g, ' ');
                                                    break;
                                                }
                                            }
                                        } else {
                                            if (allColumn[i].getField() === colId) {
                                                colIdx = i;
                                                colName = column.title;
                                                break;
                                            }
                                        }
                                    }
    
                                    let getRowData = {
                                        id: getData['id'],
                                        descItem: getHierarchyDetails(rowData, cell.getRow().getIndex()) ? getHierarchyDetails(rowData, cell.getRow().getIndex()) : '',
                                        unit: (getData['unit']) ? getData['unit'] : (
                                            getData['unit_' + colTitle]) ? getData[
                                            'unit_' + colTitle] : '',
                                        rowValue: cell.getValue(),
                                        colName: colName,
                                        introText: dept + '/' + deptCategory + '/' + tableNo + '/' + ' Page No :' + pageNo
                                    };
    
                                    var cnf = confirm('Are you sure to select' + colName +
                                        ' Value = ' + cell.getValue() + '?');
                                    if (cnf) {
    
                                        {{-- SorList.push(getRowData); --}}
                                        console.log('sor lists rows', getRowData);
                                        SorListData.push(getRowData);
                                        console.log('sor lists', SorListData);
                                        setTimeout(() => {
                                            // Create and dispatch the custom event
                                            {{-- this.$el.dispatchEvent(new CustomEvent('close-sor-modal', { bubbles: true })); --}}
                                            {{-- this.$dispatch('close-sor-modal'); --}}
                                            {{-- this.closeSORModal(); --}}
                                        }, 100);
                                        {{-- Alpine.store('SorList', [...Alpine.store('SorList'), { ...getRowData }]); --}}
                                        {{-- this.SorList.push({ ...getRowData }); --}}
    
                                        {{-- Livewire.emit('getRowValue', getRowData); --}}
                                    } else {
                                        {{-- console.log(getRowData);
                                        Livewire.emit('getRowValue', getRowData); --}}
                                    }
                                }
                            }
                        });
                    } else {
                        column.formatter = 'textarea';
                        column.variableHeight = true;
                    }
    
                });
                this.SorList = SorListData;
                {{-- this.SorList.push({ ...getRowData }); --}}
                {{-- console.log('lists data push', this.SorList); --}}
                const Tablebody = this.$refs.tabulator_table;
    
                let table = new Tabulator(Tablebody, {
                    height: '711px',
                    columnVertAlign: 'bottom',
                    layout: 'fitDataFill',
                    columns: headerData,
                    columnHeaderVertAlign: 'center',
                    data: rowData,
                    variableHeight: true,
                    variableWidth: true,
                    dataTree: true, // Enable the dataTree module
                    dataTreeStartExpanded: true, // Optional: Expand all rows by default
                    dataTreeChildField: '_subrow', // Specify the field name for subrows
                    dataTreeChildIndent: 10, // Optional: Adjust the indentation level of subrows
                });
                // Return the fetched data
                {{-- return data; --}}
            } catch (error) {
                // If an error occurs, throw it
                throw error;
            }
    
        },
    
        ViewModel: function(index) {
            {{-- console.log(index); --}}
            {{-- console.log(index.estimateId); --}}
            if (!this.showModal) {
                this.showModal = true;
                if (index.estimateId) {
                    const apiUrl = '  {{ route('estimates') }}';
                    const params = {
                        estimateId: index.estimateId,
                    };
                    const urlWithParams = new URL(apiUrl);
                    urlWithParams.search = new URLSearchParams(params).toString();
                    fetch(urlWithParams).then(response =>
                            response.json())
                        .then(data => {
                            this.modalData = data.estimateItemDtls.estimateProjectDtls;
                            console.log(this.modalData);
    
                        })
                        .catch(error => {
                            console.error('Error fetching department:', error);
                        });
                }
            }
        },
    
        renderItems: function() {
            const modalBody = this.$refs.modalBody;
            const modalTitle = this.$refs.modalTitle;
            modalBody.innerHTML = ''; // Clear existing content
            {{-- modalTitle.innerHTML = 'Estimate No : ' + this.estimateItemSelectitem.estimateId; --}}
            let html = '';
            this.modalData.forEach((estimateItems, index) => {
                modalTitle.innerHTML = 'Estimate No : ' + estimateItems.estimate_id;
                html += `
                                                                                                                                                                                                                                                                <tr>
                                                                                                                                                                                                                                                                    <td class='text-wrap'>${estimateItems.row_id}</td>
                                                                                                                                                                                                                                                                    <td class='text-wrap'>`;
                if (estimateItems.sor_item_number != null && estimateItems.sor_item_number != '0') {
                    html += `${estimateItems.operation=='Total'?'':estimateItems.sor_item_number}`;
                } else if (estimateItems.estimate_no != 0) {
                    html += `${estimateItems.estimate_no}`;
                } else if (estimateItems.rate_no != 0) {
                    html += `${estimateItems.rate_no}`;
                } else if (estimateItems.sor_item_number === 0) {
                    html += `---`;
                } else {
                    html += `---`;
                }
                html += `</td>`;
                html += `<td class='text-wrap' style='width:6rem'>`;
                if (estimateItems.item_name != '') {
                    html += `${estimateItems.item_name}`;
                }
                html += `</td>`;
                html += `<td class='text-wrap' style='width:60rem'>`;
                if (estimateItems.sor_item_number || estimateItems.rate_no) {
                    if (estimateItems.sor_item_number != '0') {
                        html += `<span style='font-size:13px;'><strong>${estimateItems.department_name+' /'+estimateItems.dept_category_name+' /'+ estimateItems.table_no+' / Page No: '+estimateItems.page_no }</strong></span>`;
                    } else if (estimateItems.sor_item_number != '0' && estimateItems.corrigenda_name != '') {
                        html += `<span style='font-size:13px;'><strong>${estimateItems.department_name+' /'+estimateItems.dept_category_name+' /'+ estimateItems.table_no+' / Page No: '+estimateItems.page_no +'('+ estimateItems.corrigenda_name +')'}</strong></span>`;
                    } else {
                        html += `-`
                    }
                } else if (estimateItems.rate_id) {
                    html += `${estimateItems.rate_id}`;
                } else if (estimateItems.estimate_no != '0' || typeof estimateItems.estimate_no === 'undefined' || estimateItems.estimate_no != 0) {
                    html += `${estimateItems.sorMasterDesc}`;
                } else if (estimateItems.operation) {
                    if (estimateItems.operation === 'Total') {
                        html += `Total of ( ${estimateItems.row_index.replace(/\+/g, ' + ')} )`;
                    } else {
                        html += `${estimateItems.row_index.replace(/\+/g, ' + ')}`;
                        if (estimateItems.comments !== '') {
                            html += `(${estimateItems.comments})`;
                        }
                    }
                } else {
                    html += `${estimateItems.other_name}`;
                }
                html += `</td>`;
                html += `<td class='text-wrap'>`;
                if (estimateItems.qty == 0) {
                    html += `-`;
                } else {
                    html += `${estimateItems.qty}`;
                }
                html += `</td>`;
                html += `<td class='text-wrap'>${estimateItems.unit_id}</td>`;
                html += `<td class='text-wrap' style='text-align:end;'> ${ estimateItems.rate} </td>`;
                html += `<td class='text-wrap' style='text-align:end;'> ${ Number(estimateItems.total_amount).toFixed(2) } </td>`;
                html += `</tr>`;
            });
            return `
                                                                                                                                                <div class='table-responsive mt-2 tableFixHead'>
                                                                                                                                                    <table id='basic-table' class='table table-striped mb-0 role='grid'>
                                                                                                                                                        <thead>
                                                                                                                                                            <tr>
                                                                                                                                                                <th class='whitespace-nowrap text-dark' style='padding-right:4rem;'>Sl.No</th>
                                                                                                                                                                <th class='whitespace-nowrap text-dark' >Item No</th>
                                                                                                                                                                <th class='whitespace-nowrap text-dark' >Item Name</th>
                                                                                                                                                                <th class='whitespace-nowrap text-dark' >Description</th>
                                                                                                                                                                <th class='whitespace-nowrap text-dark' >Qty</th>
                                                                                                                                                                <th class='whitespace-nowrap text-dark' >Unit</th>
                                                                                                                                                                <th class='whitespace-nowrap text-dark' >Price</th>
                                                                                                                                                                <th class='whitespace-nowrap text-dark' >Cost</th>
                                                                                                                                                            </tr>
                                                                                                                                                        </thead>
                                                                                                                                                        <tbody>
                                                                                                                                                            ${html}
                                                                                                                                                        </tbody>
                                                                                                                                                    </table>
                                                                                                                                            </div>`;
        },
        closeModal: function() {
            this.showModal = false;
            const modalBody = this.$refs.modalBody;
            modalBody.innerHTML = '';
        },
        init: function() {
            this.$el.addEventListener('close-sor-modal', () => {
                this.closeSORModal();
            });
        },
        updateQty(index, newQty) {
            console.log('update qty', this.AbstructList[index].qty);
            this.AbstructList[index].qty = parseFloat(newQty);
        },
        addData() {
    
            console.log('form data all data releated fieldds', this.formData);
            {{-- if(this.SelectDeptCategory==='Schedule of Rates')
            {
                this.formData = {sorDepartment:''}
            }
            console.log('datalist',this.formData); --}}
            this.errors = {};
            this.errors = this.validateAddForm(this.formData);
            subtotal = 0;
            if (Object.keys(this.errors).length === 0) {
    
                let addformData;
                if (this.SelectDeptCategory === 'Schedule of Rates') {
    
                    {{-- console.log('SOr Lists', this.SorList); --}}
                    let Rate = 0,
                        gstRate = 0,
                        totalCess = 0,
                        finalAmount = 0,
                        totalRate = 0;
                    this.SorList.forEach(items => {
                        console.log('description', items.descItem, items.introText);
    
                        Rate += parseFloat(items.rowValue);
    
                        // Calculate and round GST amount for each iteration
                        const gstAmount = Math.floor(Rate * (parseFloat(this.gstPercentage()) / 100) * 100) / 100;
                        {{-- console.log('GST Amount for this item:', gstAmount); --}}
    
                        gstRate += gstAmount;
                        {{-- const cessAmount = (Math.floor(parseFloat(gstAmount) + parseFloat(items.rowValue)) * 0.01).toFixed(2); --}}
                        const cessAmount = parseFloat(((parseFloat(gstAmount) + parseFloat(items.rowValue)) * 0.01).toFixed(2));
                        {{-- finalAmount += Math.floor(parseFloat(items.rowValue) + gstAmount + parseFloat(cessAmount)); --}}
    
                        {{-- console.log('GST Amount for this item:', cessAmount); --}}
                        totalCess += cessAmount;
    
    
                        let temTotal = parseFloat(Rate) + parseFloat(gstAmount) + parseFloat(cessAmount);
                        finalAmount += parseFloat(temTotal.toFixed(2));
                        finalAmount = finalAmount.toFixed(2);
    
                        totalRate += Math.floor(parseFloat(this.formData.sorQty) * parseFloat(finalAmount));
    
                    });
    
                    {{-- console.log('gst rate', Rate, gstRate, totalCess, finalAmount, totalRate); --}}
    
                    {{-- addIntroductoryText(this.SorList.map(item => item.descItem), ) --}}
    
    
                    {{-- console.log('format description', this.SorList.map(item => item.descItem)); --}}
                    {{-- console.log('format description details', descSOR); --}}
    
    
                    addformData = {
                        sorDesc: this.SorList.map(item => item.descItem),
                        introText: this.SorList.map(item => item.introText),
                        qty: this.formData.sorQty,
                        totalAmount: totalRate,
                        sorUnit: this.SorList.map(item => item.unit),
                        sorRate: Rate.toFixed(2),
                        deptGST: Math.floor(parseFloat(this.SorList.map(item => item.rowValue)) * (parseFloat(this.gstPercentage()) / 100) * 100) / 100,
                        cess: totalCess,
                        finalRate: finalAmount,
                        category: this.SelectDeptCategory,
                        estimateId: this.estimateItemSelectitem['estimateId'],
                    };
    
                } else {
                    this.estimateItemList.estimateProject.forEach(item => {
                        this.estimateItemSelectitem['total'] = item.total_amount,
                            this.estimateItemSelectitem['projDesc'] = item.sorMasterDesc
                        this.estimateItemSelectitem['estimateId'] = item.estimate_id
                    });
                    addformData = {
                        estimateDesc: this.estimateItemSelectitem['projDesc'],
                        category: this.SelectDeptCategory,
                        totalAmount: this.estimateItemSelectitem['total'],
                        estimateId: this.estimateItemSelectitem['estimateId'],
                    };
                }
    
    
                this.AbstructList.push({ ...addformData });
                console.log('add abstruct data list', this.AbstructList);
    
                {{-- console.log('Estimate ID', this.AbstructList.estimateId); --}}
                {{-- console.log(this.AbstructList.estimateId); --}}
    
                {{-- this.projectDesc = '';
                {{-- this.projectDesc = '';
            this.deptCategory = '';
            this.selecteddepartment = '';
            this.category = '';
            this.estimateId = ''; --}}
                this.formData.absoption = '';
                this.formData.selectEstimate = '';
                if (this.SelectDeptCategory === 'Schedule of Rates') {
                    this.formData.sorEstimateList = '';
                    this.formData.sorQty = '';
                }
                {{-- this.departments = ''; --}}
                {{-- this.category = []; --}}
                {{-- this.fetchData = []; --}}
    
                {{-- console.log('Form submitted successfully!'); --}}
            } else {
                Object.keys(this.errors).forEach(field => {
                    const errorMessage = this.errors[field];
                    const errorField = document.getElementById(`error-${field}`);
                    if (errorField) {
                        errorField.innerText = errorMessage;
                    }
                });
            }
        },
        removeItemFromEstimates: function(index) {
            this.AbstructList.splice(index, 1);
            this.calculateTotal();
        },
        generatePDF: function() {
            const doc = new jsPDF({
                orientation: 'portrait', // Set orientation to landscape
                unit: 'pt' // Use pixels as the unit for width and height
    
            });
    
    
            const table = $refs.abstructTable;
    
            //Project title and description
            var pageSize = doc.internal.pageSize;
            var totalPages = doc.internal.getNumberOfPages();
    
            //description
            const descriptionremovehtml = this.formData.projectDesc;
            const headerTitle = descriptionremovehtml.replace(/<[^>]*>/g, '');
    
            // Get all table rows
            const rows = table.querySelectorAll('tr');
            let originalData = [];
            // Hide the last cell and save original data
            rows.forEach((row, index) => {
                const cells = Array.from(row.children);
                originalData.push(cells.map(cell => cell.innerHTML));
                const lastCell = cells[cells.length - 1];
                if (lastCell) {
                    lastCell.style.display = 'none';
                }
            });
    
            // Heading
            const mainTitle = 'General Abstract of Cost';
    
            doc.setLineWidth(2);
    
            // Calculate text width and positions for center alignment
            let mainTitleWidth = doc.getTextWidth(mainTitle);
            let mainTitleXPosition = (doc.internal.pageSize.width - mainTitleWidth) / 2;
    
            doc.setFontSize(14);
            doc.text(mainTitle, mainTitleXPosition, 20);
    
            // Split subtitle if it's too long to fit in one line
            const pageWidth = doc.internal.pageSize.width;
            const maxSubtitleWidth = pageWidth - 60; // 30 pt margin on each side
            const splitSubtitle = doc.splitTextToSize(headerTitle, maxSubtitleWidth);
    
            doc.setFontSize(10);
            doc.text(splitSubtitle, 30, 35);
    
            let textHeight = doc.getTextDimensions(splitSubtitle).h;
            let startY = 35 + textHeight + 10; // Adjust startY for the table
    
            doc.autoTable({
                html: table,
                styles: {
                    fillColor: [255, 255, 255],
                    textColor: [0, 0, 0],
                    lineColor: [0, 0, 0], // Specify the border color as black [R, G, B]
                    lineWidth: 0.5, // Set border line width
                    fontSize: 10, // Reduce the font size
                    valign: 'middle',
                    overflow: 'linebreak',
                    tableWidth: 'auto',
                },
                columnStyles: {
                    2: {
                        halign: 'right',
                        tableWidth: 100,
                    },
                    8: {
                        halign: 'right',
                        tableWidth: 100,
                    }
    
                },
                margin: {
                    top: 20,
                    bottom: 20,
                },
                startY: startY, // Start printing the table from y-position 20
                pageBreak: 'auto',
                didDrawPage: function(data) {
                    let pageSize = doc.internal.pageSize;
                    let pageHeight = pageSize.height ? pageSize.height : pageSize.getHeight();
                    let pageWidth = pageSize.width ? pageSize.width : pageSize.getWidth();
                    let pageCount = doc.internal.getNumberOfPages();
    
    
    
                    let footerText = 'Page ' + data.pageNumber + ' of ' + pageCount;
                    let footerFontSize = 10;
                    let footerTextWidth = doc.getTextWidth(footerText);
                    let footerX = (pageWidth - footerTextWidth) / 2;
                    let footerY = pageHeight - 10;
    
                    doc.setFontSize(footerFontSize);
                    doc.text(footerText, footerX, footerY);
                }
            });
    
            // Get the end position of the table
            let finalY = doc.autoTable.previous.finalY || startY;
    
            // Add the final text with a box
            const finalText = '(' + this.calculateTotal().costInWords + ')';
            const textX = 40;
            const textY = finalY + 20; // Adjust the Y position to be below the table
            const boxWidth = pageWidth - 80;
            const boxHeight = doc.getTextDimensions(finalText).h + 20; // Adjust the height of the box as necessary
    
            // Draw the box
            doc.setDrawColor(0); // Black color
            doc.setLineWidth(1);
            doc.rect(textX, textY, boxWidth, boxHeight);
    
            // Add the text inside the box
            doc.setFont('helvetica', 'bold'); // Set font to Helvetica bold
            doc.setFontSize(10);
            doc.setTextColor(0); // Black color
            const splitFinalText = doc.splitTextToSize(finalText, boxWidth - 20); // Wrap the text inside the box
    
            doc.text(splitFinalText, textX + 10, textY + 10); // Adjust the position within the box
    
            {{-- doc.text(finalText, adjustedTextX, textY + 20); --}}
            {{-- doc.text(finalText, textX + 10, textY + 20); // Adjust the position within the box --}}
    
            {{-- doc.save('abstructs.pdf'); --}}
            const filename = 'abstracts.pdf';
            // Generate the PDF and get its URL
            const pdfData = doc.output('blob');
            const pdfUrl = URL.createObjectURL(pdfData);
    
            // Open the generated PDF in a new tab
            const newTab = window.open(pdfUrl, '_blank');
    
            newTab.onload = function() {
                newTab.document.title = filename;
            };
            // Optionally revoke the object URL after use
            {{-- URL.revokeObjectURL(blobUrl); --}}
            rows.forEach(row => {
                const lastCell = row.lastElementChild;
                if (lastCell) {
                    lastCell.style.display = ''; // Reset display property
                }
            });
    
    
        },
        store: function() {
            this.isSaving = true;
    
            const headers = [];
            const tBody = [];
            const Estimateitems = {};
            const table = this.$refs.abstructTable;
            table.querySelectorAll('thead th').forEach((th) => {
                const headerData = {};
                const field = th.innerText.trim();
                const title = th.innerText.trim();
                const width = parseInt(th.getAttribute('data-width') || '100', 10);
                const minWidth = parseInt(th.getAttribute('data-minWidth') || '40', 10);
                headerData.field = field;
                headerData.title = title;
                headerData.width = width;
                headerData.minWidth = minWidth;
                headers.push(headerData);
            });
            this.headers = headers;
    
            table.querySelectorAll('tbody tr').forEach((tr, rowIndex) => {
                const rowData = {};
                const tds = tr.querySelectorAll('td');
                tds.forEach((td, index) => {
                    const headerField = headers[index].field;
                    const cellValue = td.innerText.trim();
    
                    console.log('Cell Value ', cellValue);
                    if (rowIndex < this.AbstructList.length) {
                        const item = this.AbstructList[rowIndex];
                        rowData['estimate_id'] = item.estimateId;
                    }
    
                    rowData[headerField] = cellValue;
                });
                tBody.push(rowData);
            });
            console.log('tBody data', tBody);
    
            const combinedData = {
                jsonData: JSON.stringify(tBody),
                jsonData1: JSON.stringify(headers),
                projectDesc: this.formData.projectDesc,
                {{-- departmentId: this.formData.selecteddepartment, --}} 'estimateId': this.AbstructList.map(item => item.estimateId),
                {{-- deptCategory: this.formData.deptCategory, --}}
                totalAmount: this.calculateTotal().grandVal
            };
            Livewire.emit('storeTheadData', combinedData);
    
        }
    }"
        x-init='fetchTaxses(),$watch("SelectDeptCategory",(value)=>{
        if(value === "Schedule of Rates")
        {
            formData.sorDepartment = "";
        }
    })'>
        <!--Project Title-->
        <div class="card">
            <div class="card-body">
                <form>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-6">
                            <div class="form-group">
                                <x-form-level>{{ trans('cruds.estimate.fields.description') }}</x-form-level>
                                <div id="editor" x-data="{ quill: null }" x-init="() => {
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
                                        formData.projectDesc = quill.root.innerHTML;
                                    });
                                }"
                                    x-model="formData.projectDesc"></div>
                                <small x-text="errors.projectDesc" class="text-danger"
                                    x-show="errors.projectDesc"></small>
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="form-group" x-init="fetchdepartments()">
                                <x-form-level>Department</x-form-level>
                                <select x-model="formData.selecteddepartment" class="form-control"
                                    x-on:change="fetchdeptcategories" x-ref="select">
                                    <option value="" disabled>Select department</option>
                                    <template x-for="(department,index) in departments" :key="index">
                                        <option :value="department.id" x-text="department.department_name"></option>
                                    </template>
                                </select>
                                <small x-text="errors.selecteddepartment" class="text-danger"
                                    x-show="errors.selecteddepartment"></small>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="form-group">
                                <x-form-level>Department Category</x-form-level>
                                <select x-model="formData.deptCategory" class="form-control"
                                    x-on:change="fetchEstimate">
                                    <option value="" disabled>Select department</option>
                                    <template x-for="(categories,index) in category" :key="index">
                                        <option :value="categories.id" x-text="categories.dept_category_name"></option>
                                    </template>
                                </select>
                                <small x-text="errors.deptCategory" class="text-danger"
                                    x-show="errors.deptCategory"></small>
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="form-group">
                                <x-form-level x-text='label'></x-form-level>
                                <template x-if="SelectDeptCategory ==='Schedule of Rates'">
                                    <select x-model="formData.selectEstimate" class="form-control"
                                        x-on:change="fetchSelectSOR">
                                        <option value="" disabled><span x-text='label'>{{ __('Select') }}</span>
                                        </option>
                                        <div x-show="fetchData">
                                            <template x-for="(item, index) in fetchData.data" :key="index">
                                                <option :value="item.id" x-text='item.description'></option>
                                            </template>
                                        </div>
                                    </select>
                                </template>
                                <template x-if="SelectDeptCategory==='Estimates Lists'">
                                    <select x-model="formData.selectEstimate" class="form-control"
                                        x-on:change="fetchSelectCategory">
                                        <option value="" disabled><span x-text='label'>{{ __('Select') }}</span>
                                        </option>
                                        <div x-show="fetchData">
                                            <template x-for="(item, index) in fetchData.data" :key="index">
                                                <option :value="item.id" x-text='item.description'></option>
                                            </template>
                                        </div>
                                    </select>
                                </template>
                                <small x-text="errors.selectErrorEstimate" class="text-danger"
                                    x-show="errors.selectErrorEstimate"></small>
                            </div>
                        </div>
                        <template x-if="SelectDeptCategory ==='Schedule of Rates'">
                            <div class="col-lg-3 col-md-6 col-sm-6">
                                <div class="form-group">
                                    <x-form-level>Quantity</x-form-level>
                                    <input type="text" min="1" x-model="formData.sorQty" pattern="^[0-9]+$"
                                        class="form-control" placeholder="quanity"
                                        x-on:input="formData.sorQty=validateDecimal(formData.sorQty)" />
                                    <small x-text="errors.sorQty" class="text-danger" x-show="errors.sorQty"></small>
                                </div>
                            </div>
                        </template>
                    </div>
                    {{-- @endif --}}
                    <div class="row">
                        <div class="col-12">
                            <button type="button" @click='addData'
                                class="btn btn-soft-success rounded-pill float-right">
                                <x-lucide-list-plus class="w-4 h-4 text-gray-500" />
                                {{ trans('global.add_btn') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!--Project Title-->

        <div class="card">
            <template x-if='AbstructList.length>0'>
                <div class="card-header container-fluid">
                    <x-action-button class="btn-soft-secondary" @click='generatePDF'>
                        {{ trans('global.export.pdf') }}
                    </x-action-button>
                    <x-action-button class="btn-soft-primary" @click='generateExcel'>
                        {{ trans('global.export.excel') }}
                    </x-action-button>
                </div>
            </template>
            <div class="card-body overflow-auto">
                <template x-if='AbstructList.length>0'>
                    <div class="table-left-bordered table-responsive mt-4">
                        <table x-ref='abstructTable' class="table mb-0" role="grid">
                            <thead>
                                <template x-if="SelectDeptCategory==='Schedule of Rates'">
                                    <tr class="bg-white">
                                        <th class="text-dark">{{ trans('cruds.abstract.fields.id_helper') }}</th>
                                        <th class="text-dark text-center">Description</th>
                                        <th class="text-dark">Quantity</th>
                                        <th class="text-dark">Unit</th>
                                        <th class="text-dark">Rate</th>
                                        <th class="text-dark">GST</th>
                                        <th class="text-dark">CESS</th>
                                        <th class="text-dark text-center">Rate Incl.(GST & CESS)</th>
                                        <th class="text-dark text-end">
                                            {{ trans('cruds.abstract.fields.total_amount') }}
                                        </th>
                                        <th class="text-dark text-center" data-exclude="false">
                                            {{ trans('cruds.abstract.fields.actions') }}
                                        </th>
                                    </tr>
                                </template>

                                <template x-if="SelectDeptCategory==='Estimates Lists'">
                                    <tr class="bg-white">
                                        <th class="text-dark">{{ trans('cruds.abstract.fields.id_helper') }}</th>
                                        <th class="text-dark text-center">
                                            {{ trans('cruds.abstract.fields.category_works') }}
                                        </th>
                                        <th class="text-dark text-end">
                                            {{ trans('cruds.abstract.fields.total_amount') }}
                                        </th>
                                        <th class="text-dark text-center" data-exclude="false">
                                            {{ trans('cruds.abstract.fields.actions') }}
                                        </th>
                                    </tr>
                                </template>
                            </thead>
                            <tbody>

                                @if ($selectCategory === 'Schedule of Rates')
                                    {{-- <template x-if="SelectDeptCategory==='Schedule of Rates'"> --}}
                                    <template x-for="(absitem,index) in AbstructList"
                                        :key="Date.now() + Math.floor(Math.random() * 1000000)">
                                        <tr>
                                            <td class="text-dark" x-text='index+1'></td>
                                            <td class='text-wrap text-dark'>
                                                <strong x-text='absitem.introText'></strong><br />
                                                <template x-for="(desc,key) in absitem.sorDesc">
                                                    <p x-text="desc"></p><br />
                                                </template>
                                            </td>
                                            <td class='text-wrap text-dark' x-text='absitem.qty'>
                                            </td>
                                            <td class='text-wrap text-dark' x-text='absitem.sorUnit'></td>
                                            <td class='text-wrap text-dark' x-text='absitem.sorRate'></td>
                                            <td class='text-wrap text-dark' x-text='absitem.deptGST'></td>
                                            <td class='text-wrap text-dark' x-text='absitem.cess'></td>
                                            <td class='text-wrap text-dark' x-text='absitem.finalRate'></td>
                                            <td class='text-wrap text-dark' style='text-align:end;'
                                                x-text='Number(absitem.totalAmount).toFixed(2)'>
                                            </td>
                                            <td>
                                                {{-- <x-action-button class="btn-soft-primary" @click=ViewModel(absitem)
                                                    data-bs-toggle="modal" data-bs-target="#exampleModal" disabled>
                                                    <x-lucide-eye class="w-4 h-4 text-gray-500" />
                                                    {{ trans('global.view_btn') }}
                                                </x-action-button> --}}
                                                <x-action-button class="btn-soft-danger"
                                                    @click=removeItemFromEstimates(index)>
                                                    <x-lucide-trash class="w-4 h-4 text-gray-500" />
                                                    {{ trans('global.delete_btn') }}
                                                </x-action-button>
                                            </td>
                                        </tr>
                                    </template>
                                    {{-- </template> --}}
                                    <tr>
                                        <td colspan="8" style="text-align: end;">
                                            Total amount including GST and Cess (A) =
                                        </td>
                                        <td class="text-wrap" style='text-align:end;'
                                            x-text="calculateTotal().subtotal">
                                        </td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td colspan="8" class="text-end">
                                            Total Amount excluding Cess (B) = A/1.01 =
                                        </td>
                                        <td class="text-wrap" style='text-align:end;'
                                            x-text="calculateTotal().excludeCess">
                                        </td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td colspan="8" class="text-end">
                                            Contigency Charges (C) = @ 3.00 % on (B) =
                                        </td>
                                        <td class="text-wrap" style='text-align:end;'
                                            x-text='calculateTotal().contigencyTax'>

                                        </td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td colspan="8" class="text-end">
                                            Total Estimated Amount = (A+C) =
                                        </td>
                                        <td class="text-wrap" style='text-align:end;'
                                            x-text='calculateTotal().grandVal'>

                                        </td>
                                        <td>

                                        </td>
                                    </tr>
                                @endif

                                @if ($selectCategory === 'Estimates Lists')
                                    <template x-for="(absitem,index) in AbstructList"
                                        :key="Date.now() + Math.floor(Math.random() * 1000000)">
                                        <tr>
                                            <td class="text-dark" x-text='index+1'></td>
                                            <td class='text-wrap text-dark' x-text='absitem.estimateDesc'></td>
                                            <td class='text-wrap text-dark' style='text-align:end;'
                                                x-text='Number(absitem.totalAmount).toFixed(2)'>
                                            </td>
                                            <td>
                                                <x-action-button class="btn-soft-primary" @click=ViewModel(absitem)
                                                    data-bs-toggle="modal" data-bs-target="#exampleModal" disabled>
                                                    <x-lucide-eye class="w-4 h-4 text-gray-500" />
                                                    {{ trans('global.view_btn') }}
                                                </x-action-button>
                                                <x-action-button class="btn-soft-danger"
                                                    @click=removeItemFromEstimates(index)>
                                                    <x-lucide-trash class="w-4 h-4 text-gray-500" />
                                                    {{ trans('global.delete_btn') }}
                                                </x-action-button>
                                            </td>
                                        </tr>
                                    </template>
                                    <!--Total SubCost-->
                                    <tr>
                                        <td><span x-text='AbstructList.length + 1'></span></td>
                                        <td class="text-wrap">Total Cost <span
                                                x-text="'(' + Array.from({ length: AbstructList.length }, (_, i) => i + 1).join(' + ') + ')'"></span>
                                        </td>
                                        <td class="text-wrap" style='text-align:end;'
                                            x-text="calculateTotal().subtotal">
                                        </td>
                                        <td></td>

                                    </tr>
                                    <!--Total SubCost-->

                                    <!--GST Field -->
                                    <tr>
                                        <td><span x-text='AbstructList.length + 2'></span></td>
                                        <td class="text-wrap">Add GST @ <span x-text='gstPercentage()'></span>% of Sl
                                            No.
                                            <span x-text="AbstructList.length + 1"></span>
                                        </td>

                                        <td style='text-align:end;'><span x-text='calculateTotal().gstValue'></span>
                                        </td>
                                        <td></td>
                                    </tr>
                                    <!--GST Field -->

                                    <!--GST value with Total Field start-->
                                    <tr>
                                        <td><span x-text='AbstructList.length + 3'></span></td>
                                        <td class="text-wrap">Cost of Civil works excluding labour welfare cess (<span
                                                x-text="AbstructList.length + 1"></span>+<span
                                                x-text="AbstructList.length + 2"></span>)
                                        </td>
                                        <td style='text-align:end;'>
                                            <span x-text='calculateTotal().grandTotal'></span>
                                        </td>
                                        <td></td>
                                    </tr>
                                    <!--GST value with Total Field end-->

                                    <!-- All taxses start-->
                                    <template x-for="(taxes,index) in taxData" :key="index">
                                        <tr>
                                            <td><span x-text='AbstructList.length + index + 4'></span>
                                            </td>
                                            <td class="text-wrap"> <span x-text="taxes.taxName"></span> @ <span
                                                    x-text="taxes.taxPrec"></span>
                                                % on Sl. No - <span x-text='AbstructList.length + 3'></span>
                                            </td>
                                            <td style='text-align:end;'><span
                                                    x-text='Math.floor(parseFloat(calculateTotal().grandTotal) * ((taxes.taxPrec)/100)).toFixed(2)'></span>
                                            </td>
                                            <td></td>
                                        </tr>
                                    </template>
                                    <!-- All taxses end-->

                                    <!-- Final Grand Total Cost start-->
                                    <tr>
                                        <td><span x-text='AbstructList.length + 4 + taxData.length'></span></td>
                                        <td class="text-wrap">
                                            <span
                                                x-text="'Total Amount ('+Array.from({length:taxData.length},(_,i)=>(i+1)+AbstructList.length + 3).join('+')+') = Rs.'">
                                            </span>
                                        </td>
                                        <td class="font-bold" style='text-align:end;'>
                                            <span x-text='calculateTotal().grandVal'></span>
                                        </td>
                                        <td class="text-wrap"></td>

                                    </tr>
                                    <!--Final Grand Total Cost end -->
                                @endif
                                <template x-if='AbstructList.length===0'>
                                    <tr>
                                        <td colspan="5">{{ trans('global.table_data_msg') }}</td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                        <!-- Cost in Words start-->
                        <div
                            style="padding: 11px;margin-top:11px;border:1px solid;border-radius: 5px;text-align: end;">
                            <span style="font-weight: 500;color:#000000;"
                                x-text="'('+calculateTotal().costInWords+')'"></span>
                        </div>
                        <!-- Cost in Words end -->
                    </div>
                </template>
                <template x-if='AbstructList.length>0'>
                    <x-action-button type="submit" disabled class="btn-soft-primary float-right mt-2 "
                        @click='store'>
                        Save
                    </x-action-button>
                </template>

                <template x-if='AbstructList.length===0'>
                    <tr>
                        <td class="text-dark" colspan="6">No estimates available</td>
                    </tr>
                </template>
            </div>
        </div>

        <!-- Model propeties -->

        <div class="modal fade" id="exampleModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="exampleModalLabel" aria-hidden="true" x-bind:class="{ 'show': showModal }">
            <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable modal-fullscreen">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel" x-ref="modalTitle">
                            <template x-if='AbstructList.length>0'>
                                <span x-text="'Estimate No : ' + estimateItemSelectitem.estimateId"></span>
                            </template>
                            <div>
                            </div>
                        </h5>
                        <x-lucide-refresh-ccw class="w-6 h-6 text-gray-500 text-right" />
                    </div>
                    <div class="modal-body" x-ref="modalBody" x-html="renderItems()">
                    </div>
                    <div class="modal-footer">
                        <x-action-button class="btn-danger" data-bs-dismiss="modal" @click="closeModal">
                            {{ trans('global.close_btn') }}
                        </x-action-button>
                    </div>
                </div>
            </div>
        </div>


        <template x-if='showSORModal'>
            <div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                x-bind:class="{ 'show': showSORModal }" style="display:block;">
                <div class="modal-dialog modal-fullscreen modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" x-ref="modalSORTitle">
                            </h5>
                        </div>
                        <div class="modal-body" x-ref='tabulator_table'></div>
                        <div class="modal-footer">
                            <x-action-button class="btn-soft-danger" data-bs-dismiss="modal" @click="closeSORModal">
                                {{ trans('global.close_btn') }}
                            </x-action-button>
                        </div>
                    </div>
                </div>
            </div>
        </template>
        <!-- Model propeties-->

    </div>
</div>
