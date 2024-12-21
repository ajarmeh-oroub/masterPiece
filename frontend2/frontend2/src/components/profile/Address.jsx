import React, { useState, useEffect } from 'react';
import { updateAddress } from '../../services/api';


const Address = () => {
  const [query, setQuery] = useState('');
  const [suggestions, setSuggestions] = useState([]);
  const [error, setError] = useState('');
  const [loading, setLoading] = useState(false);
  const [user, setUser] = useState({ address: '', latitude: '', longitude: '' });

  const fetchSuggestions = async (query) => {
    try {
      const response = await fetch(
        `https://api.opencagedata.com/geocode/v1/json?q=${encodeURIComponent(query)}&key=&no_annotations=1`
      );
      const data = await response.json();

      if (data.results.length > 0) {
        const suggestionsList = data.results.slice(0, 5); // Limit to 5 suggestions
        setSuggestions(
          suggestionsList.map((result) => ({
            address: result.formatted,
            latitude: result.geometry.lat,
            longitude: result.geometry.lng,
          }))
        );
      } else {
        setSuggestions([]);
      }
    } catch (err) {
      console.error('Error fetching suggestions:', err);
      setError('Unable to fetch suggestions. Please try again.');
    }
  };

  useEffect(() => {
    if (query.trim().length > 2) {
      const debounceTimer = setTimeout(() => {
        fetchSuggestions(query.trim());
      }, 500);

      return () => clearTimeout(debounceTimer);
    } else {
      setSuggestions([]);
    }
  }, [query]);

  const handleInputChange = (e) => {
    const { name, value } = e.target;
    setUser((prevData) => ({
      ...prevData,
      [name]: value,
    }));
  };

  const handleSuggestionClick = (suggestion) => {
    setQuery(suggestion.address);
    setUser((prevData) => ({
      ...prevData,
      address: suggestion.address,
      latitude: suggestion.latitude,
      longitude: suggestion.longitude,
    }));
    setSuggestions([]);
  };

  const handleSaveChanges = async () => {
    const id = 1; // Replace with the actual user ID
    setLoading(true);
    try {
      await updateAddress(id, user);
      Swal.fire({
        icon: 'success',
        title: 'Success!',
        text: 'Your Address updated successfully!',
      });
    } catch (error) {
      console.error('Error updating your address:', error);
      Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: 'Failed to update your address. Please try again.',
      });
    } finally {
      setLoading(false);
    }
  };

  return (
    <div>
      <label htmlFor="suggest" className="form-label mt-3">
        Enter your Address here
      </label>
      <input
        name="address"
        type="text"
        value={query}
        onChange={(e) => setQuery(e.target.value)}
        placeholder="Search for a place"
      />
      {error && <p style={{ color: 'red' }}>{error}</p>}
      {suggestions.length > 0 && (
        <ul
          style={{
            border: '1px solid #ccc',
            padding: '0.5em',
            margin: '0',
            listStyleType: 'none',
          }}
        >
          {suggestions.map((suggestion, index) => (
            <li
              key={index}
              onClick={() => handleSuggestionClick(suggestion)}
              style={{
                cursor: 'pointer',
                padding: '0.5em',
                borderBottom: index < suggestions.length - 1 ? '1px solid #ddd' : 'none',
              }}
            >
              {suggestion.address}
            </li>
          ))}
        </ul>
      )}
      <button
        className="btn"
        onClick={handleSaveChanges}
        disabled={loading}
        style={{ color: 'white', background: 'black' }}
      >
        {loading ? 'Saving...' : 'Save Address'}
      </button>
    </div>
  );
};

export default Address;
