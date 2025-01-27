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
        url: "./ajax/fetch-products.php",
        type: 'get',
        content: "json",
        data: {
            request: 'products',
            page: page,
            search: src
        },
        success: function (result) {
            var size = result.data[0];
            var ptable = $('#productTable tbody');
            ptable.html('');
            productCount = (page * 10) - 9;

            if (result.data && result.data.length > 0) {
            for (product of result.data) {
                let sizeString = '';
                for (size of product.size) {
                    sizeString += `
                        <span style="${size.size_status === 'unavailable' ? 'color: gray': ''}">${size.size_name} | ${parseFloat(size.price).toFixed(2)} PHP</span>
                        <br>
                    `;

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
                            <button class="uil uil-eye view-btn" onclick="setProductdetail(${product.id});modalShow('viewProductModal')"></button>
                            <button class="uil uil-edit edit-btn" onclick="setProductdetail(${product.id});modalShow('editProductsModal')"></button>
                            <button class="uil uil-archive archive-btn" onclick="ArchiveProduct(${product.id},'${product.product_name}', '${product.archive_status}');modalShow('archiveProductModal')"></button>
                        </td>
                    </tr>
                `);
                productCount++;
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
            paginate($("#product_pagination"), page_count, page, 'producttable');

        }
    });

}

$(document).ready(function () {
    producttable(1);

    $("#search").on('keyup', function () {
        producttable(1, $(this).val());
    });
});

// function setEditProduct(id, name, category){
//     $("#editproduct_name").val(name);
//     $("#editcategory_dropdown").val(category);
//     $("#product").val('product_'+id +'.png');
// }


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
                    addrow('edit-product', sizes);
                    let ing = '';
                    let serving_price = '';

                    $("#editsize_id").val(sizes.size_id);
                    
                    serving_price += `${sizes.size_name} | ${parseFloat(sizes.price).toFixed(2)} PHP<br>`;
                    $('#serving_price').html(serving_price);
                    

                    // Loop over ingredients and add each one to the respective variable
                    for (let ingredients of sizes.ingredients) {
                        ing += `${ingredients.stock_name} x ${ingredients.quantity}<br>`;
                        // ing_qty += `x ${ingredients.quantity}`;
                        $("#ingredients").html(ing);
                        $("#editingredients_id").val(ingredients.ingredients)
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
                
            // Format the date and time separately
            let formattedDateTime = formatDate(product.date_added);
            let datePart = formattedDateTime.split(' ')[0]; // Extract the date part
            let timePart = formattedDateTime.split(' ')[1];
            let AMPM = formattedDateTime.split(' ')[2];

            //view info modal
            $("#viewProduct-img").attr("src", "./upload/products/product_"+product.id+".png");
            $("#viewProduct-Name").html(product.product_name);
            $("#viewProduct-Category").html(product.category_name);
            $("#viewProduct-Date").html('Date Added: '+datePart);
            $("#viewProduct-Time").html('Time: '+timePart + ' ' + AMPM);
            $("#viewProduct-AddedBy").html('Added By: '+product.added_by);

            //Edit Product modal
            // $('#editImage').val('product_'+product.id+'.png');
            $('#editProductImage').attr('src', './upload/products/product_'+product.id+'.png');
            $("#editproduct_id").val(product.id);
            $("#editproduct_name").val(product.product_name);
            $("#editProduct-category").val(product.category_id);
            $("#currentImage").val('product_' + product.id + '.png');
            $("#editProduct-addons-field").html('')
            for(addon of product.add_ons){
                addons('editProduct', addon.addons_name, addon.addons_price, addon.addons_id);
            }
            toggleAddOnsButton('editProduct');

        }
    }
    });
}

function ArchiveProduct(ArchiveProductID, Archive_name, archiveStatus){
            //archive product modal
            $('#ArchiveProduct_title').html(Archive_name);
            $('#archiveProduct-id').val(ArchiveProductID);
            $('#archiveProduct-status').val(archiveStatus);
}



async function addrow(container, size){
    
    const sizeName = size !== undefined ? size.size_name : '';
    const price = size !== undefined ? size.price : 0;
    const ingredientsArray = size !== undefined ? size.ingredients : [];     //array
    

    const getStocks = () => {
        return new Promise(function(resolve, reject){
            $.ajax({
                url: "./ajax/fetch-ingredients.php",
                type: 'get',
                content: "json",
                data: {
                    request: 'items'
                },
                success: function (result) {
                    resolve(result.data);
                },
                error: function(err){
                    reject(err);
                }
            })
        })
    }

    let ingredienstList = await getStocks();
    let ingredientsHTML = '';

    ingredienstList.map((ing) => {
        const foundItem = ingredientsArray.find(item => item.stock_id === String(ing.id));
        
        const qty = foundItem !== undefined ? foundItem.quantity : 0;
        ingredientsHTML += `
            <div class="materialRow items"> <!-- May row class dati dito -->
                <span>${ing.item_name}</span>
                <div>
                    <input 
                        type="number" 
                        class="ingredient-quantity" 
                        name="stockQty_${ing.id}[]" 
                        placeholder="Qty" 
                        value="${qty}" 
                        min="0">
                    <input type="hidden" name="stock_${ing.id}[]" value="${ing.id}">
                </div>
            </div>
        `;
    })
    
//     <?php
//     $stockRes = $conn->query("SELECT * FROM `stocks` WHERE archive_status = 0 ORDER BY stock_name ASC;");

//     while ($row = $stockRes->fetch_assoc()) {
//         echo '
//             <div class="materialRow items"> <!-- May row class dati dito -->
//                 <span>' . $row["stock_name"] . '</span>
//                 <div>
//                     <input 
//                         type="number" 
//                         class="ingredient-quantity" 
//                         name="stockQty_' . $row["stock_id"] . '[]" 
//                         placeholder="Qty" 
//                         value="${sizeArray.some(item => item.size_id === String('."'".$row["stock_id"]."'".'))} ? " 
//                         min="0">
//                     <input type="hidden" name="stock_' . $row["stock_id"] . '[]" value="' . $row["stock_id"] . '">
//                 </div>
//             </div>
//         ';
//     }

// ?>
    
    const NewRow = `
        <div class="row">
            <div style="display: flex; gap: .7rem; padding-top: .5rem">
                <div style="display: flex; flex-direction: column; width: 50%">
                    <span>Size Name <span style="color: c21807; font-weight: 600">*</span></span>
                    <div class="form-group">
                        <input name="sizeProduct-name[]" class="form-field" style="border-radius: 6px;" type="text" placeholder="Enter Size Name" value="${sizeName}" required>
                    </div>
                </div>

                <div style="display: flex; flex-direction: column;">
                    <span>Ingredients <span style="color: c21807; font-weight: 600">*</span></span>
                    <div class="ingredients">
                        <button type="button" class="ingredients-btn" id="dropdown-button">-Select Ingredients-</button>
                        <div class="dropdown-content" id="dropdown-content">
                            ${ingredientsHTML}
                        </div>
                    </div>  
                </div>
            </div>

            <div style="display: flex; gap: .2rem; justify-content: space-between; align-items: end; padding-top: .5rem">
                <div style="display: flex; flex-direction: column; width: 50%">
                    <span>Price <span style="color: c21807; font-weight: 600">*</span></span>
                    <div class="form-group">
                        <span>PHP</span>
                        <input name="productPrice[]" class="form-field" type="number" placeholder="0.00" value="${price}">
                    </div>
                </div>

                <div style="display: flex; gap: 1rem; width: 15.5rem; justify-content: center">
                    <div class="remove" style="align-items: center; justify-content: center">
                        <button type="button" class="remove-btn" onclick="removeRow('${container}', this)">
                            <i class="uil uil-times-circle"></i>
                        </button>
                    </div>

                    <div class="add-new" style="align-items: center; justify-content: center">
                        <button type="button" onclick="addrow('${container}')" class="add-new-btn">
                            <i class="uil uil-plus-circle"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    `;

    $(`#${container}-sizingRow`).append(NewRow);

}

// Function to remove the current row
function removeRow(type, button) {

if($(`#${type}-sizingRow .row`).length > 1){
    const row = $(button).closest('.row');
    row.remove();
}

}