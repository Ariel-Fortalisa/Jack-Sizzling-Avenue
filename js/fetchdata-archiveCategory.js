function displayCategory(page, src) {
    src = src !== undefined ? src : $("#search").val();
    $.ajax({
        url: "./ajax/fetch-archiveCategory.php",
        type: 'get',
        dataType: "json",
        data: {
            request: 'category',
            page: page,
            search: src
        },
        success: function (result) {
            var table = $("#archiveCategory-tbl tbody");
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
                            <button class="uil uil-history restore-btn" onclick="setDetails(${category.id}, 'restore');modalShow('restoreCategoryModal')"></button>
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
            paginate($("#archivecategory_pagination"), page_count, page, 'displayCategory');
        }
    });
}


function setDetails(id, action) {
    $.ajax({
        url: "./ajax/fetch-archiveCategory.php",
        type: 'get',
        dataType: "json",
        data: {
            request: 'category',
            id: id
        },
        success: function (result) {
            var ct = result.data[0];

        if(action === 'restore'){
            $('#restoreArchive_title').html(ct.category_name);
            $('#restorecategory_id').val(ct.id);
            $('#restorecategory_name').val(ct.category_name);
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