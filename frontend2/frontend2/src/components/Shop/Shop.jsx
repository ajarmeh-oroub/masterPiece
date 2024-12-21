import React, { useEffect, useState } from "react";
import {
  getBarnds,
  getPharmacies,
  getProducts,
  getSubCategories,
} from "../../services/api";
import { Link } from "react-router-dom";
import ProductCard from "../ProductComponents/ProductCard";

export default function Shop() {
  const [products, setProducts] = useState([]);
  const [subcategories, setSubCategories] = useState([]);
  const [brands, setBrands] = useState([]);
  const [pharmacies, setPharmacies] = useState([]);
  const [currentPage, setCurrentPage] = useState(1);
  const [productsPerPage] = useState(12);
  const [loading, setLoading] = useState(true);
  const [selectedCategory, setSelectedCategory] = useState(null);
  const [selectedBrand, setSelectedBrand] = useState(null);
  const [selectedPriceRange, setSelectedPriceRange] = useState(null);
  const [searchQuery, setSearchQuery] = useState("");


  const handleCategoryChange = (categoryId) => {
    setSelectedCategory(categoryId);
  };

  const handleBrandChange = (brandId) => {
    setSelectedBrand(brandId);
  };

  const handlePriceRangeChange = (priceRange) => {
    setSelectedPriceRange(priceRange);
  };

  const handleSearchChange = (e) => {
    setSearchQuery(e.target.value);
  };

  const handleSubmit = (e) => {
    e.preventDefault(); 
  };

  useEffect(() => {
    const fetchProducts = async () => {
    
      try {
        const filters = {
          searchQuery,
          category: selectedCategory,
          brand: selectedBrand,
          priceRange: selectedPriceRange,
        };

        // Adjust the API request to include filters
        const fetchedProducts = await getProducts(filters);

        if (Array.isArray(fetchedProducts)) {
          setProducts(fetchedProducts);
        } else {
          console.error("Fetched data is not an array:", fetchedProducts);
        }
      } catch (error) {
        console.error("Error fetching products:", error);
      } finally {
        setLoading(false); 
      }
    };

    fetchProducts();
  }, [searchQuery, selectedCategory, selectedBrand, selectedPriceRange]);

  useEffect(() => {
    const fetchSubCategories = async () => {
      try {
        const fetchedCategories = await getSubCategories();
        setSubCategories(fetchedCategories);
      } catch (error) {
        console.error("Error fetching categories:", error);
      }
    };
    fetchSubCategories();
  }, []);

  useEffect(() => {
    const fetchBrands = async () => {
      try {
        const fetchedBrands = await getBarnds();
        setBrands(fetchedBrands);
      } catch (error) {
        console.error("Error fetching brands:", error);
      }
    };
    fetchBrands();
  }, []);

  useEffect(() => {
    const fetchPharmacies = async () => {
      try {
        const fetchedPharmacies = await getPharmacies();
        setPharmacies(fetchedPharmacies);
      } catch (error) {
        console.error("Error fetching pharmacies:", error);
      }
    };
    fetchPharmacies();
  }, []);

  // Pagination logic
  const indexOfLastProduct = currentPage * productsPerPage;
  const indexOfFirstProduct = indexOfLastProduct - productsPerPage;
  const currentProducts = products.slice(
    indexOfFirstProduct,
    indexOfLastProduct
  );

  const totalPages = Math.ceil(products.length / productsPerPage);

  const paginate = (pageNumber) => setCurrentPage(pageNumber);

  const renderStars = (rating) => {
    const roundedRating = Math.round(rating * 2) / 2;
    const stars = [];

    for (let i = 1; i <= roundedRating; i++) {
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

  if (loading)
    return (
      <div id="preloder">
        <div className="loader"></div>
      </div>
    );

  return (
    <section className="shop spad">
      <div className="container">
        <div className="row">
          <div className="col-lg-3">
            <div className="shop__sidebar">
              <div className="shop__sidebar__search">
              <form onChange={handleSubmit}>
                  <input
                    type="text"
                    value={searchQuery}
                    onChange={handleSearchChange}
                    placeholder="Search..."
                  />
                  <button type="submit">
                    <span className="icon_search" />
                  </button>
                </form>
              </div>
              <div className="shop__sidebar__accordion">
                <div className="accordion" id="accordionExample">
                  <div className="card">
                    <div className="card-heading">
                      <a data-toggle="collapse" data-target="#collapseOne">
                        Categories
                      </a>
                    </div>
                    <div
                      id="collapseOne"
                      className="collapse show"
                      data-parent="#accordionExample"
                    >
                      <div className="card-body">
                        <div className="shop__sidebar__categories">
                          <ul className="nice-scroll">
                            {subcategories.map((category) => (
                              <li key={category.id}>
                                <a
                                  onClick={() =>
                                    handleCategoryChange(category.id)
                                  }
                                >
                                  {category.name}
                                </a>
                              </li>
                            ))}
                          </ul>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div className="card">
                    <div className="card-heading">
                      <a data-toggle="collapse" data-target="#collapseTwo">
                        Branding
                      </a>
                    </div>
                    <div
                      id="collapseTwo"
                      className="collapse show"
                      data-parent="#accordionExample"
                    >
                      <div className="card-body">
                        <div className="shop__sidebar__brand">
                          <ul>
                            {brands.map((brand) => (
                              <li
                                key={brand.id}
                                className="d-flex align-items-center mb-3"
                              >
                                <img
                                  src={`http://127.0.0.1:8000/storage/${brand.image}`}
                                  className="rounded-circle me-3"
                                  style={{
                                    width: "40px",
                                    height: "40px",
                                    objectFit: "cover",
                                  }}
                                  alt={`${brand.name} logo`}
                                />
                                <a
                                  onClick={() => handleBrandChange(brand.id)}
                                  className="mx-2"
                                >
                                  {brand.name}
                                </a>
                              </li>
                            ))}
                          </ul>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div className="card">
                    <div className="card-heading">
                      <a data-toggle="collapse" data-target="#collapseThree">
                        Pharmacies
                      </a>
                    </div>
                    <div
                      id="collapseThree"
                      className="collapse show"
                      data-parent="#accordionExample"
                    >
                      <div className="card-body">
                        <div className="shop__sidebar__price">
                          <ul>
                            {pharmacies.map((pharmacy) => (
                              <li key={pharmacy.id}>
                                <a href="#">{pharmacy.name}</a>
                              </li>
                            ))}
                          </ul>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div className="card">
                    <div className="card-heading">
                      <a data-toggle="collapse" data-target="#collapseFour">
                        Filter Price
                      </a>
                    </div>
                    <div
                      id="collapseFour"
                      className="collapse show"
                      data-parent="#accordionExample"
                    >
                      <div className="card-body">
                        <div className="shop__sidebar__price">
                          <ul>
                            <li onClick={() => handlePriceRangeChange("0-50")}>
                              $0.00 - $50.00
                            </li>
                            <li
                              onClick={() => handlePriceRangeChange("50-100")}
                            >
                              $50.00 - $100.00
                            </li>
                            <li
                              onClick={() => handlePriceRangeChange("100-150")}
                            >
                              $100.00 - $150.00
                            </li>
                            <li
                              onClick={() => handlePriceRangeChange("150-200")}
                            >
                              $150.00 - $200.00
                            </li>
                            <li
                              onClick={() => handlePriceRangeChange("200-250")}
                            >
                              $200.00 - $250.00
                            </li>
                            <li onClick={() => handlePriceRangeChange("250+")}>
                              $250.00+
                            </li>
                          </ul>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div className="col-lg-9">
            <div className="row">
              {currentProducts.length > 0 ? (
                currentProducts.map((product) => (
                  <ProductCard key={product.id} product={product}  rating={product.average_rating} />
                ))
              ) : (
                <p>No products available.</p>
              )}
            </div>
            <div className="product__pagination">
              <span>
                {Array.from({ length: totalPages }, (_, index) => (
                  <a
                    key={index + 1}
                    className={index + 1 === currentPage ? "active" : ""}
                    onClick={() => paginate(index + 1)}
                  >
                    {index + 1}
                  </a>
                ))}
              </span>
            </div>
          </div>
        </div>
      </div>
    </section>
  );
}
