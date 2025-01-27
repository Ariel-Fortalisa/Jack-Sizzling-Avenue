function setuserdetails(page, src){
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
            
        }
    })

}