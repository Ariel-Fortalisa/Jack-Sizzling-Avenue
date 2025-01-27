<?php
session_start();
date_default_timezone_set('Asia/Manila');
include("./includes/connection.php");

include('./includes/userValidate.php');
userRestrict(3);

include ("./includes/log_check.php");
include ("modals.php"); 

$firstname = $_SESSION["first_name"];
$lastname = $_SESSION["last_name"];
$user_role = $_SESSION["user_role"];
$username = $_SESSION["username"];
$user_id = $_SESSION["user_id"];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- sweetalert -->
    <script src="./js/sweetalert.min.js"></script>
    
    <!-- jquery -->
    <script src="./js/jquery.min.js"></script>

    <!-- Unicons -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">
    
    <!-- My CSS -->
    <link rel="stylesheet" href="style.css">

    <!-- Page Transition -->
    <link rel="stylesheet" href="page_transition.css">


    <title>Inventory</title>
</head>
<style>
   #content main {
      animation: transitionIn-Y-over 1s;
   }
</style>
<body>
<?php 
$pageLocation = "products.php";
include ("sidebar.php"); 
?>
<!-- CONTENT -->
<section id="content">
		<!-- NAVBAR -->
		<nav>
            <i class="uil uil-bars"></i>
            <a href="#" class="nav-link">Jack Sizzling Avenue</a>

            <a href="account.php" class="profile">
            <img src="./upload/user_dp/user_<?=$user_id?>.png">
            </a>
        </nav>
		<!-- NAVBAR -->




    <!-- MAIN -->
    <main style="overflow: auto; padding: 10px 24px;">
        <div class="head-title">
                <div class="left">
                    <h2>
                    <i class="uil uil-box"></i>
                    Inventory</h2>
                </div>
                        
                <div class="search-box">
                        <button class="btn-search"><i class="uil uil-search"></i></button>
                        <input id="search" type="text" class="input-search" placeholder="Search For...">
                    </div>
            </div>

                <div class="inventory-buttons">
                    <div><button role="button" id="btn1" onclick="location.href='ingredients.php';setActive(this);">Ingredients</button></div>
                    <div><button class="active" role="button" id="btn2" onclick="location.href='products.php';setActive(this);">Products</button></div>
                </div>

            <div class="table-data">
                <div class="product-list">
                    <div class="head product-title" style="margin-bottom: 0">
                        <h4>Products List</h4>
                        <div class="add-product">
                            <button class="add-product-btn" onclick="addrow('add-product');modalShow('addProductsModal')">
                                <i class="uil uil-plus"></i>Add Product
                            </button>
                        </div>
                    </div>

                    <div style="display: flex; align-items: center; font-size: 12px; gap: .5rem; padding-bottom: 15px; padding-left: 10px">
           
                    </div>

                    <div class="product-table">
                    <table id="productTable">
                        <thead>
                            <tr>
                                <th style="border-radius: 10px 0 0 0;">#</th>
                                <th>Product</th>
                                <th>Category</th>
                                <th>Serving & Price</th>
                                <th>Status</th>
                                <th style="border-radius: 0 10px 0 0;"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- body content-->
                        </tbody>
                    </table>
                    </div>
                    <div id="product_pagination">
                       
                    </div>
                </div>

        
            </div>
    </main>
    <!-- MAIN -->
</section>
<!-- CONTENT -->

<script src="./js/script.js"></script>
<script src="./js/fetchdata-Product.js"></script>

<!-- addrow -->
 <script>   

function toggleAddOnsButton(type) {
    // Show #btn-div if there are no .row elements, hide otherwise
    if ($(`#${type}-addons-field .addonsRow`).length === 0) {
        $('#btn-div').show();
    } else {
        $('#btn-div').hide();
    }
}

 $(document).ready(function() {
    // Hide add-ons field initially
    toggleAddOnsButton('addProduct');
    $('#addons-field').hide();

    // Show or hide add-ons based on selected category
    $('#addProduct-category').change(() => categoryAddonOnchange('addProduct'));
    $('#editProduct-category').change(() => categoryAddonOnchange('editProduct'));

    categoryAddonOnchange('addProduct');
});


function categoryAddonOnchange(type){
    const selectedOption = $(`#${type}-category`).find('option:selected');
    const hasAddons = selectedOption.data('addons') === 1;
    if (hasAddons) {
        
        $(`#${type}-addons-field`).html(`
            <div id="btn-div" style="max-width: fit-content; margin-left: auto; margin-right: auto;">
                <div class="add-new" style="align-items: center; justify-content: center">
                    <button type="button" id="addons-button" class="add-new-btn" onclick="addons('${type}')">Add-ons</button>
                </div>
            </div>
        `);
        
    } else {
        $(`#${type}-addons-field`).html('');
    }
    toggleAddOnsButton(type);
}

function removeAddOn(button) {
    $(button).closest('.addonsRow').remove();
    toggleAddOnsButton('addProduct');
    toggleAddOnsButton('editProduct');
    

}

 function addons(type, name, price, id) {
    let addonName = name != undefined ? name : '';
    let addonPrice = price != undefined ? price : '';
    let addon_id = id != undefined ? id : ''; 
      const addonsRow = `
        <div class="row addonsRow">
              <div style="display: flex; gap: .7rem; padding-top: .5rem">
                <div style="display: flex; flex-direction: column; width: 50%">
                    <span>Add-ons Name <span style="color: c21807; font-weight: 600">*</span></span>
                    <div class="form-group">
                        <input name="addons-Name[]" class="form-field" style="border-radius: 6px;" type="text" placeholder="Enter Add-ons Name" value="${addonName}">
                        <input name="editaddOns_id[]" id="editaddOns_id" class="form-field" style="border-radius: 6px;" type="hidden" value="${addon_id}">
                    </div>
                </div>
            </div>

            <div style="display: flex; gap: .2rem; justify-content: space-between; align-items: end; padding-top: .5rem">
                <div style="display: flex; flex-direction: column; width: 50%">
                    <span>Price <span style="color: c21807; font-weight: 600">*</span></span>
                    <div class="form-group">
                        <span>PHP</span>
                        <input name="addons-Price[]" class="form-field" type="number" placeholder="0.00" min="1" step="0.01" value="${addonPrice}">
                    </div>
                </div>

                <div style="display: flex; gap: 1rem; width: 15.5rem; justify-content: center">
                    <div class="remove" style="align-items: center; justify-content: center">
                        <button type="button" onclick="removeAddOn(this)" class="remove-btn">
                            <i class="uil uil-times-circle"></i>
                        </button>
                    </div>

                    <div class="add-new" style="align-items: center; justify-content: center">
                        <button type="button" onclick="addons('${type}')" class="add-new-btn">
                            <i class="uil uil-plus-circle"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    `;
      $(`#${type}-addons-field`).append(addonsRow);
      toggleAddOnsButton(type);
    }


    
 </script>


<!-- add-image-js -->
 <?= include("./includes/alert_msg.php") ?>
<script>

$(document).on('click', '.ingredients-btn', function(event) {
    // Toggle the visibility of the dropdown content related to this button
    const dropdownContent = $(this).siblings('.dropdown-content');
    $('.dropdown-content').not(dropdownContent).removeClass('show'); // Hide other dropdowns
    dropdownContent.toggleClass('show');
    
    // Stop the event from propagating to the window
    event.stopPropagation();
});

// Close the dropdown when clicking outside
$(window).on('click', function() {
    $('.dropdown-content').removeClass('show');
});

// Prevent the dropdown itself from closing when clicked inside
$(document).on('click', '.dropdown-content', function(event) {
    event.stopPropagation();
});

const selectImage = document.querySelector('.select-image');
const inputFile = document.querySelector('#file');
const imgArea = document.querySelector('.img-area');

selectImage.addEventListener('click', function () {
	inputFile.click();
})

inputFile.addEventListener('change', function () {
	const image = this.files[0]
	if(image.size < 2000000) {
		const reader = new FileReader();
		reader.onload = ()=> {
			const allImg = imgArea.querySelectorAll('img');
            const allText = imgArea.querySelectorAll('.text');
			allImg.forEach(item=> item.remove());
            allText.forEach(item=> item.remove());
			const imgUrl = reader.result;
			const img = document.createElement('img');
			img.src = imgUrl;
			imgArea.appendChild(img);
			imgArea.classList.add('active');
			imgArea.dataset.img = image.name;
		}
		reader.readAsDataURL(image);
	} else {
		alert("Image size more than 2MB");
	}
})

</script>
<!-- add-image-js -->


<!-- edit-image-js -->
<script>
const imageProduct = document.querySelector('#image-product');
const inputProduct = document.querySelector('#product');
const prdArea = document.querySelector('#product-area');

imageProduct.addEventListener('click', function () {
	inputProduct.click();
})

inputProduct.addEventListener('change', function () {
	const image = this.files[0]
	if(image.size < 2000000) {
		const reader = new FileReader();
		reader.onload = ()=> {
			const allImg = prdArea.querySelectorAll('img');
            const allText = prdArea.querySelectorAll('#product-text');
			allImg.forEach(item=> item.remove());
            allText.forEach(item=> item.remove());
			const imgUrl = reader.result;
			const img = document.createElement('img');
			img.src = imgUrl;
			prdArea.appendChild(img);
			prdArea.classList.add('active');
			prdArea.dataset.img = image.name;
		}
		reader.readAsDataURL(image);
	} else {
		alert("Image size more than 2MB");
	}
})
</script>
<!-- edit-image-js -->

<!-- add-ingredients-js -->
<script>
    const dropdownButton = document.getElementById('dropdown-button');
    const dropdownContent = document.getElementById('dropdown-content');

    // Toggle the dropdown content on button click
    dropdownButton.addEventListener('click', function() {
        dropdownContent.classList.toggle('show');
    });

    // Close the dropdown when clicking outside of it
    window.addEventListener('click', function(event) {
        if (!dropdownButton.contains(event.target) && !dropdownContent.contains(event.target)) {
            dropdownContent.classList.remove('show');
        }
    });
</script>
<!-- add-ingredients-js -->

<!-- edit-ingredients-js -->
<script>
    const dropdownButtonEdit = document.getElementById('dropdown-button-edit');
    const dropdownContentEdit = document.getElementById('dropdown-content-edit');

    // Toggle the dropdown content on button click
    dropdownButtonEdit.addEventListener('click', function() {
        dropdownContentEdit.classList.toggle('show');
    });

    // Close the dropdown when clicking outside of it
    window.addEventListener('click', function(event) {
        if (!dropdownButtonEdit.contains(event.target) && !dropdownContentEdit.contains(event.target)) {
            dropdownContentEdit.classList.remove('show');
        }
    });

    // $(document).ready(function(){

    // });

    // addrow('addProduct');

</script>
<!-- edit-ingredients-js -->
</body>
</html>
