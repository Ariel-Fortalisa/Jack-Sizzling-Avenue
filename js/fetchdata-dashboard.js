function formatDate(dateString) {
    const date = new Date(dateString);
    const month = String(date.getMonth() + 1).padStart(2, '0');
    const day = String(date.getDate()).padStart(2, '0');
    const year = date.getFullYear();
    // const hours = date.getHours();
    // const minutes = date.getMinutes();
    // const meridiem = hours >= 12 ? 'PM' : 'AM';
    return `${month}-${day}-${year}`;
}

function displaydashboard(page) {
    $.ajax({
        url: "./ajax/fetch-dashboard.php",
        type: 'get',
        content: "json",
        data: {
            request: 'dashboard',
            page: page,
        },
        success: function (result) {
            var table = $('#recent_transaction tbody');
            table.html('');
            count = 1;
            let sales_today = parseFloat(result.today_sale).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
            let month_sales = parseFloat(result.month_sale).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });

               $("#product_list").html(result.prd_count);
               $("#month_sale").html("₱" + month_sales);
               $("#sales_today").html("₱" + sales_today);
               $("#today_transaction").html(result.total_transaction);

            if (result.data && result.data.length > 0) {

                for (let transac of result.data) {

                    let date = formatDate(transac.date)
                    let change = parseFloat(transac.change).toFixed(2)
                    let total_amount = parseFloat(transac.total_amount).toFixed(2)

                    table.append(`
                        <tr>
                            <td style="font-weight: bold;">${count}</td>
                            <td style="text-align: center;">${transac.tr_id}</td>
                            <td style="text-align: center;">${date}</td>
                            <td style="text-align: center;">₱${total_amount}</td>
                            <td style="text-align: center;">₱ ${change}</td>
                        </tr>
                    `);

                    count++;
                }

            }else{
                table.append(`
                    <tr>
                        <td colspan="5" style="height: 200px; vertical-align: middle; text-align: center">No Today Transaction</td>
                    </tr>
                `);
            }
        }
    })
}

function generateChart7days() {
    $.ajax({
        url: "./ajax/salelast7days.php", 
        type: 'GET',
        dataType: 'json',
        success: function (result) {

            const dates = result.dates; 
            const sales = result.total_sales && Array.isArray(result.total_sales) ? result.total_sales : new Array(dates.length).fill(0);   
            
            const chartData = {
                labels: dates,  
                datasets: [{
                    label: 'Sales in the Last 7 Days',  
                    data: sales,
                    backgroundColor: 'lightblue',
                    borderColor: 'royalblue',
                    borderWidth: 1,
                }]
            };

            const chartOptions = {
                responsive: true,
                scales: {
                    y: {
                        min: 0,
                        beginAtZero: true  
                    }
                }
            };

            const ctx = document.getElementById('graph').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: chartData,
                options: chartOptions
            });
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
            stock_status: 2
        },
        success: function (result) {
            var table = $('#low_stock_tbl tbody');
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
            paginate($("#stocks_ingredients_lowstock_status_pagination"), page_count, page, 'LowStock');
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
            stock_status: 3
        },
        success: function (result) {
            var table = $('#out_of_stock_tbl tbody');
            table.html(''); 
            var count = (page * 10) - 9;

            if (result.data && result.data.length > 0) {
                // Loop through the filtered items
                for (let item of result.data) {
                    let quantity = (item.qty === null) ? `0 ${item.unit}` : `${item.qty} ${item.unit}`;

                    table.append(`
                        <tr>
                            <td class="font-weight-bold">${count}</td>
                            <td>${item.item_name}</td>
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
            paginate($("#stocks_ingredients_out_of_stock_status_pagination"), page_count, page, 'OutofStocks');
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
            var table = $('#nearly_expiration_tbl tbody');
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


                        // Append each row to the table
                        table.append(`
                            <tr>
                                <td class="text-center">${batch.batch_id}</td>
                                <td style="text-align: left;">${batch.stock_name}</td>
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
            paginate($("#nearly_pagination"), page_count, page, 'NearlyExpireStatus');
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
            var table = $('#expired_tbl tbody');
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

                        // Append each row to the table
                        table.append(`
                            <tr>
                                <td class="text-center">${batch.batch_id}</td>
                                <td style="text-align: left;">${batch.stock_name}</td>
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
            paginate($("#Expired_pagination"), page_count, page, 'ExpireStatus');
        }
    });
}




$(document).ready(function () {
    displaydashboard(1)
    generateChart7days();
    LowStock(1)
    OutofStocks(1)
    NearlyExpireStatus(1)
    ExpireStatus(1)
});