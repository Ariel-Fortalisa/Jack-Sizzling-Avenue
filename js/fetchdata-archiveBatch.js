function formatDate(dateString) {
    const date = new Date(dateString);
    const month = String(date.getMonth() + 1).padStart(2, '0');
    const day = String(date.getDate()).padStart(2, '0');
    const year = date.getFullYear();
    return `${month}-${day}-${year}`;
}

function displayBatch(page, src) {
    src = src !== undefined ? src : $("#search").val();
    $.ajax({
        url: "./ajax/fetch-archiveBatch.php",
        type: 'get',
        dataType: "json",
        data: {
            request: 'batch',
            page: page,
            search: src
        },
        success: function (result) {
            var table = $("#archive_batch_table tbody");
            table.html('');
            let BatchCount = (page * 10) - 9;

            if (result.data && result.data.length > 0) {

            for (let batch of result.data) {
                const formattedDate = batch.expiration_date && batch.expiration_date !== "0000-00-00" ? formatDate(batch.expiration_date) : 'N/A';
                if (batch.expiration_status == 1) {
                    batchStatus = '<span style="background-color: #76a004; color: #fff; padding: .3rem .5rem; border-radius: .3rem">' + formattedDate + '</span>';
                } else if (batch.expiration_status == 2) {
                    batchStatus = '<span style="background-color: #fec400; color: #000; padding: .3rem .5rem; border-radius: .3rem">' + formattedDate + '</span>';
                } else if (batch.expiration_status == 3) {
                    batchStatus = '<span style="background-color: red; color: #000; padding: .3rem .5rem; border-radius: .3rem">' + formattedDate + '</span>';
                } else {
                    batchStatus = '<span style="background-color: red; color: dark; padding: .3rem .5rem; border-radius: .3rem"> N/A </span>';
                }

                let cost = parseFloat(batch.cost).toFixed(2);

                table.append(`
                    <tr>
                        <td>${BatchCount}</td>
                        <td>${batch.batch_id}</td>
                        <td>${batch.stock_name}</td>
                        <td>${batch.qty} ${batch.unit}</td>
                        <td>${cost}</td>
                        <td>${batchStatus}</td>
                         <td>
                            <button class="uil uil-history restore-btn" onclick="setDetails(${batch.batch_id}, 'restore');modalShow('restoreBatchModal')"></button>
                        </td>
                    </tr>
                `);
                BatchCount++;
            }
        }else{
            table.append(`
                   <tr>
                    <td colspan="10" class="text-center" style="height: 200px; vertical-align: middle">No Result</td>
                  </tr>
                `);
        }

            let totalData = result.data_count; // Example value
            let page_count = (totalData % 10 > 0) ? Math.floor(totalData / 10) + 1 : totalData / 10;
            paginate($("#archiveBatch_pagination"), page_count, page, 'displayBatch');
        }
    });
}


function setDetails(id, action) {
    $.ajax({
        url: "./ajax/fetch-archiveBatch.php",
        type: 'get',
        dataType: "json",
        data: {
            request: 'batch',
            id: id
        },
        success: function (result) {
            var btch = result.data[0];

        if(action === 'restore'){
            $('#restoreBatch_title').html('Batch ID: '+btch.batch_id);
            $('#restore_batch_id').val(btch.batch_id);
            $('#restore_stock_id').val(btch.stock_id);
            }
        }
    });
            
}


$(document).ready(function () {
    displayBatch(1);

    $("#search").on('keyup', function() {
        displayBatch(1, $(this).val());
    });

});