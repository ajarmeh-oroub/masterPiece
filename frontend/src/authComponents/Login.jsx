import React, { useState } from 'react';
import axios from 'axios';
import { useStateContext } from '../context/AuthContext';
import './stylelog.css';
import { Link } from 'react-router-dom';

export default function Login() {
  const { setCurrentUser, setUserToken } = useStateContext(); // Access context methods
  const [loginData, setLoginData] = useState({ email: '', password: '' });
  const [error, setError] = useState(''); // For error messages
  const [showPassword, setShowPassword] = useState(false); // State to toggle password visibility

  // Handle input changes
  const handleChange = (e) => {
    const { name, value } = e.target;
    setLoginData({ ...loginData, [name]: value });
  };

  // Toggle Password Visibility
  const togglePasswordVisibility = () => {
    setShowPassword(!showPassword);
  };

  // Handle form submission
  const handleSubmit = async (e) => {
    e.preventDefault();
    setError(''); // Clear previous errors

    try {
      const response = await axios.post('http://127.0.0.1:8000/api/login', loginData);

      const { user, token } = response.data;
      setCurrentUser(user);
      setUserToken(token);

      alert('Login successful!');
    } catch (err) {
      console.error(err);
      setError('Invalid email or password. Please try again.');
    }
  };

  return (
    <div className="vh-100 d-flex justify-content-center align-items-center position-relative">
      {/* Background Design */}
      <div className="background">
        <div className="shape"></div>
        <div className="shape"></div>
      </div>

      {/* Login Form */}
      <form
        onSubmit={handleSubmit}
        className="p-5 rounded-3 text-white position-relative"
        style={{
          background: 'rgba(255,255,255,0.13)',
          backdropFilter: 'blur(10px)',
          border: '2px solid rgba(255,255,255,0.1)',
          boxShadow: '0 0 40px rgba(8,7,16,0.6)',
          width: '350px',
        }}
      >
 
        <h3 className="text-center mb-2">Welcome Back</h3>
        <h5 className="text-center mb-4">Log in here</h5>
   
        {/* Email Input */}
        <label htmlFor="email" className="form-label">Username</label>
        <input
          type="email"
          placeholder="Email or Phone"
          id="email"
          name="email"
          value={loginData.email}
          onChange={handleChange}
          required
          className="form-control bg-white bg-opacity-10 text-white mb-3"
          style={{
            backgroundColor: 'rgba(255,255,255,0.07)',
            border: 'none',
          }}
        />

        {/* Password Input */}
        <label htmlFor="password" className="form-label">Password</label>
        <div className="position-relative">
          <input
            type={showPassword ? 'text' : 'password'} // Toggle between text and password
            placeholder="Password"
            id="password"
            name="password"
            value={loginData.password}
            onChange={handleChange}
            required
            className="form-control bg-white bg-opacity-10 text-white mb-3"
            style={{
              backgroundColor: 'rgba(255,255,255,0.07)',
              border: 'none',
            }}
          />
          {/* Show/Hide Password Button */}
          <span
            onClick={togglePasswordVisibility}
            style={{
              position: 'absolute',
              top: '50%',
              right: '10px',
              transform: 'translateY(-50%)',
              cursor: 'pointer',
              color: '#ffffff',
              fontSize: '0.9rem',
            }}
          >
            {showPassword ? 'Hide' : 'Show'}
          </span>
        </div>

        {/* Error Message */}
        {error && (
          <div className="alert alert-danger p-2 text-center mb-3">
            {error}
          </div>
        )}
        <p className='question'>Don't have an account?<Link to='/signup' className='signUP'>Sign Up</Link></p>

        {/* Submit Button */}
        <button
          type="submit"
          className="btn btn-light w-100 mt-3"
        >
          Log In
        </button>
      </form>
    </div>
  );
}
