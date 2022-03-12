$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
$("#update-profile").submit(function(e){
    e.preventDefault()
    const data = {
        "first_name" : $("#first_name").val(),
        "middle_name" : $("#middle_name").val(),
        "last_name" : $("#last_name").val(),
        "email" : $("#email").val(),
        "contact_no" : $("#contact_no").val(),
        "birthday" : $("#birthday").val(),
    }
    const id = $(this).data('pk')
    $.post('/profile/update', {data, id})
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

$("#change-password").submit(function(e){
    e.preventDefault()
    const new_password = $("#current_password").val()
    const confirm = $("#confirm_password").val()
    const id = $(this).data('pk')
    if(new_password != confirm){
        Toast.fire({
            icon: 'error',
            title: "Password do not match!"
        })
    }
    else{
        $.post('/profile/changePassword', {id, new_password})
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
    }
})

$(".view-product").click(function(e){
    const details = $(this).data('details')
    $("#product-image").attr('src', `/storage/${details.image}`)
    $("#product-description").html(details.description)
    $("#code").html(`<b>Product Code: </b>${details.product_code}`)
    $("#price").html(`<b>Price: </b>${parseFloat(details.amount).toFixed(2)}`)
    $("#quantity").html(`<b>Available Stocks: </b>${details.quantity}`)
    $("#type").html(`<b>For </b>${details.type}`)
    $(".add-to-order").data('pk', details.product_id)
    $("#view-product").modal('show')
})

$("#submit-order").click(function(e){
    const size = $('input[name="size"]:checked').val();
    const product_id = $(this).data('productid')
    let user_id = $(this).data('pk')
    if(size === undefined){
        Toast.fire({
            icon: 'error',
            title: "Please choose the size of the product."
        })
    }
    else{
        if(user_id !== undefined)
            user_id = atob(user_id)
        const data = {
            size,
            product_id,
            user_id
        }
        $.post('/orders/add', {data})
        .done( function(msg) { 
            console.log(msg)
            Toast.fire({
                icon: 'success',
                title: msg.message
            })
            $("#view-product").modal('hide')
        })
        .fail( function(xhr, textStatus, errorThrown) {
            Toast.fire({
                icon: 'error',
                title: xhr.responseText
            })
        });
        $("#view-sizes").modal('hide')
    }
})

$(".add-to-order").click(function(e){
    const data = {
        product_id : $(this).data('pk'),
        user_id : atob($("#customer-id").data('pk'))
    }
    $.post('/orders/add', {data})
    .done( function(msg) { 
        console.log(msg)
        Toast.fire({
            icon: 'success',
            title: msg.message
        })
        $("#view-product").modal('hide')
    })
    .fail( function(xhr, textStatus, errorThrown) {
        Toast.fire({
            icon: 'error',
            title: xhr.responseText
        })
    });
})

// $("#sms").click(function(e){
//     $.post('/orders/edit', function(r){
//         alert(r)
//     })
// })

$("#search-btn").click(function(e){
    const filter = $("#filter").val()
    const search = $("#search").val()
    window.location = `/?filter=${filter}&search=${search}`;
});