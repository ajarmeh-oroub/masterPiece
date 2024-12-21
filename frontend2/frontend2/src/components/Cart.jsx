import React, { useState, useEffect } from "react";
import { Link } from "react-router-dom";
import { toast } from "react-toastify";
import "react-toastify/dist/ReactToastify.css";

// Utility function to get cart data from cookies
const getCartFromCookies = () => {
  const cookies = document.cookie.split("; ").find((row) =>
    row.startsWith("cart=")
  );
  return cookies ? JSON.parse(decodeURIComponent(cookies.split("=")[1])) : [];
};

// Utility function to save the cart to cookies
const saveCartToCookies = (cart) => {
  document.cookie = `cart=${encodeURIComponent(
    JSON.stringify(cart)
  )}; path=/; max-age=31536000`; // Expiration set to 1 year
};

const Cart = () => {
  const [cartItems, setCartItems] = useState([]);

  useEffect(() => {
    const cart = getCartFromCookies();
    setCartItems(cart);
  }, []);

  // Handle removal of item from cart
  const handleRemoveFromCart = (productId) => {
    const updatedCart = cartItems.filter((item) => item.id !== productId);
    saveCartToCookies(updatedCart);
    setCartItems(updatedCart);
    toast.warning("Product removed from cart!", {
      position: "top-center",
      autoClose: 2500,
    });
  };

  // Handle quantity update
  const handleUpdateQuantity = (productId, quantity) => {
    const newQuantity = Math.max(1, parseInt(quantity, 10)); // Ensure quantity is at least 1

    const updatedCart = cartItems.map((item) =>
      item.id === productId ? { ...item, quantity: newQuantity } : item
    );
    saveCartToCookies(updatedCart);
    setCartItems(updatedCart);
    toast.info("Cart updated!", {
      position: "top-center",
      autoClose: 2000,
    });
  };

  // Increment quantity
  const handleIncrement = (productId) => {
    const updatedCart = cartItems.map((item) =>
      item.id === productId ? { ...item, quantity: item.quantity + 1 } : item
    );
    saveCartToCookies(updatedCart);
    setCartItems(updatedCart);
  };

  // Decrement quantity
  const handleDecrement = (productId) => {
    const updatedCart = cartItems.map((item) =>
      item.id === productId
        ? { ...item, quantity: Math.max(1, item.quantity - 1) } // Ensure quantity doesn't go below 1
        : item
    );
    saveCartToCookies(updatedCart);
    setCartItems(updatedCart);
  };

  // Calculate the total cost of items in the cart
  const calculateTotal = () => {
    return cartItems.reduce(
      (total, item) => total + item.price * item.quantity,
      0
    );
  };

  return (
    <section className="shopping-cart spad">
      <div className="container">
        <div className="row">
          <div className="col-lg-8">
            <div className="shopping__cart__table">
              <table>
                <thead>
                  <tr>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Total</th>
                 
                  </tr>
                </thead>
                <tbody>
                  {cartItems.length > 0 ? (
                    cartItems.map((item) => (
                      <tr key={item.id}>
                        <td className="product__cart__item">
                          <div className="product__cart__item__pic">
                            <img
                              src={`http://127.0.0.1:8000/storage/${item.image}`}
                              alt={item.name}
                              style={{
                                width: "50px",
                                height: "50px",
                                borderRadius: "70%",
                                objectFit: "cover",
                              }}
                            />
                          </div>
                          <div className="product__cart__item__text">
                            <h6>{item.name}</h6>
                            <h5>${item.price}</h5>
                          </div>
                        </td>
                        <td className="quantity__item">
                          <div className="quantity">
                            <div className="pro-qty-2">
                            <div className="qty mt-5">
                                <span
                                  className="minus bg-dark"
                                  onClick={() => handleDecrement(item.id)}
                                >-
                                </span>
                                <input
                                 
                                  value={item.quantity}
                                  min="1"
                                  onChange={(e) =>
                                    handleUpdateQuantity(item.id, e.target.value)
                                  }
                                  className="count"
                                  name="qty"
                                />
                                <span
                                  className="plus bg-dark"
                                  onClick={() => handleIncrement(item.id)}
                                >+
                                </span>
                              </div>
                            </div>
                          </div>
                        </td>
                        <td className="cart__price">${item.price * item.quantity}</td>
                        <td className="cart__close">
                          <i
                            className="fa fa-close"
                            onClick={() => handleRemoveFromCart(item.id)}
                          />
                        </td>
                      </tr>
                    ))
                  ) : (
                    <tr>
                      <td colSpan="4">Your cart is empty.</td>
                    </tr>
                  )}
                </tbody>
              </table>
            </div>
            <div className="row">
              <div className="col-lg-6 col-md-6 col-sm-6">
                <div className="continue__btn">
                  <Link to='/shop'>Continue Shopping</Link>
                </div>
              </div>
          
            </div>
          </div>
          <div className="col-lg-4">
            <div className="cart__discount">
              <h6>Discount codes</h6>
              <form action="#">
                <input type="text" placeholder="Coupon code" />
                <button type="submit">Apply</button>
              </form>
            </div>
            <div className="cart__total">
              <h6>Cart total</h6>
              <ul>
                <li>
                  Subtotal <span>${calculateTotal()}</span>
                </li>
                <li>
                  Total <span>${calculateTotal()}</span>
                </li>
              </ul>
              <a href="#" className="primary-btn">
                Proceed to checkout
              </a>
            </div>
          </div>
        </div>
      </div>
    </section>
  );
};

export default Cart;
