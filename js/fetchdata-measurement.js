function displaymeasurement(page, search) {
    var src = search || $("#search").val();
     $.ajax({
         url: "./ajax/fetch-measurement.php",
         type: 'get',
         dataType: "json",
         data: {
             request: 'unit',
             page: page,
             search: src,
         },
         success: function (result) {
             var table = $('#measurement-tbl tbody');
             table.html('');
             Count = (page * 10) - 9;
 
             if (result.data && result.data.length > 0) {
 
                 for (let unit of result.data) {
 
 
                     table.append(`
                         <tr>
                             <td style="font-weight:bold">${Count}</td>
                             <td>${unit.unit_name}</td>
                             <td> 
                                <button class="uil uil-edit edit-btn" onclick="setDetails(${unit.id}, 'edit');modalShow('editMeasurementModal')"></button>
                                <button class="uil uil-archive archive-btn" onclick="setDetails(${unit.id}, 'archive');modalShow('archiveMeasurementModal')"></button>
                            </td>
                        </tr>
                     `);
                     Count++;
                 }
             }
             else{
                 // If no data, show "No Result" message
                 table.append(`
                     <tr>
                         <td colspan="10" class="text-center" style="height: 200px; vertical-align: middle">No Result</td>
                     </tr>
                 `);
             }
 
             let totalData = result.data_count; // Example value
             let page_count = (totalData % 10 > 0) ? Math.floor(totalData / 10) + 1 : totalData / 10;
             paginate($("#measurement_pagination"), page_count, page, 'displaymeasurement');
 
 
         }
     });
 
 }

 
function setDetails(id, action) {
    $.ajax({
        url: "./ajax/fetch-measurement.php",
        type: 'get',
        dataType: "json",
        data: {
            request: 'unit',
            id: id
        },
        success: function (result) {
            var uom = result.data[0]

            if(action === 'edit'){

            // Edit category
            $('#editmeasurement_name').val(uom.unit_name);
            $('#editmeasurement_id').val(uom.id);

            }else if (action === 'archive'){
            $('#archivemeasurement_id').val(uom.id)
            $('#Archivemeasurement_title').html('Measurement: ' + uom.unit_name)
            }
        }
    });

}

 $(document).ready(function () {
     displaymeasurement(1);
 })
 
 $("#search").on('keyup', function () {
     displaymeasurement(1, $(this).val());
 });