import React, { useEffect, useState } from 'react';
import { useParams } from 'react-router-dom';
import { getProduct } from '../../services/api';
import RelatedProducts from './RelatedProducts'
import RatingStars from '../ProductComponents/RatingStars';

export default function ShopDetails() {
  const { id } = useParams();
  const [product, setProduct] = useState(null);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);

  useEffect(() => {
    const fetchProduct = async () => {
      try {
        if (!id) {
          throw new Error("Product ID is missing");
        }
        const fetchedProduct = await getProduct(id);
       
          setProduct(fetchedProduct);
       
      } catch (err) {
        setError(err.message);
      } finally {
        setLoading(false);
      }
    };

    fetchProduct();
  }, [id]);

  const renderStars = (rating) => {
    const roundedRating = Math.round(rating * 2) / 2; 
    const stars = [];
    
    for (let i = 1; i <= roundedRating; i++) {
      if (i <= Math.floor(roundedRating)) {
        stars.push(<i key={i} className="fa fa-star mx-1" />); 
      } else if (i === Math.ceil(roundedRating)) {
        stars.push(<i key={i} className="fa fa-star-half-o mx-1" />); 
      } else {
        stars.push(<i key={i} className="fa fa-star-o mx-1" />);
      }
    }
    return stars;
  };
  
 
  
  

  

  if (loading) return  <div id="preloder">
  <div class="loader"></div>
</div>;
  if (error) return <div>Error: {error}</div>;
  return (
    <>

    <section className="shop-details">
  <div className="product__details__pic">
    <div className="container">
      <div className="row">
        <div className="col-lg-12">
          <div className="product__details__breadcrumb">
            <a href="./index.html">Home</a>
            <a href="./shop.html">Shop</a>
            <span>Product Details</span>
          </div>
        </div>
      </div>
      <div className="row">
      <div className="col-lg-3 col-md-3">
  <ul className="nav nav-tabs" role="tablist">
    {product.images?.map((imageObj, index) => (
      <li className="nav-item" key={imageObj.id || index}>
        <a
          className={`nav-link ${index === 0 ? "active" : ""}`} // Set the first item as active
          data-toggle="tab"
          href={`#tabs-${index + 1}`} // Unique ID for each tab
          role="tab"
        >
          <img
            className="product__thumb__pic"
            src={`http://127.0.0.1:8000/storage/${imageObj.image}`}
            alt={`Product Thumbnail ${index + 1}`}
          />
        </a>
      </li>
    ))}
  </ul>
</div>

        <div className="col-lg-6 col-md-9">
          <div className="tab-content">
            <div className="tab-pane active" id="tabs-1" role="tabpanel">
              <div className="product__details__pic__item">
                <img src={`http://127.0.0.1:8000/storage/${product.main_image}`} alt="" />
              </div>
            </div>
            <div className="tab-pane" id="tabs-2" role="tabpanel">
              <div className="product__details__pic__item">
                <img src={`http://127.0.0.1:8000/storage/${product.main_image}`} alt="" />
              </div>
            </div>
            <div className="tab-pane" id="tabs-3" role="tabpanel">
              <div className="product__details__pic__item">
                <img src={`http://127.0.0.1:8000/storage/${product.main_image}`} alt="" />
              </div>
            </div>
            <div className="tab-pane" id="tabs-4" role="tabpanel">
              <div className="product__details__pic__item">
                <img src={`http://127.0.0.1:8000/storage/${product.main_image}`}alt="" />
            
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div className="product__details__content">
    <div className="container">
      <div className="row d-flex justify-content-center">
        <div className="col-lg-8">
          <div className="product__details__text">
            <h4>{product.name}</h4>
            <div className="rating">
           <RatingStars rating={product.average_rating}/>
            </div>
            <h3>
  {product.discounts && product.discounts.length > 0 && product.discounts[0].new_price ? (
    <>
      <span className="old-price">{product.price} JOD</span>
      <span className="new-price text-danger">{product.discounts[0].new_price} JOD</span>
    </>
  ) : (
    <span className="price">{product.price} JOD</span>
  )}
</h3>
            <p>
            {product.description}
            </p>
          
            <div className="product__details__cart__option">
              <div className="quantity">
                <div className="pro-qty">
                  <input type="text" defaultValue={1} />
                </div>
              </div>
              <a href="#" className="primary-btn">
                add to cart
              </a>
            </div>
            <div className="product__details__btns__option">
              <a href="#">
                <i className="fa fa-heart" /> add to wishlist
              </a>
            
            </div>
            <div className="product__details__last__option">
              <ul>
             
                <li>
                  <span>Category:</span> {product.category.name}
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <div className="row">
        <div className="col-lg-12">
          <div className="product__details__tab">
            <ul className="nav nav-tabs" role="tablist">
              <li className="nav-item">
                <a
                  className="nav-link active"
                  data-toggle="tab"
                  href="#tabs-5"
                  role="tab"
                >
                  Description
                </a>
              </li>
              <li className="nav-item">
                <a
                  className="nav-link"
                  data-toggle="tab"
                  href="#tabs-6"
                  role="tab"
                >
                  Customer Previews ({product.reviews.length})
                </a>
              </li>
              <li className="nav-item">
                <a
                  className="nav-link"
                  data-toggle="tab"
                  href="#tabs-7"
                  role="tab"
                >
                  Additional information
                </a>
              </li>
            </ul>
            <div className="tab-content">
              <div className="tab-pane active" id="tabs-5" role="tabpanel">
                <div className="product__details__tab__content">
                  <p className="note">
                 {product.description}
                  </p>
                  <div className="product__details__tab__content__item">
                    <h5>Skin Type</h5>
                    <p>
                    {product.skin_type}
                    </p>
                    </div>
                    <div className="product__details__tab__content__item">
                    <h5>Nutritional Information</h5>
                    <p>
                   {product.nutritional_information}
                    </p>
                  </div>
                  <div className="product__details__tab__content__item">
                    <h5>Active Ingredients</h5>
                    <p>
               {product.active_ingredients}
                    </p>
                  </div>
                  <div className="product__details__tab__content__item">
                    <h5>Usage Instructions</h5>
                    <p>
               {product.usage_instructions}
                    </p>
                  </div>
                  <div className="product__details__tab__content__item">
                    <h5>Warnings</h5>
                    <p>
               {product.warnings}
                    </p>
                  </div>
                  <div className="product__details__tab__content__item">
                    <h5>Disclaimers</h5>
                    <p>
               {product.disclaimers}
                    </p>
                  </div>
                </div>
              </div>
              <div className="tab-pane" id="tabs-6" role="tabpanel">
              
                
              <div className="product__details__tab__content__item">
  {product.reviews && product.reviews.length > 0 ? (
    product.reviews.map((review, index) => (
      <div key={index} className="review" style={{
        borderBottom: '1px solid #ddd', // Add a line to separate reviews
        padding: '20px 0',
        marginBottom: '20px'
      }}>
        <h5 className="review__author" style={{
          fontWeight: 'bold',
          fontSize: '16px',
          color: '#333'
        }}>
          {review.user.first_name} {review.user.last_name}
        </h5>
        <div className="review__rating" style={{
          marginTop: '10px'
        }}>
          {renderStars(review.rating)} {/* Custom component for stars */}
        </div>
        <p className="review__text" style={{
          fontSize: '14px',
          color: '#555',
          marginTop: '10px',
          fontStyle: 'italic'
        }}>
          {review.comment}
        </p>
        <small className="review__date" style={{
          fontSize: '12px',
          color: '#999',
          marginTop: '10px'
        }}>
          {new Date(review.created_at).toLocaleDateString()}
        </small>
      </div>
    ))
  ) : (
    <p style={{
      fontSize: '16px',
      color: '#888',
      textAlign: 'center',
      marginTop: '30px'
    }}>No reviews available for this product.</p>
  )}
</div>


              </div>
              <div className="tab-pane" id="tabs-7" role="tabpanel">
                <div className="product__details__tab__content">
                  <p className="note">
                    
                    {product.description}
                    
                  </p>
                  <div className="product__details__tab__content__item">
                    <h5>Other Ingredients</h5>
                    <p>
                     {product.other_ingredients}
                    </p>
                  </div>
                  <div className="product__details__tab__content__item">
                    <h5>Bottle Volume</h5>
                    <p>
                 {product.bottle_volume}
                    </p>
                  </div>
                  <div className="product__details__tab__content__item">
                    <h5>Bottle Material</h5>
                    <p>
                 {product.bottle_material}
                    </p>
                  </div>
                  <div className="product__details__tab__content__item">
                    <h5>Bottle Type</h5>
                    <p>
                 {product.bottle_type}
                    </p>
                  </div>
                  <div className="product__details__tab__content__item">
                    <h5>Cap Type</h5>
                    <p>
                 {product.cap_type}
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>


<RelatedProducts/>

</>

  )
}
