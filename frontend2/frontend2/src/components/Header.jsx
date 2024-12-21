import React from 'react'
import { Link } from 'react-router-dom'
import CartIcon from './ProductComponents/CartIcon'

export default function Header() {
  return (

    <header className="header">
  <div className="container">
    <div className="row">
      <div className="col-lg-3 col-md-3">
        <div className="header__logo">
          <a href="./index.html">
            <img src="./public/assets/img/AfiyahLogo-small4.png" alt=""   />
          </a>
        </div>
      </div>
      <div className="col-lg-6 col-md-6">
        <nav className="header__menu mobile-menu">
          <ul>
            <li className="active">
              <Link to='/'>Home</Link>
            </li>
            <li>
              <Link to='/shop'>Shop</Link>
            </li>
            <li>
              <a href="#">Pages</a>
              <ul className="dropdown">
                <li>
                  <a href="./about.html">About Us</a>
                </li>
                <li>
                  <Link to='/shopdetails'>Shop Details</Link>
                </li>
                <li>
                  <Link to='/cart'>Shopping Cart</Link>
                </li>
                <li>
                  <Link to='/checkout'>Check Out</Link>
                </li>
                <li>
                  <a href="./blog-details.html">Blog Details</a>
                </li>
                <li>
                  <Link to='/pharmacy'>Pharmacy</Link>
                </li>
                <li>
                  <Link to='/user'>user</Link>
                </li>
              </ul>
            </li>
            <li>
              <Link to='/blog'>Blog</Link>
            </li>
            <li>
              <Link to='/contact'>Contacts</Link>
            </li>
          </ul>
        </nav>
      </div>
      <div className="col-lg-3 col-md-3">
        <div className="header__nav__option">
        
          <a href="#">
            <img src="./public/assets/img/icon/heart.png" alt="" />
          </a>
        
       <a> <CartIcon /></a>
   
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
