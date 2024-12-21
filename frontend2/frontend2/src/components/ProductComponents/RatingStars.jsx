import React from 'react';

const renderStars = (rating) => {
  const roundedRating = Math.round(rating * 2) / 2; 
  const stars = [];
  
  for (let i = 1; i <= 5; i++) {
    if (i <= Math.floor(roundedRating)) {
      stars.push(<i key={i} className="fa fa-star mr-1" />); 
    } else if (i === Math.ceil(roundedRating)) {
      stars.push(<i key={i} className="fa fa-star-half mr-1" />); 
    } else {
      stars.push(<i key={i} className="fa fa-star-o mr-1" />); 
    }
  }
  return stars;
};

export default function RatingStars({ rating }) {
  return (
    <span>
      {renderStars(rating)} 
      <span>{rating}/ 5</span>
    </span>
  );
}

