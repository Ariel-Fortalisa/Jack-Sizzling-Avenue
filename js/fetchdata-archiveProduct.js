function formatDate(dateString) {
    var date = new Date(dateString); // Convert dateString to Date object
    var hours = date.getHours();
    var minutes = date.getMinutes();
    var ampm = hours >= 12 ? 'PM' : 'AM'; // Set AM/PM in uppercase
    hours = hours % 12;
    hours = hours ? hours : 12; // '0' hour should be '12'
    minutes = minutes < 10 ? '0' + minutes : minutes;
    var strTime = hours + ':' + minutes + ' ' + ampm;
    var formattedDate = (date.getMonth() + 1) + '-' + date.getDate() + '-' + date.getFullYear();
    return formattedDate + ' ' + strTime;
}


//onchange for picture of food
function readURL(input, id) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $(`#${id}`).attr('src', e.target.result).width(75).height(75);
        };

        reader.readAsDataURL(input.files[0]);
    } else {
        $(`#${id}`).attr('src', './upload/default.png').width(75).height(75);
    }
}


function producttable(page, search) {
    var src = search != undefined ? search : $("#search").val();
    $.ajax({
        url: "./ajax/fetch-archiveProduct.php",
        type: 'get',
        content: "json",
        data: {
            request: 'products',
            page: page,
            search: src
        },
        success: function (result) {
            var size = result.data[0];
            var ptable = $('#archiveProduct_tbl tbody');
            ptable.html('');
            productCount = (page * 10) - 9;

            if (result.data && result.data.length > 0) {
            for (product of result.data) {
                let sizeString = '';
                for (size of product.size) {
                    sizeString += `${size.size_name} | ${parseFloat(size.price).toFixed(2)} PHP<br>`;

                }

                let status = product.product_status === 'available' 
        ? `<span style="background-color: #76a004; color: #fff; padding: .3rem .5rem; border-radius: .3rem">Available</span>` 
        : `<span style="background-color: red; color: #fff; padding: .3rem .5rem; border-radius: .3rem">Unavailable</span>`;


                ptable.append(`
                    <tr>
                        <td> <p>${productCount}</p></td>
                        <td><span><img src="./upload/products/product_${product.id}.png" alt="product_image" style="width: 70px; height: 70px">${product.product_name}</span></td>
                        <td>${product.category_name}</td>
                        <td>${sizeString}</td>
                        <td>${status}</td>
                        <td>
                        
                           <button class="uil uil-history restore-btn" onclick="restoreProduct(${product.id}, '${product.product_name}');modalShow('restoreProductModal')"></button>
                        </td>
                    </tr>
                `);
                productCount++;
                // <button class="uil uil-eye view-btn" onclick="modalShow('viewProductModal')"></button> 
                //ilalagay to sa taas ng isang button sa td
            }
        }else{
            ptable.append(`
                <tr>
                 <td colspan="10" class="text-center" style="height: 200px; vertical-align: middle">No Result</td>
                </tr>
                `);
        }

        let totalData = result.data_count; // Example value
        let page_count = (totalData % 10 > 0) ? Math.floor(totalData / 10) + 1 : totalData / 10;
            paginate($("#Archiveproduct_pagination"), page_count, page, 'producttable');

        }
    });

}

$(document).ready(function () {
    producttable(1);

    $("#search").on('keyup', function () {
        producttable(1, $(this).val());
    });
});

function restoreProduct(id, product_name){
    $('#Restoreproduct_title').html(product_name)
    $('#archiveproduct_id').val(id)
}


function setProductdetail(id) {
    $.ajax({
        url: "./ajax/fetch-products.php",
        type: 'get',
        dataType: "json",
        data: {
            request: 'products',
            id: id,
        },
        success: function (result) {
            var product = result.data[0];
            var viewDetailTable = $('#viewDetailTable tbody');
            viewDetailTable.html('');  // Clear previous data in the table

            // Loop over each product
            for (product of result.data) {


                // Loop over each size in the product
                for (let sizes of product.size) {
                    $('#edit-product-sizingRow').html('');
                    addrow('edit-product-sizingRow', sizes);
                    let ing = '';
                    let serving_price = '';
                    
                    serving_price += `${sizes.size_name} | ${parseFloat(sizes.price).toFixed(2)} PHP<br>`;
                    $('#serving_price').html(serving_price);
                    

                    // Loop over ingredients and add each one to the respective variable
                    for (let ingredients of sizes.ingredients) {
                        ing += `${ingredients.stock_name} x ${ingredients.quantity}<br>`;
                        // ing_qty += `x ${ingredients.quantity}`;
                        $("#ingredients").html(ing);
                    }

                    // let size_name = sizes.size_name;  // Set size_name for each row
                    // let price = sizes.price;

                    // // Append a new row for each size
                    // viewDetailTable.append(`
                    //     <tr>
                    //         <td class="text-center">${size_name}</td>
                    //         <td class="text-center">PHP ${parseFloat(price).toFixed(2)}</td>
                    //         <td>${ing}</td>
                    //         <td>${ing_qty}</td>
                    //     </tr>
                    // `);
                }
            }
            let formattedDateTime = formatDate(product.date_added);
            let [datePart, timePart] = formattedDateTime.split(' ');  // Directly destructure into two parts
            
            // View info modal
            $("#viewProduct-img").attr("src", "./upload/products/product_" + product.id + ".png");
            $("#viewProduct-Name").html(product.product_name);
            $("#viewProduct-Category").html(product.category_name);
            $("#viewProduct-Date").html(datePart);  // Date only
            $("#viewProduct-Time").html(timePart);  // Time only
            $("#viewProduct-AddedBy").html(product.added_by);

            // Edit Product modal
            $("#editproduct_name").val(product.product_name);
            $("#editcategory").val(product.category);
            $("#product").val('product_' + product.id + '.png');

        }
    });
}
