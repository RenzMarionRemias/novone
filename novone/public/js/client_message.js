
$('#clientSendMessage').on('submit',function(e){

    e.preventDefault(); 
    var clientId = $('.clientId').val();
    console.log(clientId)
    console.log($('#clientMessage').val())
    $.ajax({
        url: '/novone/public/api/message/send',
        type: 'POST',
        dataType: 'json',
        data:{
            sender: clientId,
            senderType:'CLIENT',
            message:$('#clientMessage').val()
        },
        success: function (data) {
            $('#clientMessage').val('')
            getMessages()
        }
    })
    
})


function getMessages(){

    var clientId = $('.clientId').val();
    $('#clientConversation').empty();
    $('#clientMessageCount').empty();
    $('#clientMessageList').empty();
    $.ajax({
        url: '/novone/public/api/message/get?userId=' + clientId,
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            if(data.length > 0 ){
                $('#clientMessageCount').append(data.length)
                var notifMessage = '<b>' + data[data.length-1].sender_name + '</b><br/>';
                    notifMessage += '' + data[data.length-1].message + '<br/>';
                    notifMessage += '<i>' + data[data.length-1].created_at + '</i>';
                $('#clientMessageList').attr('style','padding-left:24px;')
                $('#clientMessageList').append(notifMessage)
                data.map(function(e){
                    var msgTemplate = '<div class="col-xs-12 col-sm-12 col-md-12">';
                    msgTemplate += '<h4><b>'+e.sender_name+'</b></h4>'
                    msgTemplate += e.message
                    msgTemplate += '</div>';
    
                    $('#clientConversation').append(msgTemplate);
                })
            }


        }
    })

}

getMessages()