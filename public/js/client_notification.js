function getNotification() {

    var clientId = $('.clientId').val();

    $.ajax({
        url: '/novone/public/api/notification/' + clientId,
        type: 'GET',
        dataType: 'json',
        success: function (data) {

            $('#clientNotificationCount').append(data.length);
            data.map(function (e) {
                var notifTemplate = '<li id="item_notification_1">';
                notifTemplate += '<div class="media">';
                notifTemplate += '<div class="media-body">';
                notifTemplate += '<div class="exclusaoNotificacao">';
                notifTemplate += ' ';
                notifTemplate += ' </div>';
                notifTemplate += '   <h4 class="media-heading">' + e.notif_type + '</h4>';
                notifTemplate += '     <p>' + e.message + '</p>';
                notifTemplate += '  </div>';
                notifTemplate += '  </div>';
                notifTemplate += '  </li>';

                $('#notificationList').append(notifTemplate)
            })

        }
    })
}

getNotification();