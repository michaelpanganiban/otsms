$("#submit-custom").submit(function(e){
    e.preventDefault()
    var formData = new FormData();
    const data = {
        garment_type : $("#garment-type").val(),
        pickup_date : $("#custom-pickup-date").val(),
        downpayment: 0,
        details: $(".summernote").val().trim()
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
    $("#custom-image").attr('src', '../storage/'+details.proof_of_payment)
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

    $("#submit-custom-edit").data('ref', details.reference_id)
    $("#submit-custom-edit").data('email', details.email)
    $("#submit-custom-edit").data('customer_id', details.user_id)
    $("#submit-custom-edit").data('first_name', details.first_name)
    $("#submit-custom-edit").data('contact_no', details.contact_no)

    console.log(details);
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
    $("#view-custom").modal('show')
})

$("#submit-custom-edit").submit(function(e){
    e.preventDefault()
    var formData = new FormData();
    const id = $("#garment-type-edit").data('pk')
    const measurement_id = $("#garment-type-edit").data('m_id')
    const user_type = $(".view-custom").data('usertype')
    let data = {}
    let measurement = {}
    if(user_type == 0){
        data = {
            garment_type : $("#garment-type-edit").val(),
            pickup_date : $("#custom-pickup-date-edit").val(),
            downpayment: $("#custom-downpayment-edit").val(),
            details: $(".desc-edit").val().trim()
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
        data = {
            status : $("#status-edit").val(),
            fullpayment : $("#fullpayment-edit").val(),
            price: $("#custom-price-edit").val()
        }
    }
    formData.append("data", JSON.stringify(data))
    formData.append("measurement", JSON.stringify(measurement))
    formData.append('design', document.getElementById('design-edit').files[0])
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
    $("#proceed-delete-custom").data('pk', id)
    $("#delete-custom").modal('show')
})

$("#proceed-delete-custom").click(function(e){
    const id = $(this).data('pk')
    $.post('/customize/delete', {id})
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