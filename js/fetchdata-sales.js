function displaySales(page, search) {
   var src = search || $("#search").val();
    $.ajax({
        url: "./ajax/fetch-sales.php",
        type: 'get',
        dataType: "json",
        data: {
            request: 'sales',
            page: page,
            search: src,
            order_by: 'date_created',
            order_method: 'DESC'
        },
        success: function (result) {
            var table = $('#sales-table tbody');
            table.html('');
            saleCount = (page * 10) - 9;

            if (result.data && result.data.length > 0) {

                for (let sale of result.data) {

                    let saleDate = new Date(sale.date);
                    let formattedDate = formatDate(saleDate);
                    let formattedTime = formatTime(saleDate);

                    let total_amount = parseFloat(sale.total_amount).toFixed(2);
                    let amount_tendered = parseFloat(sale.amount_tendered).toFixed(2);
                    let change = parseFloat(sale.change_amount).toFixed(2);



                    table.append(`
                        <tr>
                            <td style="font-weight:bold">${saleCount}</td>
                            <td>${sale.id}</td>
                            <td>${total_amount}</td>
                            <td>${amount_tendered}</td>
                            <td>${sale.vat_amount}</td>
                            <td>${sale.vat_sales}</td>
                            <td>${change}</td>
                            <td>${sale.discount}</td>
                            <td>${formattedDate} ${formattedTime}</td>
                            <td><button class="uil uil-eye" onclick="setItems(${sale.id});modalShow('viewDetailsModal')">View</button></td>
                        </tr>
                    `);
                    saleCount++;

                    //cards
                    let overall_total = parseFloat(result.overall_total).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                    let cost = parseFloat(result.cost).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                    let Grand_topselling = parseFloat(result.top_sale).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                    
                    $('#total_Sales').html('₱'+overall_total);
                    $('#total_transaction').html(result.data_count);
                    $('#total_cost').html('₱'+cost);
                    $('#top_Selling').html('₱'+Grand_topselling);



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
            paginate($("#sales_pagination"), page_count, page, 'displaySales');


        }
    });

}

function formatDate(date) {
    const month = date.toLocaleString('en-US', { month: 'short' });
    const day = date.getDate();
    const year = date.getFullYear();
    return `${month} ${day}, ${year}`;
}

function formatTime(date) {
    let hours = date.getHours() % 12 || 12;
    let minutes = date.getMinutes().toString().padStart(2, '0');
    let ampm = date.getHours() >= 12 ? 'PM' : 'AM';
    return `${hours}:${minutes} ${ampm}`;
}

function setItems(id) {
    $.ajax({
        url: "./ajax/fetch-sales.php",
        type: 'get',
        dataType: "json",
        data: {
            request: 'sales',
            id: id
        },
        success: function (result) {
            var items = result.data[0];
            var tr_itemsModal = $('#sales_items tbody');
            tr_itemsModal.html(''); // Clear the previous items in modal
            var itemsCount = 1;

            // Loop through each item in the transaction and display them
            for (let tr of items.transac_items) {
                let subtotal = parseFloat(tr.subtotal).toFixed(2);
                tr_itemsModal.append(`
                  <tr>
                    <td style="font-weight:bold">${itemsCount}</td>
                    <td>${tr.product_name}</td>
                    <td>${tr.qty}</td>
                    <td>${subtotal}</td>
                </tr>`);
                itemsCount++;
            }

            // Check if there is a discount and display customer details accordingly
            if (items.discount && items.discount > 0) { 
                // Show customer details
                $('#cs_name').html('Customer Name: '+items.customer_name);
                $('#cs_id').html('Customer ID: ' + items.customer_id);
                $('#dc_type').html('Discount: ' + items.discount + '% ' + items.discount_type);
            } else {
                // Hide customer details if there's no discount
                $('#cs_name').html('');
                $('#cs_id').html('');
                $('#dc_type').html('');
            }

            // Always show reference number and total regardless of discount
            $('#reference_number').html('Reference# ' + items.id);
            $('#total').html('Total: ₱' + items.total_amount);
            $("#receiptPrintBtn").attr("href", `./print-Reciept.php?transaction=${items.id}&rep=1`);
        }
    });
}



$(document).ready(function () {
   const currentMonth = new Date().getMonth() + 1; 
   const currentYear = new Date().getFullYear();
   
   $("#month").val(currentMonth);
   $("#year").val(currentYear);
    displaySales(1);
    generateChart();
    generateChartPrd();

})

$("#search").on('keyup', function () {
    displaySales(1, $(this).val());
});

//top and least chart
function generateChartPrd(){
    const sort = $('#sort').val();
    $.ajax({
        url: "./ajax/ProductSaleChart.php",
        type: 'get',
        dataType: "json",
        data: {
            sort: sort
        },
        success: function (result) {
            const chartData = result.data;
            let name = [];
            let total = [];
            chartData.map((item) => {
                name.push(item.product_name)
            })

            chartData.map((item) => {
                total.push(item.total)
            })
            
                // Destroy the existing chart para ma avoid yung conflict
                if (window.productChartInstance) {
                    window.productChartInstance.destroy();
                }


            var sellingChart = document.getElementById('sellingChart').getContext('2d');
            window.productChartInstance = new Chart(sellingChart, {
                type: 'horizontalBar',  
                data: {
                    labels: name,
                    datasets: [{
                        label: "Total Sales",
                        backgroundColor: '#e0d4cc',
                        borderColor: '#91521f',
                        borderWidth: 1,
                        data: total,
                    }]
                },
                options: {
                    responsive: true, 
                    maintainAspectRatio: false, 
                    layout: {
                        padding: 0,
                    },
                    legend: {
                            display: false,
                        },
                    scales: {
                        x: {
                            beginAtZero: true, 
                        },
                        y: {
                            beginAtZero: true,
                        }
                    }
                }
            });
            
        }
    });
    window.productChartInstance.update();
}



//chart for daily etc. basis
function generateChart() {
    // Get selected values from the dropdowns
    const basis = $('#basis').val();
    const month = $('#month').val();
    const year = $('#year').val();

    $.ajax({
        url: "./ajax/SalesChart.php",
        type: 'get',
        dataType: "json",
        data: {
            basis: basis,
            month: month,
            year: year
        },
        success: function (result) {
            const chartData = result.data[0];
            const dateArray = chartData.date_array;
            const totalArray = chartData.total_array;

            const totalSales = totalArray.reduce((sum, value) => sum + parseFloat(value), 0).toFixed(2);

            let total_sales_html = parseFloat(totalSales).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });

            // Destroy the existing chart para ma avoid yung conflict
            if (window.salesChartInstance) {
                window.salesChartInstance.destroy();
            }

            // Set up the chart with the parsed data
            const ctx = document.getElementById('salesChart').getContext('2d');
            window.salesChartInstance = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: dateArray,
                    datasets: [{
                        label: 'Total Sales',
                        data: totalArray,
                        backgroundColor: 'lightblue',
                        borderColor: 'royalblue',
                        borderWidth: 1,
                    }]
                },
                options: {
                    responsive: true,
                    layout: {
                        padding: 0,
                    },
                    legend: {
                        position: 'bottom',
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            min: 0,
                        }
                    }
                }
            });

            let perBasis = $("#basis option:selected").text();
            let perMonth = $("#month option:selected").text();
            let perYear = $('#year option:selected').text();
        
            // Show perMonth and perYear only when they are applicable
            if (basis === "Monthly") {
                $('#header-sales-chart').html(`(₱${total_sales_html}) ${perBasis} Sales (${perYear})`);
            } else if (basis === "Yearly") {
                $('#header-sales-chart').html(`(₱${total_sales_html}) ${perBasis} Sales`);
            } else {
                $('#header-sales-chart').html(`(₱${total_sales_html}) ${perBasis} Sales (${perMonth} ${perYear})`);
            }
        },
        
    });


}

$("#basis").change(function() {
    const type = $(this).val();
    if (type === "Monthly") {
        $("#month").prop("disabled", true);
        $("#year").prop("disabled", false);
    } else if (type === "Yearly") {
        $("#month").prop("disabled", true);
        $("#year").prop("disabled", true);
    } else {
        $("#month").prop("disabled", false);
        $("#year").prop("disabled", false);
    }
    generateChart(); 
});