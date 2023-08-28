import "./chatRoom.css"
import React, { useCallback, useContext, useState, useRef, useEffect } from "react"
import User from "../components/chatRoom_component/user/User"
import Message from "../components/chatRoom_component/message/Message"
import Chat from "../axios/Chat"
import { GlobelDate } from "../App"
import { io } from "socket.io-client"
import unreadNotificationFunc from "../components/chatRoom_component/notification/unreadNotificationFunc"

function ChatRoom() {
    const [conversations, setConversations] = useState([]);
    const [currentChat, setCurrentChat] = useState(null);
    const [messages, setMessages] = useState([]);
    const [newMessage, setNewMessage] = useState(null);
    const [arrivalMessage, setArrivalMessage] = useState(null);
    const [onlineUsers, setOnlineUsers] = useState([]);
    const [messageSend, setMessageSend] = useState([]);
    const [socket, setSocket] = useState(null);
    const scrollRef = useRef();
    const messageRef = useRef(null);
    const buttonRef = useRef(null);
    const { notifications, setNotifications, chatChatUser } = useContext(GlobelDate);
    const currentUserID = JSON.parse(localStorage.getItem("userID"));
    const unreadNotification = unreadNotificationFunc(notifications);

    // #region Socket.io
    // * Socket.io 連線
    useEffect(() => {
        const newSocket = io("http://localhost:4000");
        setSocket(newSocket);

        return () => {
            newSocket.disconnect();
        }
    }, [currentUserID]);

    // * 取得上線用戶
    useEffect(() => {
        if (socket === null) return;
        socket.emit("addUser", currentUserID);
        socket.on("getUsers", (users) => {
            setOnlineUsers(users);
        })
    }, [socket]);

    // * 取得對方傳來的訊息(透過socket.io)
    useEffect(() => {
        if (socket === null) return;
        socket.on("getMessage", data => {
            setArrivalMessage({
                fromID: data.senderId,
                message: data.text,
            })
            console.log("getMessage", data);

        })

        socket.on("getNotification", data => {
            const isChatOpen = currentChat?.userID === data.senderId;

            if (isChatOpen) {
                setNotifications(prev => [{ ...data, isRead: true }, ...prev]);
            } else {
                setNotifications(prev => [data, ...prev]);
            }
        })

        return () => {
            socket.off("getMessage");
            socket.off("getNotification");
        };
    }, [socket, currentChat]);
    // #endregion

    // 將從對方取得的訊息存到 messages 陣列中
    useEffect(() => {
        if (arrivalMessage && arrivalMessage.fromID === currentChat?.userID) {
            setMessages((prev) => [...prev, arrivalMessage])
        }
    }, [arrivalMessage, currentChat]);

    // 畫面一掛載時，將當前使用者ID傳入，並取得其他已聊過的人員資訊
    useEffect(() => {
        Chat.getChatOtherUser(currentUserID)
            .then((res) => {
                setConversations(res['data']);
            })
            .catch((err) => {
                console.error(err);
            });
    }, [currentUserID, messageSend]);

    useEffect(() => {
        if (!chatChatUser) {
            return;
        } else {
            buttonRef.current?.addEventListener('onClick', setCurrentChat(chatChatUser));
            if (currentChat) buttonRef.current?.click();
        }
    }, [conversations]);

    // 得到兩人之間的歷史訊息
    useEffect(() => {
        if (currentChat !== null) {
            Chat.getMessage(currentUserID, currentChat.userID)
                .then((res) => {
                    setMessages(res['data']);
                })
                .catch((err) => {
                    console.error(err);
                });
        }
    }, [currentChat, currentUserID]);

    const handleKeyup = (e) => {
        if (e.keyCode === 13) {
            handleSubmit();
        }
    }

    // 按下 Send 傳送訊息
    const handleSubmit = (e) => {
        messageRef.current.value = '';

        Chat.sendMessage(currentUserID, currentChat.userID, newMessage, null)
            .then((res) => {
                setMessages([...messages, res['data'][0]]);
                console.log("sendMessage", res['data'][0]);
                setMessageSend([...messageSend, res['data']]);
            })
            .catch((err) => {
                console.error(err);
            });

        // 傳送訊息給對方(透過 socket.io)
        if (socket === null) return;
        socket.emit("sendMessage", {
            senderId: currentUserID,
            receiverId: currentChat.userID,
            text: newMessage,
        })
    }

    // 消除通知紅點
    const markUserNotificationAsRead = useCallback(
        (thisUsernotification, notifications) => {
            const mNotifications = notifications.map(el => {
                let notification;

                thisUsernotification.forEach(n => {
                    if (n.senderId === el.senderId) {
                        notification = {
                            ...n,
                            isRead: true,
                        }
                    } else {
                        notification = el;
                    }
                })

                return notification;
            })

            setNotifications(mNotifications);
        });

    // 訊息滾動至最新一筆
    useEffect(() => {
        scrollRef.current?.scrollIntoView({ behavior: "smooth" });
    }, [messages]);


    return (
        <div className="messenger">
            <div className="chatMenu">
                <div className="chatMenuWrapper">
                    {/* <input placeholder="Search for friends" className="chatMenuInput" /> */}
                    {conversations.map((c) => (
                        <div ref={c.userID === chatChatUser.userID ? buttonRef : null}
                            className="chatMenuUser"
                            onClick={() => {
                                setCurrentChat(c);
                            }}>
                            <User
                                user={c}
                                online={onlineUsers.some((o) => c.userID === o.userId)}
                                notifications={notifications}
                                unreadNotification={unreadNotification}
                                messageSend={messageSend}
                                arrivalMessage={arrivalMessage}
                                markUserNotificationAsRead={markUserNotificationAsRead}
                            />
                        </div>
                    ))}
                </div>
            </div>
            <div className="chatBox">
                <div className="chatBoxWrapper">
                    {currentChat ? (
                        <>
                            <div className="chatBoxTop">
                                {messages.map((m) => (
                                    <div ref={scrollRef}>
                                        <Message message={m} own={m.fromID === currentUserID} chatUser={currentChat} />
                                    </div>
                                ))}
                            </div>
                            <div className="chatBoxBottom">
                                <input
                                    ref={messageRef}
                                    className="chatMessageInput"
                                    placeholder=" 寫點訊息..."
                                    onChange={(e) => setNewMessage(e.target.value)}
                                    onKeyUp={handleKeyup}
                                ></input>
                                <button className="chatSubmitButton" onClick={handleSubmit}>
                                    傳送
                                </button>
                            </div>
                        </>
                    ) : (
                        <span className="noConversationText">
                            選擇用戶開始聊天吧!
                        </span>
                    )}
                </div>
            </div>
        </div>
    );
}

export default ChatRoom;
