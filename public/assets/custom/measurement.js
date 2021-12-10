$("#submit-measurement").submit(function(e){
    e.preventDefault()
    const data = {
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
    $.post('/measurement/add', {data})
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