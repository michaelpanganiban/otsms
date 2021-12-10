$(".view-order").click(function(e){
    const details = $(this).data('details')
    const type = $("#submit-order").data('type')
    $("#ref-no").html(details.reference_id)
    $("#order-status").val(details.status)
    $("#pickup-date").val(details.pickup_date)
    $("#return-date").val(details.return_date)
    $("#additional_fee").val(details.addtional_fee)
    $("#downpayment").val(details.downpayment_amount)
    $("#product-image").attr('src', `/storage/${details.product_sale.image}`)
    $("#product-description").html(details.product_sale.description)
    $("#code").html(`<b>Product Code: </b>${details.product_sale.product_code}`)
    $("#price").html(`<b>Price: </b>${parseFloat(details.product_sale.amount).toFixed(2)}`)
    $("#product-name-desc").html(`<b>Product Name: </b>${details.product_sale.product_name}`)
    $("#type").html(`<b>For </b> <label style="color: blue;">${details.product_sale.type}</label>`)
    $("#submit-order").data('pk', details.order_id)
    $("#submit-order").data('product-type', details.product_sale.type)
    if(details.receipt != '' && details.receipt != null)
        $("#download-file").html(`<a href='../storage/${details.receipt}' download style='color: white;' ><u>Download Receipt</u></a>`)
    else
        $("#download-file").html('')

    if(details.status !== 'Pending' && type == 0){
        $(".submit-order-btn").hide()
        $(".processing").show()
    }
    else{
        $(".submit-order-btn").show()
        $(".processing").hide()
    }
    if(details.product_sale.type !== 'Rent'){
        $(".hideUs").attr('hidden', true)
    }
    else{
        $(".hideUs").removeAttr('hidden')
    }

    $(".view-measurement").attr('href', `/measurement?id=${details.user_id}`)
    $("#view-order").modal('show')
})

$("#submit-order").submit(function(e){
    e.preventDefault()
    const type = $(this).data('type')
    const product_type = $(this).data('product-type')
    const id = $(this).data('pk')
    var formData = new FormData();
    let data = {}
    if(type == 0){
        data = {
            "pickup_date" : $("#pickup-date").val(),
            "downpayment_amount" : $("#downpayment").val()
        }
        formData.append('payment', document.getElementById('payment').files[0])
    }
    else{
        if(product_type == 'Rent'){
            data = {
                "status" : $("#order-status").val(),
                "return_date" : $("#return-date").val(),
                "addtional_fee" : $("#additional_fee").val() == '' ? 0 : $("#additional_fee").val()
            }
        }
        else{
            data = {
                "status" : $("#order-status").val(),
            }
        }
    }
    formData.append("data", JSON.stringify(data))
    formData.append("id", id)
    $.ajax({
        url: 'orders/edit',
        data: formData,
        processData: false,
        contentType: false,
        method: "POST",
        async: false,
        success: function (response) {
            console.log(response)
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
                title: e.message.errorInfo[3]
            })
        }
    })
})

$(".delete-order").click(function(e){
    const id = $(this).data('id')
    $("#proceed-delete-order").data('pk', id)
    $("#delete-order").modal('show')
})

$("#proceed-delete-order").click(function(e){
    const id = $(this).data('pk')
    $.post('/orders/delete', {id})
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
            title: xhr.responseText.message
        })
    });
})

$("#order-btn").click(function(e){
    const id = $("#customer").val()
    window.location = `/?id=${btoa(id)}`
})