<div>
    <div id="table"></div>
    <button id="addColumnBtn">Add Column</button>
    <button id="addColumnGroupBtn">Add Column Group</button>
</div>

<script>
    var table = new Tabulator("#table", {
      columns: [

      ],
    //   data: [

    //   ]
    });

    document.getElementById("addColumnBtn").addEventListener("click", function() {
      addColumn();
    });
    document.getElementById("addColumnGroupBtn").addEventListener("click", function() {
      addColumnGroup();
    });

    function addColumn() {
      const newColumnTitle = prompt("Enter the column title:");

      if (newColumnTitle) {
        const newColumnField = "column_" + Math.random().toString(36).substring(7);

        const newColumnDefinition = {
          title: newColumnTitle,
          field: newColumnField,
          headerFilter: true
        };

        table.addColumn(newColumnDefinition);
      }
    }
    function addColumnGroup() {
        const newColumnGroup = prompt("Enter the column group name:");
      const columnCount = parseInt(prompt("Enter the number of columns to add:"));

      if (newColumnGroup && columnCount > 0) {
        const existingColumns = table.getColumns();
        const groupHeaders = [];

        existingColumns.forEach(function(column) {
          if (column.definition.title === newColumnGroup && column.definition.columns) {
            // Column group already exists, add new columns to it
            for (let i = 0; i < columnCount; i++) {
              const newColumnTitle = prompt("Enter the title for column " + (i + 1) + ":");
              const newColumnField = "column_" + Math.random().toString(36).substring(7);

              const newColumnDefinition = {
                title: newColumnTitle,
                field: newColumnField,
                headerFilter: true
              };

              column.definition.columns.push(newColumnDefinition);
            }
          } else {
            groupHeaders.push(column.definition);
          }
        });

        if (columnCount > 0) {
          // Create new column group with the added columns
          const newColumns = [];

          for (let i = 0; i < columnCount; i++) {
            const newColumnTitle = prompt("Enter the title for column " + (i + 1) + ":");
            const newColumnField = "column_" + Math.random().toString(36).substring(7);

            const newColumnDefinition = {
              title: newColumnTitle,
              field: newColumnField,
              headerFilter: true
            };

            newColumns.push(newColumnDefinition);
          }

          const newGroupColumnDefinition = {
            title: newColumnGroup,
            columns: newColumns
          };

          groupHeaders.push(newGroupColumnDefinition);
        }

        table.setColumns(groupHeaders);
      }
    }
  </script>
