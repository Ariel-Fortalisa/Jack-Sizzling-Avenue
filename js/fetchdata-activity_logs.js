function displayActivity(page) {
    $.ajax({
        url: "./ajax/fetch-activity_log.php",
        type: 'get',
        dataType: "json",
        data: {
            request: 'activity',
            page: page,
            
        },
        success: function (result) {
            var list = $("#list_activity");
            list.html('');
            let logID = '';
            let role = '';
            if (result.data && result.data.length > 0) {

            for (let logs of result.data) {

                //for log id
                if(logs.id < 10){
                    logID = `00${logs.id}`
                }else if(logs.id < 100){
                    logID = `0${logs.id}`
                }else{
                    logID = `${logs.id}`
                }

                // for user_role
                if (logs.user_role == 1){
                    role = 'Admin';
                } else if (logs.user_role == 2){
                    role = 'Inv. Admin';
                }else{
                    role = 'Cashier';
                }     

                

                const date = new Date(`${logs.date}`);
                let hours = date.getHours();
                let minutes = date.getMinutes().toString().padStart(2, '0');
                let meridiem = hours >= 12 ? 'PM' : 'AM';

                // Convert to 12-hour format
                hours = hours % 12 || 12;

                const formattedDate = date.toLocaleDateString('en-US', {
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric',
                });

                const currentTime = `${hours}:${minutes} ${meridiem}`;
             
                list.append(`
                       <li style="border-bottom: 2px solid #e0d4cc;">
                                    <p style="padding: .7rem 0; font-weight: 600; color: #91521f;">
                                        Log ID ${logID}
                                    </p>

                                    <p style="padding-left: 1.5rem">
                                       ${logs.activity}
                                    </p>

                                    <div style="display: flex; justify-content: space-between; font-size: .9rem; padding-top: .7rem">
                                        <div>
                                            <p>Username: ${logs.username}</p>
                                        </div>

                                        <div>
                                            <p>${formattedDate}</p>
                                        </div>
                                    </div>

                                    <div style="display: flex; justify-content: space-between; font-size: .9rem;">
                                        <div>
                                            <p>Role: ${role}</p>
                                        </div>

                                        <div>
                                            <p>${currentTime}</p>
                                        </div>
                                    </div>
                                </li>
                `);
            }
        }else{
            list.append(`
                   <tr>
                    <td colspan="4" class="text-center" style="height: 200px; vertical-align: middle">No Result</td>
                  </tr>
                `);
        }

            let totalData = result.data_count; // Example value
            let page_count = (totalData % 10 > 0) ? Math.floor(totalData / 10) + 1 : totalData / 10;
            paginate($("#activity_pagination"), page_count, page, 'displayActivity');
        }
    });
}

$(document).ready(function(){
    displayActivity(1)
})

