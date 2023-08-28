import React from "react";
import "./footer.css";
import logo from "../imgs/logo.jpg";

function Footer() {
  return (
    <div className="footer">
      <div className="footer-left">
        <div className="footer-img"></div>
      </div>
      <div className="footer-right ">
        {/* <p className="footer-right-content">追蹤我們</p> */}
        <ul className="socials">
          <li>
            <a className="facebook" href="#">
              <ion-icon name="logo-facebook"></ion-icon>
            </a>
          </li>
          <li>
            <a className="twitter" href="#">
              <ion-icon name="logo-twitter"></ion-icon>
            </a>
          </li>
          <li>
            <a className="youtube" href="#">
              <ion-icon name="logo-youtube"></ion-icon>
            </a>
          </li>
          <li>
            <a className="instagram" href="#">
              <ion-icon name="logo-instagram"></ion-icon>
            </a>
          </li>
        </ul>
        <p className="footer-bottom-content">
          &copy;2023 Copyright Piece Of Case. All rights reserved.
        </p>
      </div>
    </div>
  );
}

export default Footer;
