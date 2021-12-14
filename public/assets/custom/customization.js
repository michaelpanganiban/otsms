$("#submit-custom").submit(function(e){
    e.preventDefault()
    var formData = new FormData();
    const data = {
        garment_type : $("#garment-type").val(),
        pickup_date : $("#custom-pickup-date").val(),
        downpayment: 0,
        details: $(".summernote").val().trim()
    }

    formData.append("data", JSON.stringify(data))
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
    $("#status-edit").val(details.status)
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
    const user_type = $(".view-custom").data('usertype')
    let data = {}
    if(user_type == 0){
        data = {
            garment_type : $("#garment-type-edit").val(),
            pickup_date : $("#custom-pickup-date-edit").val(),
            downpayment: $("#custom-downpayment-edit").val(),
            details: $(".desc-edit").val().trim()
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
    formData.append('design', document.getElementById('design-edit').files[0])
    formData.append("id", id)
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