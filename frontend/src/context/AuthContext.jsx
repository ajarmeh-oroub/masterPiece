import { useContext, useState, createContext } from "react";

// Create context with default values
const StateContext = createContext({
  currentUser: {},
  userToken: null,
  setCurrentUser: () => {},
  setUserToken: () => {},
});

export const ContextProvider = ({ children }) => {
  // Set initial state from localStorage or default values
  const [currentUser, setCurrentUser] = useState({
    id: localStorage.getItem('USER_ID') || null,
    name: "",
    email: "",
  });

  const [userToken, setUserTokenState] = useState(localStorage.getItem('TOKEN') || '');

  const setCurrentUserData = (user) => {
    setCurrentUser(user);
    if (user?.id) {
      localStorage.setItem('USER_ID', user.id); // Store user ID in localStorage
    } else {
      localStorage.removeItem('USER_ID'); // Remove user ID from localStorage if no user
    }
  };

  const setUserToken = (token) => {
    if (token) {
      localStorage.setItem('TOKEN', token); // Store token in localStorage
    } else {
      localStorage.removeItem('TOKEN'); // Remove token from localStorage if not available
    }
    setUserTokenState(token); // Update state with the token
  };

  return (
    <StateContext.Provider
      value={{
        currentUser,
        setCurrentUser: setCurrentUserData,
        userToken,
        setUserToken,
      }}
    >
      {children}
    </StateContext.Provider>
  );
};

// Custom hook to access context values in components
export const useStateContext = () => useContext(StateContext);
