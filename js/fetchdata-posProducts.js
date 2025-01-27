function displayProduct(ajaxData) {
    $.ajax({
        url: "./ajax/fetch-products.php",
        type: 'get',
        dataType: "json",
        data: {
            request: 'products',
            ...ajaxData
        },
        success: function (result) {
            var display = $('#product_display');
            display.html('');

            for (const product of result.data) {
                let sizeOptions = '';
                let addonsOption = ''; 
                let hasMultipleSizes = product.size.length > 1;
                let hasMultipleAddons = product.add_ons.length > 0;
                let defaultPrice = '';

                // Loop through sizes and create options
                product.size.forEach((size, index) => {
                    sizeOptions += `
                    <option 
                        value="${size.size_id}" 
                        data-size-name="${size.size_name}" 
                        data-price="${parseFloat(size.price).toFixed(2)}"
                        ${size.size_status === 'unavailable' && 'disabled'}>
                    ${size.size_name}
                    </option>`;
                    if (index === 0) defaultPrice = `₱ ${parseFloat(size.price).toFixed(2)}`;
                });

                  // Loop through addons and create options
                  product.add_ons.forEach((addon) => {
                    addonsOption += `<option value="${addon.addons_id}" data-addons-price="${addon.addons_price}" 
                                        data-addons-name="${addon.addons_name}">${addon.addons_name} ₱${addon.addons_price}</option>`;
                });

                // Set up addons dropdown HTML
                let sizeHTML = "";
                if (hasMultipleSizes) {
                    sizeHTML = `
                    <div class="select-menu" id="sizes" >
                        <label class="sizes title" for="size-select">Size:</label>
                        <select id="size-menu" class="select-menu select-btn select-size" ${product.product_status === 'unavailable' ? 'disabled' : ''}>
                            ${sizeOptions}
                        </select>
                    </div>`;
                } else {
                    sizeHTML = `<p class="sizes-title" style="margin-bottom: 60px"></p>`;
                }
             
                   // Set up addons dropdown HTML
                   let addonsHTML = '';
                   if (hasMultipleAddons) {
                       addonsHTML = `
                       <div class="select-menu add-ons-menu style="margin-top: 105px;">
                           <label for="add-ons" class="add-ons title select-placeholder" style="margin-top: -65px;font-size: 14px;">Add-ons:</label>
                           <select id="add-ons" class="select-btn select-menu add-on-btn select-add-ons" ${product.product_status === 'unavailable' ? 'disabled' : ''}>
                               <option value="0" data-addons-price="0" 
                                        data-addons-name="">None</option>
                               ${addonsOption}
                           </select>
                       </div>`;
                   }

                // Add single-size class if there is only one size
                let productClass = hasMultipleSizes ? "" : "single-size";
                
                display.append(`
                    <div class="product_list ${productClass}" style="position: relative;">
                        ${product.product_status === 'unavailable' ? '<img src="./img/unavailable.png" style="position: absolute; width: 90%; z-index: 2"/>' : ''}
                        
                        <div class="opacity-layer" style=" z-index: 1; ${product.product_status === 'unavailable' ? 'opacity: 0.5;' : ''}">
                            <img src="./upload/products/product_${product.id}.png" class="product_img" alt="">
                            <div class="name">Name: ${product.product_name}
                                <p class="price">Price: <span class="price-amount">${defaultPrice}</span></p>
                            </div>
                            
                            ${sizeHTML}

                            ${addonsHTML}
                            

                            <hr style="margin-top:">
                            <div class="add_button">
                                <button type="button" class="add add-to-cart" id="appendbtn_${product.id}"
                                data-product-id="${product.id}"
                                data-product-name="${product.product_name}"
                                data-size-name="${product.size[0].size_name}"
                                data-size-price="${product.size[0].price}"
                                data-size-id="${product.size[0].size_id}"
                                data-addons_id="0"
                                data-addons_name=""
                                data-addons_price="0"
                                ${product.product_status === 'unavailable' ? 'disabled' : ''}
                                >
                                
                                    <img src="img/add-to-cart.png" class="add_icon" alt="">
                                </button>
                                <p class="add_title">Add to Order</p>
                            </div>
                        </div>
                        

                        
                    </div>  
                `);
            }

            // Event listener for changing price based on selected size
            $(document).on('change', '#size-menu', function () {
                let selectedOption = $(this).find('option:selected');
                let newPrice = selectedOption.data('price');
                $(this).closest('.product_list').find('.price-amount').text(`₱ ${newPrice}`);
            });

            // Add empty divs to occupy space if data is less than 3
            if (result.data.length < 3 && result.data.length > 0) {
                let count = 3 - result.data.length;
                for (let i = 0; i < count; i++) {
                    display.append(`<div class=""></div>`);
                }
            }
        }
    });
}

$(document).on('change', '.select-size', function(){
    var price = $(this).find(':selected').data('price');
    var sizeName = $(this).find(':selected').data('size-name');
    var sizeid = $(this).val();
    
    $(this).closest('.product_list').find('.add-to-cart').data("size-price", price);
    $(this).closest('.product_list').find('.add-to-cart').data("size-name", sizeName);
    $(this).closest('.product_list').find('.add-to-cart').data("size-id", sizeid);
    // let selectedOption = $(this).find('option:selected');
    // let newSizeName = selectedOption.data('size-name');
    // let newPrice = selectedOption.data('price');
    // let newSizeId = selectedOption.val();

    // // Update displayed price
    // $(this).closest('.product_list').find('.price-amount').text(`PHP ${newPrice}`);

    // // Update add-to-cart button data attributes
    // let addToCartButton = $(this).closest('.product_list').find('.add-to-cart');
    // addToCartButton.data('size-name', newSizeName);
    // addToCartButton.data('size-price', `₱ ${newPrice}`);
    // addToCartButton.data('size-id', newSizeId);
});

// onchange Addons
$(document).on('change', '.select-add-ons', function(){
    var addons_price = $(this).find(':selected').data('addons-price');
    var addons_name = $(this).find(':selected').data('addons-name');
    var addons_id = $(this).val();
    
    $(this).closest('.product_list').find('.add-to-cart').data("addons_price", addons_price);
    $(this).closest('.product_list').find('.add-to-cart').data("addons_name", addons_name);
    $(this).closest('.product_list').find('.add-to-cart').data("addons_id", addons_id);
});

let discountValue = 0;

function applyDiscount() {
    const name = $('#Fullname').val()
    const idNumber = $('#id_number').val()
    const discountSelect = document.getElementById("discount_type")
    const discountPercentage = parseInt(discountSelect.value)
    const discountText = $("#discount_type option:selected").text()

    // let CustomerDetailsHTML = '';
    // let ifNoneHTML = '';

    // CustomerDetailsHTML += `
    //        <div id="customer_detailsPreview">
    //                 <div style="display: flex; justify-content: space-between;">
    //                     <div style="font-size: .9rem;">
    //                         Customer Name:
    //                     </div>
    //                     <div style="font-size: .9rem;">
    //                         Time: <?= $time_part ?>
    //                     </div>
    //                 </div>
    //                 <div style="font-size: .9rem;">
    //                     Customer ID:
    //                 </div>
    //             </div>
    // `;

    // ifNoneHTML += 

    discountValue = discountPercentage;
    calculateTotalPrice();

    $('#hidden_fullname').val(name);
    $("#hidden_id_number").val(idNumber);
    $("#hidden_discount_value").val(discountValue);
    $("#hidden_discount_text").val(discountText);

    modalHide('discountModal');
}

// Calculate the discount
function calculateDiscountedTotal(total) {
    let discountAmount = (total * discountValue) / 100;
    let totalAfterDiscount = total - discountAmount;
    $('#inputDiscount').val(discountAmount);
    return totalAfterDiscount;


}


// calculation of total price
function calculateTotalPrice() {
    let total = 0;
    $("#table_append tbody tr").each(function() {
       total += parseFloat($(this).find('.hidden_subtotal').val());

    });

    let totalWithDiscount = calculateDiscountedTotal(total);

    // Update the total price display
    $("#total_amount").text(`₱ ${totalWithDiscount.toFixed(2)}`);
    $("#inputTotal_Amount").val(totalWithDiscount.toFixed(2));

    // Recalculate VAT with the discounted total
    calculateVat(totalWithDiscount);

}

// calculation of VAT
function calculateVat(totalAmount){
    const VAT_RATE = 0.12;
    let vatableSales = (totalAmount / (1 + VAT_RATE)).toFixed(2);
    let vatAmount = (totalAmount - vatableSales).toFixed(2);
    
    $('#vat_sales').text('₱'+ vatableSales);
    $('#vat_amount').text('₱'+ vatAmount);
    $('#inputVat_sales').val(vatableSales);
    $('#inputVat_amount').val(vatAmount);

  }

 // calculation of change
function calculateChange() {
    let amountTendered = parseFloat($(".pay").val()) || 0;
    let totalAmount = parseFloat($("#total_amount").text().replace('₱', '')) || 0;
    let change = amountTendered - totalAmount;
    
    // if the change is negative, display 0
    change = change > 0 ? change : 0;

    // display change
    $("#change").text(`₱${change.toFixed(2)}`);
    $("#inputChange").val(change)
    $("#inputAmounttendered").attr("min", totalAmount.toFixed(2));
}

$(document).on('input', '.pay', calculateChange);

// Check if the cart is empty
function updateCartVisibility() {

    // var pay = $('#inputAmounttendered').val();  

    // Check if the cart has no items
    if ($("#table_append tbody tr").length === 0) {
        // Show "No results" message
        $("#noResults").show();
        // Hide discount and cart table
        $("#discountSection").hide();
        $("#cartTable").hide();

        // Don't submit and disable checkout button
        // $("#check_out").attr("type", "button");
    } else {
        // Hide "No results" message
        $("#noResults").hide();
        // Show discount and cart table
        $("#discountSection").show();
        $("#cartTable").show();

        
    }
}
// ORDER PREVIEW START HERE
//display cartItems in Modal
function displayCartItems() {
    let cartItemsHtml = '';

    // Loop through all items in the cart table (the cart table should be populated earlier)
    $("#table_append tbody tr").each(function() {
        var productName = $(this).find('input[name="product_name[]"]').val();
        var sizeName = $(this).find('input[name="size_name[]"]').val();
        var addonsName = $(this).find('input[name="addons_name[]"]').val();
        var quantity = $(this).find('.input_qty').val();
        var subtotal = $(this).find('.hidden_subtotal').val();

        cartItemsHtml += `
            <div style="display: flex; justify-content: space-between; gap: 1rem; align-items: center">
                <div style="font-size: .9rem">
                    ${productName} ${sizeName} ${addonsName ? `w/ ${addonsName}` : ''} (Qty: ${quantity})
                </div>
                <div style="font-size: .9rem; font-weight: 600;">
                    ₱${parseFloat(subtotal).toFixed(2)}
                </div>
            </div>
        `;
    });

    // Update the modal with cart items
    $('#order-items').html(cartItemsHtml);
}

//
function displaySummary(){
    let summaryHTML = '';
    let cashHTML = '';

    $("#cart_footer").each(function() {
        //SUMMARY
        var discount = $(this).find('input[name="inputDiscountVal"]').val();
        var vatAmount =  $(this).find('input[name="inputVat_amount"]').val();
        var vatSales =  $(this).find('input[name="inputvat_sales"]').val();

        //CASH related
        var TotalAmount = $(this).find('input[name="inputTotal_Amount"]').val();
        var amount_tendered = $(this).find('input[name="inputAmounttendered"]').val();
        var change = $(this).find('input[name="inputChange"]').val();


        summaryHTML +=`
            <div style="display: flex; justify-content: space-between;">
                    <div style="font-size: .9rem; font-weight: 500;">
                        Discount:
                    </div>

                    <div style="font-size: .9rem; font-weight: 600;">
                        -₱${parseFloat(discount).toFixed(2)}
                    </div>
                </div>

                <div style="display: flex; justify-content: space-between;">
                    <div style="font-size: .9rem; font-weight: 500;">
                        VAT Amount:
                    </div>

                    <div style="font-size: .9rem; font-weight: 600;">
                      ₱${parseFloat(vatAmount).toFixed(2)}
                    </div>
                </div>

                <div style="display: flex; justify-content: space-between;">
                    <div style="font-size: .9rem; font-weight: 500;">
                        VAT Sales:
                    </div>

                    <div style="font-size: .9rem; font-weight: 600;">
                       ₱${parseFloat(vatSales).toFixed(2)}
                    </div>
                </div>
        `;

        cashHTML +=`
              <div style="display: flex; justify-content: space-between; align-items: center">
                <div style="font-size: 1.3rem; font-weight: 600;">
                    Total:
                </div>

                <div style="font-size: 1.3rem; font-weight: 600;">
                    ₱${parseFloat(TotalAmount).toFixed(2)}
                </div>
            </div>

            <div style="display: flex; justify-content: space-between;">
                <div style="font-size: .9rem; font-weight: 500;">
                    Amount Tendered:
                </div>

                <div style="font-size: .9rem; font-weight: 600;">
                   ₱${parseFloat(amount_tendered).toFixed(2)}
                </div>
            </div>

            <div style="display: flex; justify-content: space-between;">
                <div style="font-size: .9rem; font-weight: 500;">
                    Change:
                </div>

                <div style="font-size: .9rem; font-weight: 600;">
                    ₱${parseFloat(change).toFixed(2)}
                </div>
            </div>
        `;

    });

    // Update the modal with summary
    $('#summary').html(summaryHTML);
    $('#cash').html(cashHTML);

}

// ORDER PREVIEW END HERE



$("#pos-form").on("submit", function(evt){
    displayCartItems();
    displaySummary();
    var checkout = $("#check_out").val();
    var totalValue = parseFloat($("#inputTotal_Amount").val());
    
    //prevent submit when checkout is not confirmed in modal and when totalValue is 0
    if(checkout !== 'confirmed'){
        evt.preventDefault();
        if(totalValue > 0){
            modalShow('checkoutModal');
            
        }
        
    }

    
});

$("#checkoutProceed").click(function(){
    $("#check_out").val("confirmed");
    $("#pos-form").submit();
});


// Trigger the function when the payment amount changes
$(document).on('input', '#inputAmounttendered', function(){
    updateCartVisibility();
});

//add to cart
$(document).on("click", ".add-to-cart", function () {
    var productId = $(this).data('product-id');
    var productName = $(this).data('product-name');
    var price = $(this).data('size-price');
    var sizeName = $(this).data('size-name');
    var sizeid = $(this).data('size-id');
    var addonsId = $(this).data('addons_id');
    var addonsName = $(this).data('addons_name');
    var formattedName = addonsName ? `w/ ${addonsName}` : '';
    var addonsPrice = $(this).data('addons_price');
      // Capture add-on data
    //   var addonId = $(this).data('addon-id') || '';
    //   var addonName = $(this).data('addon-name') ? 'w/ ' + $(this).data('addon-name') : '';
    //   var addonPrice = $(this).data('addon-price') || 0;
      var totalPrice = parseFloat(price) + parseFloat(addonsPrice);
      


    // Check if the product already exists in the cart
    var existingRow = $("#table_append tbody").find(`tr[data-product-id='${productId}'][data-size-id='${sizeid}'][data-addon-id='${addonsId}']`).length > 0; 
    
    if (existingRow) {
        // If the product is already in the cart, increment the quantity
        var row = $("#table_append tbody").find(`tr[data-product-id='${productId}'][data-size-id='${sizeid}'][data-addon-id='${addonsId}']`);
        var qtyInput = row.find('.input_qty');
        var subtotalInput = row.find('.hidden_subtotal');
        var subtotalText = row.find('.subtotal');
        var qtyVal = parseInt(qtyInput.val());
        var newqty = qtyVal + 1;
        qtyInput.val(newqty);
        subtotalInput.val(newqty * totalPrice);
        subtotalText.html(`₱ ${parseFloat(newqty * totalPrice).toFixed(2)}`);
        calculateTotalPrice();

    } else {
        // If the product is not in the cart, append a new row and hidden fields
        $("#table_append tbody").append(`
            <tr data-product-id="${productId}" data-size-id="${sizeid}" data-addon-id="${addonsId}">
                <td>
                    <p>${productName} / ${sizeName} ${formattedName}</p>
                    <input type="hidden" name="product_name[]" value="${productName}">
                    <input type="hidden" name="size_name[]" value="${sizeName}">
                    <input type="hidden" name="price[]" class="hidden_price" value="${price}">
                    <input type="hidden" name="product_ids[]" value="${productId}">
                    <input type="hidden" name="size_ids[]" value="${sizeid}">
                    <input type="hidden" name="quantities[]" class="hidden_qty" value="1">
                    
                    <input type="hidden" name="addons_id[]" class="hidden_addons_id" value="${addonsId}">
                    <input type="hidden" name="addons_name[]" class="hidden_addons_name" value="${addonsName}">
                    <input type="hidden" name="addons_price[]" class="hidden_addons_price" value="${addonsPrice}">

                    <input type="hidden" name="subtotal[]" class="hidden_subtotal" value="${price + addonsPrice}">
                </td>
                <td>
                    <div class="quantity_container">
                        <div class="quantity">
                            <button type="button" class="decrement"><i class="uil uil-minus"></i></button>
                            <input type="number" class="input_qty" name="qty" value="1" required>
                            <button type="button" class="increment"><i class="uil uil-plus"></i></button>
                        </div>
                    </div>
                </td>
                <td><span class="subtotal">₱ ${parseFloat(totalPrice).toFixed(2)}</span></td>
                <td><button class="uil uil-trash-alt remove-row"></button></td>
            </tr>
        `);
        
    }
    calculateTotalPrice();
    updateCartVisibility();
    
});



function updateHiddenFields(row, newQty) {
    row.find('.hidden_qty').val(newQty);
    const price = parseFloat(row.find('.hidden_price').val());
    const addonsPrice = parseFloat(row.find('.hidden_addons_price').val());
    const subtotal = parseInt(newQty) * (price + addonsPrice);
    row.find('.hidden_subtotal').val(subtotal);
    row.find('.subtotal').html(`₱ ${subtotal.toFixed(2)}`); 

}


$("#search").on('input', function () {
    var search = $(this).val();
    displayProduct({ search: search });
});


$(document).on('input', '.input_qty', function () {
    var qty = parseInt($(this).val()); 
    var row = $(this).closest('tr');
    var price = parseFloat(row.find('.hidden_price').val());
    var addonsPrice = parseFloat(row.find('.hidden_addons_price').val());

    if (isNaN(qty) || qty < 1) {
        qty = 1;
        $(this).val(qty); 
    }
    
    // Update the hidden qty field
    row.find('.hidden_qty').val(qty);

    // Calculate the new subtotal
    var subtotal = qty * (price + addonsPrice);

    // Update the hidden subtotal field
    row.find('.hidden_subtotal').val(subtotal);

    // Update the displayed subtotal in the row
    row.find('.subtotal').text(`₱ ${subtotal.toFixed(2)}`);

    // Recalculate the total price after updating the quantity
    calculateTotalPrice();
    calculateChange();
});

// Increment and Decrement functionality
$(document).on('click', '.increment', function () {
    let qtyInput = $(this).siblings('.input_qty');
    let currentValue = parseInt(qtyInput.val());
    qtyInput.val(currentValue + 1);
    updateHiddenFields($(this).closest('tr'), currentValue + 1);
    calculateTotalPrice();
    calculateChange();

});

$(document).on('click', '.decrement', function () {
    let qtyInput = $(this).siblings('.input_qty');
    let currentValue = parseInt(qtyInput.val());
    if (currentValue > 1) {
        qtyInput.val(currentValue - 1);
        updateHiddenFields($(this).closest('tr'), currentValue - 1);
        calculateTotalPrice();
        calculateChange();
    }
});

// Remove row when trash icon is clicked
$(document).on("click", ".remove-row", function () {
    $(this).closest('tr').remove();
    calculateTotalPrice()
    updateCartVisibility();
    calculateChange();
});

$(".category-btn").click(function () {
    $(".category-btn").removeClass("active");
    $(this).addClass("active");
});

$(document).ready(function () {
    displayProduct();
    calculateTotalPrice();
    updateCartVisibility();

});

