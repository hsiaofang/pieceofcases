import React, { Component, useEffect, useState } from "react";
import back from "../axios/back";
import "./Backstage.css";
// function Backstage(){
// back.alluser(1)
// .then((result)=> {
//   console.log(result['data']);
// });
function Backstage() {
  const [page, setPage] = useState(1); //預設頁碼為第一頁
  const [state, setState] = useState(0); //預設state為0
  const [AllUsers, setAllUsers] = useState([]); //AllUsers內資料有變的話會調整
  const [AllCase, setAllCase] = useState([]);
  useEffect(() => {
    back.alluser(page).then((result) => {
      console.log(result["data"]);
      setAllUsers(result["data"]);
    });
    back.allcase(page).then((result) => {
      console.log(result["data"]);
      setAllCase(result["data"]);
    });
  }, [setAllUsers, setAllCase, page]);

  return (
    <div className="container">
      <button onClick={() => setState(1)}>所有會員</button>
      <button onClick={() => setState(2)}>所有案件</button>

      {state === 1 && (
        <div>
          <input type="text" placeholder="搜尋案件或使用者" />

          <div>
            <h2>所有使用者</h2>
            <ul>
              {AllUsers.map((user, index) => (
                <li key={index}>
                  <li>{user.userName}</li>
                  <li>{user.email}</li>
                  <li>{user.phone}</li>
                  <li>{user.publish}</li>
                  <li>{user.finish}</li>
                </li>
              ))}
            </ul>
          </div>
        </div>
      )}
      {state === 2 && (
        <div>
          <h2>所有案件</h2>
          <ul>
            {AllCase.map((Allcase, index) => (
              <li key={index}>
                <li>{Allcase.caseName}</li>
                <li>{Allcase.Class}</li>
                <li>{Allcase.location}</li>
                <li>{Allcase.caseStatus}</li>
                <li>{Allcase.userName}</li>
              </li>
            ))}
          </ul>
        </div>
      )}
    </div>
  );
}

export default Backstage;
