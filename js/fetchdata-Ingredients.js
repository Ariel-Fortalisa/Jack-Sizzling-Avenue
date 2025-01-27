function formatDate(dateString) {
    const date = new Date(dateString);
    const month = String(date.getMonth() + 1).padStart(2, '0');
    const day = String(date.getDate()).padStart(2, '0');
    const year = date.getFullYear();
    
    let hours = date.getHours();
    const minutes = String(date.getMinutes()).padStart(2, '0');
    const ampm = hours >= 12 ? 'PM' : 'AM';
    hours = hours % 12;
    hours = hours ? hours : 12; // the hour '0' should be '12'
    
    return `${month}-${day}-${year}`;
}

$("#search").on("input", function () {
    itemtable(1, $(this).val());
})


function itemtable(page, search) {
    var src = search != undefined ? search : $("#search").val();
    $.ajax({
        url: "./ajax/fetch-ingredients.php",
        type: 'get',
        content: "json",
        data: {
            request: 'items',
            page: page,
            search: src
        },
        success: function (result) {
            var table = $('#ingredientsTable tbody');
            table.html('')
            var count = (page * 10) - 9;

            if (result.data && result.data.length > 0) {
            
                for (let item of result.data) {
                    let badge = '';
                    // Set badge based on stock status
                    if (item.stock_status == 1) {
                        badge = `<div style="width: 5rem; margin: auto; background-color: #76a004; color: #fff; padding: .3rem .3rem; border-radius: .3rem">
                                    In stock</div>`;
                    } else if (item.stock_status == 2) {
                        badge = `<div style="width: 5rem; margin: auto; background-color: #fec400; color: #000; padding: .3rem .3rem; border-radius: .3rem">
                                    Low stock</div>`;
                    } else if (item.stock_status == 3) {
                        badge = `<div style="width: 5rem; margin: auto; background-color: red; color: #fff; padding: .3rem .3rem; border-radius: .3rem">
                                    Out of stock</div>`;
                    }

                let quantity = (item.qty === null) ? `0 ${item.unit}` : `${item.qty} ${item.unit}`;


                table.append(`
                    <tr>
                       <td class="font-weight-bold">${count}</td>
                       <td>${item.item_name}</td>
                       <td class="text-center">PHP ${parseFloat(item.cost).toFixed(2)}</td>
                       <td class="text-center">${quantity}</td>
                       <td class="text-center">${badge}</td>
                       <td> 
                            <button class="batch" onclick="setDetailModal(${item.id});modalShow('viewBatchModal');"><img src="img/boxes.png"></button>
                                    <button class="uil uil-eye view-btn" onclick="setDetailModal(${item.id});modalShow('viewItemModal')"></button>
                                    <button class="uil uil-edit edit-btn" onclick="setDetailModal(${item.id});modalShow('editItemModal')"></button>
                                    <button class="uil uil-archive archive-btn" onclick="setDetailModal(${item.id});modalShow('archiveItemModal')"></button>
                                
                        </td>
                    </tr>
                `);
                count++;
            }
        } else {
            // If no data, show "No Result" message
            table.append(`
                <tr>
                    <td colspan="6" class="text-center" style="height: 200px; vertical-align: middle">No Result</td>
                </tr>
            `);
        }

            let totalData = result.data_count; // Example value
            let page_count = (totalData % 10 > 0) ? Math.floor(totalData / 10) + 1 : totalData / 10;
            paginate($("#ingredients_pagination"), page_count, page, 'itemtable');
        }
    })


}



function setDetailModal(id) {
    $.ajax({
        url: "./ajax/fetch-ingredients.php",
        type: 'get',
        content: "json",
        data: {
            request: 'items',
            id: id,
        },
        success: function (result) {
            var stock = result.data[0];
            var BatchTableModal = $("#batchTable tbody");
            BatchTableModal.html('');
            var batchStatus = "";
            let batchcount = 1;
            let badge = '';


            if (stock.batch && stock.batch.length > 0) {

                for (batch of stock.batch) {
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

                    BatchTableModal.append(`
                       <tr> 
                            <td class="font-weight-bold">${batchcount}</td>
                            <td class="text-center">${batch.batch_id}</td>
                            <td class="text-center">${batch.qty} ${stock.unit}</td>
                            <td class="text-center">PHP ${parseFloat(batch.cost).toFixed(2)}</td>
                            <td class="text-center">${batchStatus}</td>
                                <td><button class="uil uil-edit edit-btn" onclick="setEditBatch(${batch.batch_id}, '${stock.item_name}',${batch.qty}, ${batch.cost}, '${batch.expiration_date}', ${stock.id});modalShow('editBatchModal')"></button>
                            <button class="uil uil-archive archive-btn" onclick="setArchiveBatch(${batch.batch_id}, ${batch.archive_status}, ${stock.id});modalShow('archiveBatchModal')"></button>                       
                        </td>
                        </tr>

                `);
                    batchcount++;
                }
            } else {
                BatchTableModal.append(`
                <tr>
                <td colspan="10" class="text-center" style="height: 200px; vertical-align: middle">No Result</td>
                </tr>
                `);
            }

               // Format stock date and time
               const formattedDateAdded = formatDate(stock.date_added);
               const formattedTimeAdded = new Date(stock.date_added).toLocaleTimeString('en-US', {
                   hour: '2-digit',
                   minute: '2-digit',
                   hour12: true,
               });
            
            if (stock.stock_status == 1) {
                badge = `<div style="width: 5rem; margin: auto; background-color: #76a004; color: #fff; padding: .3rem .3rem; border-radius: .3rem; margin-left: -3px;">&nbsp;&nbsp;In stock</div>`;
            } else if (stock.stock_status == 2) {
                badge = `<div style="width: 5rem; margin: auto; background-color: #fec400; color: #000; padding: .3rem .3rem; border-radius: .3rem; margin-left: -3px;">Low stock</div>`;
            } else if (stock.stock_status == 3) {
                badge = `<div style="width: 5rem; margin: auto; background-color: red; color: #fff; padding: .3rem .3rem; border-radius: .3rem; margin-left: -3px;">out of stock</div>`;
            }

            let quantity = (stock.qty === null) ? `0 ${stock.unit}` : `${stock.qty} ${stock.unit}`;

                //view batch modal
                $('#viewstock_name').html(stock.item_name);
                $('#viewstock_qty').html(quantity);
                $('#viewbatch_count').html('x' + stock.batch_count);
                $('#viewcost').html('PHP ' + stock.cost);
                $('#viewcritical_stock').html(stock.critical);
                $('#viewstock').html(badge);
                $('#viewbatch_title').html(stock.item_name + ' Batches');
                $('#viewdate_added').html('Date Added: ' + formattedDateAdded);
                $('#viewtime').html('Time: ' + formattedTimeAdded);
                $('#viewAdded_by').html('Added By: '+stock.added_by);
                

                //add new batch modal
                $('#addnewBatch-stockName').attr("value", stock.item_name);
                $('#addnewBatch-stock_id').val(stock.id);
                $('#addNewBatch-cost').val(stock.cost);

                //edit STOCK modal
                $('#editStock-id').val(stock.id);
                $('#editStock-Item_name').val(stock.item_name);
                $('#editStock-cost').val(stock.cost);
                $('#editStock-critical').val(stock.critical);
                $('#editunit_stock').val(stock.unit_id);

                //archive stock
                $('#archive_title').html(stock.item_name);
                $('#archivestock_id').val(stock.id);
                $('#archivestock_status').val(stock.archive_status);
          
        }

    })

}

function setEditBatch(batch_id, item_name, qty, cost, expiration_date, stock_id) {
    //edit batch modal
    $('#editbatch_title').html('Edit Batch ' + batch_id);
    $('#editBatch-batch_id').val(batch_id);
    $('#editStock-Item').attr("value", item_name);
    $('#editBatch-cost').val(cost);
    $('#editBatch-qty').val(qty);
    $('#editexpiration_date').val(expiration_date);
    $('#editbatch-stock_id').val(stock_id);
}

function setArchiveBatch(id, status, stock_id) {
    //archive batch
    $('#archive_batch_title').html('Archive Batch ' + id);
    $('#archivebatch_id').val(id);
    $('#archivebatch_status').val(status);
    $('#archivebatch_stock_id').val(stock_id);
}



$(document).ready(function () {
    itemtable(1);
})
