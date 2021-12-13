$("#submit-pm").submit(function(e){
    e.preventDefault()
    const data = {
        method_name : $("#method-name").val(),
        bank_name: $("#bank-name").val(),
        account_no: $("#account-number").val(),
        account_name: $("#account-name").val()
    }

    $.ajax({
        url: 'paymentMethods/add',
        data,
        method: "POST",
        success: function (response) {
            Toast.fire({
                icon: 'success',
                title: response.message
            })
            setTimeout(() => {
                location.reload()
            }, 1500)
        },
        error: function(e){
            Toast.fire({
                icon: 'error',
                title: JSON.stringify(e.responseText)
            })
        }
    })  
})

$(".edit-pm").click(function(){
    const details = $(this).data('details')
    $("#edit-method-name").data('id', details.method_id),
    $("#edit-method-name").val(details.method_name),
    $("#edit-bank-name").val(details.bank_name),
    $("#edit-account-number").val(details.account_no),
    $("#edit-account-name").val(details.account_name),
    $("#edit-method").modal('show')
})

$("#edit-pm-submit").submit(function(e){
    e.preventDefault();
    const data = {
        method_name : $("#edit-method-name").val(),
        bank_name: $("#edit-bank-name").val(),
        account_no: $("#edit-account-number").val(),
        account_name: $("#edit-account-name").val()
    }
    const id = $("#edit-method-name").data('id')
    $.post('paymentMethods/edit', {data, id})
    .done( function(msg) { 
        Toast.fire({
            icon: 'success',
            title: msg.message
        })
        setTimeout(() => {
            location.reload()
        }, 1500)
     })
    .fail( function(xhr, textStatus, errorThrown) {
        Toast.fire({
            icon: 'error',
            title: xhr.responseText
        })
    });
})

$(".delete-pm").click(function(){
    const id = $(this).data('id')
    $("#proceed-delete-pm").data('pk', id)
    $("#delete-pm").modal('show')
})

$("#proceed-delete-pm").click(function(e){
    const id = $(this).data('pk')
    $.post('/paymentMethods/delete', {id})
    .done( function(msg) { 
        Toast.fire({
            icon: 'success',
            title: msg.message
        })
        setTimeout(() => {
            location.reload()
        }, 1500)
     })
    .fail( function(xhr, textStatus, errorThrown) {
        Toast.fire({
            icon: 'error',
            title: xhr.responseText
        })
    });
})