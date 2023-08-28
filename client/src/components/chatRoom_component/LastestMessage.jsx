import { useEffect, useState } from "react";
import Chat from "../../axios/Chat";

export const LastestMessage = (
  currentUserID,
  user,
  messageSend,
  arrivalMessage,
  notifications
) => {
  const [lastestMessage, setLastestMessage] = useState(null);

  useEffect(() => {
    const getMessage = async () => {
       await Chat.getMessage(currentUserID, user.userID)
        .then((res) => {
          setLastestMessage(res["data"][res["data"]?.length - 1]);
        })
        .catch((err) => {
          console.error(err);
        });
    };
    getMessage();
  }, [messageSend, arrivalMessage, notifications]);

  return { lastestMessage };
};
