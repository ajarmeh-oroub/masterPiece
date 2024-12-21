import React from 'react';

export default function ThanksForPurchasing() {
  return (
    <section className="thanks-for-purchasing spad">
      <div className="container">
        <div className="thanks-for-purchasing__content text-center">
          <h2>Thank you for your purchase!</h2>
          <p>Your order has been successfully placed. We are preparing your items for shipment.</p>
          <p>You will receive an email confirmation shortly with the details of your order.</p>
          <button className="site-btn" onClick={() => window.location.href = '/'}>Go to Home</button>
        </div>
      </div>
    </section>
  );
}
