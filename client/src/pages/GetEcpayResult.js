import React from "react";
import Payment from "../axios/Payment";
import axios from "axios";

function GetEcpayResult() {
  axios.post("http://localhost:3000/GetEcpayResult").then((result) => {
    console.log(result);
  });
  //   Payment.callback()
  return <div>GetEcpayResult</div>;
}

export default GetEcpayResult;
