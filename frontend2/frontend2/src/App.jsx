import React, { Suspense, lazy } from "react";
import { BrowserRouter as Router, Routes, Route } from "react-router-dom";

import Shoplanding from "./components/Shop/Shoplanding";
import ShopDetails from "./components/Shop/ShopDetails";
import Cart from "./components/Cart";
import Header from "./components/Header";
import Footer from "./components/Footer";
import CheckOut from "./components/CheckOut";
import BlogCards from "./components/Blog.jsx/BlogCards";
import Contact from "./components/Contact";
import PharmacyIndex from "./components/profile/PharmacyIndex";
import UserIndex from "./components/profile/UserIndex";
import ThanksForPurchasing from "./components/Thnaks";

const Home = lazy(() => import("./components/landing/Home"));
// const Login = lazy(() => import("./components/auth/Login"));
// const SignUp = lazy(() => import("./components/auth/SignUp"));

function App() {
  return (
    <Router>
      <Suspense fallback={<div>Loading...</div>}>
      <Header/>
        <Routes>
        

          <Route path="/" element={<Home />} />
          <Route path="/shop" element={<Shoplanding/>} />
          <Route path="/shopdetails/:id" element={<ShopDetails />} />
          <Route path="/thnaks" element={<ThanksForPurchasing/>}/>
          <Route path="/cart" element={<Cart/>}/>
          <Route path="/checkout" element={<CheckOut/>}/>
          <Route path="/blog" element={<BlogCards/>}/>
          <Route path="/contact" element={<Contact/>}/>
          <Route path="/pharmacy" element={<PharmacyIndex/>}/>
          <Route path="/user" element={<UserIndex/>}/>
          {/* <Route path="/login" element={<Login />} />
          <Route path="/signup" element={<SignUp />} /> */}
        </Routes>
      
        <Footer/>
      </Suspense>
    </Router>
  );
}

export default App;
