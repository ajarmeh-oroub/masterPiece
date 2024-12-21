import React, { useEffect, useState } from "react";
import "./user.css";
import { getUserData, updateUserData } from "../../services/api";
import Address from "./Address";

const UserProfile = () => {
  const [activeTab, setActiveTab] = useState("user-data");
  const [user, setUser] = useState(null);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    const fetchUser = async () => {
      let id = 1; // Assume user ID is 1 for now
      try {
        const fetchedUser = await getUserData(id);
        setUser(fetchedUser);
        setLoading(false);
      } catch (error) {
        console.error("Error fetching user data:", error);
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
    let id = 1; // Assume user ID is 1 for now
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
              <ul className="nav nav-pills flex-column" id="tabs" role="tablist">
                <li className="nav-item" role="presentation">
                  <a
                    className={`nav-link ${activeTab === "user-data" ? "active" : ""}`}
                    style={{
                      backgroundColor: activeTab === "user-data" ? "#F3F2EE" : "",
                      color: activeTab === "user-data" ? "black" : "",
                    }}
                    onClick={() => handleTabChange("user-data")}
                  >
                    User Data
                  </a>
                </li>
                <li className="nav-item" role="presentation">
                  <a
                    className={`nav-link ${activeTab === "delivery" ? "active" : ""}`}
                    style={{
                      backgroundColor: activeTab === "delivery" ? "#F3F2EE" : "",
                      color: activeTab === "delivery" ? "black" : "",
                    }}
                    onClick={() => handleTabChange("delivery")}
                  >
                    Delivery Addresses
                  </a>
                </li>
                <li className="nav-item" role="presentation">
                  <a
                    className={`nav-link ${activeTab === "orders" ? "active" : ""}`}
                    style={{
                      backgroundColor: activeTab === "orders" ? "#F3F2EE" : "",
                      color: activeTab === "orders" ? "black" : "",
                    }}
                    onClick={() => handleTabChange("orders")}
                  >
                    Orders
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
            {activeTab === "user-data" && user && (
              <div className="tab-pane fade show active" role="tabpanel">
                <h3>User Information</h3>
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

            {/* Delivery Tab */}
            {activeTab === "delivery" && (
              <div className="tab-pane fade" role="tabpanel">
                <h3>Delivery Addresses</h3>
                <div className="user-data-box p-4 rounded shadow-sm">
                  <div className="mb-3">
                    <label htmlFor="address" className="form-label">
                      Address
                    </label>
                    <input
                      type="text"
                      id="address"
                      name="address"
                      value={user.address || ""}
                      onChange={handleInputChange}
                      className="form-control"
                      disabled
                    />
                    <Address />
                  </div>
                </div>
              </div>
            )}

            {/* Orders Tab */}
            {activeTab === "orders" && (
              <div className="tab-pane fade" role="tabpanel">
                <h3>Orders</h3>
                {user.orders && user.orders.length > 0 ? (
                  <ul className="list-group">
                    {user.orders.map((order) => (
                      <li key={order.id} className="list-group-item">
                        <h5>Order #{order.id}</h5>
                        <p>Status: <span className="badge bg-info">{order.status}</span></p>
                        <p>Total: ${parseFloat(order.total).toFixed(2)}</p>
                        <p>Created At: {new Date(order.created_at).toLocaleDateString()}</p>
                        <button className="btn btn-primary">View Order Details</button>
                      </li>
                    ))}
                  </ul>
                ) : (
                  <p>No orders found.</p>
                )}
              </div>
            )}
          </div>
        </div>
      </div>
    </div>
  );
};

export default UserProfile;
