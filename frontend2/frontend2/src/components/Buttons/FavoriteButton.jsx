import React, { useState } from "react";
import { toast } from "react-toastify";
import "react-toastify/dist/ReactToastify.css";

// Utility function to get favorites from cookies
const getFavoritesFromCookies = () => {
  const cookies = document.cookie.split("; ").find((row) =>
    row.startsWith("favorites=")
  );
  return cookies ? JSON.parse(decodeURIComponent(cookies.split("=")[1])) : [];
};

// Utility function to save favorites to cookies
const setFavoritesToCookies = (favorites) => {
  const expires = new Date();
  expires.setDate(expires.getDate() + 7); // Set expiration to 7 days
  document.cookie = `favorites=${encodeURIComponent(
    JSON.stringify(favorites)
  )};expires=${expires.toUTCString()};path=/`;
};

function AddToFavorite({ productId }) {
  const [isFavorite, setIsFavorite] = useState(() => {
    // Check if the product is already in the favorites cookie
    const favoriteProducts = getFavoritesFromCookies();
    return favoriteProducts.includes(productId);
  });

  const handleToggleFavorite = () => {
    try {
      // Retrieve current favorites from cookies
      let favoriteProducts = getFavoritesFromCookies();

      if (isFavorite) {
        // Remove the product from favorites
        favoriteProducts = favoriteProducts.filter((id) => id !== productId);
        setFavoritesToCookies(favoriteProducts);
        setIsFavorite(false);
        toast.warning("Removed from favorites!");
      } else {
        // Add the product to favorites
        if (!favoriteProducts.includes(productId)) {
          favoriteProducts.push(productId);
          setFavoritesToCookies(favoriteProducts);
          setIsFavorite(true);
          toast.success("Added to favorites!");
        } else {
          toast.info("This product is already in your favorites.");
        }
      }
    } catch (error) {
      toast.error("Something went wrong. Please try again.");
    }
  };

  return (
    <div
      className={`favorite-icon ${isFavorite ? "favorited" : ""}`}
      onClick={handleToggleFavorite}
      title={isFavorite ? "Remove from Favorite" : "Add to Favorite"}
    >
      <i className={`fa ${isFavorite ? "fa-heart" : "fa-heart-o"}`}></i>
    </div>
  );
}

export default AddToFavorite;
