function displayCategory(page, src) {
    src = src !== undefined ? src : $("#search").val();
    $.ajax({
        url: "./ajax/fetch-category.php",
        type: 'get',
        dataType: "json",
        data: {
            request: 'category',
            page: page,
            search: src
        },
        success: function (result) {
            var table = $("#category_table tbody");
            table.html('');
            let categoryCount = (page * 10) - 9;

            if (result.data && result.data.length > 0) {

            for (let category of result.data) {
                let category_result = (category.add_ons == 1) ? "<span style='background-color: #76a004; color: #fff; padding: .3rem .5rem; border-radius: .3rem'>Yes</span>" : "<span style='background-color: #fec400; color: #000; padding: .3rem .5rem; border-radius: .3rem'> No</span>";
                table.append(`
                    <tr>
                        <td>${categoryCount}</td>
                        <td>${category.category_name}</td>
                        <td>${category_result}</td>
                        <td>
                            <button onclick="setDetails(${category.id}, 'edit')" class="uil uil-edit"></button>
                            <button onclick="setDetails(${category.id}, 'archive')" class="uil uil-archive"></button>
                        </td>
                    </tr>
                `);
                categoryCount++;
            }
        }else{
            table.append(`
                   <tr>
                    <td colspan="4" class="text-center" style="height: 200px; vertical-align: middle">No Result</td>
                  </tr>
                `);
        }

            let totalData = result.data_count; // Example value
            let page_count = (totalData % 10 > 0) ? Math.floor(totalData / 10) + 1 : totalData / 10;
            paginate($("#category_pagination"), page_count, page, 'displayCategory');
        }
    });
}


function setDetails(id, action) {
    $.ajax({
        url: "./ajax/fetch-category.php",
        type: 'get',
        dataType: "json",
        data: {
            request: 'category',
            id: id
        },
        success: function (result) {
            var ct = result.data[0];
            var selectedAddons = ct.add_ons == 1 ? '1' : '0';

            if(action === 'edit'){

            // Edit category
            $('#editcategory_name').val(ct.category_name);
            $('#editcategory_id').val(ct.id);

            var addonsDropdown = `
                <select name="editcategory_addons" class="unit-measure" style="width: 100%; border-radius: 6px; font-size: 14px; line-height: 23px;" required>
                    <option value="1" ${selectedAddons === '1' ? 'selected' : ''}>Yes</option>
                    <option value="0" ${selectedAddons === '0' ? 'selected' : ''}>No</option>
                </select>
            `;

            $('#dropdown').find('.unit-measure').remove(); 
            $('#dropdown').append(addonsDropdown);

            modalShow('editCategoryModal');

            }else if(action === 'archive'){

            //archive status
            $('#archivemodal_title').html(ct.category_name);
            $('#archivecategory_id').val(ct.id);
            $('#archivecategory_name').val(ct.category_name);
            modalShow('archiveCategoryModal')
            }
        }
    });
            
}




$(document).ready(function () {
    displayCategory(1);

    $("#search").on('keyup', function() {
        displayCategory(1, $(this).val());
    });

});