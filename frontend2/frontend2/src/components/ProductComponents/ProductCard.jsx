import React from 'react';
import { Link } from 'react-router-dom';


import RatingStars from './RatingStars'; 
import AddToCartButton from '../Buttons/AddtoCartButton';
import AddToFavorite from '../Buttons/FavoriteButton';

const ProductCard = ({ product, rating }) => {
  return (
    
 
 <div key={product.id} className="col-lg-4 col-md-6 col-sm-6 ">
                    <div className="product__item">
                      <div
                        className="product__item__pic"
                        style={{
                          backgroundImage: `url(http://127.0.0.1:8000/storage/${product.main_image})`,
                          backgroundSize: "cover",
                          backgroundPosition: "center",
                          backgroundRepeat: "no-repeat",
                        }}
                      >
                        <ul className="">
                          <li className="text-left">
                           <AddToFavorite  productId={product.id} />
                          </li>
                        </ul>
                      </div>
                      <div className="product__item__text">
                        <Link to={`/shopdetails/${product.id}`}>
                          <h6>{product.name}</h6>
                        </Link>

                     <AddToCartButton productId={product.id}  price={product.price} name={product.name} image={product.main_image} quantity={1}/>
                        <div className="rating mx-3"><RatingStars rating={rating} /></div>
                        <h5>
                          {product.discounts &&
                          product.discounts.length > 0 &&
                          product.discounts[0].new_price ? (
                            <>
                              <span className="old-price">
                                {product.price} JOD
                              </span>
                              <span className="new-price">
                                {product.discounts[0].new_price} JOD
                              </span>
                            </>
                          ) : (
                            <span className="price">{product.price} JOD</span>
                          )}
                        </h5>
                      </div>
                    </div>
                  </div>

  );
};

export default ProductCard;
