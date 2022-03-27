$("#submit-custom").submit(function(e){
    e.preventDefault()
    var formData = new FormData();
    const classification = $('input[name="classification"]:checked').val();
    const data = {
        garment_type : $("#garment-type").val(),
        pickup_date : $("#custom-pickup-date").val(),
        downpayment: 0,
        details: $(".summernote").val().trim(),
        classification
    }
    const measurement = {
        shoulder_length : $("#shoulder").val(),
        sleeve_length : $("#sleeve").val(),
        bust_chest : $("#bust-chest").val(),
        waist : $("#waist").val(),
        skirt_length : $("#skirt").val(),
        slack_length : $("#slacks-length").val(),
        slack_front_rise : $("#slacks-front-rise").val(),
        slack_fit_seat : $("#fit-seat").val(),
        slack_fit_thigh : $("#fit-thigh").val(),
    }

    formData.append("data", JSON.stringify(data))
    formData.append("measurement", JSON.stringify(measurement))
    formData.append('design', document.getElementById('design').files[0])
    $.ajax({
        url: 'customize/add',
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
                title: e.message
            })
        }
    })
})

$(".garment-type-cls").change(function(e){
    if($(this).val() === 'Jersey'){
        $(".for-jersey").removeAttr('hidden')
        $(".not-jersey").attr('hidden', 'true')
    }
    else{
        $(".for-jersey").attr('hidden', 'true')
        $(".not-jersey").removeAttr('hidden')
    }
})

$(".view-custom").click(function(e){
    const details = $(this).data('details')
    
    const user_type = $(this).data('usertype')
    $("#custom-image").attr('src', '../uploads/'+details.design)
    $("#ref-no").html(details.reference_id)
    $("#garment-type-edit").val(details.garment_type)
    $("#garment-type-edit").data('pk', details.custom_id)
    $("#custom-pickup-date-edit").val(details.pickup_date)
    $("#custom-downpayment-edit").val(details.downpayment)
    $("#custom-price-edit").val(details.price)
    $(".desc-edit").summernote('code',details.details)
    $("#fullpayment-edit").val(details.fullpayment ? details.fullpayment : 0)
    $("#status-edit").val(details.c_status)
  
    $("#edit-shoulder").val(details.shoulder_length)
    $("#edit-sleeve").val(details.sleeve_length)
    $("#edit-bust-chest").val(details.bust_chest)
    $("#edit-waist").val(details.waist)
    $("#edit-skirt").val(details.skirt_length)
    $("#edit-slacks-length").val(details.slack_length)
    $("#edit-slacks-front-rise").val(details.slack_front_rise)
    $("#edit-fit-seat").val(details.slack_fit_seat)
    $("#edit-fit-thigh").val(details.slack_fit_thigh)
    $("#garment-type-edit").data('m_id', details.measurement_id)
    $("#tailor").val(details.tailor_id)
    console.log(details)
    $("#submit-custom-edit").data('ref', details.reference_id)
    $("#submit-custom-edit").data('email', details.email)
    $("#submit-custom-edit").data('customer_id', details.user_id)
    $("#submit-custom-edit").data('first_name', details.first_name)
    $("#submit-custom-edit").data('contact_no', details.contact_no)
    if(details.price > 0){
        $("#proof-edit").removeAttr('disabled')
        $("#custom-downpayment-edit").removeAttr('disabled')
    }
    else{
        $("#proof-edit").attr('disabled', true)
        $("#custom-downpayment-edit").attr('disabled', true)
    }
    if(details.classification == 'Both'){
        $("#both").attr('checked', 'checked');
        $(".upper").removeAttr('hidden')
        $(".upper").removeAttr('hidden')
    }
    else if(details.classification == 'Upper Cloth'){
        $("#upper").attr('checked', 'checked');
        $(".upper").removeAttr('hidden')
        $(".lower").attr('hidden', true)
    }
    else if(details.classification == 'Lower Cloth'){
        $("#lower").attr('checked', 'checked');
        $(".lower").removeAttr('hidden')
        $(".upper").attr('hidden', true)
    }
    else {
        $("#both").removeAttr('checked');
        $("#upper").removeAttr('checked');
        $("#lower").removeAttr('checked');
    }
    console.log(details.proof_of_payment);
    if(details.garment_type === 'Jersey'){
        $(".for-jersey").removeAttr('hidden')
        $(".not-jersey").attr('hidden', 'true')
    }
    else{
        $(".for-jersey").attr('hidden', 'true')
        $(".not-jersey").removeAttr('hidden')
    }
    if(user_type != 0)
        $('.desc-edit').next().find(".note-editable").attr("contenteditable", false);
    else
        $('.desc-edit').next().find(".note-editable").attr("contenteditable", true);
    if(details.proof_of_payment != '' && details.proof_of_payment != null)
        $("#download-file-custom").html(`<a href='../uploads/${details.proof_of_payment}' download style='color: white;' ><u>Download Receipt</u></a>`)
    else
        $("#download-file-custom").html('')
    if($("#custom-downpayment-edit").data('usertype') != 0)
        $("#custom-downpayment-edit").attr('disabled', true)
    else if((details.downpayment == 0 || details.downpayment == null) && details.price > 0)
        $("#custom-downpayment-edit").removeAttr('disabled')
    else
        $("#custom-downpayment-edit").attr('disabled', true)
    $("#view-custom").modal('show')
})

$("#submit-custom-edit").submit(function(e){
    e.preventDefault()
    var formData = new FormData();
    const id = $("#garment-type-edit").data('pk')
    const measurement_id = $("#garment-type-edit").data('m_id')
    const user_type = $(".view-custom").data('usertype')
    const classification = $('input[name="classification-edit"]:checked').val();
    let data = {}
    let measurement = {}
    if(user_type == 0){
        data = {
            garment_type : $("#garment-type-edit").val(),
            pickup_date : $("#custom-pickup-date-edit").val(),
            downpayment: $("#custom-downpayment-edit").val(),
            details: $(".desc-edit").val().trim(),
            classification
        }
        measurement = {
            shoulder_length : $("#edit-shoulder").val(),
            sleeve_length : $("#edit-sleeve").val(),
            bust_chest : $("#edit-bust-chest").val(),
            waist : $("#edit-waist").val(),
            skirt_length : $("#edit-skirt").val(),
            slack_length : $("#edit-slacks-length").val(),
            slack_front_rise : $("#edit-slacks-front-rise").val(),
            slack_fit_seat : $("#edit-fit-seat").val(),
            slack_fit_thigh : $("#edit-fit-thigh").val(),
        }
    }
    else{
        $('input[name="classification-edit"]').attr('disabled', 'disabled')
        data = {
            status : $("#status-edit").val(),
            fullpayment : $("#fullpayment-edit").val(),
            price: $("#custom-price-edit").val(),
            tailor_id: $("#tailor").val()
        }
    }
    formData.append("data", JSON.stringify(data))
    formData.append("measurement", JSON.stringify(measurement))
    formData.append('design', document.getElementById('design-edit').files[0])
    formData.append('proof', document.getElementById('proof-edit').files[0])
    formData.append("id", id)
    formData.append("pick_date", $("#custom-pickup-date-edit").val())
    formData.append("measurement_id", measurement_id)
    formData.append("reference_id", $("#submit-custom-edit").data('ref'))
    formData.append("email", $("#submit-custom-edit").data('email'))
    formData.append("first_name", $("#submit-custom-edit").data('first_name'))
    formData.append("contact_no", $("#submit-custom-edit").data('contact_no'))
    formData.append("customer_id", $("#submit-custom-edit").data('customer_id'))

    $.ajax({
        url: 'customize/edit',
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
            console.log(response)
            Toast.fire({
                icon: 'error',
                title: e.message
            })
        }
    }) 
})

$(".delete-custom").click(function(e){
    const id = $(this).data('id')
    const ref = $(this).data('ref')
    $("#proceed-delete-custom").data('pk', id)
    $("#proceed-delete-custom").data('ref', ref)
    $("#delete-custom").modal('show')
})

$("#proceed-delete-custom").click(function(e){
    const id = $(this).data('pk');
    const ref = $(this).data('ref');
    $.post('/customize/cancel', {id, ref})
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

// $("#proceed-delete-custom").click(function(e){
//     const id = $(this).data('pk')
//     $.post('/customize/delete', {id})
//     .done( function(msg) { 
//         Toast.fire({
//             icon: 'success',
//             title: msg.message
//         })
//         setTimeout(() => {
//             location.reload()
//         }, 1500)
//      })
//     .fail( function(xhr, textStatus, errorThrown) {
//         Toast.fire({
//             icon: 'error',
//             title: xhr.responseText.message
//         })
//     });
// })

$(".pay-custom").click(function(e){
    $("#paypal-button-container").attr('hidden', 'true')
    $("#show-error").attr('hidden', 'true')
    $("#amount-to-pay-custom").val(0)
    const details = $(this).data('details')
    console.log('details: ', details)
    $("#item-price-custom").val(details.price)
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
                  value: $("#amount-to-pay-custom").val(),
                  currency_code: 'PHP',
                },
              }],
              application_context: { shipping_preference: "NO_SHIPPING", }
            });
        },
        onApprove: function(data, actions) {
            return actions.order.capture().then(async function(payment_details) {
                console.log('payment_details: ', payment_details)
                const amount = {downpayment:$("#amount-to-pay-custom").val()}
                await $.post('/customize/update-payment', {id: details.custom_id, amount }, function(r){})
                $("#payer-id").html(payment_details.payer.payer_id)
                $("#merchant-id").html(payment_details.purchase_units[0].payee.merchant_id)
                $("#transaction-id").html(payment_details.id)
                $("#order-id").html(details.custom_id)
                $("#payment-date").html(payment_details.create_time)
                $("#status").html(payment_details.status)

                $("#product-name").html(details.garment_type)
                $("#product-code").html('')
                $(".subtotal").html('PHP ' + $("#amount-to-pay-custom").val())
                $("#pay-order-modal").modal('hide')
                $("#pay-receipt-modal").modal({
                    backdrop: 'static',
                    keyboard: false,
                    show: true
                })
            })
        }
    }).render('#paypal-button-container');
    $("#pay-custom-modal").modal({
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

$("#amount-to-pay-custom").keyup(function(e){
    console.log($(this).val())
    if(parseFloat($(this).val()) <= 0 || $(this).val() == ""){
        $("#paypal-button-container").attr('hidden', 'true')
        $("#show-error").removeAttr('hidden')
    }
    else if(parseFloat($("#item-price-custom").val()) < parseFloat($(this).val())){
        $("#paypal-button-container").attr('hidden', 'true')
        $("#show-error").removeAttr('hidden')
    }
    else {
        $("#paypal-button-container").removeAttr('hidden')
        $("#show-error").attr('hidden', 'true')
    }
})

$(".classification").click(function(e){
    const value = $(this).val()
    if(value == 'Upper Cloth'){
        $(".upper").removeAttr('hidden')
        $(".lower").attr('hidden', true)
    }
    else if(value == 'Both'){
        $(".upper").removeAttr('hidden')
        $(".lower").removeAttr('hidden')
    }
    else {
        $(".lower").removeAttr('hidden')
        $(".upper").attr('hidden', true)
    }
})