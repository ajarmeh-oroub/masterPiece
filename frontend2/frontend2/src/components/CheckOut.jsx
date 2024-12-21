import React, { useEffect, useState } from 'react';
import { getUserData } from '../services/api';


// Utility function to get the cart from cookies
const getCartFromCookies = () => {
  const cart = document.cookie
    .split("; ")
    .find((row) => row.startsWith("cart="));
  return cart ? JSON.parse(decodeURIComponent(cart.split("=")[1])) : [];
};

// Utility function to delete the cart cookie
const deleteCartCookie = () => {
  document.cookie = "cart=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/";
};

export default function CheckOut() {
  // States to store user data and cart content
  const [user, setUserData] = useState(null);
  const [cartItems, setCartItems] = useState([]);


  useEffect(() => {
    const fetchUserData = async () => {
      let id = 1; // You can replace this with a dynamic value
      try {
        const fetchedUser = await getUserData(id);
        setUserData(fetchedUser);
      } catch (error) {
        console.error("Error fetching user data:", error);
      }
    };

    // Fetch cart from cookies
    const cart = getCartFromCookies();
    setCartItems(cart);

    // Fetch user data
    fetchUserData();
  }, []);

  const calculateTotal = () => {
    return cartItems.reduce(
      (total, item) => total + item.price * item.quantity,
      0
    );
  };

  const handlePlaceOrder = (e) => {
    e.preventDefault();

    // Empty the cart cookie
    deleteCartCookie();

    // Redirect the user to the 'Thanks for Purchasing' page
    window.location.href=  ('/thnaks');
  };

  return (
    <section className="checkout spad">
      <div className="container">
        <div className="checkout__form">
          <form onSubmit={handlePlaceOrder}>
            <div className="row">
              <div className="col-lg-8 col-md-6">
                <h6 className="coupon__code">
                  <span className="icon_tag_alt" /> Have a coupon?{" "}
                  <a href="#">Click here</a> to enter your code
                </h6>
                <h6 className="checkout__title">Billing Details</h6>
                <div className="row">
                  <div className="col-lg-6">
                    <div className="checkout__input">
                      <p>First Name<span>*</span></p>
                      <input type="text" value={user?.first_name || ''} readOnly />
                    </div>
                  </div>
                  <div className="col-lg-6">
                    <div className="checkout__input">
                      <p>Last Name<span>*</span></p>
                      <input type="text" value={user?.last_name || ''} readOnly />
                    </div>
                  </div>
                </div>

                <div className="checkout__input">
                  <p>Address<span>*</span></p>
                  <input
                    type="text"
                    placeholder="Street Address"
                    className="checkout__input__add"
                    value={user?.address?.address || ''}
                    readOnly
                  />
                </div>

                <div className="row">
                  <div className="col-lg-6">
                    <div className="checkout__input">
                      <p>Phone<span>*</span></p>
                      <input type="text" value={user?.phone || ''} readOnly />
                    </div>
                  </div>
                  <div className="col-lg-6">
                    <div className="checkout__input">
                      <p>Email<span>*</span></p>
                      <input type="text" value={user?.email || ''} readOnly />
                    </div>
                  </div>
                </div>
              </div>
              <div className="col-lg-4 col-md-6">
                <div className="checkout__order">
                  <h4 className="order__title">Your order</h4>
                  <div className="checkout__order__products">
                    Product <span>Total</span>
                  </div>
                  <ul className="checkout__total__products">
                    {cartItems.length > 0 ? cartItems.map((item, index) => (
                      <li key={index}>
                        {item.name} <span>{item.price} Jd</span>
                      </li>
                    )) : <li>No items in the cart</li>}
                  </ul>
                  <ul className="checkout__total__all">
                    <li>Subtotal <span>{calculateTotal()} Jd</span></li>
                    <li>Total <span>{calculateTotal()} Jd</span></li>
                  </ul>
                  <div className="checkout__input__checkbox">
                    <label htmlFor="payment">
                      Check Payment
                      <input type="checkbox" id="payment" />
                      <span className="checkmark" />
                    </label>
                  </div>
                  <div className="checkout__input__checkbox">
                    <label htmlFor="paypal">
                      Paypal
                      <input type="checkbox" id="paypal" />
                      <span className="checkmark" />
                    </label>
                  </div>
                  <button type="submit" className="site-btn">PLACE ORDER</button>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </section>
  );
}
