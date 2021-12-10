$("#add-employee-submit").submit(function(e){
    e.preventDefault()
    const data = {
        "first_name" : $("#employee-first_name").val(),
        "middle_name" : $("#employee-middle_name").val(),
        "last_name" : $("#employee-last_name").val(),
        "email" : $("#employee-email").val(),
        "contact_no" : $("#employee-contact_no").val(),
        "birthday" : $("#employee-birthday").val(),
        "user_type": $("#employee-user_type").val(),
        "salary" : $("#employee-salary").val(),
        "password_changed" : 0
    }
    $.post('/employee/add', {data})
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

$(document).on('click', '.edit-employee', function(e){
    const details = $(this).data('details')
    $("#edit-employee-first_name").val(details.first_name)
    $("#edit-employee-middle_name").val(details.middle_name)
    $("#edit-employee-last_name").val(details.last_name)
    $("#edit-employee-email").val(details.email)
    $("#edit-employee-contact_no").val(details.contact_no)
    $("#edit-employee-birthday").val(details.birthday)
    $("#edit-employee-user_type").val(details.user_type)
    $("#edit-employee-salary").val(details.salary)
    $("#edit-employee-status").val(details.status)
    $("#edit-employee-submit").data('pk', details.id)
    $("#edit-employee").modal('show')
})


$("#edit-employee-submit").submit(function(e){
    e.preventDefault()
    const data = {
        "first_name" : $("#edit-employee-first_name").val(),
        "middle_name" : $("#edit-employee-middle_name").val(),
        "last_name" : $("#edit-employee-last_name").val(),
        "email" : $("#edit-employee-email").val(),
        "contact_no" : $("#edit-employee-contact_no").val(),
        "birthday" : $("#edit-employee-birthday").val(),
        "user_type" : $("#edit-employee-user_type").val(),
        "status" : $("#edit-employee-status").val(),
        "salary" : $("#edit-employee-salary").val(),
    }
    const id = $(this).data('pk')
    $.post('/employee/edit', {data, id})
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

$(document).on('click', '.delete-employee', function(e){
    const id = $(this).data('id')
    $("#proceed-delete-employee").data('pk', id)
    $("#delete-employee").modal('show')
})

$("#proceed-delete-employee").click(function(e){
    const id = $(this).data('pk')
    $.post('/employee/delete', {id})
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

let monday_off = 0;
let tuesday_off = 0;
let wednesday_off = 0;
let thursday_off = 0;
let friday_off = 0;
let saturday_off = 0;
let sunday_off = 0;
let id
let ids = []
$(document).on('click', '.schedule-employee', function(e){
    id = $(this).data('id')
    $.post('/schedule/get', {id})
    .done( function(result) { 
        if(result.length == 0){
            Toast.fire({
                icon: 'info',
                title: "No schedule added yet. Please create now."
            })
            $("#monday-from").removeAttr('disabled')
            $("#monday-to").removeAttr('disabled')
            $(`#monday-off`).removeAttr('checked')

            $("#tuesday-from").removeAttr('disabled')
            $("#tuesday-to").removeAttr('disabled')
            $(`#tuesday-off`).removeAttr('checked')

            $("#wednesday-from").removeAttr('disabled')
            $("#wednesday-to").removeAttr('disabled')
            $(`#wednesday-off`).removeAttr('checked')

            $("#thursday-from").removeAttr('disabled')
            $("#thursday-to").removeAttr('disabled')
            $(`#thursday-off`).removeAttr('checked')

            $("#friday-from").removeAttr('disabled')
            $("#friday-to").removeAttr('disabled')
            $(`#friday-off`).removeAttr('checked')

            $("#saturday-from").removeAttr('disabled')
            $("#saturday-to").removeAttr('disabled')
            $(`#saturday-off`).removeAttr('checked')

            $("#sunday-from").removeAttr('disabled')
            $("#sunday-to").removeAttr('disabled')
            $(`#sunday-off`).removeAttr('checked')

            $("#monday-from").val('')
            $("#monday-to").val('')

            $("#tuesday-from").val('')
            $("#tuesday-to").val('')

            $("#wednesday-from").val('')
            $("#wednesday-to").val('')

            $("#thursday-from").val('')
            $("#thursday-to").val('')

            $("#friday-from").val('')
            $("#friday-to").val('')

            $("#saturday-from").val('')
            $("#saturday-to").val('')

            $("#sunday-from").val('')
            $("#sunday-to").val('')
        }
        else{
            result.map(x => {
                const day = x.day.toLowerCase()
                if(x.off_duty == 1){
                    $(`#${day}-from`).val('')
                    $(`#${day}-to`).val('')
                    $(`#${day}-from`).attr('disabled', true)
                    $(`#${day}-to`).attr('disabled', true)
                    $(`#${day}-off`).attr('checked', 'checked')
                }
                else{
                    $(`#${day}-from`).removeAttr('disabled')
                    $(`#${day}-to`).removeAttr('disabled')
                    $(`#${day}-off`).removeAttr('checked')
                    $(`#${day}-from`).val(x.time_from)
                    $(`#${day}-to`).val(x.time_to)
                    ids.push(x.schedule_id)
                }
            })
        }
     })
    .fail( function(xhr, textStatus, errorThrown) {
        Toast.fire({
            icon: 'info',
            title: "No schedule added yet. Please create now."
        })
    });
    $("#schedule-modal").data('pk', id)
    $("#schedule-modal").modal('show')
})

// schedule
$("#monday-off").change(function(e){
    if($(this).is(':checked')){
        $("#monday-from").val('')
        $("#monday-to").val('')
        $("#monday-from").attr('disabled', true)
        $("#monday-to").attr('disabled', true)
        monday_off = 1
    }
    else{
        monday_off = 0
        $("#monday-from").removeAttr('disabled')
        $("#monday-to").removeAttr('disabled')
    }
})

$("#tuesday-off").change(function(e){
    if($(this).is(':checked')){
        $("#tuesday-from").val('')
        $("#tuesday-to").val('')
        $("#tuesday-from").attr('disabled', true)
        $("#tuesday-to").attr('disabled', true)
        tuesday_off = 1
    }
    else{
        tuesday_off = 0
        $("#tuesday-from").removeAttr('disabled')
        $("#tuesday-to").removeAttr('disabled')
    }
})

$("#wednesday-off").change(function(e){
    if($(this).is(':checked')){
        $("#wednesday-from").val('')
        $("#wednesday-to").val('')
        $("#wednesday-from").attr('disabled', true)
        $("#wednesday-to").attr('disabled', true)
        wednesday_off = 1
    }
    else{
        wednesday_off = 0
        $("#wednesday-from").removeAttr('disabled')
        $("#wednesday-to").removeAttr('disabled')
    }
})

$("#thursday-off").change(function(e){
    if($(this).is(':checked')){
        $("#thursday-from").val('')
        $("#thursday-to").val('')
        $("#thursday-from").attr('disabled', true)
        $("#thursday-to").attr('disabled', true)
        thursday_off = 1
    }
    else{
        thursday_off = 0
        $("#thursday-from").removeAttr('disabled')
        $("#thursday-to").removeAttr('disabled')
    }
})

$("#friday-off").change(function(e){
    if($(this).is(':checked')){
        $("#friday-from").val('')
        $("#friday-to").val('')
        $("#friday-from").attr('disabled', true)
        $("#friday-to").attr('disabled', true)
        friday_off = 1
    }
    else{
        friday_off = 0
        $("#friday-from").removeAttr('disabled')
        $("#friday-to").removeAttr('disabled')
    }
})

$("#saturday-off").change(function(e){
    if($(this).is(':checked')){
        $("#saturday-from").val('')
        $("#saturday-to").val('')
        $("#saturday-from").attr('disabled', true)
        $("#saturday-to").attr('disabled', true)
        saturday_off = 1
    }
    else{
        saturday_off = 0
        $("#saturday-from").removeAttr('disabled')
        $("#saturday-to").removeAttr('disabled')
    }
})

$("#sunday-off").change(function(e){
    if($(this).is(':checked')){
        $("#sunday-from").val('')
        $("#sunday-to").val('')
        $("#sunday-from").attr('disabled', true)
        $("#sunday-to").attr('disabled', true)
        sunday_off = 1
    }
    else{
        sunday_off = 0
        $("#sunday-from").removeAttr('disabled')
        $("#sunday-to").removeAttr('disabled')
    }
})

const getData = () => {
    return 
}

$("#submit-schedule").click(function(e){
    e.preventDefault()
    const temp = [
            {
                "day" : "Monday",
                "time_from" : $("#monday-from").val(),
                "time_to" : $("#monday-to").val(),
                "off_duty" : monday_off,
                "user_id" : id
            },
            {
                "day" : "Tuesday",
                "time_from" : $("#tuesday-from").val(),
                "time_to" : $("#tuesday-to").val(),
                "off_duty" : tuesday_off,
                "user_id" : id
            },
            {
                "day" : "Wednesday",
                "time_from" : $("#wednesday-from").val(),
                "time_to" : $("#wednesday-to").val(),
                "off_duty" : wednesday_off,
                "user_id" : id
            },
            {
                "day" : "Thursday",
                "time_from" : $("#thursday-from").val(),
                "time_to" : $("#thursday-to").val(),
                "off_duty" : thursday_off,
                "user_id" : id
            },
            {
                "day" : "Friday",
                "time_from" : $("#friday-from").val(),
                "time_to" : $("#friday-to").val(),
                "off_duty" : friday_off,
                "user_id" : id
            },
            {
                "day" : "Saturday",
                "time_from" : $("#saturday-from").val(),
                "time_to" : $("#saturday-to").val(),
                "off_duty" : saturday_off,
                "user_id" : id
            },
            {
                "day" : "Sunday",
                "time_from" : $("#sunday-from").val(),
                "time_to" : $("#sunday-to").val(),
                "off_duty" : sunday_off,
                "user_id" : id
            },
        ]
    $.post("/schedule/add", {data: temp})
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
