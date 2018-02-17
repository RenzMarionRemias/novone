$('#adminMessageSubmit')
    .on('submit', function (e) {

        e.preventDefault();
        var clientId = $('.currentClientId').val(),
            adminId = $('.adminId').val();

        $.ajax({
            url: '/public/api/message/send',
            type: 'POST',
            dataType: 'json',
            data: {
                sender: adminId,
                recipient: clientId,
                senderType: 'ADMIN',
                message: $('#adminMessage').val()
            },
            success: function (data) {
                console.log(data)
                $('#adminMessage').val('')
                getMessages()
            }
        })
    })
function getMessages() {

    var clientId = $('.currentClientId').val();
    $('#adminMessageThread').empty();
    $.ajax({
        url: '/public/api/message/get?userId=' + clientId,
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            if (data.length > 0) {

                data
                    .map(function (e) {
                        var msgTemplate = '<div class="col-xs-12 col-sm-12 col-md-12 alert alert-success">';
                        msgTemplate += '<h4>' + e.sender_name + '</h4>'
                        msgTemplate += e.message + '<br/>';
                        msgTemplate += '<i>' + e.created_at + '</i>';
                        msgTemplate += '</div>';

                        $('#adminMessageThread').append(msgTemplate);
                    })
            }

        }
    })

} 