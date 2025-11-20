<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sydney Opera House - Book Tickets</title>
    <link rel="stylesheet" href="styles.css">

</head>
<body>
    <header>
        <div class="nav-container">
            <div class="logo-container">
                <img src="logos.png" alt="Sydney Opera House" class="logo">
            </div>
            <ul class="nav-menu">
                <li class="nav-item"><a href="index.php" class="nav-link" data-page="home">Home</a></li>
                <li class="nav-item"><a href="shows.php" class="nav-link" data-page="shows">Shows</a></li>

                <!-- Cart link: includes a dynamic badge that updates from JS -->
                <li class="nav-item">
                    <a href="carts.php" class="nav-link" data-page="cart">
                        Cart
                        <span class="cart-badge" id="cartBadge">0</span>
                    </a>
                </li>
                <li class="nav-item"><a href="experiences.php" class="nav-link" data-page="experiences">Experiences</a></li>
                <li class="nav-item"><a href="account.php" class="nav-link" data-page="account">Account</a></li>

                <!-- PHP conditional logic: show "Logout" if user is logged in, else "Login" -->
                <li class="nav-item">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <!-- User is logged in -->
                        <a href="logout.php" class="nav-link" id="logoutLink">Logout</a>
                    <?php else: ?>
                        <!-- Guest or not logged in -->
                        <a href="account.php" class="nav-link" id="headerLoginLink">Login</a>
                    <?php endif; ?>
                </li>
            </ul>
        </div>
    </header>

    <section class="hero">
        <div class="hero-content">
            <h1 class="hero-title-style fancy-font">Experience the Magic of Sydney's Opera House</h1>
            <p>Book tickets to world-class opera, ballet, theatre, and concerts.</p>
            <a href="shows.php" class="btn primary-btn">Explore Shows</a>
        </div>
    </section>

    <section class="history-section content-split-section">
        <div class="container">
            <h2 class="section-title">History of the <span>Opera House</span></h2>
            <div class="history-content">
                <div class="content-text">
                    <p>Conceived by Jørn Utzon and opened in 1973, the **Sydney Opera House** is a UNESCO World Heritage site. Its iconic sail-like design makes it one of the most recognizable buildings of the 20th century. Construction took 14 years and required 10,000 workers.</p>
                    <p>It remains a testament to human ingenuity and is celebrated globally as a cultural landmark, representing both modern architecture and Australian identity.</p>
                </div>
                <div class="content-image history-image">
                    <img src="aboutus.png" alt="La Traviata" class="show-image">
                    </div>
            </div>
        </div>
    </section>

    <section class="about-us content-box-section">
        <div class="container">
            <h2 class="section-title">About <span>Us</span></h2>
            <div class="about-content">
                <p>The Sydney Opera House is an architectural masterpiece and a world-class performing arts venue. As one of the world's busiest cultural hubs, we host over 1,500 performances and welcome more than 10.9 million visitors every year.</p>
                <p>Our mission is to **treasure and renew** the Opera House for future generations of artists, audiences and visitors, and to inspire, provoke and encourage the pursuit of the beautiful.</p>
            </div>
        </div>
    </section>

    <section class="featured-shows">
        <div class="container">
            <h2 class="section-title">Popular <span>Now</span></h2>
            <div class="show-grid">
                <div class="show-card">
                    <img src="show1.png" alt="La Traviata" class="show-image">
                    <div class="show-info">
                        <h3>La Traviata</h3>
                        <div class="show-meta">
                            <div class="show-venue"><i class="fas fa-map-marker-alt"></i> Main Hall</div>
                            <div class="show-date"><i class="far fa-calendar-alt"></i> November, 2025</div>
                        </div>
                        <p>Verdi's passionate tale of love and sacrifice returns.</p>
                        <div class="show-price">$120.00</div>
                        <a href="shows.html?open=1" class="btn primary-btn">Book Tickets</a>
                    </div>
                </div>

                <div class="show-card">
                    <img src="show2.png" alt="Swan Lake" class="show-image">
                    <div class="show-info">
                        <h3>Swan Lake</h3>
                        <div class="show-meta">
                            <div class="show-venue"><i class="fas fa-map-marker-alt"></i> Concert Hall</div>
                            <div class="show-date"><i class="far fa-calendar-alt"></i> November, 2025</div>
                        </div>
                        <p>The Australian Ballet presents Tchaikovsky's timeless masterpiece.</p>
                        <div class="show-price">$150.00</div>
                        <a href="shows.html?open=2" class="btn primary-btn">Book Tickets</a>
                    </div>
                </div>

                <div class="show-card">
                    <img src="show3.png" alt="Sydney Symphony Orchestra" class="show-image">
                    <div class="show-info">
                        <h3>Sydney Symphony Orchestra</h3>
                        <div class="show-meta">
                            <div class="show-venue"><i class="fas fa-map-marker-alt"></i> Concert Hall</div>
                            <div class="show-date"><i class="far fa-calendar-alt"></i> November, 2025</div>
                        </div>
                        <p>A night of classical masterpieces performed by Australia's finest musicians.</p>
                        <div class="show-price">$95.00</div>
                        <a href="shows.html?open=3" class="btn primary-btn">Book Tickets</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer>
        <div class="footer-content">
            <div class="footer-column">
                <h3>Sydney Opera House</h3>
                <p>Bennelong Point<br>Sydney NSW 2000<br>Australia</p>
            </div>
            <div class="footer-column">
                <h3>Quick Links</h3>
                <ul class="footer-links">
                    <li><a href="shows.php">What's On</a></li>
                    <li><a href="account.php">My Account</a></li>
                </ul>
            </div>
        </div>
    </footer>

    <!-- Handles adding/removing items from localStorage/sessionStorage -->
    <script src="cart-store.js"></script>
     <!-- Updates cart badge count beside “Cart” on the nav bar -->
    <script src="cart-badge.js"></script>
</body>
</html>