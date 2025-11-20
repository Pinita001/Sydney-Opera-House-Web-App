<?php session_start(); require_once 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Experiences - Sydney Opera House</title>
  <link rel="stylesheet" href="styles.css">
  <style>
    /* tab styling */
    .tabs { display: flex; gap: 8px; justify-content: center; margin: 0 auto 20px; }
    .tab-btn { background: transparent; border: 2px solid var(--gray); padding: 10px 16px; border-radius: 6px; font-weight: 700; cursor: pointer; }
    .tab-btn.active { border-color: var(--primary); color: var(--primary); }
    .tab-panel { display: none; }
    .tab-panel.active { display: block; }
  
    .tab-intro {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
      gap: 16px;
      margin: 0 auto 30px;
      max-width: 1100px;
    }
    .intro-card {
      margin: 0; padding: 0;
      background: var(--white);
      border-radius: 8px;
      overflow: hidden;
      box-shadow: 0 4px 14px rgba(0,0,0,0.12);
      text-align: center;
    }
    .intro-card img {
      width: 100%;
      height: 200px;
      object-fit: cover;
      display: block;
    }
    .intro-card figcaption {
      padding: 12px 10px;
      font-weight: 700;
      color: var(--dark);
    }
  </style>

<?php
// Preload reserved times by date  
$__RESERVED_BY_DATE__ = [];  // Initialize an empty array to store all reservations grouped by date
try {
  if (isset($conn)) {   // Check if database connection ($conn) exists before running any query
    $q = $conn->query("SELECT DATE(date) AS d, TIME(time) AS t FROM reservations ORDER BY date, time");    // Execute SQL query to fetch all reservation dates and times, ordered chronologically
    if ($q) {     // Verify the query executed successfully before processing results
      while ($row = $q->fetch_assoc()) {       // Loop through each row of the query result set
        $d = $row['d'];  // Extract the reservation date (formatted as YYYY-MM-DD)
        $t = substr($row['t'], 0, 5);  // Extract only the first 5 characters of time (HH:MM format)
        if (!isset($__RESERVED_BY_DATE__[$d])) {  // If this date doesn't exist in the array yet, create a new subarray for it
          $__RESERVED_BY_DATE__[$d] = [];  
        }
        $__RESERVED_BY_DATE__[$d][] = $t;  // Add the time value under the corresponding date in the associative array
      }
      $q->close(); // Close the query result to free up database resources
    }
  }
} 
catch (Throwable $e) { 
  /* Silent fail: prevents fatal errors from breaking page rendering
     (e.g., if query fails or database is unavailable). */ 
}
?>

<script>
  // Convert the PHP array $__RESERVED_BY_DATE__ into a JSON object
  // and assign it to a JavaScript global variable `window.__RESERVED_BY_DATE__`
  // This makes reservation date/time data accessible in client-side scripts
  window.__RESERVED_BY_DATE__ = <?php echo json_encode($__RESERVED_BY_DATE__ ?? [], JSON_UNESCAPED_SLASHES); ?>; 
</script>
</script>
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
                    <a href="carts.php" class="nav-link" data-page="cart">Cart
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

  <section class="container"><h2 class="section-title">Experiences</h2>

    <!-- Tabs with intro images  (visible until a tab is selected)-->
<div id="tabIntro" class="tab-intro" aria-hidden="false">
      <a href="panel-tours" class="intro-link" data-target="panel-tours"><figure class="intro-card">
        <img src="tour.png" alt="Backstage Tours" />
        <figcaption>Tours &amp; Experiences</figcaption>
      </figure></a>
      <a href="#panel-dining" class="intro-link" data-target="panel-dining"><figure class="intro-card">
        <img src="dining.png" alt="Dining with harbour views" />
        <figcaption>Dining &amp; Private Events</figcaption>
      </figure></a>
      <a href="#panel-calendar" class="intro-link" data-target="panel-calendar"><figure class="intro-card">
        <img src="calendar.png" alt="Events calendar" />
        <figcaption>Events Calendar</figcaption>
      </figure></a>
    </div>

    <!-- Panel: Tours & Experiences -->
    <div class="tab-panel" id="panel-tours" role="tabpanel" aria-labelledby="tab-tours">
      <div class="show-grid">
        <div class="show-card">
          <img src="backstage.png" alt="Backstage Tour" class="show-image">
          <div class="show-info">
            <h3>Backstage Tour</h3>
            <p>Go behind the curtains and explore the inner workings of the Opera House.</p>
            <div class="show-price">$60.00</div>
            <div class="show-actions">
              <select class="showtime-select">
                <option value="">Select a time</option>
                <option value="Daily - 10:00 AM - $60.00">Daily, 10:00 AM</option>
                <option value="Daily - 2:00 PM - $60.00">Daily, 2:00 PM</option>
              </select>
              <div class="quantity-add-to-cart">
                <input type="number" class="quantity-input" value="1" min="1" max="10">
                <button class="btn add-to-cart-btn" onclick="addExperienceToCart(this)">Add to Cart</button>
              </div>
            </div>
          </div>
        </div>
        <div class="show-card">
          <img src="cruise.png" alt="Harbour Cruise" class="show-image">
          <div class="show-info">
            <h3>Harbour Cruise</h3>
            <p>Enjoy a scenic cruise with breathtaking views of the Sydney Harbour.</p>
            <div class="show-price">$85.00</div>
            <div class="show-actions">
              <select class="showtime-select">
                <option value="">Select a time</option>
                <option value="Weekends - 11:00 AM - $85.00">Weekends, 11:00 AM</option>
                <option value="Weekends - 4:00 PM - $85.00">Weekends, 4:00 PM</option>
              </select>
              <div class="quantity-add-to-cart">
                <input type="number" class="quantity-input" value="1" min="1" max="10">
                <button class="btn add-to-cart-btn" onclick="addExperienceToCart(this)">Add to Cart</button>
              </div>
            </div>
          </div>
        </div>
        <div class="show-card">
          <img src="archi.png" alt="Architecture Walk" class="show-image">
          <div class="show-info">
            <h3>Architecture Walk</h3>
            <p>Guided tour focusing on the iconic design and engineering of the Opera House.</p>
            <div class="show-price">$45.00</div>
            <div class="show-actions">
              <select class="showtime-select">
                <option value="">Select a time</option>
                <option value="Tue/Thu - 1:00 PM - $45.00">Tue/Thu, 1:00 PM</option>
                <option value="Sat - 3:00 PM - $45.00">Sat, 3:00 PM</option>
              </select>
              <div class="quantity-add-to-cart">
                <input type="number" class="quantity-input" value="1" min="1" max="10">
                <button class="btn add-to-cart-btn" onclick="addExperienceToCart(this)">Add to Cart</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

<div class="tab-panel" id="panel-dining" role="tabpanel" aria-labelledby="tab-dining"> <!-- Dining reservation tab container -->
  <section class="content-box-section"> <!-- Section wrapper for reservation form -->
    <div class="about-content"> <!-- Content container -->

      <p>Reserve a table at our partner restaurants or enquire about private event spaces.</p> <!-- Introductory message -->

      <form method="POST" action="reservation.php"> <!-- Form sends data to reservation.php using POST method -->

        <div class="form-group"> <!-- Full Name field -->
          <label for="resName">Full Name</label>
          <input type="text" id="resName" name="full_name" required> <!-- Required text input -->
        </div>

        <div class="form-group"> <!-- Email field -->
          <label for="resEmail">Email</label>
          <input type="email" id="resEmail" name="email" required> <!-- Validates email format -->
        </div>

        <div class="form-group"> <!-- Phone field -->
          <label for="resPhone">Phone</label>
          <input type="text" id="resPhone" name="phone" required> <!-- Required phone input -->
        </div>

        <div class="form-group-split"> <!-- Split layout for date and time inputs -->

          <div class="form-group"> <!-- Reservation Date -->
            <label for="resDate">Date</label>
            <?php
              date_default_timezone_set('Asia/Singapore'); // Set timezone to Singapore for accurate local date
              $today = date('Y-m-d'); // Get todays date in YYYY-MM-DD format
            ?>
            <input type="date" id="resDate" name="resDate" required min="<?= $today ?>"> <!-- Prevent selecting past dates -->
          </div>

          <div class="form-group"> <!-- Reservation Time -->
            <label for="resTime">Time</label>
            <select id="resTime" name="time" required> <!-- Dropdown with 30-min intervals -->
              <option value="12:00">12:00 PM</option>
              <option value="12:30">12:30 PM</option>
              <option value="13:00">1:00 PM</option>
              <option value="13:30">1:30 PM</option>
              <option value="14:00">2:00 PM</option>
              <option value="14:30">2:30 PM</option>
              <option value="15:00">3:00 PM</option>
              <option value="15:30">3:30 PM</option>
              <option value="16:00">4:00 PM</option>
              <option value="16:30">4:30 PM</option>
              <option value="17:00">5:00 PM</option>
              <option value="17:30">5:30 PM</option>
              <option value="18:00">6:00 PM</option>
              <option value="18:30">6:30 PM</option>
              <option value="19:00">7:00 PM</option>
              <option value="19:30">7:30 PM</option>
              <option value="20:00">8:00 PM</option>
              <option value="20:30">8:30 PM</option>
              <option value="21:00">9:00 PM</option>
            </select>
          </div>
        </div>

        <div class="form-group"> <!-- Number of Guests -->
          <label for="resGuests">Guests</label>
          <input type="number" id="resGuests" name="guests" min="1" max="20" value="2" required> <!-- Restricts guests between 1-20 -->
        </div>

        <div class="form-group"> <!-- Notes or special requests -->
          <label for="resNotes">Notes (Private Events / Occasion)</label>
          <input type="text" id="resNotes" name="notes"> <!-- Optional remarks field -->
        </div>

        <button type="submit" class="btn">Book Reservation</button> <!-- Submits form to reservation.php -->
      </form>
    </div>
  </section>
</div> <!-- End of dining reservation tab -->



    <!-- Panel: Events Calendar -->
    <div class="tab-panel" id="panel-calendar" role="tabpanel" aria-labelledby="tab-calendar">
      <section class="content-split-section">
        <div class="container" style="padding:0;">
          <div id="calendarControls" class="login-options" style="margin-top:0;">
            <button class="btn" id="prevMonthBtn" type="button">&laquo; </button>
            <strong id="calendarTitle" style="margin:0 15px;"></strong>
            <button class="btn" id="nextMonthBtn" type="button"> &raquo;</button>
          </div>
          <table class="cart-table" id="calendarTable" aria-label="Events Calendar">
            <thead>
              <tr><th>Sun</th><th>Mon</th><th>Tue</th><th>Wed</th><th>Thu</th><th>Fri</th><th>Sat</th></tr>
            </thead>
            <tbody id="calendarBody"></tbody>
          </table>
          <p style="text-align:center;color:#666">Click a highlighted date to view shows.</p>
        </div>
      </section>
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
  <script src="cart-badge.js"></script>
  <script src="shows-dates.js"></script>
  <script>
    // Tabs logic: show a panel only when its tab is pressed (no default active)
    function addExperienceToCart(buttonElement) {
      const card = buttonElement.closest('.show-card');
      const title = card.querySelector('h3').textContent;
      const select = card.querySelector('.showtime-select');
      const quantityInput = card.querySelector('.quantity-input');
      const selected = select.options[select.selectedIndex].value;
      const qty = parseInt(quantityInput.value, 10);

      if (!selected) { alert('Please select a time.'); return; }
      if (!qty || qty < 1) { alert('Please enter a valid quantity.'); return; }

      const parts = selected.split(' - ');
      const when = parts[0] + ' ' + parts[1];
      const priceStr = (parts[2] || '$0.00').replace(' (Matinee)','');
      const price = parseFloat(priceStr.replace('$','')) || 0;

      const item = { showName: title, showtime: when, quantity: qty, price: price };
      const cart = readCartArr(); cart.push(item); writeCartArr(cart);
      if (typeof updateCartBadge === 'function') updateCartBadge();
      alert('Added to cart!');
    }

    // --- Calendar logic with month toggle & clickable show dates -> shows.html
    const calTitle = document.getElementById('calendarTitle');
    const calBody  = document.getElementById('calendarBody');
    let viewYear = 2025, viewMonth = 10; // Start at Nov 2025

    function renderCalendar(y,m){
      const first = new Date(y, m, 1);
      const last  = new Date(y, m+1, 0);
      calTitle.textContent = first.toLocaleString(undefined, { month: 'long', year: 'numeric' });
      calBody.innerHTML = '';

      let row = document.createElement('tr');
      for (let i=0;i<first.getDay();i++){
        row.appendChild(document.createElement('td'));
      }

      for (let d=1; d<=last.getDate(); d++){
        if (row.children.length === 7){
          calBody.appendChild(row);
          row = document.createElement('tr');
        }
        const td = document.createElement('td');
        td.setAttribute('data-date', (y+'-'+String(m+1).padStart(2,'0')+'-'+String(d).padStart(2,'0')) );
td.textContent = d;

        const key = y + '-' + String(m+1).padStart(2,'0') + '-' + String(d).padStart(2,'0');
        if (window.SHOWS_DATES && window.SHOWS_DATES.has(key)){
          td.style.fontWeight = '700';
          td.style.background = 'var(--highlight-bg)';
          td.style.boxShadow = 'inset 0 0 0 2px var(--highlight-glow)';
          td.style.cursor = 'pointer';
          td.setAttribute('title','View shows for ' + key);
          td.addEventListener('click', function(){
            // Navigate to the Shows page 
            window.location.href = 'shows.html';
          });
        }
        row.appendChild(td);
      }
      while (row.children.length < 7){
        row.appendChild(document.createElement('td'));
      }
      calBody.appendChild(row);
    }

    document.getElementById('prevMonthBtn').addEventListener('click', function(){
      viewMonth--; if (viewMonth < 0){ viewMonth = 11; viewYear--; } renderCalendar(viewYear, viewMonth);
    });
    document.getElementById('nextMonthBtn').addEventListener('click', function(){
      viewMonth++; if (viewMonth > 11){ viewMonth = 0; viewYear++; } renderCalendar(viewYear, viewMonth);
    });

    // Do not render until calendar tab is opened; however it's okay to pre-render.
    renderCalendar(viewYear, viewMonth);
  </script>

<script>
// Map calendar dates to show IDs for deep-link highlight
window.__DATE_TO_SHOWID__ = {
  '2025-11-10': 1, '2025-11-11': 1, '2025-11-14': 1,
  '2025-11-18': 2, '2025-11-19': 2, '2025-11-21': 2,
  '2025-11-25': 3, '2025-11-26': 3,
  '2025-12-05': 4, '2025-12-07': 4,
  '2025-12-12': 5, '2025-12-13': 5,
  '2026-01-02': 6, '2026-01-03': 6,
  '2026-02-10': 7, '2026-02-11': 7,
  '2026-03-05': 8,
  '2026-04-10': 9, '2026-04-11': 9,
  '2026-05-01': 10, '2026-05-02': 10,
  '2026-06-20': 12, '2026-06-21': 12,
  '2026-06-01': 11, '2026-06-02': 11
};

// Enhance calendar cells after each render to add click - shows page highlight
(function(){
  function enhanceCalendarCells() { 
    var body = document.getElementById('calendarBody');
    if (!body || !window.SHOWS_DATES) return;
    var cells = body.querySelectorAll('td[data-date]'); // Select all table cells with a data-date attribute
    cells.forEach(function(td){    // Loop through each calendar cell
      var dateStr = td.getAttribute('data-date');
      if (window.SHOWS_DATES.has(dateStr)) {
        td.classList.add('has-show'); // Visually highlight the cell
        td.style.cursor = 'pointer'; // Change cursor to pointer to indicate clickability
       // Attach click event listener to navigate user to that show's detail page
        td.addEventListener('click', function(){
          var id = window.__DATE_TO_SHOWID__[dateStr];
          var target = 'shows.php?open=' + encodeURIComponent(id || 1); // Build target URL with show ID fallback
          window.location.href = target;
        });
      }
    });
  }
  // Try to hook after calendar render calls
  document.addEventListener('DOMContentLoaded', function(){
    setTimeout(enhanceCalendarCells, 0);
  });
  // Also enhance after arrow clicks (delegate)
  document.addEventListener('click', function(e){
    if (e.target && (e.target.id==='prevMonthBtn' || e.target.id==='nextMonthBtn')) {
      setTimeout(enhanceCalendarCells, 0);
    }
  });
  window.__enhanceCalendarCells = enhanceCalendarCells;
})();
</script>


    <script>
    // Image cards open their corresponding panels
    (function(){
      function openPanel(panelId){
        var intro = document.getElementById('tabIntro');
        if (intro) { intro.style.display = 'none'; intro.setAttribute('aria-hidden','true'); }
        var panels = ['panel-tours','panel-dining','panel-calendar'];
        panels.forEach(function(id){
          var el = document.getElementById(id);
          if (el) { el.classList.remove('active'); }
        });
        var target = document.getElementById(panelId);
        if (target) {
          target.classList.add('active');
          target.scrollIntoView({behavior:'smooth', block:'start'});
        }
      }
      document.addEventListener('click', function(e){
        var a = e.target.closest && e.target.closest('a.intro-link[data-target]');
        if (a){
          e.preventDefault();
          openPanel(a.getAttribute('data-target'));
        }
      });
    })();
    </script>
    

<?php
// Build map of booked slots: BOOKED['YYYY-MM-DD']['HH:MM'] = true
$__booked_rows = []; // Initialize an empty array to hold all booked date/time entries
if (isset($conn)) {
    $q = $conn->query("SELECT DATE_FORMAT(date, '%Y-%m-%d') AS d, DATE_FORMAT(time, '%H:%i') AS t FROM reservations"); // Query all reservations, formatting date as YYYY-MM-DD and time as HH:MM
    if ($q) {
        while ($r = $q->fetch_assoc()) { $__booked_rows[] = $r; }
    }
}
?>
<script>
  // Populate booked slots (server-rendered)
  var BOOKED = {}; // JS object to store booked time slots by date
  <?php foreach ($__booked_rows as $row): // Loop through each PHP row to output JS entries
        $d = $row['d']; $t = $row['t']; ?> // Extract date and time from each database record
    if (!BOOKED['<?php echo $d; ?>']) BOOKED['<?php echo $d; ?>'] = {}; // Initialize date key if missing
    BOOKED['<?php echo $d; ?>']['<?php echo $t; ?>'] = true; // Mark that time as booked for this date
  <?php endforeach; ?>

  (function(){
    var dateInput = document.getElementById('resDate');
    var timeSelect = document.getElementById('resTime');

    if (!dateInput || !timeSelect) return;

    function updateTimeOptions(){
      var d = dateInput.value; // 'YYYY-MM-DD'
      var booked = BOOKED[d] || {}; // Retrieve booked times for that date, or empty object if none
      var anyEnabled = false;
      for (var i=0; i<timeSelect.options.length; i++){
        var opt = timeSelect.options[i];
        var v = (opt.value || '').slice(0,5); // Extract HH:MM from option value
        var disabled = !!booked[v];
        opt.disabled = disabled; // Disable booked time slots in dropdown
        if (!disabled) { anyEnabled = true; }
      }
      // If currently-selected option is disabled, pick the first enabled one
      if (timeSelect.selectedOptions.length && timeSelect.selectedOptions[0].disabled){ // Find first available option
        for (var j=0; j<timeSelect.options.length; j++){ 
          if (!timeSelect.options[j].disabled){ timeSelect.selectedIndex = j; break; }
        }
      }
    }

    // Initialize on load and on date change
    dateInput.addEventListener('change', updateTimeOptions);
    // Trigger once if a default date exists
    try { updateTimeOptions(); } catch(e){}
  })();
</script>


<?php
$__booked_rows = []; // Initialize array to store all booked date/time records from database
if (isset($conn)) {
  $q = $conn->query("SELECT DATE_FORMAT(date, '%Y-%m-%d') AS d, DATE_FORMAT(time, '%H:%i') AS t FROM reservations");
  if ($q) { while ($r = $q->fetch_assoc()) { $__booked_rows[] = $r; } } // Fetch each row and append to $__booked_rows array
}
?>
<script>
var BOOKED = {};
<?php foreach ($__booked_rows as $row): $d=$row['d']; $t=$row['t']; ?>
if (!BOOKED['<?php echo $d; ?>']) BOOKED['<?php echo $d; ?>'] = {};
BOOKED['<?php echo $d; ?>']['<?php echo $t; ?>'] = true;
<?php endforeach; ?>

(function(){
  var dateInput = document.getElementById('resDate');
  var timeSelect = document.getElementById('resTime');
  if (!dateInput || !timeSelect) return;

  function updateTimeOptions(){
    var d = dateInput.value;
    var booked = BOOKED[d] || {};
    var selectedValid = false;
    for (var i=0; i<timeSelect.options.length; i++){
      var opt = timeSelect.options[i];
      var hhmm = (opt.value||'').slice(0,5);
      var isBooked = !!booked[hhmm];
      opt.disabled = isBooked;
      if (!isBooked && !selectedValid) { timeSelect.selectedIndex = i; selectedValid = true; }
    }
  }
  dateInput.addEventListener('change', updateTimeOptions);
  try { updateTimeOptions(); } catch(e){}
})();
</script>


<script>
(function(){
  function ready(fn){ if(document.readyState!=='loading'){ fn(); } else { document.addEventListener('DOMContentLoaded', fn); } }
  ready(function(){
    var dateInput = document.getElementById('resDate');
    var timeSelect = document.getElementById('resTime');
    if(!dateInput || !timeSelect) return;

    function updateDisabledTimes(){
      var d = dateInput.value; // format 'YYYY-MM-DD'
      var disabled = (window.__RESERVED_BY_DATE__ && window.__RESERVED_BY_DATE__[d]) ? window.__RESERVED_BY_DATE__[d] : [];
      // Enable all first
      Array.prototype.forEach.call(timeSelect.options, function(opt){
        opt.disabled = false;
        opt.classList && opt.classList.remove('disabled-slot');
      });
      // Disable the reserved ones (compare values like '12:00', '13:00', etc.)
      disabled.forEach(function(hhmm){
        for (var i=0;i<timeSelect.options.length;i++){
          var opt = timeSelect.options[i];
          // opt.value might be '12:00' or '12:00 PM' — normalize to HH:MM
          var val = (opt.value || '').slice(0,5);
          if (val === hhmm) {
            opt.disabled = true;
            opt.classList && opt.classList.add('disabled-slot');
          }
        }
      });
      // If current selection is disabled, reset
      if (timeSelect.selectedOptions && timeSelect.selectedOptions[0] && timeSelect.selectedOptions[0].disabled){
        timeSelect.value = '';
      }
    }

    dateInput.addEventListener('change', updateDisabledTimes);
    // Run once on load in case a date is prefilled
    updateDisabledTimes();
  });
})();
</script>
<style>
/* Optional subtle cue; does not change layout */
#resTime option.disabled-slot { color: #999; }
</style>
</body>
</html>
