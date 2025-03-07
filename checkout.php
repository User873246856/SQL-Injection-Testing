<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="stylesheets/checkout.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>Checkout</h1>
            <nav>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="new_food_drink.php">Menu</a></li>
                    <li><a href="upcomingfilms.php">Upcoming Films</a></li>
                    <li><a href="contact.php">Contact Us</a></li>
                    <li><a href="cart.php">Cart</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main>
        <div class="checkout-container">
            <h2>Complete Your Payment</h2>
            <p>Select your preferred payment method below:</p>

            <div class="payment-options">
                <!-- Credit/Debit Card Option -->
                <div class="payment-option">
                    <h3>Pay with Card</h3>
                    <p>Secure payment powered by Third-Party Gateway.</p>
                    <form action="#" method="post">
                        <div class="form-group">
                            <label for="card-number">Card Number:</label>
                            <input type="text" id="card-number" name="card-number" placeholder="1234 5678 9012 3456" disabled>
                        </div>
                        <div class="form-group">
                            <label for="expiry">Expiry Date:</label>
                            <input type="text" id="expiry" name="expiry" placeholder="MM/YY" disabled>
                        </div>
                        <div class="form-group">
                            <label for="cvv">CVV:</label>
                            <input type="text" id="cvv" name="cvv" placeholder="123" disabled>
                        </div>
                        <button type="submit" class="disabled-btn">Pay Now</button>
                    </form>
                </div>

                <!-- PayPal Option -->
                <div class="payment-option">
                    <h3>Pay with PayPal</h3>
                    <p>Quick and easy checkout with PayPal.</p>
                    <button class="paypal-btn">Pay with PayPal</button>
                </div>
            </div>
        </div>
    </main>

    <footer>
        <p>© 2025 Projection Room. All Rights Reserved.</p>
    </footer>
</body>
</html>
