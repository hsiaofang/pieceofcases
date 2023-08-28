export default function unreadNotificationFunc(notifications) {
    return notifications?.filter(n => n.isRead === false);
};