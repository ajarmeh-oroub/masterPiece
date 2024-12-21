
import React, { useEffect, useState } from 'react'
import { getBestSellers, getNewArrivals, getProducts, getSales} from '../../services/api';
import { Link } from 'react-router-dom';
import ProductCard from '../ProductComponents/ProductCard';

export default function Product() {
  const [products , setProduct]=useState([]);
  const [filter , setFilter]=useState('best');
  const [loading, setLoading] = useState(true);
  

useEffect(()=>{
  const fetchProducts=async()=>{
          try{
            if(filter=='hot'){
const fetchedProducts= await getSales();
setProduct(fetchedProducts);
}else if(filter=='new'){
  const fetchedProducts= await getNewArrivals();
setProduct(fetchedProducts);
}else{
  const fetchedProducts= await getBestSellers();
setProduct(fetchedProducts);
}

setLoading(false);

          }catch (error) {
            console.error("Error fetching Products:", error);
          }
  }
  fetchProducts();

},[filter]);




if (loading) return  <div id="preloder">
<div class="loader"></div>
</div>;
return (
  <section className="product spad">
    <div className="container">
      <div className="row">
        <div className="col-lg-12">
          <ul className="filter__controls">
          <li
                className={filter === 'best' ? 'active' : ''}
                onClick={() => setFilter('best')}
              >
                Best Sellers
              </li>
              <li
                className={filter === 'new' ? 'active' : ''}
                onClick={() => setFilter('new')}
              >
                New Arrivals
              </li>
              <li
                className={filter === 'hot' ? 'active' : ''}
                onClick={() => setFilter('hot')}
              >
                Hot Sales
              </li>
          </ul>
        </div>
      </div>
      <div className="row product__filter mt-4">
        {products.length > 0 ? (
          products.map((product) => (
      
           <ProductCard product={product}  rating={product.average_rating} />
     
          ))
        ) : (
          <p>No products available</p>
        )}
      </div>
    </div>
  </section>
);
}

