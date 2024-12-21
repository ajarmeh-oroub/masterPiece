import React from 'react'


export default function Header() {
  return (
<header className="header">
  <div className="container">
    <div className="row">
      <div className="col-lg-3 col-md-3">
        <div className="header__logo">
          <a href="./index.html">
            <img src="img/logo.png2.png" alt="" width="90px" height="60px" />
          </a>
        </div>
      </div>
      <div className="col-lg-6 col-md-6">
        <nav className="header__menu mobile-menu">
          <ul>
            <li className="active">
              <a href="./index.html">Home</a>
            </li>
            <li>
              <a href="./shop.html">Shop</a>
            </li>
            <li>
              <a href="#">Pages</a>
              <ul className="dropdown">
                <li>
                  <a href="./about.html">About Us</a>
                </li>
                <li>
                  <a href="./shop-details.html">Shop Details</a>
                </li>
                <li>
                  <a href="./shopping-cart.html">Shopping Cart</a>
                </li>
                <li>
                  <a href="./checkout.html">Check Out</a>
                </li>
                <li>
                  <a href="./blog-details.html">Blog Details</a>
                </li>
              </ul>
            </li>
            <li>
              <a href="./blog.html">Blog</a>
            </li>
            <li>
              <a href="./contact.html">Contacts</a>
            </li>
          </ul>
        </nav>
      </div>
      <div className="col-lg-3 col-md-3">
        <div className="header__nav__option">
          <a href="#" className="search-switch">
            <img src="img/icon/search.png" alt="" />
          </a>
          <a href="#">
            <img src="img/icon/heart.png" alt="" />
          </a>
          <a href="#">
            <img src="img/icon/cart.png" alt="" /> <span>0</span>
          </a>
          <div className="price">$0.00</div>
        </div>
      </div>
    </div>
    <div className="canvas__open">
      <i className="fa fa-bars" />
    </div>
  </div>
</header>

  
  )
}
