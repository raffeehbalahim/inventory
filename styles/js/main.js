$('.set').click(function(){
    $tr = $(this).closest('tr');

    $data = $tr.children('td').map(function(){
        return $(this).text();
    }).get();

    console.log($data);
    if($data[2] == "None"){
        $('#editSet #currentAssignee').val(0);
        $('#editSet #empID').val(0);
        $('#editSet #none').hide();
    } else {
        $('#editSet #empID').val($data[3]);
        $('#editSet #currentAssignee').val($data[3]);
        $('#editSet #none').show();
    }
    $('#editSet #currentAssignee').html($data[2]);

    $('.modal #set').html($data[1]);
    $('#deleteBundle #delete').attr('href','lib/delete.php?set='+ $data[0]);

    $('#editSet #setID').val($data[0]);
    $('#editSet #set').val($data[1]);
    // $('#editSet #currentAssignee').html($data[2]);
    // $('#editSet #assignee').val($data[3]);
    // $('#editSet #empID').val($data[3]);
    
});
/*
$('.item').click(function(){
    $tr = $(this).closest('tr');

    $data = $tr.children('td').map(function(){
        return $(this).text();
    }).get();

    // organize->change to class 

    

    $('#editItem #item').val($data[0]);
    $('#editItem #brand').val($data[2]);
    $('#editItem #unit').val($data[3]);
    $('#editItem #serial').val($data[4]);
    $('#editItem #purchaseDate').val($data[5]);
    $('#editItem #specs').val($data[9]);
    $('#editItem #price').val($data[6]);
    $('#editItem #manufacturer').val($data[7]);
    $('#editItem #receiptId').val($data[8]);
    $('#editItem #set').val($data[1]);
    $('#editItem #set').text($data[10]);

    $('#deleteItem #item').val($data[0]);
    $('#deleteItem #brand').val($data[1]);
    $('#deleteItem #unit').val($data[2]);
    $('#deleteItem #serial').val($data[3]);
    $('#deleteItem #purchaseDate').val($data[4]);
    $('#deleteItem #set').val($data[5]);
    
    $('#deleteItem #delete').attr('href','lib/delete.php?item='+ $data[0]);
}); 
*/
$('.employee').click(function(){
    $tr = $(this).closest('tr');

    $data = $tr.children('td').map(function(){
        return $(this).text();
    }).get();
    
    console.log($data);

    if($data[3] == "None"){
        $('#editEmployee #none').hide();
        $('#editEmployee #currentBundle').html($data[2]);
        $('#editEmployee #currentBundle').val(2);
    } else {
        $('#editEmployee #none').show();
        $('#editEmployee #currentBundle').html($data[3]);
        $('#editEmployee #currentBundle').val($data[2]);
    }
    //$('#editEmployee #employee').val($data[0]);
    $('#editEmployee #firstname').val($data[0]);
    $('#editEmployee #lastname').val($data[1]);

    

    // $('#editEmployee #set').val($data[1]);
    // $('#editEmployee #set').text($data[4]);

    $('#deleteEmployee #employee').val($data[0]);
    $('#deleteEmployee #firstname').val($data[1]);
    $('#deleteEmployee #lastname').val($data[2]);
    $('#deleteEmployee #set').val($data[4]);

    $('#deleteEmployee #delete').attr('href','lib/delete.php?employee='+ $data[0]);
});

$('.sidebar-item a').each(function(){
    if($(location).attr('pathname').includes($(this).attr('href'))){
        $(this).parent().addClass("active");
    } else if($(location).attr('pathname') == '/InventoryHR/'){
        $('.sidebar-item a[href="index.php"]').parent().addClass("active");
    }
});

function showFilters(){
    document.getElementById("showFilter").style.display = 'none';
    document.getElementById("filter").style.display = 'block';
}
function closeFilters(){
    document.getElementById("showFilter").style.display = 'block';
    document.getElementById("filter").style.display = 'none';
}
function searchItemTable() {
    // Declare variables
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("searchInput");
    filter = input.value.toUpperCase();
    table = document.getElementById("myTable");
    tr = table.getElementsByTagName("tr");

    // Loop through all table rows, and hide those who don't match the search query
    for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[3]; // Change the index to the column you want to search
        td2 = tr[i].getElementsByTagName("td")[4];
        td3 = tr[i].getElementsByTagName("td")[5];
        td4 = tr[i].getElementsByTagName("td")[6];
        td5 = tr[i].getElementsByTagName("td")[7];
        td6 = tr[i].getElementsByTagName("td")[8];
        td7 = tr[i].getElementsByTagName("td")[9];
        td8 = tr[i].getElementsByTagName("td")[10];
        if (td) {
            txtValue = (td.textContent + td2.textContent + td3.textContent + td4.textContent + td5.textContent + td6.textContent + td7.textContent + td8.textContent) || (td.innerText + td2.innerText);
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }       
    }
}

function searchEmployeeTable() {
    // Declare variables
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("searchInput");
    filter = input.value.toUpperCase();
    table = document.getElementById("myTable");
    tr = table.getElementsByTagName("tr");
  
    // Loop through all table rows, and hide those who don't match the search query
    for (i = 0; i < tr.length; i++) {
      td = tr[i].getElementsByTagName("td")[1]; // Change the index to the column you want to search
	  td2 = tr[i].getElementsByTagName("td")[2];
      if (td) {
        txtValue = (td.textContent + td2.textContent) || (td.innerText + td2.innerText);
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
          tr[i].style.display = "";
        } else {
          tr[i].style.display = "none";
        }
      }       
    }
}
$(document).ready( function () {
    var table = $('#myTable').DataTable({
        scrollX: true,
        fixedHeader: {
            header: true,
        }
    });
    //Adding Pagination and Page Info into Footer
    $("#myTable_info").detach().appendTo('#footer');
    $("#myTable_paginate").detach().appendTo('#footer');

    // Add event listener for opening and closing details
    /*$('#myTable tbody').on('click', 'td', function () {
        var tr = $(this).closest('tr');
        var row = table.row(tr)
 
        if (row.child.isShown()) {
            //This row is already open - close it
           row.child.hide();
           tr.removeClass('shown');
       }
       table.rows().every(function() {
           if(this.child.isShown()) {
           // Collapse row details
           this.child.hide();
           $(this.node()).removeClass('parent');
           }
       })
       if(row.child.hide()) {        
           // Open this row
           row.child(format(row.data())).show();
           tr.addClass('shown');
       }
    });*/
});

$(document).ready( function () {
    $('#employeeTables').DataTable({
        scrollX: true,
        fixedHeader: {
            header: true,
        }
    });
    //Adding Pagination and Page Info into Footer
    $("#employeeTables_info").detach().appendTo('#footer');
    $("#employeeTables_paginate").detach().appendTo('#footer');
});
$(document).ready( function () {
    $('#fileTable').DataTable({
        scrollX: true,
        fixedHeader: {
            header: true,
        }
    });
    //Adding Pagination and Page Info into Footer
    $("#fileTable_info").detach().appendTo('#footer');
    $("#fileTable_paginate").detach().appendTo('#footer');
});

$(document).ready( function () {
    var table = $('#itemTable').DataTable({
        scrollX: true,
        fixedHeader: {
            header: true,
        }
    });
    //Adding Pagination and Page Info into Footer
    $("#itemTable_info").detach().appendTo('#footer');
    $("#itemTable_paginate").detach().appendTo('#footer');
    

    // Add event listener for opening and closing details
    $('#itemTable tbody').on('click', 'td', function () {
            
        var tr = $(this).closest('tr');
        var row = table.row(tr);
 
        if (row.child.isShown()) {
            //This row is already open - close it
            $('div.slider', row.child()).slideUp(function () {
                row.child.hide();
                tr.removeClass('shown');
            });
        }
        /*table.rows().every(function() {
            if(this.child.isShown()) {
            // Collapse row details
                $('div.slider', this.child()).slideUp(function () {
                    this.child.hide();
                    $(this.node()).removeClass('parent');
                });
            }
        });*/ else {
        if(row.child.hide()) {        
            // Open this row
            row.child(format(row.data()), 'no-padding').show();
            tr.addClass('shown');
            $('div.slider', row.child()).slideDown();
        }}
        
    });
    //Open Accordion Selected From Set Page
    var row_id = document.getElementById('searchItem').innerHTML;
    var itemtr = document.getElementById(row_id);
    var itemrow = table.row(itemtr);
    if(row_id != ''){ 
            itemrow.child(format(itemrow.data()), 'no-padding').show();
            $('div.slider', itemrow.child()).slideDown();
            itemtr.addClass('shown');
            
    }
});

$(document).ready( function () {
    var table = $('#setsTable').DataTable({
        scrollX: true,
        fixedHeader: {
            header: true,
        }
    });
    //Adding Pagination and Page Info into Footer
    $("#setsTable_info").detach().appendTo('#footer');
    $("#setsTable_paginate").detach().appendTo('#footer');
    

    // Add event listener for opening and closing details
    $('#setsTable tbody').on('click', 'td', function () {
       
        var tr = $(this).closest('tr');
        var row = table.row(tr)
 
        if (row.child.isShown()) {
            //This row is already open - close it
           row.child.hide();
           tr.removeClass('shown');
       }
       table.rows().every(function() {
           if(this.child.isShown()) {
           // Collapse row details
           this.child.hide();
           $(this.node()).removeClass('parent');
           }
       })
       if(row.child.hide()) {        
           // Open this row
           row.child(setformat(row.data())).show();
           tr.addClass('shown');
       }
    });
});

function format(row) {
    return (
        '<div class="slider">'+
        row[12] +
        '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">' +
        '<tr>' +
        '<td>Serial Number:</td>' +
        '<td>'+ row[4] +'</td>' +
        '</tr>' +
        '<tr>' +
        '<td>Assignee:</td>' +
        '<td>'+ row[10] +'</td>' +
        '</tr>' +
        '<tr>' +
        '<td>Additional Information:</td>' +
        '<td>'+ row[9] +'</td>' +
        '</tr>' +
        '</table>'+
        '</div>' 
    );
}

function setformat(row) {
    return (
        '<span>Peripherals:</span>' +
        '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">' +
        '<thead>' +
        '<tr>' +
        '<th>Unit</th>' +
        '<th>Serial Number</th>' +
        '<th>Receipt ID</th>' +
        '<th>Purchase Date</th>' +
        '<th>View</th>' +
        '</tr>' +
        '</thead>' +
        '<tbody>' +
        '<tr>' +
        '<td>'+ row[4] +'</td>' +
        '<td>'+ row[5] +'</td>' +
        '<td>'+ row[6] +'</td>' +
        '<td>'+ row[7] +'</td>' +
        '<td>'+ row[8] +'</td>' +
        '</tr>' +
        '</tr>' +
        '</tbody>' +
        '</table>'
    );
}
function editItems($id){
    //$tr = $(this).attr('id');
    //$tr = document.getElementById('row_'+$id);
    //alert($tr.id);
    //$data = $tr.children('td').map(function(){
    //    return $(this).text();
    //}).get();
    $item = document.getElementById('component_id_'+$id).innerHTML;
    $brand = document.getElementById('brand_'+$id).innerHTML;
    $unit = document.getElementById('unit_'+$id).innerHTML;
    $serial = document.getElementById('serial_number_'+$id).innerHTML;
    $purchaseDate = document.getElementById('purchase_date_'+$id).innerHTML;
    $specs = document.getElementById('specs_'+$id).innerHTML;
    $price = document.getElementById('price_'+$id).innerHTML;
    $manufacturer = document.getElementById('manufacturer_'+$id).innerHTML;
    $receiptId = document.getElementById('receipt_id_'+$id).innerHTML;
    $setVal = document.getElementById('set_id_'+$id).innerHTML;
    $setText = document.getElementById('set_text_'+$id).innerHTML;
    //alert($setText);
    
    //alert($item);

    // organize->change to class 

    

    $('#editItem #item').val($item);
    $('#editItem #brand').val($brand);
    $('#editItem #unit').val($unit);
    $('#editItem #serial').val($serial);
    $('#editItem #purchaseDate').val($purchaseDate);
    $('#editItem #specs').val($specs);
    $('#editItem #price').val($price);
    $('#editItem #manufacturer').val($manufacturer);
    $('#editItem #receiptId').val($receiptId);
    $('#editItem #set').val($setVal);
    $('#editItem #set').text($setText);

    $('#deleteItem #item').val($item);
    $('#deleteItem #brand').val($brand);
    $('#deleteItem #unit').val($unit);
    $('#deleteItem #serial').val($serial);
    $('#deleteItem #purchaseDate').val($purchaseDate);
    $('#deleteItem #set').val($setVal);
    
    $('#deleteItem #delete').attr('href','lib/delete.php?item='+ $item);

    $('#assignItem #item').val($item);
    $('#assignItem #unit').val($unit);
    $('#assignItem #serial').val($serial);
    $('#assignItem #set').val($setVal);
    $('#assignItem #set').text($setText);
}; 

function showItem(row_id){
    var table = document.getElementByID('itemTable');
    var tr = document.getElementByID(row_id);
    //var tr = $(this).closest('tr');
    var row = table.row(tr)

    row.child(format(row.data())).show();
    tr.addClass('shown');
}
$(document).ready( function () {
$(".updateTooltip").hover(function(){
    $(".showupdateTooltip").css("visibility", "visible");
},function(){
    $(".showupdateTooltip").css("visibility", "hidden");
});
});