import React, { useState, useEffect } from "react";
import { Link } from "react-router-dom";

// Utility function to get cart data from cookies
const getCartFromCookies = () => {
  const cookies = document.cookie.split("; ").find((row) =>
    row.startsWith("cart=")
  );
  return cookies ? JSON.parse(decodeURIComponent(cookies.split("=")[1])) : [];
};

// Utility function to save cart data to cookies
const saveCartToCookies = (cart) => {
  document.cookie = `cart=${encodeURIComponent(
    JSON.stringify(cart)
  )}; path=/; max-age=31536000`; // Expiration set to 1 year
};

const CartIcon = () => {
  const [cartItems, setCartItems] = useState([]);

  useEffect(() => {
    const cart = getCartFromCookies();
    setCartItems(cart);
  }, []);

  // Calculate total price of items in the cart
  const calculateTotal = () => {
    return cartItems.reduce(
      (total, item) => total + item.price * item.quantity,
      0
    ).toFixed(2); // Returns total as a string with two decimal places
  };

  // Calculate total number of items in the cart
  const calculateItemCount = () => {
    return cartItems.reduce((count, item) => count + item.quantity, 0);
  };

  return (
    <div className="cart-icon">
      <Link to="cart">
        <img src="./public/assets/img/icon/cart.png" alt="Cart" />
        <span style={{color:'#ff4757'}}>{calculateItemCount()}</span>
      </Link>
      <div className="price">${calculateTotal()}</div> 
    </div>
  );
};

export default CartIcon;
