import axios from "axios";

// 後端給的網址
const API_URL =
    "http://localhost/Full-Stack-Project/server/public/index.php/api/chat";

class Chat {
    // 取得與該對象聊天訊息
    getMessage(currentUserId, chatUserId) {
        return axios.get(API_URL + '/getMessage', {
            params: {
                currentUserId, chatUserId
            }
        })
    }

    // 取得所有聊過天的使用者資訊
    getChatOtherUser(currentUserId) {
        return axios.get(API_URL + '/getChatOtherUser', {
            params: {
                currentUserId
            }
        })
    }

    // 將訊息儲存後端
    sendMessage(fromID, toID, message, image) {
        return axios.post(API_URL + '/sendMessage', {
            fromID, toID, message, image
        })
    }
}

export default new Chat();
