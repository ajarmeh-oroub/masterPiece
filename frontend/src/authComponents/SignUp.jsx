import React, { useState } from 'react';
import axios from 'axios';
import { useStateContext } from '../context/AuthContext';
import './stylelog.css';
import { Link } from 'react-router-dom';

export default function SignUp() {
  const { setCurrentUser, setUserToken } = useStateContext(); // Access context methods
  const [signUpData, setSignUpData] = useState({
    first_name: '',
    last_name: '',
    email: '',
    password: '',
    password_confirmation: '',
  });
  const [error, setError] = useState(''); // For error messages
  const [showPassword, setShowPassword] = useState(false); // State to toggle password visibility
  const [showConfirmPassword, setShowConfirmPassword] = useState(false); // State to toggle confirm password visibility

  // Handle input changes
  const handleChange = (e) => {
    const { name, value } = e.target;
    setSignUpData({ ...signUpData, [name]: value });
  };

  // Toggle Password Visibility
  const togglePasswordVisibility = () => {
    setShowPassword(!showPassword);
  };

  // Toggle Confirm Password Visibility
  const toggleConfirmPasswordVisibility = () => {
    setShowConfirmPassword(!showConfirmPassword);
  };

  // Handle form submission
  const handleSubmit = async (e) => {
    e.preventDefault();
    setError(''); // Clear previous errors

    // Check if passwords match
    if (signUpData.password !== signUpData.password_confirmation) {
      setError('Passwords do not match. Please try again.');
      return;
    }

    try {
      const response = await axios.post('http://127.0.0.1:8000/api/register', signUpData);

      const { user, token } = response.data;
      setCurrentUser(user);
      setUserToken(token);

      alert('Registration successful!');
    } catch (err) {
      console.error(err);
      setError('Error during registration. Please try again.');
    }
  };

  return (
    <div>
      {/* Background Design */}
      <div className="background">
        <div className="shape"></div>
        <div className="shape"></div>
      </div>

      {/* Sign-Up Form */}
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
        <h3 className="text-center mb-2">Create Account</h3>
        <h5 className="text-center mb-4">Sign up to get started</h5>

        {/* First Name Input */}
        <label htmlFor="first_name" className="form-label">First Name</label>
        <input
          type="text"
          placeholder="First Name"
          id="first_name"
          name="first_name"
          value={signUpData.first_name}
          onChange={handleChange}
          required
          className="form-control bg-white bg-opacity-10 text-white mb-3"
          style={{
            backgroundColor: 'rgba(255,255,255,0.07)',
            border: 'none',
          }}
        />

        {/* Last Name Input */}
        <label htmlFor="last_name" className="form-label">Last Name</label>
        <input
          type="text"
          placeholder="Last Name"
          id="last_name"
          name="last_name"
          value={signUpData.last_name}
          onChange={handleChange}
          required
          className="form-control bg-white bg-opacity-10 text-white mb-3"
          style={{
            backgroundColor: 'rgba(255,255,255,0.07)',
            border: 'none',
          }}
        />

        {/* Email Input */}
        <label htmlFor="email" className="form-label">Email</label>
        <input
          type="email"
          placeholder="Email"
          id="email"
          name="email"
          value={signUpData.email}
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
            type={showPassword ? 'text' : 'password'}
            placeholder="Password"
            id="password"
            name="password"
            value={signUpData.password}
            onChange={handleChange}
            required
            className="form-control bg-white bg-opacity-10 text-white mb-3"
            style={{
              backgroundColor: 'rgba(255,255,255,0.07)',
              border: 'none',
            }}
          />
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

        {/* Confirm Password Input */}
        <label htmlFor="password_confirmation" className="form-label">Confirm Password</label>
        <div className="position-relative">
          <input
            type={showConfirmPassword ? 'text' : 'password'}
            placeholder="Confirm Password"
            id="confirmPassword"
            name="password_confirmation"
            value={signUpData.confirmPassword}
            onChange={handleChange}
            required
            className="form-control bg-white bg-opacity-10 text-white mb-3"
            style={{
              backgroundColor: 'rgba(255,255,255,0.07)',
              border: 'none',
            }}
          />
          <span
            onClick={toggleConfirmPasswordVisibility}
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
            {showConfirmPassword ? 'Hide' : 'Show'}
          </span>
        </div>

        {/* Error Message */}
        {error && (
          <div className="alert alert-danger p-2 text-center mb-3">
            {error}
          </div>
        )}
        <p className='question'>You have an account already?<Link to='/login' className='signUP'>Login</Link></p>
        {/* Submit Button */}
        <button
          type="submit"
          className="btn btn-light w-100 mt-3"
        >
          Sign Up
        </button>
      </form>
    </div>
  );
}
