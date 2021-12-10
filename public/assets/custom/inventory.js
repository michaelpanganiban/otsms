$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
})

$("#submit-item").submit(function(e){
    e.preventDefault();
    const data = {
        "item_name" : $("#item-name").val(),
        "description"   : $("#description").val(),
        "price" : $("#amount").val(),
        "quantity" : $("#quantity").val(),
    }
    $.ajax({
        url: 'inventory/add',
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

$(".edit-item").click(function(){
    const details = $(this).data('details')
    $("#edit-item-name").data('id', details.item_id),
    $("#edit-item-name").val(details.item_name),
    $("#edit-description").val(details.description),
    $("#edit-amount").val(details.price),
    $("#edit-quantity").val(details.quantity),
    $("#edit-status").val(details.status),
    $("#edit-item").modal('show')
})

$("#edit-item-submit").submit(function(e){
    e.preventDefault();
    const data = {
        "item_name" : $("#edit-item-name").val(),
        "description"   : $("#edit-description").val(),
        "price" : $("#edit-amount").val(),
        "quantity" : $("#edit-quantity").val(),
        "status": $("#edit-status").val()
    }
    const id = $("#edit-item-name").data('id')
    $.post('/inventory/edit', {data, id})
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

$(".delete-item").click(function(){
    const id = $(this).data('id')
    $("#proceed-delete-item").data('pk', id)
    $("#delete-item").modal('show')
})

$("#proceed-delete-item").click(function(e){
    const id = $(this).data('pk')
    $.post('/inventory/delete', {id})
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

$(".stock-in").click(function(e){
    const current = $(this).data('quantity')
    const id = $(this).data('id')
    $("#current-quantity").val(current)
    $("#current-quantity").data('pk', id)
    $("#stock-in-model").modal('show')
})

$(document).on('submit', '#stock-in-submit', function(e){
    e.preventDefault()
    const current = $("#current-quantity").val()
    const id = $("#current-quantity").data('pk')
    const stock_in = $("#stock-in-quantity").val()
    if(stock_in <= 0){
        Toast.fire({
            icon: 'error',
            title: "Invalid quantity to stock in!"
        })
    }
    else{
        const data = {
            "quantity" : parseFloat(current) + parseFloat(stock_in)
        }
        $.post('inventory/stockIn', {data, id})
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

$(".stock-out").click(function(e){
    const current = $(this).data('quantity')
    const id = $(this).data('id')
    $("#current-quantity-out").val(current)
    $("#current-quantity-out").data('pk', id)
    $("#stock-out-model").modal('show')
})

$(document).on('submit', '#stock-out-submit', function(e){
    e.preventDefault()
    const current = $("#current-quantity-out").val()
    const id = $("#current-quantity-out").data('pk')
    const stock_out = $("#stock-out-quantity").val()
    if(parseFloat(stock_out) > parseFloat(current)){
        Toast.fire({
            icon: 'error',
            title: "Invalid quantity to stock out!"
        })
    }
    else{
        const data = {
            "quantity" : parseFloat(current) - parseFloat(stock_out)
        }
        $.post('inventory/stockIn', {data, id})
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