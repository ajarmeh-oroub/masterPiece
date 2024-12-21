import React, { useEffect, useState } from "react";
import "./user.css";
import { getUserData, updateUserData } from "../../services/api";
import Address from "./Address";

const UserProfile = () => {
  const [activeTab, setActiveTab] = useState("user-data");
  const [user, setUser] = useState("");
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    const fetchUser = async () => {
      let id = 1;
      try {
        const fetchedUser = await getUserData(id);
        setUser(fetchedUser);
        setLoading(false);
      } catch (error) {
        console.log(error);
      }
    };

    fetchUser();
  }, []);

  // Handler to switch active tab
  const handleTabChange = (tab) => {
    setActiveTab(tab);
  };

  // Handler to update user data
  const handleInputChange = (e) => {
    const { name, value } = e.target;
    setUser((prevData) => ({
      ...prevData,
      [name]: value,
    }));
  };

  const handleSaveChanges = async () => {
    let id = 1;
    try {
      await updateUserData(id, user);
      Swal.fire({
        icon: "success",
        title: "Success!",
        text: "User data updated successfully!",
      });
    } catch (error) {
      console.error("Error updating user data:", error);
      Swal.fire({
        icon: "error",
        title: "Oops...",
        text: "Failed to update user data. Please try again.",
      });
    } finally {
      setLoading(false);
    }
  };

  return (
    <div className="containerUser container mt-5">
      <div className="row">
        {/* Left Column with Card and Tabs */}
        <div className="col-lg-3">
          <div className="card">
            <div className="card-body">
              <ul
                className="nav nav-pills flex-column"
                id="tabs"
                role="tablist"
              >
                <li className="nav-item" role="presentation">
                  <a
                    className={`nav-link ${
                      activeTab === "user-data" ? "active" : ""
                    }`}
                    style={{
                      backgroundColor:
                        activeTab === "user-data" ? "#F3F2EE" : "",
                      color: activeTab === "user-data" ? "black" : "",
                    }}
                    onClick={() => handleTabChange("user-data")}
                  >
                    User Data
                  </a>
                </li>
                <li className="nav-item" role="presentation">
                  <a
                    className={`nav-link ${
                      activeTab === "Delivery" ? "active" : ""
                    }`}
                    style={{
                      backgroundColor:
                        activeTab === "Delivery" ? "#F3F2EE" : "",
                      color: activeTab === "Delivery" ? "black" : "",
                    }}
                    onClick={() => handleTabChange("Delivery")}
                  >
                    Delivery Addresses
                  </a>
                </li>
                <li className="nav-item" role="presentation">
                  <a
                    className={`nav-link ${
                      activeTab === "orders" ? "active" : ""
                    }`}
                    style={{
                      backgroundColor: activeTab === "orders" ? "#F3F2EE" : "",
                      color: activeTab === "orders" ? "black" : "",
                    }}
                    onClick={() => handleTabChange("orders")}
                  >
                    Track Orders
                  </a>
                </li>
                <li className="nav-item" role="presentation">
                  <a
                    className={`nav-link ${
                      activeTab === "favorites" ? "active" : ""
                    }`}
                    style={{
                      backgroundColor:
                        activeTab === "favorites" ? "#F3F2EE" : "",
                      color: activeTab === "favorites" ? "black" : "",
                    }}
                    onClick={() => handleTabChange("favorites")}
                  >
                    Favorites
                  </a>
                </li>
              </ul>
            </div>
          </div>
        </div>

        {/* Right Column displaying content based on active tab */}
        <div className="col-lg-9">
          <div className="tab-content" id="myTabContent">
            {/* User Data Tab Content */}
            {activeTab === "user-data" && (
              <div
                className="tab-pane fade show active"
                id="user-data"
                role="tabpanel"
              >
                <h3 style={{ color: "black" }}>User Information</h3>
                <div className="user-data-box p-4 rounded shadow-sm">
                  <div className="mb-3">
                    <label htmlFor="first_name" className="form-label">
                      First Name
                    </label>
                    <input
                      type="text"
                      id="first_name"
                      name="first_name"
                      value={user.first_name || ""}
                      onChange={handleInputChange}
                      className="form-control"
                    />
                  </div>
                  <div className="mb-3">
                    <label htmlFor="last_name" className="form-label">
                      Last Name
                    </label>
                    <input
                      type="text"
                      id="last_name"
                      name="last_name"
                      value={user.last_name || ""}
                      onChange={handleInputChange}
                      className="form-control"
                    />
                  </div>
                  <div className="mb-3">
                    <label htmlFor="email" className="form-label">
                      Email
                    </label>
                    <input
                      type="email"
                      id="email"
                      name="email"
                      value={user.email || ""}
                      onChange={handleInputChange}
                      className="form-control"
                    />
                  </div>
                  <div className="mb-3">
                    <label htmlFor="phone" className="form-label">
                      Phone
                    </label>
                    <input
                      type="text"
                      id="phone"
                      name="phone"
                      value={user.phone || ""}
                      onChange={handleInputChange}
                      className="form-control"
                    />
                  </div>
                  <button
                    className="btn"
                    style={{ color: "white", background: "black" }}
                    onClick={handleSaveChanges}
                    disabled={loading}
                  >
                    {loading ? "Saving..." : "Save Changes"}
                  </button>
                </div>
              </div>
            )}

            {/* delivery addresses tab */}
            {activeTab === "Delivery" && (
              <div
                className="tab-pane fade show active"
                id="user-data"
                role="tabpanel"
              >
                <h3 style={{ color: "black" }}>Delivery Addresses</h3>
                <div className="user-data-box p-4 rounded shadow-sm">
                  <div className="mb-3">
                    <label htmlFor="first_name" className="form-label">
                      Address
                    </label>
                    <input
                      type="text"
                      id="first_name"
                      name="first_name"
                      value={user.address.address}
                      onChange={handleInputChange}
                      className="form-control"
                      disabled
                    />
                    <Address />
                  </div>
                </div>
              </div>
            )}
            {/* Orders Tab Content */}
            {activeTab === "orders" && (
              <div className="tab-pane fade" id="orders" role="tabpanel">
                <h3>Order History</h3>
                {user.orders && user.orders.length > 0 ? (
                  <ul className="list-group">
                    {user.orders.map((order) => (
                      <li key={order.id} className="list-group-item">
                        <h5>Order #{order.id}</h5>
                        <p>
                          Status:{" "}
                          <span className="badge bg-info">{order.status}</span>
                        </p>
                        <p>Total: ${parseFloat(order.total).toFixed(2)}</p>
                        <p>
                          Created At:{" "}
                          {new Date(order.created_at).toLocaleDateString()}
                        </p>

                        {order.order_items ? (
                          <ul>
                            {order.order_items.map((item, index) => (
                              <li key={index}>
                                {item.product_name} - {item.quantity} x $
                                {item.price}
                              </li>
                            ))}
                          </ul>
                        ) : (
                          <p>No order items listed.</p>
                        )}
                        <button className="btn btn-primary">
                          View Order Details
                        </button>
                      </li>
                    ))}
                  </ul>
                ) : (
                  <p>No orders available.</p>
                )}
              </div>
            )}

            {/* Favorites Tab Content */}
            {activeTab === "favorites" && (
              <div className="tab-pane fade" id="favorites" role="tabpanel">
                <h3>Your Favorite Products</h3>
                <div className="row">
                  {favorites.map((product) => (
                    <div className="col-md-4" key={product.id}>
                      <div className="card">
                        <img
                          src={product.img}
                          alt={product.name}
                          className="card-img-top"
                          style={{ height: "200px", objectFit: "cover" }}
                        />
                        <div className="card-body">
                          <h5 className="card-title">{product.name}</h5>
                          <p className="card-text">{product.price}</p>
                          <button className="btn btn-danger">Remove</button>
                        </div>
                      </div>
                    </div>
                  ))}
                </div>
              </div>
            )}
          </div>
        </div>
      </div>
    </div>
  );
};

export default UserProfile;
