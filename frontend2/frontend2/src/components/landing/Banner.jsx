import React, { useEffect } from 'react'

export default function Banner() {
    useEffect(() => {
        const $ = window.jQuery; // Ensure jQuery is available
        $(".owl-carousel").owlCarousel({
          loop: true,
          margin: 10,
          nav: true,
          items: 1,
        });
      }, []);
  return (
    <section className="hero">
    <div className="hero__slider owl-carousel">
    <div
  className="hero__items set-bg"
  style={{ backgroundImage: `url(./public/assets/img/hero/hero-5.png)` }}
>
        <div className="container">
          <div className="row">
            <div className="col-xl-5 col-lg-7 col-md-8">
              <div className="hero__text">
              <h6 style={{ color: "#799E7C" }}>Summer Collection</h6>
        <h2 >
          Fall - Winter Collections 2030
        </h2>
                <p>
                  A specialist label creating luxury essentials. Ethically crafted
                  with an unwavering commitment to exceptional quality.
                </p>
                <a href="#" className="primary-btn">
                  Shop now <span className="arrow_right" />
                </a>
              
              </div>
            </div>
              {/* Right Column: Image */}
    <div className="col-xl-7 col-lg-5 d-none d-md-block">
    <div className="hero__image" style={{ position: "relative"  , height:550 , width:500}} >
  <img
    src={`./public/assets/img/product-shampoo.png`}
    alt="Hero"
    style={{
      maxWidth: "100%",
      height: "auto",
      borderRadius: "50%",
      position: "absolute",
      top: "-90px", // Moves the image upwards
      left: "100px", // Adjust horizontal positioning if needed
      transform: "rotate(10deg)", // Tilts the image slightly to the right
      boxShadow: "0px 4px 10px rgba(0, 0, 0, 0.2)", // Optional shadow for better appearance
    }}
  />
</div>

    </div>
          </div>
          
        </div>
      </div>
      <div
  className="hero__items set-bg"
  style={{ backgroundImage: `url(./public/assets/img/hero/hero-5.png)` }}
>
        <div className="container">
          <div className="row">
            <div className="col-xl-5 col-lg-7 col-md-8">
              <div className="hero__text">
                <h6>Summer Collection</h6>
                <h2>Fall - Winter Collections 2030</h2>
                <p>
                  A specialist label creating luxury essentials. Ethically crafted
                  with an unwavering commitment to exceptional quality.
                </p>
                <a href="#" className="primary-btn">
                  Shop now <span className="arrow_right" />
                </a>
              
              </div>
            </div>
              {/* Right Column: Image */}
    <div className="col-xl-7 col-lg-5 d-none d-md-block">
    <div className="hero__image" style={{ position: "relative"  , height:550 , width:500}} >
  <img
    src={`./public/assets/img/product-lips.png`}
    alt="Hero"
    style={{
      maxWidth: "100%",
      height: "auto",
      borderRadius: "50%",
      position: "absolute",
      top: "-90px", // Moves the image upwards
      left: "100px", // Adjust horizontal positioning if needed
      transform: "rotate(10deg)", // Tilts the image slightly to the right
      boxShadow: "0px 4px 10px rgba(0, 0, 0, 0.2)", // Optional shadow for better appearance
    }}
  />
</div>

    </div>
          </div>
          
        </div>
      </div>
    </div>
  </section>
  
  )
}
