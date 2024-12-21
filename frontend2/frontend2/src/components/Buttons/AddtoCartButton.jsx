import React, { useState, useEffect } from "react";
import { toast, ToastContainer } from "react-toastify";
import "react-toastify/dist/ReactToastify.css";

// Utility function to get the cart from cookies
const getCartFromCookies = () => {
  const cart = document.cookie
    .split("; ")
    .find((row) => row.startsWith("cart="));
  return cart ? JSON.parse(decodeURIComponent(cart.split("=")[1])) : [];
};

// Utility function to save the cart to cookies
const saveCartToCookies = (cart) => {
  document.cookie = `cart=${encodeURIComponent(
    JSON.stringify(cart)
  )}; path=/; max-age=31536000`; // 1 year expiration
};

const AddToCartButton = ({ productId, name, image , quantity , price}) => {
  const [inCart, setInCart] = useState(false);

  useEffect(() => {
    const cart = getCartFromCookies();
    // Check if the product is in the cart by its id
    setInCart(cart.some((item) => item.id === productId));
  }, [productId]);

  const handleAddToCart = () => {
    const cart = getCartFromCookies();

    // Check if the product already exists in the cart
    const productExists = cart.some((item) => item.id === productId);
    
    if (!productExists) {
      const newProduct = { id: productId, name, image , quantity , price };
      cart.push(newProduct);
      saveCartToCookies(cart);
      setInCart(true);
      toast.success("Product added to cart!", {
        position: "top-center",
        autoClose: 2000,
      });
    } else {
      toast.info("Product is already in the cart.", {
        position: "top-center",
        autoClose: 2000,
      });
    }
  };

  const handleRemoveFromCart = () => {
    const cart = getCartFromCookies();
    const updatedCart = cart.filter((item) => item.id !== productId);
    saveCartToCookies(updatedCart);
    setInCart(false);
    toast.warning("Product removed from cart!", {
      position: "top-center",
      autoClose: 2500,
    });
  };

  return (
    <>
      <ToastContainer />
      <a
        onClick={inCart ? handleRemoveFromCart : handleAddToCart}
        className="add-cart-button"
      >
        {inCart ? "- Remove From Cart" : "+ Add To Cart"}
      </a>
    </>
  );
};

export default AddToCartButton;
