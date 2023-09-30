import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

window.Echo.private(`App.Models.User.${userId}`)
    .notification((data) => {
        // alert(data.body);
        // let counter = document.getElementById('newNotifications');
        // counter.textContent = parseInt(counter.textContent) + 1;

        // let notificationsList = document.getElementById('#notificationsList');
        // let notificationsItem = document.createElement('li');
        // notificationsItem.className = 'notifications-not-read';
        // notificationsItem.style.backgroundColor = '#C6FAF9';

        // notificationsItem.innerHTML =`
        //     <a href="${data.url}">
        //         <span class="notification-icon">
        //             <i class="icon-material-outline-group"></i>
        //         </span>
        //         <span class="notification-text">
        //             <strong>*</strong>
        //             '${data.body}'
        //         </span>
        //     </a>
        //     `;

        // notificationsList.appendChild(notificationsItem);

        let count = Number($('#newNotifications').text());
        count++;
        $('#newNotifications').text(count);

        $('#notificationsList').prepend(
            `<li class="notifications-not-read" style = "background-color: #C6FAF9">
                <a href="${data.url}?notify_id=${data.id}">
                    <span class="notification-icon">
                        <i class="icon-material-outline-group"></i>
                    </span>
                    <span class="notification-text">
                        <strong>*</strong>
                        ${data.body}
                    </span>
                </a>
            </li >`
        )
    })

window.Echo.join(`messages.${userId}`)
    .listen('.message.created', function (data) {
        $('#messagesList').append(
            `<div class="message-bubble me">
                <div class="message-bubble-inner">
                    <div class="message-avatar"><img src="${data.user_image}" alt="" /></div>
                    <div class="message-text"><p>${data.message.message}</p></div>
                </div>
                <div class="clearfix"></div>
            </div>`
        )
    })
