$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
})

$("#submit-product").submit(function(e){
    e.preventDefault();
    const data = {
        "product_code" : $("#product-code").val(),
        "product_name" : $("#product-name").val(),
        "description"   : $("#description").val(),
        "type"   : $("#product-type").val(),
        "amount" : $("#amount").val(),
        "quantity" : $("#quantity").val(),
    }
    var formData = new FormData();
    formData.append('image', document.getElementById('image').files[0])
    formData.append("data", JSON.stringify(data))
    $.ajax({
        url: 'sales/add', //web.php
        data: formData, // values
        processData: false,
        contentType: false,
        method: "POST", //post
        async: false,
        success: function (response) {
            Toast.fire({
                icon: 'success',
                title: response.message
            }) //alert
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

$(".edit-product").click(function(){
    const details = $(this).data('details')
    $("#edit-product-code").val(details.product_code),
    $("#edit-product-code").data('id', details.product_id),
    $("#edit-product-name").val(details.product_name),
    $("#edit-description").val(details.description),
    $("#edit-amount").val(details.amount),
    $("#edit-quantity").val(details.quantity),
    $("#attach-image").html(`<img src="storage/${details.image}" alt="no available image" id="product-image" width="25%"><hr>`)
    $("#edit-product").modal('show')
})

$("#edit-product").submit(function(e){
    e.preventDefault();
    const data = {
        "product_code" : $("#edit-product-code").val(),
        "product_name" : $("#edit-product-name").val(),
        "description"   : $("#edit-description").val(),
        "amount" : $("#edit-amount").val(),
        "quantity" : $("#edit-quantity").val(),
    }
    const id = $("#edit-product-code").data('id')
    var formData = new FormData();
    formData.append('image', document.getElementById('edit-image').files[0])
    formData.append("data", JSON.stringify(data))
    formData.append('id', id)
    $.ajax({
        url: 'sales/edit',
        data: formData,
        processData: false,
        contentType: false,
        method: "POST",
        async: false,
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
                title: e.message
            })
        }
    })
})

$(".delete-product").click(function(){
    const id = $(this).data('id')
    $("#proceed-delete").data('pk', id)
    $("#delete-product").modal('show')
})

$("#proceed-delete").click(function(e){
    const id = $(this).data('pk')
    $.post('/sales/delete', {id})
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