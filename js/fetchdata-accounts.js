function displayaccounts(page, src){
    src = src !== undefined ? src : $("#search").val();
    $.ajax({
        url: "./ajax/fetch-accounts.php",
        type: 'get',
        dataType: "json",
        data: {
            request: 'accounts',
            page: page,
            search: src
        },
        success: function (result) {
            var table = $('#user_table tbody');
            table.html('');
            var user_count = (page * 10) - 9;

            if (result.data && result.data.length > 0) {

            for(let account of result.data){
                let role = '';

                if(account.role == 1){
                    role = `<span style="background-color: lightblue; color: #000; padding: .3rem .5rem; border-radius: .3rem">Admin</span>`
                }else if(account.role == 2){
                    role = `<span style="background-color: #76a004; color: #fff; padding: .3rem .5rem; border-radius: .3rem">Inv. Admin</span>`
                }else if(account.role == 3){
                    role = `<span style="background-color: #fec400; color: #000; padding: .3rem .5rem; border-radius: .3rem">Cashier</span>`
                }

            table.append(`
                <tr>
                    <td>${user_count}</td>
                    <td><span><img src="./upload/user_dp/user_${account.id}.png">${account.first_name} ${account.last_name}</span></td>
                    <td>${account.user_name}</td>
                    <td>${role}</td>
                    <td>
                        <button class="uil uil-exchange-alt change-btn" onclick="setchangerole(${account.id}, ${account.role},'${account.first_name}', '${account.last_name}');modalShow('exchangeUserModal')"></button>
                        <button class="uil uil-archive archive-btn" onclick="archiveAccount(${account.id}, '${account.first_name}', '${account.last_name}');modalShow('archiveUserModal')"></button>
                    </td>
                </tr>
                `);
                user_count++;
        }
    }else{
          // If no data, show "No Result" message
          table.append(`
            <tr>
                <td colspan="5" class="text-center" style="height: 200px; vertical-align: middle">No Result</td>
            </tr>
        `);
    }
        
        let totalData = result.data_count; // Example value
        let page_count = (totalData % 10 > 0) ? Math.floor(totalData / 10) + 1 : totalData / 10;
        paginate($("#user_pagination"), page_count, page, 'displayaccounts');
    }
    });
}

function setchangerole(userId, userRole, fname, lname){
    $('#user_id').val(userId)
    $('#edit_userrole').val(userRole)
    $('#title_role').html('Change Role '+fname+' '+lname)
}

function archiveAccount(userId, fname, lname){
    $('#modalArchive_title').html(fname+' '+lname);
    $('#Archive_userId').val(userId)
}

// Function to validate the passwords
function validatePasswords() {
    var password = document.getElementById('password').value;
    var confirmPassword = document.getElementById('confirm_password').value;
    var errorMessage = document.getElementById('wrong_password');
    
    if (password !== confirmPassword) {
        // Show the error message if passwords do not match
        errorMessage.style.display = 'block';
        return false;  // Prevent form submission
    } else {
        // Hide the error message if passwords match
        errorMessage.style.display = 'none';
        return true;  // Allow form submission
    }
}


$(document).ready(function(){
    displayaccounts(1);
});

$("#search").on("input", function () {
    displayaccounts(1, $(this).val());
})
