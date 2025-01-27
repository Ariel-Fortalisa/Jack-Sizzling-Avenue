function formatDate(dateString) {
    const date = new Date(dateString);
    const month = String(date.getMonth() + 1).padStart(2, '0');
    const day = String(date.getDate()).padStart(2, '0');
    const year = date.getFullYear();
    return `${month}-${day}-${year}`;
}

function itemtable(page, search) {
    var src = search != undefined ? search : $("#search").val();
    $.ajax({
        url: "./ajax/fetch-stockStatus.php",
        type: 'get',
        content: "json",
        data: {
            request: 'items',
            page: page,
            search: src,
            stock_status: 1
        },
        success: function (result) {
            var table = $('#table_stockin tbody');
            table.html('');  // Clear the table content
            var count = (page * 10) - 9;

            if (result.data && result.data.length > 0) {
                // Loop through the filtered items
                for (let item of result.data) {
                    let quantity = (item.qty === null) ? `0 ${item.unit}` : `${item.qty} ${item.unit}`;

                    table.append(`
                        <tr>
                            <td class="font-weight-bold">${count}</td>
                            <td>${item.item_name}</td>
                            <td class="text-center">${parseFloat(item.cost).toFixed(2)}</td>
                            <td class="text-center">${quantity}</td>
                            <td class="text-center">
                                <div style="width: 5rem; margin: auto; background-color: #76a004; color: #fff; padding: .3rem .3rem; border-radius: .3rem">
                                    In stock
                                </div>
                            </td>
                        </tr>
                    `);
                    count++;
                }
            } else {
                table.append(`
                    <tr>
                        <td colspan="6" class="text-center" style="height: 200px; vertical-align: middle">No Result</td>
                    </tr>
                `);
            }

            let totalData = result.inStockCount; 
            let page_count = (totalData % 10 > 0) ? Math.floor(totalData / 10) + 1 : totalData / 10;
            paginate($("#stocks_ingredients_Instock_status_pagination"), page_count, page, 'itemtable');
            
            let inventory_cost = parseFloat(result.inventory_cost).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });

            $('#overall_count_items').html(result.overall_items);
            $('#inventory_cost').html('₱'+inventory_cost);
            $('#low_stock_batches').html(result.LowStockCount)
            
        }
    });
}


function LowStock(page, search) {
    var src = search != undefined ? search : $("#search").val();
    $.ajax({
        url: "./ajax/fetch-stockStatus.php",
        type: 'get',
        content: "json",
        data: {
            request: 'items',
            page: page,
            search: src,
            stock_status: 2 // For Low Stock items (status 2)
        },
        success: function (result) {
            var table = $('#lowStock tbody');
            table.html('');  // Clear the table content
            var count = (page * 10) - 9;

            if (result.data && result.data.length > 0) {
                // Loop through the filtered items
                for (let item of result.data) {
                    let quantity = (item.qty === null) ? `0 ${item.unit}` : `${item.qty} ${item.unit}`;

                    table.append(`
                        <tr>
                            <td class="font-weight-bold">${count}</td>
                            <td>${item.item_name}</td>
                            <td class="text-center">${parseFloat(item.cost).toFixed(2)}</td>
                            <td class="text-center">${quantity}</td>
                            <td>
                                <div style="width: 5rem; margin: auto; background-color: #fec400; color: #000; padding: .3rem .3rem; border-radius: .3rem">
                                    Low stock</div>
                            </td>
                        </tr>
                    `);
                    count++;
                }
            } else {
                table.append(`
                    <tr>
                        <td colspan="6" class="text-center" style="height: 200px; vertical-align: middle">No Result</td>
                    </tr>
                `);
            }

            let totalData = result.LowStockCount; 
            let page_count = (totalData % 10 > 0) ? Math.floor(totalData / 10) + 1 : totalData / 10;
            paginate($("#lowStock_pagination"), page_count, page, 'LowStock');
        }
    });
}


function OutofStocks(page, search) {
    var src = search != undefined ? search : $("#search").val();
    $.ajax({
        url: "./ajax/fetch-stockStatus.php",
        type: 'get',
        content: "json",
        data: {
            request: 'items',
            page: page,
            search: src,
            stock_status: 3 // For Out of Stock items (status 3)
        },
        success: function (result) {
            var table = $('#out_of_stocks tbody');
            table.html('');  // Clear the table content
            var count = (page * 10) - 9;

            if (result.data && result.data.length > 0) {
                // Loop through the filtered items
                for (let item of result.data) {
                    let quantity = (item.qty === null) ? `0 ${item.unit}` : `${item.qty} ${item.unit}`;

                    table.append(`
                        <tr>
                            <td class="font-weight-bold">${count}</td>
                            <td>${item.item_name}</td>
                            <td class="text-center">${parseFloat(item.cost).toFixed(2)}</td>
                            <td class="text-center">${quantity}</td>
                            <td>
                                <div style="width: 5rem; margin: auto; background-color: #c21807; color: #fff; padding: .3rem .2rem; border-radius: .3rem">
                                    Out of stock</div>
                            </td>
                        </tr>
                    `);
                    count++;
                }
            } else {
                table.append(`
                    <tr>
                        <td colspan="6" class="text-center" style="height: 200px; vertical-align: middle">No Result</td>
                    </tr>
                `);
            }

            let totalData = result.OutofStockCount; 
            let page_count = (totalData % 10 > 0) ? Math.floor(totalData / 10) + 1 : totalData / 10;
            paginate($("#OutofStocks_pagination"), page_count, page, 'OutofStocks');
        }
    });
}


function GoodStatus(page, search) {
    var src = search !== undefined ? search : $("#search").val();
    $.ajax({
        url: "./ajax/fetch-batch.php",
        type: 'get',
        dataType: "json",
        data: {
            request: 'batch',
            page: page,
            search: src,
            expiration_status: 1
        },
        success: function (result) {
            var table = $('#good_status_table tbody');
            table.html('');
            var count = (page * 10) - 9;

            if (result.data && result.data.length > 0) {
                for (let batch of result.data) {
                    const formattedDate = batch.expiration_date && batch.expiration_date !== "0000-00-00" 
                        ? formatDate(batch.expiration_date) 
                        : 'N/A';

                    let batchStatus = '<span style="background-color: #76a004; color: #fff; padding: .3rem .5rem; border-radius: .3rem">' + formattedDate + '</span>';
                    let cost = parseFloat(batch.cost).toFixed(2);

                    // Append each row to the table
                    table.append(`
                        <tr>
                            <td class="font-weight-bold">${count}</td>
                            <td style="text-align: left;">${batch.stock_name}</td>
                            <td style="text-align: right;"> ${cost}</td>
                            <td class="text-center">${batch.batch_id}</td>
                            <td class="text-center">${batchStatus}</td>
                        </tr>
                    `);
                    count++;
                }
            } else {
                table.append(`
                    <tr>
                        <td colspan="4" class="text-center" style="height: 200px; vertical-align: middle">No Good Batches</td>
                    </tr>
                `);
            }

            let totalData = result.Goodcount;
            let page_count = (totalData % 10 > 0) ? Math.floor(totalData / 10) + 1 : totalData / 10;
            paginate($("#goodstatus_pagination"), page_count, page, 'GoodStatus');
        }
    });
}


function NearlyExpireStatus(page, search) {
    var src = search !== undefined ? search : $("#search").val();
    $.ajax({
        url: "./ajax/fetch-batch.php",
        type: 'get',
        dataType: "json",
        data: {
            request: 'batch',
            page: page,
            search: src
        },
        success: function (result) {
            var table = $('#nearly_expire_table tbody');
            table.html('');
            var count = (page * 10) - 9;

            if (result.data && result.data.length > 0) {
                // Filter batches with expiration_status == 2
                let filteredData = result.data.filter(batch => batch.expiration_status == 2);

                if (filteredData.length > 0) {
                    for (let batch of filteredData) {
                        const formattedDate = batch.expiration_date && batch.expiration_date !== "0000-00-00" 
                            ? formatDate(batch.expiration_date) 
                            : 'N/A';

                        let batchStatus = '<span style="background-color: #fec400; color: #000; padding: .3rem .5rem; border-radius: .3rem">' + formattedDate + '</span>';
                        let cost = parseFloat(batch.cost).toFixed(2);


                        // Append each row to the table
                        table.append(`
                            <tr>
                                <td class="font-weight-bold">${count}</td>
                                <td style="text-align: left;">${batch.stock_name}</td>
                                <td style="text-align: right">₱ ${cost}</td>
                                <td class="text-center">${batch.batch_id}</td>
                                <td class="text-center">${batchStatus}</td>
                            </tr>
                        `);
                        count++;
                    }
                } else {
                    table.append(`
                        <tr>
                            <td colspan="4" class="text-center" style="height: 200px; vertical-align: middle">No Nearly Expired Batches</td>
                        </tr>
                    `);
                }
            } else {
                table.append(`
                    <tr>
                        <td colspan="4" class="text-center" style="height: 200px; vertical-align: middle">No Result</td>
                    </tr>
                `);
            }

            let totalData = result.NearlyExpireCount;
            let page_count = (totalData % 10 > 0) ? Math.floor(totalData / 10) + 1 : totalData / 10;
            paginate($("#nearly_expire_pagination"), page_count, page, 'NearlyExpireStatus');
        }
    });
}


function ExpireStatus(page, search) {
    var src = search !== undefined ? search : $("#search").val();
    $.ajax({
        url: "./ajax/fetch-batch.php",
        type: 'get',
        dataType: "json",
        data: {
            request: 'batch',
            page: page,
            search: src
        },
        success: function (result) {
            var table = $('#expire_table tbody');
            table.html('');
            var count = (page * 10) - 9;

            if (result.data && result.data.length > 0) {
                // Filter batches with expiration_status == 3
                let filteredData = result.data.filter(batch => batch.expiration_status == 3);

                if (filteredData.length > 0) {
                    for (let batch of filteredData) {
                        const formattedDate = batch.expiration_date && batch.expiration_date !== "0000-00-00" 
                            ? formatDate(batch.expiration_date) 
                            : 'N/A';

                        let batchStatus = '<span style="background-color: #c21807; color: #fff; padding: .3rem .5rem; border-radius: .3rem">' + formattedDate + '</span>';
                        let cost = parseFloat(batch.cost).toFixed(2);

                        // Append each row to the table
                        table.append(`
                            <tr>
                                <td class="font-weight-bold">${count}</td>
                                <td style="text-align: left;">${batch.stock_name}</td>
                                <td style="text-align: right;">${cost}</td>
                                <td class="text-center">${batch.batch_id}</td>
                                <td class="text-center">${batchStatus}</td>
                            </tr>
                        `);
                        count++;
                    }
                } else {
                    table.append(`
                        <tr>
                            <td colspan="4" class="text-center" style="height: 200px; vertical-align: middle">No Expired Batches</td>
                        </tr>
                    `);
                }
            } else {
                table.append(`
                    <tr>
                        <td colspan="4" class="text-center" style="height: 200px; vertical-align: middle">No Result</td>
                    </tr>
                `);
            }

            let totalData = result.expired_count;
            let page_count = (totalData % 10 > 0) ? Math.floor(totalData / 10) + 1 : totalData / 10;
            paginate($("#expired_pagination"), page_count, page, 'ExpireStatus');

            $('#expired_items_count').html(result.expired_count);
        }
    });
}


$("#search").on("input", function () {
    itemtable(1, $(this).val());
})

$(document).ready(function () {
    itemtable(1);
    LowStock(1);
    OutofStocks(1);
    GoodStatus(1);
    NearlyExpireStatus(1);
    ExpireStatus(1);
})
