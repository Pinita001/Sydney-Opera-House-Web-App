<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shows - Sydney Opera House</title>
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
                <li class="nav-item">
                    <a href="carts.php" class="nav-link" data-page="cart">
                        Cart
                        <span class="cart-badge" id="cartBadge">0</span>
                    </a>
                </li>
                <li class="nav-item"><a href="experiences.php" class="nav-link" data-page="experiences">Experiences</a></li>
                <li class="nav-item"><a href="account.php" class="nav-link" data-page="account">Account</a></li>
                <li class="nav-item">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <a href="logout.php" class="nav-link" id="logoutLink">Logout</a>
                    <?php else: ?>
                        <a href="account.php" class="nav-link" id="headerLoginLink">Login</a>
                    <?php endif; ?>
                </li>
            </ul>
        </div>
    </header>

    <section class="featured-shows">
        <div class="container">
            <h2 class="section-title">All <span>Shows</span></h2>
            <div class="show-grid">
                
                <div class="show-card">
                    <img src="show1.png" alt="La Traviata" class="show-image">
                    <div class="show-info">
                        <h3>La Traviata</h3>
                        <div class="show-meta">
                            <div class="show-venue"><i class="fas fa-map-marker-alt"></i> Main Hall</div>
                            <div class="show-date"><i class="far fa-calendar-alt"></i> November, 2025</div>
                        </div>
                        <p>Experience Verdi's passionate tale of love and sacrifice.</p>
                        <div class="show-price">$120.00</div>
                        <div class="show-actions">
                            <details id="details-1">
                                <summary>More Details</summary>
                                <p>A three-act opera by Giuseppe Verdi to an Italian libretto. The production features world-class singers and the Opera Australia Chorus.</p>
                            </details>
                            <select class="showtime-select">
                                <option value="">Select a Showtime</option>
                                <option value="Nov 10 - 7:30 PM - $120.00">Nov 10, 7:30 PM</option>
                                <option value="Nov 11 - 2:00 PM - $100.00">Nov 11, 2:00 PM (Matinee)</option>
                                <option value="Nov 14 - 6:00 PM - $110.00">Nov 14, 6:00 PM</option>
                            </select>
                            <div class="quantity-add-to-cart">
                                <input type="number" class="quantity-input" value="1" min="1" max="10">
                                <button class="btn add-to-cart-btn" onclick="addToCart(this)">Add to Cart</button>
                            </div>
                        </div>
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
                        <div class="show-actions">
                            <details id="details-2">
                                <summary>More Details</summary>
                                <p>The classic tale of Odette, a princess turned into a swan by an evil sorcerer's curse, featuring stunning choreography.</p>
                            </details>
                            <select class="showtime-select">
                                <option value="">Select a Showtime</option>
                                <option value="Nov 18 - 7:30 PM - $150.00">Nov 18, 7:30 PM</option>
                                <option value="Nov 19 - 2:00 PM - $120.00">Nov 19, 2:00 PM (Matinee)</option>
                                <option value="Nov 21 - 6:00 PM - $135.00">Nov 21, 6:00 PM</option>
                            </select>
                            <div class="quantity-add-to-cart">
                                <input type="number" class="quantity-input" value="1" min="1" max="10">
                                <button class="btn add-to-cart-btn" onclick="addToCart(this)">Add to Cart</button>
                            </div>
                        </div>
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
                        <div class="show-actions">
                            <details id="details-3">
                                <summary>More Details</summary>
                                <p>The orchestra presents a selection of iconic classical works from composers like Beethoven and Mozart in the stunning Concert Hall.</p>
                            </details>
                            <select class="showtime-select">
                                <option value="">Select a Showtime</option>
                                <option value="Nov 25 - 7:30 PM - $95.00">Nov 25, 7:30 PM</option>
                                <option value="Nov 26 - 2:00 PM - $85.00">Nov 26, 2:00 PM (Matinee)</option>
                            </select>
                            <div class="quantity-add-to-cart">
                                <input type="number" class="quantity-input" value="1" min="1" max="10">
                                <button class="btn add-to-cart-btn" onclick="addToCart(this)">Add to Cart</button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="show-card">
                    <img src="show13.png" alt="Matilda The Musical" class="show-image">
                    <div class="show-info">
                        <h3>Matilda The Musical</h3>
                        <div class="show-meta">
                            <div class="show-venue"><i class="fas fa-map-marker-alt"></i> Lyric Theatre</div>
                            <div class="show-date"><i class="far fa-calendar-alt"></i> December, 2025</div>
                        </div>
                        <p>The acclaimed musical based on the beloved Roald Dahl novel.</p>
                        <div class="show-price">$130.00</div>
                        <div class="show-actions">
                            <details id="details-4">
                                <summary>More Details</summary>
                                <p>This hilarious and heartwarming show is a must-see for all ages. Limited run.</p>
                            </details>
                            <select class="showtime-select">
                                <option value="">Select a Showtime</option>
                                <option value="Dec 5 - 8:00 PM - $130.00">Dec 5, 8:00 PM</option>
                                <option value="Dec 7 - 2:30 PM - $115.00">Dec 7, 2:30 PM (Matinee)</option>
                            </select>
                            <div class="quantity-add-to-cart">
                                <input type="number" class="quantity-input" value="1" min="1" max="10">
                                <button class="btn add-to-cart-btn" onclick="addToCart(this)">Add to Cart</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="show-card">
                    <img src="show4.png" alt="The Phantom of the Opera" class="show-image">
                    <div class="show-info">
                        <h3>The Phantom of the Opera</h3>
                        <div class="show-meta">
                            <div class="show-venue"><i class="fas fa-map-marker-alt"></i> Capitol Theatre</div>
                            <div class="show-date"><i class="far fa-calendar-alt"></i> December, 2025</div>
                        </div>
                        <p>Andrew Lloyd Webber's timeless musical returns to Sydney.</p>
                        <div class="show-price">$145.00</div>
                        <div class="show-actions">
                            <details id="details-5">
                                <summary>More Details</summary>
                                <p>A romantic tragedy featuring the classic score and stunning visuals.</p>
                            </details>
                            <select class="showtime-select">
                                <option value="">Select a Showtime</option>
                                <option value="Dec 12 - 7:00 PM - $145.00">Dec 12, 7:00 PM</option>
                                <option value="Dec 13 - 1:00 PM - $125.00">Dec 13, 1:00 PM (Matinee)</option>
                            </select>
                            <div class="quantity-add-to-cart">
                                <input type="number" class="quantity-input" value="1" min="1" max="10">
                                <button class="btn add-to-cart-btn" onclick="addToCart(this)">Add to Cart</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="show-card">
                    <img src="show5.png" alt="Sydney Dance Company" class="show-image">
                    <div class="show-info">
                        <h3>Sydney Dance Company</h3>
                        <div class="show-meta">
                            <div class="show-venue"><i class="fas fa-map-marker-alt"></i> Roslyn Packer Theatre</div>
                            <div class="show-date"><i class="far fa-calendar-alt"></i> January, 2026</div>
                        </div>
                        <p>A contemporary double bill of world-class Australian choreography.</p>
                        <div class="show-price">$105.00</div>
                        <div class="show-actions">
                            <details id="details-6">
                                <summary>More Details</summary>
                                <p>Powerful and evocative movement that pushes the boundaries of modern dance.</p>
                            </details>
                            <select class="showtime-select">
                                <option value="">Select a Showtime</option>
                                <option value="Jan 2 - 8:00 PM - $105.00">Jan 2, 8:00 PM</option>
                                <option value="Jan 3 - 6:00 PM - $95.00">Jan 3, 6:00 PM</option>
                            </select>
                            <div class="quantity-add-to-cart">
                                <input type="number" class="quantity-input" value="1" min="1" max="10">
                                <button class="btn add-to-cart-btn" onclick="addToCart(this)">Add to Cart</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="show-card">
                    <img src="show6.png" alt="A Midsummer Night's Dream" class="show-image">
                    <div class="show-info">
                        <h3>A Midsummer Night's Dream</h3>
                        <div class="show-meta">
                            <div class="show-venue"><i class="fas fa-map-marker-alt"></i> Opera Theatre</div>
                            <div class="show-date"><i class="far fa-calendar-alt"></i> January, 2026</div>
                        </div>
                        <p>Shakespeare's enchanting comedy brought to life by the Bell Shakespeare Company.</p>
                        <div class="show-price">$80.00</div>
                        <div class="show-actions">
                            <details id="details-7">
                                <summary>More Details</summary>
                                <p>Follow the comedic adventures of four young lovers and a group of actors in a mystical forest.</p>
                            </details>
                            <select class="showtime-select">
                                <option value="">Select a Showtime</option>
                                <option value="Jan 10 - 7:30 PM - $80.00">Jan 10, 7:30 PM</option>
                                <option value="Jan 11 - 2:00 PM - $65.00">Jan 11, 2:00 PM (Matinee)</option>
                            </select>
                            <div class="quantity-add-to-cart">
                                <input type="number" class="quantity-input" value="1" min="1" max="10">
                                <button class="btn add-to-cart-btn" onclick="addToCart(this)">Add to Cart</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="show-card">
                    <img src="show7.png" alt="Tame Impala Concert" class="show-image">
                    <div class="show-info">
                        <h3>Tame Impala</h3>
                        <div class="show-meta">
                            <div class="show-venue"><i class="fas fa-map-marker-alt"></i> Concert Hall</div>
                            <div class="show-date"><i class="far fa-calendar-alt"></i> February, 2026</div>
                        </div>
                        <p>The iconic Australian psychedelic rock band plays a one-off special performance.</p>
                        <div class="show-price">$175.00</div>
                        <div class="show-actions">
                            <details id="details-8">
                                <summary>More Details</summary>
                                <p>Experience a full band show with immersive visuals and soundscapes.</p>
                            </details>
                            <select class="showtime-select">
                                <option value="">Select a Showtime</option>
                                <option value="Feb 5 - 9:00 PM - $175.00">Feb 5, 9:00 PM</option>
                            </select>
                            <div class="quantity-add-to-cart">
                                <input type="number" class="quantity-input" value="1" min="1" max="10">
                                <button class="btn add-to-cart-btn" onclick="addToCart(this)">Add to Cart</button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="show-card">
                    <img src="show8.png" alt="LUZIA" class="show-image">
                    <div class="show-info">
                        <h3>Cirque du Soleil: LUZIA</h3>
                        <div class="show-meta">
                            <div class="show-venue"><i class="fas fa-map-marker-alt"></i> Big Top, Entertainment Quarter</div>
                            <div class="show-date"><i class="far fa-calendar-alt"></i> March, 2026</div>
                        </div>
                        <p>A dazzling journey through an imaginary Mexico, filled with visual surprises.</p>
                        <div class="show-price">$160.00</div>
                        <div class="show-actions">
                            <details id="details-9">
                                <summary>More Details</summary>
                                <p>In a series of breathtaking acrobatic performances, LUZIA brings the stage to life with rain and stunning visual poetry.</p>
                            </details>
                            <select class="showtime-select">
                                <option value="">Select a Showtime</option>
                                <option value="Mar 10 - 7:30 PM - $160.00">Mar 10, 7:30 PM</option>
                                <option value="Mar 11 - 5:00 PM - $150.00">Mar 11, 5:00 PM</option>
                            </select>
                            <div class="quantity-add-to-cart">
                                <input type="number" class="quantity-input" value="1" min="1" max="10">
                                <button class="btn add-to-cart-btn" onclick="addToCart(this)">Add to Cart</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="show-card">
                    <img src="show10.png" alt="Chicago The Musical" class="show-image">
                    <div class="show-info">
                        <h3>Chicago The Musical</h3>
                        <div class="show-meta">
                            <div class="show-venue"><i class="fas fa-map-marker-alt"></i> Main Hall</div>
                            <div class="show-date"><i class="far fa-calendar-alt"></i> April, 2026</div>
                        </div>
                        <p>Razzle Dazzle 'em with this long-running, sizzling hot Broadway hit.</p>
                        <div class="show-price">$135.00</div>
                        <div class="show-actions">
                            <details id="details-10">
                                <summary>More Details</summary>
                                <p>A story of murder, greed, corruption, violence, exploitation, adultery, and treachery-all those things we hold dear to our hearts.</p>
                            </details>
                            <select class="showtime-select">
                                <option value="">Select a Showtime</option>
                                <option value="Apr 1 - 7:30 PM - $135.00">Apr 1, 7:30 PM</option>
                                <option value="Apr 2 - 2:00 PM - $110.00">Apr 2, 2:00 PM (Matinee)</option>
                            </select>
                            <div class="quantity-add-to-cart">
                                <input type="number" class="quantity-input" value="1" min="1" max="10">
                                <button class="btn add-to-cart-btn" onclick="addToCart(this)">Add to Cart</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="show-card">
                    <img src="show11.png" alt="Sydney Film Festival" class="show-image">
                    <div class="show-info">
                        <h3>Sydney Film Festival</h3>
                        <div class="show-meta">
                            <div class="show-venue"><i class="fas fa-map-marker-alt"></i> Various Venues</div>
                            <div class="show-date"><i class="far fa-calendar-alt"></i> June, 2026</div>
                        </div>
                        <p>Explore the best of world cinema at this annual event.</p>
                        <div class="show-price">$25.00</div>
                        <div class="show-actions">
                            <details id="details-11">
                                <summary>More Details</summary>
                                <p>Individual tickets and passes available for screenings across the city.</p>
                            </details>
                            <select class="showtime-select">
                                <option value="">Select a Showtime</option>
                                <option value="June 1 - 7:00 PM - $25.00">Opening Night Screening</option>
                                <option value="June 2 - 4:00 PM - $20.00">Afternoon Pass</option>
                            </select>
                            <div class="quantity-add-to-cart">
                                <input type="number" class="quantity-input" value="1" min="1" max="10">
                                <button class="btn add-to-cart-btn" onclick="addToCart(this)">Add to Cart</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="show-card">
                    <img src="show12.png" alt="Australian Chamber Orchestra" class="show-image">
                    <div class="show-info">
                        <h3>Australian Chamber Orchestra</h3>
                        <div class="show-meta">
                            <div class="show-venue"><i class="fas fa-map-marker-alt"></i> Concert Hall</div>
                            <div class="show-date"><i class="far fa-calendar-alt"></i> June, 2026</div>
                        </div>
                        <p>A festive concert of Baroque and contemporary classics.</p>
                        <div class="show-price">$115.00</div>
                        <div class="show-actions">
                            <details id="details-12">
                                <summary>More Details</summary>
                                <p>Led by Richard Tognetti, the ACO delivers a powerful and intimate performance.</p>
                            </details>
                            <select class="showtime-select">
                                <option value="">Select a Showtime</option>
                                <option value="June 20 - 7:30 PM - $115.00">June 20, 7:30 PM</option>
                                <option value="June 21 - 2:00 PM - $90.00">June 21, 2:00 PM (Matinee)</option>
                            </select>
                            <div class="quantity-add-to-cart">
                                <input type="number" class="quantity-input" value="1" min="1" max="10">
                                <button class="btn add-to-cart-btn" onclick="addToCart(this)">Add to Cart</button>
                            </div>
                        </div>
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
    
    <script src="cart-store.js"></script>
<script>
    /*
         * addToCart(buttonElement)
         * ------------------------
         * Handles user interaction when "Add to Cart" is clicked:
         *  1. Validates the selected showtime and quantity.
         *  2. Creates a cart item object with show info.
         *  3. Saves it into browser localStorage (via cart-store.js).
         *  4. Calls updateCartBadge() to refresh cart counter in header.
         */
        
        function addToCart(buttonElement) {
            const showCard = buttonElement.closest('.show-card');
            const selectElement = showCard.querySelector('.showtime-select');
            const selectedOption = selectElement.options[selectElement.selectedIndex].value;
            const showName = showCard.querySelector('h3').textContent;
            
            // Get the quantity from the new input field
            const quantityInput = showCard.querySelector('.quantity-input');
            const quantity = parseInt(quantityInput.value, 10);

            if (selectedOption === "") {
                alert(`Please select a showtime for ${showName}.`);
                return;
            }
            if (quantity < 1 || isNaN(quantity)) {
                alert(`Please enter a valid quantity for ${showName}.`);
                return;
            }
            
            // Extract selected show details (e.g., "May 10 - 7:30 PM - $120.00")
            const parts = selectedOption.split(' - ');
            const date = parts[0];
            const time = parts[1];
            const priceStr = parts[2];

            const price = parseFloat(priceStr.replace('$', '').replace(' (Matinee)', ''));
            
            const cartItem = {
                showName: showName,
                showtime: `${date} - ${time}`,
                quantity: quantity, 
                price: price
            };

            // Save to localStorage
            let cart = readCartArr();
            cart.push(cartItem);
            writeCartArr(cart);
            
            // Call the global badge update function (from cart-badge.js)
            if (typeof updateCartBadge === 'function') {
                updateCartBadge();
            }

            alert(`Added ${quantity} tickets for ${showName} at ${date}, ${time} to your cart!`);
        }
    </script>
    
    <script src="cart-badge.js"></script> 
    <script src="shows-ui-fix.js"></script></body>
</html>