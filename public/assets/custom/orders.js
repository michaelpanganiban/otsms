$(".view-order").click(function(e){
    const details = $(this).data('details')
    const type = $("#submit-order-edit").data('type')
    $("#ref-no").html(details.reference_id)
    $("#order-status").val(details.status)
    $("#pickup-date").val(details.pickup_date)
    $("#return-date").val(details.return_date)
    $("#additional_fee").val(details.addtional_fee)
    $("#downpayment").val(details.downpayment_amount)
    $("#product-image").attr('src', `/uploads/${details.product_sale.image}`)
    $("#product-description").html(details.product_sale.description)
    $("#code").html(`<b>Product Code: </b>${details.product_sale.product_code}`)
    $("#price").html(`<b>Price: </b>${parseFloat(details.product_sale.amount).toFixed(2)}`)
    $("#product-name-desc").html(`<b>Product Name: </b>${details.product_sale.product_name}`)
    $("#type").html(`<b>For </b> <label style="color: blue;">${details.product_sale.type}</label>`)
    $("#submit-order-edit").data('pk', details.order_id)
    $("#submit-order-edit").data('ref', details.reference_id)
    $("#submit-order-edit").data('email', details.user.email)
    $("#submit-order-edit").data('customer_id', details.user.id)
    $("#submit-order-edit").data('first_name', details.user.first_name)
    $("#submit-order-edit").data('contact_no', details.user.contact_no)
    $("#submit-order-edit").data('product', details.product_sale.product_name)
    $("#submit-order-edit").data('product-type', details.product_sale.type)
    if(details.receipt != '' && details.receipt != null)
        $("#download-file").html(`<a href='../storage/${details.receipt}' download style='color: white;' ><u>Download Receipt</u></a>`)
    else
        $("#download-file").html('')
    if(details.status === 'Cancelled'){
        $(".processing").hide()
        $(".cancel-order-btn").hide()
        $(".submit-order-btn").hide()
    }
    else if(details.status !== 'Pending' && type == 0){
        $(".submit-order-btn").hide()
        $(".processing").show()
        $(".cancel-order-btn").hide()
    }
    else if(details.status === 'Pending' && type == 0){
        $(".cancel-order-btn").show()
        $(".submit-order-btn").show()
        $(".processing").hide()
        $(".cancel-order-btn").data('pk', details.order_id)
        $(".cancel-order-btn").data('ref', details.reference_id)
    }
    else{
        $(".submit-order-btn").show()
        $(".processing").hide()
        $(".cancel-order-btn").hide()
    }
    if(details.product_sale.type !== 'Rent'){
        $(".hideUs").attr('hidden', true)
    }
    else{
        $(".hideUs").removeAttr('hidden')
    }
    if($("#downpayment").data('usertype') != 0)
        $("#downpayment").attr('disabled', true)
    else if(details.downpayment_amount == 0 || details.downpayment_amount == null)
        $("#downpayment").removeAttr('disabled')
    else
        $("#downpayment").attr('disabled', true)
    
    $(".view-measurement").attr('href', `/measurement?id=${details.user_id}`)
    $("#view-order").modal('show')
})

$("#submit-order-edit").submit(function(e){
    e.preventDefault()
    waitingDialog.show('Please wait...', {dialogSize: 'md', progressType: 'info'});
    $("#submit-order-edit").attr('disabled', 'disabled')
    const type = $(this).data('type')
    const product_type = $(this).data('product-type')
    const id = $(this).data('pk')
    const email = $(this).data('email')
    const first_name = $(this).data('first_name')
    const customer_id = $(this).data('customer_id')
    const contact_no = $(this).data('contact_no')
    const product = $(this).data('product')
    const ref = $(this).data('ref')
    var formData = new FormData();
    let async_type = true;
    let data = {}
    if(type == 0){
        async_type = false;
        data = {
            "pickup_date" : $("#pickup-date").val(),
            "downpayment_amount" : $("#downpayment").val()
        }
        formData.append('payment', document.getElementById('payment').files[0])
    }
    else{
        async_type = true;
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
    formData.append("customer_id", customer_id)
    formData.append("ref", ref)
    formData.append("email", email)
    formData.append("first_name", first_name)
    formData.append("contact_no", contact_no)
    formData.append("product", product)
    formData.append("pick_date", $("#pickup-date").val())
    $.ajax({
        url: 'orders/edit',
        data: formData,
        processData: false,
        contentType: false,
        method: "POST",
        async: async_type,
        success: function (response) {
            waitingDialog.hide();
            $("#submit-order-edit").removeAttr('disabled')
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
            $("#submit-order-edit").removeAttr('disabled')
            console.log('error: ', e);
            waitingDialog.hide();
            Toast.fire({
                icon: 'error',
                title: 'An error occured. Please try again.'
            })
        }
    })
    waitingDialog.hide();

})

$(".delete-order").click(function(e){
    const id = $(this).data('id')
    const ref = $(this).data('ref')
    $("#proceed-delete-order").data('pk', id)
    $("#proceed-delete-order").data('ref', ref)
    $("#delete-order").modal('show')
})

$("#proceed-delete-order").click(function(e){
    const order_id = $(this).data('pk')
    const ref = $(this).data('ref')
    $.post('/orders/cancel', {order_id, ref})
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
        console.log(xhr);
        Toast.fire({
            icon: 'error',
            title: xhr.statusText
        })
    });
    // $.post('/orders/delete', {id})
    // .done( function(msg) { 
    //     Toast.fire({
    //         icon: 'success',
    //         title: msg.message
    //     })
    //     setTimeout(() => {
    //         location.reload()
    //     }, 1500)
    //  })
    // .fail( function(xhr, textStatus, errorThrown) {
    //     Toast.fire({
    //         icon: 'error',
    //         title: xhr.responseText.message
    //     })
    // });
})

$("#order-btn").click(function(e){
    const id = $("#customer").val()
    window.location = `/?id=${btoa(id)}`
})

$(".cancel-order-btn").click(function(e){
    const order_id = $(this).data('pk');
    const ref = $(this).data('ref')
    $("#proceed-cancel-order").data('pk', order_id)
    $("#proceed-cancel-order").data('ref', ref)
    $("#cancel-order-modal").modal('show')
})

$("#proceed-cancel-order").click(function(e){
    const order_id = $(this).data('pk');
    const ref = $(this).data('ref');
    $.post('/orders/cancel', {order_id, ref})
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
        console.log(xhr);
        Toast.fire({
            icon: 'error',
            title: xhr.statusText
        })
    });
})

$(".pay-order").click(function(e){
    $("#paypal-button-container").attr('hidden', 'true')
    $("#show-error").attr('hidden', 'true')
    $("#amount-to-pay").val(0)
    const details = $(this).data('details')
    $("#item-price").val(details.product_sale.amount)
    console.log('details: ', details)
    paypal.Buttons({
        style: {
            layout: 'vertical',
            color:  'gold',
            shape:  'rect',
            label:  'paypal',
        },
        createOrder: function(data, actions) {
            // Set up the transaction
            return actions.order.create({
              purchase_units: [{
                amount: {
                  value: $("#amount-to-pay").val(),
                  currency_code: 'PHP',
                },
              }],
              application_context: { shipping_preference: "NO_SHIPPING", }
            });
        },
        onApprove: function(data, actions) {
            return actions.order.capture().then(async function(payment_details) {
                console.log('payment_details: ', payment_details)
                const amount = {downpayment_amount: $("#amount-to-pay").val()}
                await $.post('/orders/update-payment', {id: details.order_id, amount }, function(r){

                })
                $("#payer-id").html(payment_details.payer.payer_id)
                $("#merchant-id").html(payment_details.purchase_units[0].payee.merchant_id)
                $("#transaction-id").html(payment_details.id)
                $("#order-id").html(details.order_id)
                $("#payment-date").html(payment_details.create_time)
                $("#status").html(payment_details.status)

                $("#product-name").html(details.product_sale.product_name)
                $("#product-code").html(details.product_sale.product_code)
                $("#product-desc").html(details.product_sale.description)
                $(".subtotal").html('PHP ' + $("#amount-to-pay").val())
                $("#pay-order-modal").modal('hide')
                $("#pay-receipt-modal").modal({
                    backdrop: 'static',
                    keyboard: false,
                    show: true
                })
            })
        }
    }).render('#paypal-button-container');
    $("#pay-order-modal").modal({
        backdrop: 'static',
        keyboard: false,
        show: true
    })
    // $("#pay-receipt-modal").modal({
    //     backdrop: 'static',
    //     keyboard: false,
    //     show: true
    // })
})

$("#amount-to-pay").keyup(function(e){
    console.log($(this).val())
    if(parseFloat($(this).val()) <= 0 || $(this).val() == ""){
        $("#paypal-button-container").attr('hidden', 'true')
        $("#show-error").removeAttr('hidden')
    }
    else if(parseFloat($("#item-price").val()) < parseFloat($(this).val())){
        $("#paypal-button-container").attr('hidden', 'true')
        $("#show-error").removeAttr('hidden')
    }
    else {
        $("#paypal-button-container").removeAttr('hidden')
        $("#show-error").attr('hidden', 'true')
    }
})