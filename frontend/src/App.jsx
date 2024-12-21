import React from 'react';
import { BrowserRouter as Router, Route, Routes, useLocation } from 'react-router-dom'; // Correct import for BrowserRouter and Routes
import { ContextProvider } from './context/AuthContext'; // Adjust path if necessary
import Login from './authComponents/Login';
import SignUp from './authComponents/SignUp';
import Home from './components/pages/Home.jsx';

function App() {
  return (
    <ContextProvider>
      <Router>
     
      
        <Routes>
          <Route path="/login" element={<Login />} />
          <Route path="/signup" element={<SignUp />} />
          <Route path='/' element={<Home/>}/>
          {/* Other routes */}
        </Routes>
      </Router>
    </ContextProvider>
  );
}

// Component to conditionally render the Header
// function HeaderWithCondition() {
//   const location = useLocation();

//   // Check if the current route is not '/login' or '/signup'
//   if (location.pathname === '/login' || location.pathname === '/signup') {
//     return null; // Don't render Header on these routes
//   }

//   return <Header />; // Render Header on all other routes
// }

export default App;