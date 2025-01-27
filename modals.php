<?php
date_default_timezone_set('Asia/Manila');
?>
<!-- forget password -->
<dialog class="modal" id="forgetPasswordModal">
    <div class="modal-header">
        <h4 class="modal-title">Forgot Password</h4>
        <button type="button" onclick="modalHide('forgetPasswordModal')" aria-label="close" class="x">❌</button>
    </div>

    <div class="modal-body" style="padding: 2rem 1.5rem">
        <div style="display: flex; flex-direction: column; width: 100%">

            <span>Email Address <span style="color: #c21807; font-weight: 600">*</span></span>
            <div class="form-group" style="padding-bottom: 1rem">
                <input id="email" class="form-field" style="border-radius: 6px;" type="email" placeholder="Enter your email address" required>
            </div>

            <span>Username <span style="color: #c21807; font-weight: 600">*</span></span>
            <div class="form-group" style="padding-bottom: 1rem">
                <input id="username" class="form-field" style="border-radius: 6px;" type="text" placeholder="Enter your username" required>
            </div>

            <span>New Password <span style="color: #c21807; font-weight: 600;">*</span></span>
            <div class="form-group" style="padding-bottom: 1rem">
                <input id="new_password" class="form-field" style="border-radius: 6px;" type="password" placeholder="Enter new password" required>
            </div>

            <span>Confirm New Password <span style="color: #c21807; font-weight: 600;">*</span></span>
            <div class="form-group" style="padding-bottom: 1rem">
                <input id="confirm_password" class="form-field" style="border-radius: 6px;" type="password" placeholder="Confirm your new password" required>
            </div>

        </div>
    </div>

    <div class="modal-footer">
        <button type="button" onclick="resetPassword()" style="background-color: #0F52BA; color: #f9f9f9; border: none" aria-label="close">Reset Password</button>
        <button type="button" onclick="modalHide('forgetPasswordModal')" aria-label="close">Cancel</button>
    </div>

</dialog>

<!-- forget password -->


<!-- POS -->
<!-- discount -->
<dialog class="modal" id="discountModal">
    <div class="modal-header">
        <h4 class="modal-title">Select Discount</h4>
        <button type="button" onclick="modalHide('discountModal')" aria-label="close" class="x">❌</button>
    </div>

    <div class="modal-body" style="padding: 2rem 1.5rem">
        <div style="display: flex; flex-direction: column; width: 100%">

            <span>Name <span style="color: c21807; font-weight: 600">*</span></span>
            <div class="form-group" style="padding-bottom: 1rem">
                <input id="Fullname" class="form-field" style="border-radius: 6px; " type="text" placeholder="Enter Full name" required>
            </div>

            <span>ID number <span style="color: c21807; font-weight: 600">*</span></span>
            <div class="form-group" style="padding-bottom: 1rem">
                <input id="id_number" class="form-field" style="border-radius: 6px; " type="text" placeholder="Enter ID Number" required>
            </div>

            <span>Discount <span style="color: c21807; font-weight: 600;">*</span></span>
            <div class="form-group">
                <select id="discount_type" style="width: 100%; border-radius: 6px; font-size: 14px; line-height: 23px; text-transform: capitalize">
                    <option value="0" style="font-size: 14px; text-transform: capitalize" hidden selected="true" disabled="disabled">-Select Discount-</option>
                    <option value="0" style="font-size: 14px; text-transform: capitalize">No Discount</option>
                    <option value="20" style="font-size: 14px; text-transform: capitalize">20% PWD</option>
                    <option value="20" style="font-size: 14px; text-transform: capitalize">20% student</option>
                    <option value="20" style="font-size: 14px; text-transform: capitalize">20% senior citizen</option>
                </select>
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" onclick="applyDiscount()" style="background-color: #0F52BA; color: #f9f9f9; border: none" aria-label="close">Save</button>
        <button type="button" onclick="modalHide('discountModal')" aria-label="close">Cancel</button>
    </div>

</dialog>
<!-- discount -->

<!-- checkout -->
<dialog class="modal" id="checkoutModal">
    <div class="modal-header">
        <h4 class="modal-title">Order Preview</h4>
        <button onclick="modalHide('checkoutModal')" aria-label="close" class="x">❌</button>
    </div>

    <div class="modal-body" style="padding: .3rem 0; margin: 0 1rem;">
        <div style="display: flex; flex-direction: column; width: 100%; border-bottom: 3px double #808080;">
            <span style="color: #91521f; font-size: 1rem; font-weight: 500">Confirmation</span></span>
            <div style="margin-bottom: .4rem">
                <div style="display: flex; justify-content: space-between;">
                    <div style="font-size: .9rem">
                        <?php
                        $transactionId = $conn->query("SELECT MAX(`transaction_id`) AS `reference` FROM `transactions`")->fetch_assoc()["reference"];
                        $date = date("Y-m-d H:i:s");
                        $date_timestamp = strtotime($date);
                        $dt = date('M. j, Y', $date_timestamp);
                        $time_part = date('h:i A', $date_timestamp);
                        ?>
                        Reference# <?= $transactionId ?>
                    </div>

                    <div style="font-size: .9rem">
                        Date: <?= $dt ?>
                    </div>
                </div>

                <div id="customer_detailsPreview">
                    <div style="display: flex; justify-content: space-between;">
                        <!-- <div style="font-size: .9rem;">
                            Customer Name:
                        </div> -->
                        <div style="font-size: .9rem;">
                            Time: <?= $time_part ?>
                        </div>
                    </div>
                    <div style="font-size: .9rem;">
                        <!-- Customer ID: -->
                    </div>
                </div>

            </div>
        </div>

        <div class="checkout-items">
            <span style="color: #91521f; font-size: 1rem; font-weight: 500">Items</span></span>
            <div id="order-items" class="order-items">
                <!-- field for order items -->
            </div>
        </div>

        <div style="display: flex; flex-direction: column; padding-top: .5rem; width: 100%; border-bottom: 3px double #808080;">
            <span style="color: #91521f; font-size: 1rem; font-weight: 500">Summary</span></span>
            <div id="summary" style="margin-bottom: .4rem">
                <!-- summary -->
            </div>
        </div>
    </div>

    <div class="modal-footer-checkout">
        <div id="cash" style="margin-bottom: .4rem">
            <!-- cash related -->
        </div>

        <div class="checkout-btn">
            <button id="checkoutProceed" style="background-color: #91521f; color: #f9f9f9; border: none" aria-label="close">Proceed</button>
            <button onclick="modalHide('checkoutModal')" aria-label="close">Cancel</button>
        </div>
    </div>

</dialog>
<!-- checkout -->
<!-- POS -->

<!-- category -->
<!-- add-category -->
<form action="add-category-form.php" method="POST">
    <dialog class="modal" id="addCategoryModal" style="width: 25rem">
        <div class="modal-header">
            <h4 class="modal-title">Add Category</h4>
            <button type="button" onclick="modalHide('addCategoryModal')" aria-label="close" class="x">❌</button>
        </div>

        <div class="modal-body">
            <div style="display: flex;">
                <div style="display: flex; flex-direction: column; width: 100%">
                    <span>Category Name <span style="color: c21807; font-weight: 600">*</span></span>
                    <div class="form-group">
                        <input class="form-field" name="addCategory_name" style="border-radius: 6px; " type="text" placeholder="Enter Category Name" required>
                    </div>
                </div>
            </div>

            <div style="display: flex; padding-top: 1rem">
                <div style="display: flex; flex-direction: column; width: 100%">
                    <span>Add-ons <span style="color: c21807; font-weight: 600">*</span></span>
                    <div class="form-group">
                        <select class="unit-measure" name="addcategory_addons" style="width: 100%; border-radius: 6px; font-size: 14px; line-height: 23px;" required>
                            <option value="0" style="font-size: 14px" selected>No</option>
                            <option value="1" style="font-size: 14px">Yes</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal-footer">
            <button type="submit" style="background-color: #0F52BA; color: #f9f9f9; border: none" aria-label="close">Add</button>
            <button type="button" onclick="modalHide('addCategoryModal')" aria-label="close">Close</button>
        </div>

    </dialog>
</form>
<!-- add-category -->

<!-- edit-category -->
<form action="edit-category-form.php" method="POST">
    <dialog class="modal" id="editCategoryModal" style="width: 25rem">
        <div class="modal-header">
            <h4 class="modal-title">Edit Category</h4>
            <button type="button" onclick="modalHide('editCategoryModal')" aria-label="close" class="x">❌</button>
        </div>

        <div class="modal-body">
            <div style="display: flex;">
                <div style="display: flex; flex-direction: column; width: 100%">
                    <span>Category Name <span style="color: c21807; font-weight: 600">*</span></span>
                    <div class="form-group">

                        <input class="form-field" id="editcategory_name" name="editcategory_name" style="border-radius: 6px; " type="text" value="" required>
                    </div>
                </div>
            </div>

            <div style="display: flex; padding-top: 1rem">
                <div style="display: flex; flex-direction: column; width: 100%">
                    <span>Add-ons <span style="color: c21807; font-weight: 600">*</span></span>
                    <div class="form-group" id="dropdown">
                        <input type="hidden" name="editcategory_id" id="editcategory_id">
                        <!--dropdown field-->

                    </div>
                </div>
            </div>
        </div>

        <div class="modal-footer">
            <button type="submit" style="background-color: #0F52BA; color: #f9f9f9; border: none" aria-label="close">Save</button>
            <button type="button" onclick="modalHide('editCategoryModal')" aria-label="close">Close</button>
        </div>
</form>

</dialog>
<!-- edit-category -->

<!-- archive-category -->
<form action="archive-form-category.php" method="POST">
    <dialog class="modal" id="archiveCategoryModal">
        <div class="modal-header" style="border: none">
            <h4 class="modal-title-category" id="archivemodal_title">...</h4>
            <button type="button" onclick="modalHide('archiveCategoryModal')" aria-label="close" class="x">❌</button>
        </div>

        <div class="modal-body">
            <div class="archive">
                <img src="img/archive.png">
                <h3>Are you sure you want to archive this category?</h3>
                <input type="hidden" name="archivecategory_id" id="archivecategory_id">
                <input type="hidden" name="archivecategory_name" id="archivecategory_name">
            </div>
        </div>

        <div class="modal-footer">
            <button type="submit" style="background-color: #c21807; color: #f9f9f9; border: none" aria-label="close">Archive</button>
            <button type="button" onclick="modalHide('archiveCategoryModal')" aria-label="close">Cancel</button>
        </div>

    </dialog>
</form>
<!-- archive-category -->
<!-- category -->

<!-- sales -->
<!-- view-btn -->
<dialog class="modal" id="viewDetailsModal">
    <div class="modal-header">
        <h4 class="modal-title" id="reference_number">...</h4>
        <button type="button" onclick="modalHide('viewDetailsModal')" aria-label="close" class="x">❌</button>
    </div>

    <div class="modal-body">
        <div class="discount_section">
            <div id="cs_name"></div>
            <div id="cs_id"></div>
            <div id="dc_type"></div>
        </div>
        <table class="table" id="sales_items">
            <thead>
                <tr>
                    <th style="border-radius: 10px 0 0 0;"></th>
                    <th>PRODUCT</th>
                    <th>QUANTITY</th>
                    <th>(₱)SUBTOTAL</th>
                </tr>
            </thead>
            <tbody>
                <!--Display transaction Items-->
            </tbody>
        </table>
        <div class="view-total">
            <span class="total" id="total">....</span>
        </div>
    </div>

    <div class="modal-footer">
        <button type="button"><a type="button" id="receiptPrintBtn" href="#" class="btn btn-primary">Print</a></button>
        <button type="button" onclick="modalHide('viewDetailsModal')" aria-label="close">Close</button>
    </div>

</dialog>
<!-- view-btn -->
<!-- sales -->

<!-- ingredients -->
<!-- add-stocks -->
<form action="ingredientsAdd-form.php" method="POST">
    <dialog class="modal" id="addStocksModal">
        <div class="modal-header">
            <h4 class="modal-title">Add Stock</h4>
            <button type="button" onclick="modalHide('addStocksModal')" aria-label="close" class="x">❌</button>
        </div>

        <div class="modal-body">
            <div style="display: flex; gap: 1rem; justify-content: space-between">
                <div style="display: flex; flex-direction: column; width: 17rem">
                    <span>Item Name <span style="color: c21807; font-weight: 600">*</span></span>
                    <div class="form-group">
                        <input class="form-field" name="newitemStock_name" style="border-radius: 6px; " type="text" placeholder="Enter Name" required>
                    </div>
                </div>

                <div style="display: flex; flex-direction: column">
                    <span>Cost <span style="color: c21807; font-weight: 600">*</span></span>
                    <div class="form-group">
                        <span>PHP</span>
                        <input class="form-field" name="new-cost" type="number" placeholder="0" required>
                    </div>
                </div>
            </div>

            <div style="display: flex; gap: 1rem; justify-content: space-between; padding-top: 1rem">
                <div style="display: flex; flex-direction: column">
                    <span>Quantity <span style="color: c21807; font-weight: 600">*</span></span>
                    <div class="form-group">
                        <input class="form-field" name="addnew-qty" style="border-radius: 6px 0 0 6px; width: 11.2rem" type="number" placeholder="0" required>
                        <select class="form-control" id="unit" name="unit" required>
                            <?php
                            $unit = $conn->query("SELECT * FROM `unit_of_measurement`");
                            while ($row = $unit->fetch_assoc()) {
                                echo '
                                                <option value="' . $row["unit_id"] . '">' . $row["unit_name"] . '</option>
                                            ';
                            }
                            ?>
                        </select>
                    </div>
                </div>

                <div style="display: flex; flex-direction: column; width: 16rem">
                    <span>Critical Stocks <span style="color: c21807; font-weight: 600">*</span></span>
                    <div class="form-group">
                        <input class="form-field" name="addnew-crit" style="border-radius: 6px;" type="number" placeholder="0">
                    </div>
                </div>
            </div>

            <div style="display: flex; width: 100%; padding-top: 1rem">
                <div style="display: flex; flex-direction: column">
                    <span>Expiration Date <span style="color: c21807; font-weight: 600">*</span></span>
                    <div class="form-group">
                        <input name="addnew-expdate" type="date" required>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal-footer">
            <button type="submit" style="background-color: #0F52BA; color: #f9f9f9; border: none" aria-label="close">Add</button>
            <button type="button" onclick="modalHide('addStocksModal')" aria-label="close">Close</button>
        </div>

    </dialog>
</form>
<!-- add-stocks -->

<!-- view-item -->
<dialog class="modal" id="viewItemModal">
    <div class="modal-header">
        <h4 class="modal-title">View Item</h4>
        <button type="button" onclick="modalHide('viewItemModal')" aria-label="close" class="x">❌</button>
    </div>

    <div class="modal-body" style="padding: .8rem 2rem;">
        <div style="display: flex; gap: .5rem; border-radius: .5rem; padding: 1.5rem; 
                border: 1px solid #91521f; justify-content: space-between; background-color: #e0d4cc">
            <div style="display: flex; flex-direction: column">
                <span>Name:</span>
                <div style="padding-bottom: 1rem">
                    <h3 id="viewstock_name">...</h3>
                </div>

                <span>Quantity:</span>
                <div style="padding-bottom: 1rem">
                    <h4 id="viewstock_qty">...</h4>
                </div>

                <span>No. of Batches:</span>
                <div>
                    <h4 id="viewbatch_count">...</h4>
                </div>
            </div>

            <div style="display: flex; flex-direction: column">
                <span>Cost:</span>
                <div style="padding-bottom: 1rem">
                    <h3 id="viewcost">...</h3>
                </div>

                <span>Status:</span>
                <div style="padding-bottom: 1rem">
                    <span id="viewstock"></span>
                </div>

                <span>Critical Stocks:</span>
                <div>
                    <h4 id="viewcritical_stock">
                        ...
                    </h4>
                </div>
            </div>
        </div>
    </div>

    <div class="modal-footer" style="border-top: 1px solid #91521f; flex-direction: row">
        <div style="display: flex; justify-content: space-between; gap: .5rem; align-items: center; padding: .8rem 1rem 0; width: 100%">
            <div style="display: flex; flex-direction: column; font-size: .8rem">
                <div id="viewdate_added">Date Added: 10-25-2024</div>

                <div id="viewtime">Time: 10:20 PM</div>
            </div>

            <div style="display: flex; flex-direction: column; font-size: .8rem">
                <div id="viewAdded_by">Added By: Seafoodshrimp</div>
            </div>
        </div>
    </div>

</dialog>
<!-- view-item -->

<!-- edit-stock-item -->
<form action="edit-stock-ingredients-form.php" method="POST">
    <dialog class="modal" id="editItemModal">
        <div class="modal-header">
            <h4 class="modal-title">Edit Item</h4>
            <button type="button" onclick="modalHide('editItemModal')" aria-label="close" class="x">❌</button>
        </div>

        <div class="modal-body">
            <input type="hidden" id="editStock-id" name="editStock-id">
            <div style="display: flex; gap: 1rem; justify-content: space-between">
                <div style="display: flex; flex-direction: column">
                    <span>Item</span>
                    <div class="form-group">
                        <input name="editStock-Item_name" id="editStock-Item_name" class="form-field" style="border-radius: 6px; width: 19rem" type="text" value="">
                    </div>
                </div>

                <div style="display: flex; flex-direction: column">
                    <span>Cost</span>
                    <div class="form-group">
                        <span>PHP</span>
                        <input name="editStock-cost" id="editStock-cost" class="form-field" type="number" value="600.00">
                    </div>
                </div>
            </div>

            <div style="display: flex; gap: 1rem; justify-content: space-between; padding-top: 1rem">
                <div style="display: flex; flex-direction: column">
                    <span>Unit of Measurement</span>
                    <div class="form-group">
                        <select name="editunit_stock" id="editunit_stock" class="unit-measure" style="width: 19rem; border-radius: 6px; font-size: 14px; line-height: 23px;">
                            <option hidden selected disabled value>Select Unit of measurement</option>
                            <?php
                            $unit = $conn->query("SELECT * FROM `unit_of_measurement`");
                            while ($row = $unit->fetch_assoc()) {
                                echo '
                                                <option value="' . $row["unit_id"] . '">' . $row["unit_name"] . '</option>
                                            ';
                            }
                            ?>
                        </select>
                    </div>
                </div>

                <div style="display: flex; flex-direction: column">
                    <span>Critical Stocks</span>
                    <div class="form-group">
                        <input name="editStock-critical" id="editStock-critical" class="form-field" style="border-radius: 6px;" type="number" value="69">
                    </div>
                </div>
            </div>
        </div>

        <div class="modal-footer">
            <button type="submit" style="background-color: #0F52BA; color: #f9f9f9; border: none" aria-label="close">Save</button>
            <button type="button" onclick="modalHide('editItemModal')" aria-label="close">Cancel</button>
        </div>

    </dialog>
</form>
<!-- edit-item -->


<!-- archive-item -->
<form action="archive-stock-form.php" method="POST">
    <dialog class="modal" id="archiveItemModal">
        <div class="modal-header" style="border: none">
            <h4 class="modal-title" id="archive_title">Chicharon Bulaklak</h4>
            <button type="button" onclick="modalHide('archiveItemModal')" aria-label="close" class="x">❌</button>
        </div>

        <div class="modal-body">
            <div class="archive">
                <img src="img/archive.png">
                <h3>Are you sure you want to archive this item?</h3>
                <input type="hidden" id="archivestock_id" name="archivestock_id">
                <input type="hidden" id="archivestock_status" name="archivestock_status">
            </div>
        </div>

        <div class="modal-footer">
            <button type="submit" style="background-color: #c21807; color: #f9f9f9; border: none" aria-label="close">Archive</button>
            <button type="button" onclick="modalHide('archiveItemModal')" aria-label="close">Cancel</button>
        </div>

    </dialog>
</form>
<!-- archive-item -->

<!-- view batch -->
<dialog class="modal" id="viewBatchModal" style="width: 40rem">
    <div class="modal-header">
        <h4 class="modal-title" id="viewbatch_title">...</h4>
        <button type="button" onclick="modalHide('viewBatchModal')" aria-label="close" class="x">❌</button>
    </div>

    <div class="modal-body">
        <div style="display: flex; flex-direction: row-reverse; padding-bottom: .5rem">
            <button type="button" class="add-batch-btn" onclick="modalShow('addBatchModal')">
                <i class="uil uil-plus"></i>Add Stock In
            </button>
        </div>

        <table class="table batchtable" id="batchTable">
            <thead style="background-color: #e0d4cc">
                <tr>
                    <th></th>
                    <th>ID</th>
                    <th>QTY</th>
                    <th>COST</th>
                    <th>EXPIRATION DATE</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>

    <div class="modal-footer">
        <button type="button" onclick="modalHide('viewBatchModal')" aria-label="close">Close</button>
    </div>

</dialog>
<!-- view batch -->

<!-- add-batch -->
<form action="ingredientsAddnewBatch-form.php" method="POST">
    <dialog class="modal" id="addBatchModal">
        <div class="modal-header">
            <h4 class="modal-title">Add Batch</h4>
            <button type="button" onclick="modalShow('viewBatchModal')" aria-label="close" class="x">❌</button>
        </div>

        <div class="modal-body">
            <input type="hidden" name="addnewBatch-stock_id" id="addnewBatch-stock_id">
            <div style="display: flex; gap: .5rem; justify-content: space-between">
                <div style="display: flex; flex-direction: column">
                    <span>Item</span>
                    <div class="form-group">
                        <input name="addnewBatch-stockName" id="addnewBatch-stockName" class="form-field" style="border-radius: 6px; width: 19rem" type="text" readonly="readonly" value="">
                    </div>
                </div>

                <div style="display: flex; flex-direction: column">
                    <span>Quantity</span>
                    <div class="form-group">
                        <input name="addnewBatch-qty" id="addnewBatch-qty" class="form-field" style="border-radius: 6px;" type="number" value="" required>
                    </div>
                </div>
            </div>

            <div style="display: flex; gap: 1rem; justify-content: space-between; padding-top: 1rem">
                <div style="display: flex; flex-direction: column">
                    <span>Expiration Date</span>
                    <div class="form-group">
                        <input name="addnewBatch-expdate" id="addnewBatch-expdate" type="date" style="width: 19rem" value="" required>
                    </div>
                </div>

                <div style="display: flex; flex-direction: column">
                    <span>Cost</span>
                    <div class="form-group">
                        <span>PHP</span>
                        <input name="addNewBatch-cost" id="addNewBatch-cost" class="form-field" type="number" value="" required>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal-footer">
            <button type="submit" style="background-color: #0F52BA; color: #f9f9f9; border: none" onclick="modalHide('editBatchModal')" aria-label="close">Add</button>
            <button type="button" onclick="modalShow('viewBatchModal')" aria-label="close">Cancel</button>
        </div>

    </dialog>
</form>
<!-- add-batch -->



<!-- edit-batch -->
<form action="ingredientsEditBatch-form.php" method="POST">
    <dialog class="modal" id="editBatchModal">
        <div class="modal-header">
            <h4 class="modal-title" id="editbatch_title">Edit Batch ....</h4>
            <button type="button" onclick="modalShow('viewBatchModal')" aria-label="close" class="x">❌</button>
        </div>

        <div class="modal-body">
            <input type="hidden" name="editBatch-batch_id" id="editBatch-batch_id">
            <input type="hidden" name="editbatch-stock_id" id="editbatch-stock_id">
            <div style="display: flex; gap: .5rem; justify-content: space-between">
                <div style="display: flex; flex-direction: column">
                    <span>Item</span>
                    <div class="form-group">
                        <input name="editStock-Item" id="editStock-Item" class="form-field" style="border-radius: 6px; width: 19rem" type="text" readonly="readonly" value="" required>
                    </div>
                </div>

                <div style="display: flex; flex-direction: column">
                    <span>Quantity</span>
                    <div class="form-group">
                        <input name="editBatch-qty" id="editBatch-qty" class="form-field" style="border-radius: 6px;" type="number" value="" required>
                    </div>
                </div>
            </div>

            <div style="display: flex; gap: 1rem; justify-content: space-between; padding-top: 1rem">
                <div style="display: flex; flex-direction: column">
                    <span>Expiration Date</span>
                    <div class="form-group">
                        <input name="editexpiration_date" id="editexpiration_date" type="date" style="width: 19rem" value="">
                    </div>
                </div>

                <div style="display: flex; flex-direction: column">
                    <span>Cost</span>
                    <div class="form-group">
                        <span>PHP</span>
                        <input name="editBatch-cost" id="editBatch-cost" class="form-field" type="number" value="">
                    </div>
                </div>
            </div>
        </div>

        <div class="modal-footer">
            <button type="submit" style="background-color: #0F52BA; color: #f9f9f9; border: none" onclick="modalHide('editBatchModal')" aria-label="close">Save</button>
            <button type="button" onclick="modalShow('viewBatchModal')" aria-label="close">Cancel</button>
        </div>

    </dialog>
</form>
<!-- edit-batch -->


<!-- archive-batch -->
<form action="archiveBatch-form.php" method="POST">
    <dialog class="modal" id="archiveBatchModal">
        <div class="modal-header" style="border: none">
            <h4 class="modal-title" id="archive_batch_title">...</h4>
            <button type="button" onclick="modalShow('viewBatchModal')" aria-label="close" class="x">❌</button>
        </div>

        <div class="modal-body">
            <div class="archive">
                <img src="img/archive.png">
                <h3>Are you sure you want to archive this batch?</h3>
                <input type="hidden" name="archivebatch_id" id="archivebatch_id">
                <input type="hidden" name="archivebatch_status" id="archivebatch_status">
                <input type="hidden" name="archivebatch_stock_id" id="archivebatch_stock_id">

            </div>
        </div>

        <div class="modal-footer">
            <button type="submit" style="background-color: #c21807; color: #f9f9f9; border: none" onclick="modalHide('archiveBatchModal')" aria-label="close">Archive</button>
            <button type="button" onclick="modalShow('viewBatchModal')" aria-label="close">Cancel</button>
        </div>

    </dialog>
</form>
<!-- archive-batch -->
<!-- ingredients -->


<!-- products -->
<!-- add-products -->
<form action="addProduct-form.php" method="POST" enctype="multipart/form-data">
    <dialog class="modal" id="addProductsModal">
        <div class="modal-header">
            <h4 class="modal-title">Add Product</h4>
            <button type="button" onclick="modalHide('addProductsModal')" aria-label="close" class="x">❌</button>
        </div>

        <div class="modal-body" style="overflow: auto">
            <div style="display: flex; justify-content: space-between; gap: 1rem; padding-bottom: .5rem; border-bottom: 1px solid #91521f">
                <div class="upload-image">
                    <input name="productImage" type="file" id="file" accept="image/*" hidden required>
                    <div class="img-area" data-img="">
                        <div class="icon"><img src="img/upload.png"></div>
                        <h3 class="text">Upload Image</h3>
                    </div>
                    <button type="button" class="select-image">Select Image</button>
                </div>

                <div style="display: flex; flex-direction: column; gap: 1.5rem">
                    <div style="padding-top: 1.2rem">
                        <span>Product Name <span style="color: c21807; font-weight: 600">*</span></span>
                        <div class="form-group" style="width: 15rem">
                            <input name="addProduct-productName" class="form-field" style="border-radius: 6px;" type="text" placeholder="Enter Name" required>
                        </div>
                    </div>

                    <div>
                        <span>Category <span style="color: c21807; font-weight: 600">*</span></span>
                        <div class="form-group">
                            <select name="addProduct-category" id="addProduct-category" class="category" style="width: 15rem; border-radius: 6px; font-size: 14px; line-height: 23px; text-transform: capitalize;" required>
                                <option style="font-size: 14px; text-transform: capitalize" selected disabled>-Select Category-</option>
                                <?php
                                $ctg = $conn->query("SELECT * FROM `categories` WHERE 1 ORDER BY category_name ASC");
                                while ($row = $ctg->fetch_assoc()) {
                                    echo '
                                    <option style="font-size: 14px; text-transform: capitalize" value="' . $row["id"] . '" data-addons="' . $row["add-ons"] . '" >' . $row["category_name"] . '</option>
                                ';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div id="add-product-sizingRow" style="padding: 1rem 0; border-bottom: 1px solid #91521f">
                <!-- INPUT FIELD OF PRODUCT SIZE -->
            </div>
            <div class="addonsField" id="addProduct-addons-field" style="padding: 1rem 0; border-bottom: 1px solid #91521f;">
                <!-- INPUT FIELD OF ADDONS-->
                <!-- <div id="btn-div" style="max-width: fit-content; margin-left: auto; margin-right: auto;">
                    <div class="add-new" style="align-items: center; justify-content: center">
                        <button type="button" id="addons-button" class="add-new-btn" onclick="addons('addProduct')">Add-ons</button>
                    </div>
                </div> -->
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" style="background-color: #0F52BA; color: #f9f9f9; border: none" aria-label="close">Add</button>
            <button type="button" onclick="modalHide('addProductsModal')" aria-label="close">Close</button>
        </div>

    </dialog>
</form>
<!-- add-products -->

<!-- view-product -->
<dialog class="modal" id="viewProductModal">
    <div class="modal-header">
        <h4 class="modal-title">View Product</h4>
        <button type="button" onclick="modalHide('viewProductModal')" aria-label="close" class="x">❌</button>
    </div>

    <div class="modal-body" style="padding: .8rem 2rem;">
        <div style="display: flex; gap: .5rem; border-radius: .5rem; padding: 1.5rem; 
                border: 1px solid #91521f; justify-content: space-between; background-color: #e0d4cc">
            <div style="display: flex; flex-direction: column;">
                <span>Image:</span>
                <div style="padding-bottom: 1rem; width: 8rem">
                    <img id="viewProduct-img" src="upload/products/" alt="" style="width: 8rem">
                </div>

                <span>Category:</span>
                <div style="padding-bottom: 1rem">
                    <h4 id="viewProduct-Category">Crispy Rice Meal</h4>
                </div>

                <span>Ingredients:</span>
                <div>
                    <h5 id="ingredients">...</h5>
                </div>
            </div>

            <div style="display: flex; flex-direction: column; padding-left: 1.5rem">
                <span>Name:</span>
                <div style="padding-bottom: .5rem">
                    <h3 id="viewProduct-Name">...</h3>
                </div>

                <span>Serving & Price:</span>
                <div style="padding-bottom: .8rem">
                    <h3 id="serving_price">... <!--<span style="padding: 0 .3rem"></span>...--></h3>
                </div>

                <span>Status:</span>
                <div>
                    <div style="width: 7rem; background-color: #76a004; color: #fff; text-align: center; padding: .2rem 0; border-radius: .3rem">
                        <h4>Available</h4>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
    

    <div class="modal-footer" style="border-top: 1px solid #91521f; flex-direction: row">
        <div style="display: flex; justify-content: space-between; gap: .5rem; align-items: center; padding: .8rem 1rem 0; width: 100%">
            <div style="display: flex; flex-direction: column; font-size: .8rem">
                <div id="viewProduct-Date">Date Added: 10-25-2024</div>

                <div id="viewProduct-Time">Time: 10:20 PM</div>
            </div>

            <div style="display: flex; flex-direction: column; font-size: .8rem">
                <div id="viewProduct-AddedBy">Added By: Seafoodshrimp</div>
            </div>
        </div>
    </div>

</dialog>
<!-- view-product -->

<!-- edit-products -->
<form action="edit-form-product.php" method="POST" enctype="multipart/form-data">
    <dialog class="modal" id="editProductsModal">
        <div class="modal-header">
            <h4 class="modal-title">Edit Product</h4>
            <button type="button" onclick="modalHide('editProductsModal')" aria-label="close" class="x">❌</button>
        </div>

        <div class="modal-body" style="overflow: auto">
            <div style="display: flex; justify-content: space-between; gap: 1rem; padding-bottom: .5rem; border-bottom: 1px solid #91521f">
                <div class="upload-image">
                    <input name="editImage" type="file" id="editproduct" accept="image/*" hidden>
                   <input type="hidden" id="currentImage" name="currentImage">
                    <div class="img-area" id="product-area" data-img="">
                        <div class="icon"><img id="editProductImage" src="img/upload.png"></div>
                        
                    </div>
                    <button type="button" class="select-image" id="image-product">Change Image</button>
                </div>

                <div style="display: flex; flex-direction: column; gap: 1.5rem">
                    <div style="padding-top: 1.2rem">
                        <span>Product Name <span style="color: c21807; font-weight: 600">*</span></span>
                        <div class="form-group" style="width: 15rem">
                            <input name="editproduct_name" id="editproduct_name" class="form-field" style="border-radius: 6px;" type="text" value="" required>
                        </div>
                        <input name="editproduct_id" id="editproduct_id" class="form-field" style="border-radius: 6px;" type="hidden" value="">
                    </div>

                    <div>
                        <span>Category <span style="color: c21807; font-weight: 600">*</span></span>
                        <div class="form-group">
                            <select name="editProduct-category" id="editProduct-category" class="category" style="width: 15rem; border-radius: 6px; font-size: 14px; line-height: 23px; text-transform: capitalize;" required>
                                <option style="font-size: 14px; text-transform: capitalize" selected disabled>-Select Category-</option>
                                <?php
                                $ctg = $conn->query("SELECT * FROM `categories` WHERE 1 ORDER BY category_name ASC");
                                while ($row = $ctg->fetch_assoc()) {
                                    echo '
                                    <option style="font-size: 14px; text-transform: capitalize" value="' . $row["id"] . '" data-addons="' . $row["add-ons"] . '" >' . $row["category_name"] . '</option>
                                ';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
                 
            <!-- hidden input for size_id and product_ingredients(ID) -->
            <input name="editsize_id" id="editsize_id" class="form-field" style="border-radius: 6px;" type="hidden" value="">
            <input name="editingredients_id" id="editingredients_id" class="form-field" style="border-radius: 6px;" type="hidden" value="">

            <div id="edit-product-sizingRow" style="padding: 1rem 0; border-bottom: 1px solid #91521f">
                <!-- size id -->
            </div>

            <div class="addonsField" id="editProduct-addons-field" style="padding: 1rem 0; border-bottom: 1px solid #91521f;">
                <!-- INPUT FIELD OF ADDONS-->
                <!-- <div id="btn-div" style="max-width: fit-content; margin-left: auto; margin-right: auto;">
                    <div class="add-new" style="align-items: center; justify-content: center">
                        <button type="button" id="addons-button" class="add-new-btn" onclick="addons(this)">Add-ons</button>
                    </div>
                </div> -->
            </div>
        </div>

        <div class="modal-footer">
            <button type="submit" style="background-color: #0F52BA; color: #f9f9f9; border: none" aria-label="close">Save</button>
            <button type="button" onclick="modalHide('editProductsModal')" aria-label="close">Close</button>
        </div>

    </dialog>
</form>
<!-- edit-products -->

<!-- archive-product -->
<form action="archive-form-product.php" method="POST">
    <dialog class="modal" id="archiveProductModal">
        <div class="modal-header" style="border: none">
            <h4 class="modal-title" id="ArchiveProduct_title">...</h4>
            <button type="button" onclick="modalHide('archiveProductModal')" aria-label="close" class="x">❌</button>
        </div>

        <div class="modal-body">
            <div class="archive">
                <img src="img/archive.png">
                <h3>Are you sure you want to archive this product?</h3>
                <input type="hidden" name="archiveProduct-id" id="archiveProduct-id">
                <input type="hidden" name="archiveProduct-status" id="archiveProduct-status">
            </div>
        </div>

        <div class="modal-footer">
            <button type="submit" style="background-color: #c21807; color: #f9f9f9; border: none" aria-label="close">Archive</button>
            <button type="button" onclick="modalHide('archiveProductModal')" aria-label="close">Cancel</button>
        </div>

    </dialog>
</form>
<!-- archive-product -->
<!-- products -->

<!-- user-management -->
<!-- add-user -->
<form action="add-user.php" method="POST" enctype="multipart/form-data" onsubmit="return validatePasswords()">
    <dialog class="modal" id="addUserModal">
        <div class="modal-header">
            <h4 class="modal-title">Add User</h4>
            <button type="button" onclick="modalHide('addUserModal')" aria-label="close" class="x">❌</button>
        </div>

        <div class="modal-body" style="overflow: auto">
            <div style="display: flex; justify-content: space-between; gap: 1rem; padding-bottom: .5rem; border-bottom: 1px solid #91521f">
                <div class="upload-image">
                    <input name="user_pic" type="file" id="profile" accept="image/*" hidden required>
                    <div class="img-area" id="profile-area" data-img="">
                        <div class="icon"><img src="img/upload.png"></div>
                        <h3 class="text" id="profile-text">Upload Image</h3>
                    </div>
                    <button type="button" class="select-image" id="select-profile">Select Image</button>
                </div>

                <div style="display: flex; flex-direction: column; gap: 1.5rem">
                    <div style="padding-top: 1.2rem">
                        <span>First Name <span style="color: c21807; font-weight: 600">*</span></span>
                        <div class="form-group" style="width: 15rem">
                            <input class="form-field" name="first_name" id="first_name" style="border-radius: 6px;" type="text" placeholder="Enter First Name" required>
                        </div>
                    </div>

                    <div>
                        <span>Last Name <span style="color: c21807; font-weight: 600">*</span></span>
                        <div class="form-group" style="width: 15rem">
                            <input class="form-field" name="last_name" id="last_name" style="border-radius: 6px;" type="text" placeholder="Enter Last Name" required>
                        </div>
                    </div>
                </div>
            </div>

            <div style="padding: 1rem 0; border-bottom: 1px solid #91521f">
                <div style="display: flex; gap: .7rem; padding-top: .5rem">
                    <div style="display: flex; flex-direction: column; width: 50%">
                        <span>Username <span style="color: c21807; font-weight: 600">*</span></span>
                        <div class="form-group">
                            <input class="form-field" name="username" id="username" style="border-radius: 6px;" type="text" placeholder="Enter Username" required>
                        </div>
                    </div>

                    <div style="display: flex; flex-direction: column; width: 50%">
                        <span>Role <span style="color: c21807; font-weight: 600">*</span></span>
                        <div class="form-group">
                            <select name="user_role" id="user_role" style="width: 100%; border-radius: 6px; font-size: 14px; line-height: 23px; text-transform: capitalize" required>
                                <option value="" style="font-size: 14px; text-transform: capitalize" selected="true" disabled="disabled">-Select Role-</option>
                                <option value="1" style="font-size: 14px; text-transform: capitalize">Admin</option>
                                <option value="2" style="font-size: 14px; text-transform: capitalize">Inventory Admin</option>
                                <option value="3" style="font-size: 14px; text-transform: capitalize">Cashier</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div style="display: flex; gap: .7rem; padding-top: .5rem">
                    <div style="display: flex; flex-direction: column; width: 50%">
                        <span>New Password <span style="color: c21807; font-weight: 600">*</span></span>
                        <div class="form-group">
                            <input name="password" id="password" class="form-field" style="border-radius: 6px;" type="password" placeholder="Enter New Password" required>
                        </div>
                    </div>

                    <div style="display: flex; flex-direction: column; width: 50%">
                        <span>Confirm Password <span style="color: c21807; font-weight: 600">*</span></span>
                        <div class="form-group">
                            <input class="form-field" id="confirm_password" style="border-radius: 6px;" type="password" placeholder="Enter Confirm Password" required>
                        </div>
                        <div id="wrong_password" style="color: red; display: none;">Password Mismatch</div>
                    </div>
                </div>
            </div>

            <div style="padding: 1rem 0; border-bottom: 1px solid #91521f">
                <div style="display: flex; gap: .7rem; padding-top: .5rem">
                    <div style="display: flex; flex-direction: column; width: 50%">
                        <span>Security Question <span style="color: c21807; font-weight: 600">*</span></span>
                        <div class="form-group">
                            <select name="sc_question" id="sc_question" style="width: 100%; border-radius: 6px; font-size: 14px; line-height: 23px;" required>
                                <option value="" style="font-size: 14px; text-transform: capitalize" selected="true" disabled="disabled">-Select One Question-</option>
                                <?php
                                $sc_question = $conn->query("SELECT * FROM `security_question` WHERE 1");

                                while ($sc = $sc_question->fetch_assoc()) {
                                    echo '
                                <option value="' . $sc["id"] . '" style="font-size: 14px;">' . $sc["list_question"] . '</option>
                                ';
                                }
                                ?>

                            </select>
                        </div>
                    </div>

                    <div style="display: flex; flex-direction: column; width: 50%">
                        <span>Answer <span style="color: c21807; font-weight: 600">*</span></span>
                        <div class="form-group">
                            <input name="answer" id="answer" class="form-field" style="border-radius: 6px;" type="text" placeholder="Enter Answer" required>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal-footer">
            <button type="submit" style="background-color: #0F52BA; color: #f9f9f9; border: none" aria-label="close">Add</button>
            <button type="button" onclick="modalHide('addUserModal')" aria-label="close">Close</button>
        </div>
    </dialog>
</form>
<!-- add-user -->

<!-- change role -->
<form action="change_role-user.php" method="POST">
    <dialog class="modal" id="exchangeUserModal">
        <div class="modal-header">
            <h4 class="modal-title" id="title_role">Change Role</h4>
            <button type="button" onclick="modalHide('exchangeUserModal')" aria-label="close" class="x">❌</button>
        </div>

        <div class="modal-body" style="padding: 2rem 1rem">
            <div style="display: flex; flex-direction: column; width: 100%">
                <span>Role <span style="color: c21807; font-weight: 600">*</span></span>
                <div class="form-group">
                    <input type="hidden" name="user_id" id="user_id">
                    <select name="edit_userrole" id="edit_userrole" style="width: 100%; border-radius: 6px; font-size: 14px; line-height: 23px; text-transform: capitalize">
                        <option value="" style="font-size: 14px; text-transform: capitalize" hidden selected disabled value></option>
                        <option value="1" style="font-size: 14px; text-transform: capitalize">Admin</option>
                        <option value="2" style="font-size: 14px; text-transform: capitalize">Inventory Admin</option>
                        <option value="3" style="font-size: 14px; text-transform: capitalize">Cashier</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="modal-footer">
            <button type="submit" style="background-color: #0F52BA; color: #f9f9f9; border: none" aria-label="close">Save</button>
            <button type="button" onclick="modalHide('exchangeUserModal')" aria-label="close">Cancel</button>
        </div>
    </dialog>
</form>
<!--change role-->

<!-- user-management -->
<!-- archive-user -->
<form action="archive-form-user.php" method="POST">
    <dialog class="modal" id="archiveUserModal">
        <div class="modal-header" style="border: none">
            <h4 class="modal-title" id="modalArchive_title">...</h4>
            <button type="button" onclick="modalHide('archiveUserModal')" aria-label="close" class="x">❌</button>
        </div>

        <div class="modal-body">
            <div class="archive">
                <img src="img/archive.png">
                <input type="hidden" name="Archive_userId" id="Archive_userId">
                <h3>Are you sure you want to archive this user?</h3>
            </div>
        </div>

        <div class="modal-footer">
            <button type="submit" style="background-color: #c21807; color: #f9f9f9; border: none" aria-label="close">Archive</button>
            <button type="button" onclick="modalHide('archiveUserModal')" aria-label="close">Cancel</button>
        </div>
    </dialog>
</form>
<!-- archive-user -->
<!-- user-management -->


<!-- Settings -->
<!-- change-store-logo -->
<form action="change-form-logo.php" method="POST" enctype="multipart/form-data">
    <dialog class="modal" id="changeLogo">
        <div class="modal-header" style="border: none">
            <h4 class="modal-title">Change Store Logo</h4>
            <button type="button" onclick="modalHide('changeLogo')" aria-label="close" class="x">❌</button>
        </div>

        <div style="display: flex; justify-content: center; align-items: center;">
            <div class="upload-image" style="max-width: 430px; ">
                <input name="store_logo" type="file" id="logo" accept="image/*" hidden required>
                <div class="img-area" id="logo-area" style="height: 250px;" data-img="">
                    <div class="icon" style="top: 6rem"><img src="img/upload.png"></div>
                    <h3 class="store-text" style="padding-top: 6rem;">Upload Image</h3>
                </div>
                <button type="button" class="select-image" id="store-image">Select Image</button>
            </div>
        </div>

        <div class="modal-footer">
            <button type="submit" style="background-color: #0F52BA; color: #f9f9f9; border: none" aria-label="close">Save</button>
            <button type="button" onclick="modalHide('changeLogo')" aria-label="close">Cancel</button>
        </div>
    </dialog>
</form>
<!-- change-store-logo -->

<!-- change-login-background -->
<form action="change-form-login-background.php" method="POST" enctype="multipart/form-data">
    <dialog class="modal" id="changeBackground">
        <div class="modal-header" style="border: none">
            <h4 class="modal-title">Change Login Background</h4>
            <button type="button" onclick="modalHide('changeBackground')" aria-label="close" class="x">❌</button>
        </div>

        <div style="display: flex; justify-content: center; align-items: center;">
            <div class="upload-image" style="max-width: 430px; ">
                <input name="bglogin" type="file" id="login" accept="image/*" hidden required>
                <div class="img-area" id="login-area" style="height: 250px;" data-img="">
                    <div class="icon" style="top: 6rem"><img src="img/upload.png"></div>
                    <h3 class="login-text" style="padding-top: 6rem;">Upload Image</h3>
                </div>
                <button type="button" class="select-image" id="login-image">Select Image</button>
            </div>
        </div>

        <div class="modal-footer">
            <button type="submit" style="background-color: #0F52BA; color: #f9f9f9; border: none" aria-label="close">Save</button>
            <button type="button" onclick="modalHide('changeBackground')" aria-label="close">Cancel</button>
        </div>
    </dialog>
</form>
<!-- change-login-background -->

<!-- add-measurement -->
<form action="add-form-measurement.php" method="POST">
    <dialog class="modal" id="addMeasurementModal" style="width: 25rem">
        <div class="modal-header">
            <h4 class="modal-title">Add Measurement</h4>
            <button type="button" onclick="modalHide('addMeasurementModal')" aria-label="close" class="x">❌</button>
        </div>

        <div class="modal-body" style="padding: 1rem 0">
            <div style="display: flex;">
                <div style="display: flex; flex-direction: column; width: 100%">
                    <span>Measurement Name <span style="color: c21807; font-weight: 600">*</span></span>
                    <div class="form-group">
                        <input id="measurement_name" name="measurement_name" class="form-field" style="border-radius: 6px; " type="text" placeholder="Enter Measurement Name" required>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal-footer">
            <button type="submit" style="background-color: #0F52BA; color: #f9f9f9; border: none" aria-label="close">Add</button>
            <button type="button" onclick="modalHide('addMeasurementModal')" aria-label="close">Close</button>
        </div>

    </dialog>
</form>
<!-- add-measurement -->

<!-- edit-measurement -->
<form action="edit-form-measurement.php" method="POST">
    <dialog class="modal" id="editMeasurementModal" style="width: 25rem">
        <div class="modal-header">
            <h4 class="modal-title">Edit Measurement</h4>
            <button type="button" onclick="modalHide('editMeasurementModal')" aria-label="close" class="x">❌</button>
        </div>

        <div class="modal-body" style="padding: 1rem 0">
            <div style="display: flex;">
                <div style="display: flex; flex-direction: column; width: 100%">
                    <input type="hidden" id="editmeasurement_id" name="editmeasurement_id">
                    <span>Measurement Name <span style="color: c21807; font-weight: 600">*</span></span>
                    <div class="form-group">
                        <input id="editmeasurement_name" name="editmeasurement_name" class="form-field" style="border-radius: 6px; " type="text" value="" placeholder="New Measurement Name">
                    </div>
                </div>
            </div>
        </div>

        <div class="modal-footer">
            <button type="submit" style="background-color: #0F52BA; color: #f9f9f9; border: none" aria-label="close">Save</button>
            <button type="button" onclick="modalHide('editMeasurementModal')" aria-label="close">Close</button>
        </div>
    </dialog>
</form>
<!-- edit-measurement -->

<!-- archive-measurement -->
<form action="archive-form-measurement.php" method="POST">
    <dialog class="modal" id="archiveMeasurementModal">
        <div class="modal-header" style="border: none">
            <h4 class="modal-title" id="Archivemeasurement_title">...</h4>
            <button type="button" onclick="modalHide('archiveMeasurementModal')" aria-label="close" class="x">❌</button>
        </div>

        <div class="modal-body">
            <div class="archive">
                <img src="img/archive.png">
                <h3>Are you sure you want to archive this measurement?</h3>
                <input type="hidden" name="archivemeasurement_id" id="archivemeasurement_id">
            </div>
        </div>

        <div class="modal-footer">
            <button type="submit" style="background-color: #c21807; color: #f9f9f9; border: none" aria-label="close">Archive</button>
            <button type="button" onclick="modalHide('archiveMeasurementModal')" aria-label="close">Cancel</button>
        </div>

    </dialog>
</form>
<!-- archive-measurement -->

<!-- restore-ingredient -->
<form action="restore-form-ingredients.php" method="POST">
    <dialog class="modal" id="restoreIngredientModal">
        <div class="modal-header" style="border: none">
            <h4 class="modal-title">Chicharon Bulaklak</h4>
            <button type="button" onclick="modalHide('restoreIngredientModal')" aria-label="close" class="x">❌</button>
        </div>

        <div class="modal-body">
            <div class="restore">
                <img src="img/restore.png">
                <h3>Are you sure you want to restore this item?</h3>
                <input type="hidden" name="archiveIngredients_id" id="archiveIngredients_id">
            </div>
        </div>

        <div class="modal-footer">
            <button type="submit" style="background-color: #009dff; color: #ffffff; border: none" aria-label="close">Restore</button>
            <button type="button" onclick="modalHide('restoreIngredientModal')" aria-label="close">Cancel</button>
        </div>

    </dialog>
</form>
<!-- restore-ingredient -->

<!-- restore-batch -->
 <form action="restore-form-batch.php" method="POST">
<dialog class="modal" id="restoreBatchModal">
        <div class="modal-header" style="border: none">
            <h4 class="modal-title" id="restoreBatch_title">Batch ID: 00000000</h4>
            <button type="button" onclick="modalHide('restoreBatchModal')" aria-label="close" class="x">❌</button>
        </div>
        
        <div class="modal-body">
            <div class="restore">
                <img src="img/restore.png">
                <h3>Are you sure you want to restore this batch?</h3>
                <input type="hidden" id="restore_batch_id" name="restore_batch_id">
                <input type="hidden" id="restore_stock_id" name="restore_stock_id">
            </div>
        </div>
        
        <div class="modal-footer">
            <button type="submit" style="background-color: #009dff; color: #ffffff; border: none" aria-label="close">Restore</button>
            <button type="button" onclick="modalHide('restoreBatchModal')" aria-label="close">Cancel</button>
        </div>
        
    </dialog>
    </form>
<!-- restore-batch -->

<!-- restore-product -->
<form action="restore-form-product.php" method="POST">
    <dialog class="modal" id="restoreProductModal">
        <div class="modal-header" style="border: none">
            <h4 class="modal-title" id="Restoreproduct_title">...</h4>
            <button type="button" onclick="modalHide('restoreProductModal')" aria-label="close" class="x">❌</button>
        </div>

        <div class="modal-body">
            <div class="restore">
                <img src="img/restore.png">
                <h3>Are you sure you want to restore this product?</h3>
                <input type="hidden" name="archiveproduct_id" id="archiveproduct_id">
            </div>
        </div>

        <div class="modal-footer">
            <button type="submit" style="background-color: #009dff; color: #ffffff; border: none" aria-label="close">Restore</button>
            <button type="button" onclick="modalHide('restoreProductModal')" aria-label="close">Cancel</button>
        </div>

    </dialog>
</form>
<!-- restore-product -->

<!-- restore-user -->
<form action="restore-form-users.php" method="POST">
    <dialog class="modal" id="restoreUserModal">
        <div class="modal-header" style="border: none">
            <h4 class="modal-title" id="restoreuser_title">...</h4>
            <button type="button" onclick="modalHide('restoreUserModal')" aria-label="close" class="x">❌</button>
        </div>

        <div class="modal-body">
            <div class="restore">
                <img src="img/restore.png">
                <h3>Are you sure you want to restore this user?</h3>
                <input type="hidden" id="restoreuser_id" name="restoreuser_id">
            </div>
        </div>

        <div class="modal-footer">
            <button type="submit" style="background-color: #009dff; color: #ffffff; border: none" aria-label="close">Restore</button>
            <button type="button" onclick="modalHide('restoreUserModal')" aria-label="close">Cancel</button>
        </div>
</form>

</dialog>
<!-- restore-user -->

<!-- restore-category -->
<form action="restore-form-category.php" method="POST">
    <dialog class="modal" id="restoreCategoryModal">
        <div class="modal-header" style="border: none">
            <h4 class="modal-title" id="restoreArchive_title">...</h4>
            <button type="button" onclick="modalHide('restoreCategoryModal')" aria-label="close" class="x">❌</button>
        </div>

        <div class="modal-body">
            <div class="restore">
                <img src="img/restore.png">
                <h3>Are you sure you want to restore this category?</h3>
                <input type="hidden" name="restorecategory_id" id="restorecategory_id">
                <input type="hidden" name="restorecategory_name" id="restorecategory_name">
            </div>
        </div>

        <div class="modal-footer">
            <button type="submit" style="background-color: #009dff; color: #ffffff; border: none" aria-label="close">Restore</button>
            <button type="button" onclick="modalHide('restoreCategoryModal')" aria-label="close">Cancel</button>
        </div>

    </dialog>
</form>
<!-- restore-category -->

<!-- restore-measurement -->
<form action="restore-form-measurement.php" method="POST">
    <dialog class="modal" id="restoreMeasurementModal">
        <div class="modal-header" style="border: none">
            <h4 class="modal-title" id="restore_measurement_title">...</h4>
            <button type="button" onclick="modalHide('restoreMeasurementModal')" aria-label="close" class="x">❌</button>
        </div>

        <div class="modal-body">
            <div class="restore">
                <img src="img/restore.png">
                <h3>Are you sure you want to restore this measurement?</h3>
                <input type="hidden" id="restoremeasurement_id" name="restoremeasurement_id">
            </div>
        </div>

        <div class="modal-footer">
            <button type="submit" style="background-color: #009dff; color: #ffffff; border: none" aria-label="close">Restore</button>
            <button type="button" onclick="modalHide('restoreMeasurementModal')" aria-label="close">Cancel</button>
        </div>

    </dialog>
</form>
<!-- restore-measurement -->
<!-- Settings -->

<!-- Account -->
<!-- change-profile -->
<form action="change-form-profile-picture.php" method="POST" enctype="multipart/form-data">
    <dialog class="modal" id="changeProfile" method="POST" enctype="multipart/form-data">
        <div class="modal-header" style="border: none">
            <h4 class="modal-title">Change Profile Picture</h4>
            <button type="button" onclick="modalHide('changeProfile')" aria-label="close" class="x">❌</button>
        </div>

        <div style="display: flex; justify-content: center; align-items: center;">
            <div class="upload-image" style="max-width: 430px; ">
                <input name="profile_picture" type="file" id="account-profile" accept="image/*" hidden required>
                <div class="img-area" id="account-profile-area" style="height: 250px;" data-img="">
                    <div class="icon" style="top: 6rem"><img src="img/upload.png"></div>
                    <h3 class="account-text" style="padding-top: 6rem;">Upload Image</h3>
                </div>
                <button class="select-image" id="account-profile-image">Select Image</button>
            </div>
        </div>

        <div class="modal-footer">
            <button type="submit" style="background-color: #0F52BA; color: #f9f9f9; border: none" aria-label="close">Save</button>
            <button type="button" onclick="modalHide('changeProfile')" aria-label="close">Cancel</button>
        </div>
    </dialog>
</form>
<!-- change-profile -->
<!-- Account -->



<!-- logout -->
<form action="logout.php" method="POST">
    <dialog class="modal" id="logoutModal" style="width: 30rem">
        <div class="modal-header" style="border: none">
            <h4 class="modal-title"></h4>
            <button type="button" onclick="modalHide('logoutModal')" aria-label="close" class="x">❌</button>
        </div>

        <div class="modal-body">
            <div class="archive">
                <img src="img/logout.png">
                <h3>Are you sure you want to logout?</h3>
            </div>
        </div>

        <div class="modal-footer">
            <button type="submit" style="background-color: #c21807; color: #f9f9f9; border: none" aria-label="close">Logout</button>
            <button type="button" onclick="modalHide('logoutModal')" aria-label="close">Cancel</button>
        </div>
    </dialog>
</form>
<!-- logout -->