(function(){
  // Converts cart array into a single encoded string for storage
  function serialize(items){
    // items: array of {showName, showtime, quantity, price}
    if (!Array.isArray(items)) return "";
    const parts = []; //Store each item as a string

    // Loop through all items in the cart
    for (var i=0;i<items.length;i++){
      var it = items[i] || {};
      var n = (it.quantity!=null? parseInt(it.quantity,10):0);
      var p = (it.price!=null? parseFloat(it.price):0);
      if (!it.showName || !it.showtime || !Number.isFinite(n) || n<=0) continue; // Skip invalid items

      // Build one compact string
      parts.push(
        encodeURIComponent(String(it.showName)) + "~" +
        encodeURIComponent(String(it.showtime)) + "~" +
        String(n) + "~" +
        String(Number.isFinite(p)? p : 0)
      );
    }
    return parts.join("|");
  }

  // Takes the string from localStorage and converts it back into an array of objects.
  function deserialize(raw){
    var items = [];
    if (!raw) return items;
    var rows = String(raw).split("|");
    for (var i=0;i<rows.length;i++){
      var row = rows[i];
      if (!row) continue;
      var cols = row.split("~");
      if (cols.length < 4) continue;
      var showName = decodeURIComponent(cols[0]);
      var showtime = decodeURIComponent(cols[1]);
      var qty = parseInt(cols[2], 10);
      var price = parseFloat(cols[3]);
      if (!Number.isFinite(qty) || qty<=0) continue;
      if (!Number.isFinite(price)) price = 0;
      items.push({ showName: showName, showtime: showtime, quantity: qty, price: price });
    }
    return items;
  }

  window.readCartArr = function(){ // Reads and returns the current cart items from localStorage (decoded into an array)
    var raw = localStorage.getItem("cart_str") || ""; // Get the stored string (if none found, default to empty)
    return deserialize(raw); // Convert the raw string back into an array of item objects
  };

  window.writeCartArr = function(items){ 
    var raw = serialize(items);
    localStorage.setItem("cart_str", raw);
    try { window.dispatchEvent(new CustomEvent('cart:changed')); } catch (e) {}
  };

  window.cartCountArr = function(items){
    if (!Array.isArray(items)) return 0;
    var t = 0;
    for (var i=0;i<items.length;i++){
      var n = parseInt(items[i].quantity, 10);
      if (Number.isFinite(n)) t += n;
    }
    return t;
  };
})();

// Shortcut Helper for Reading and Counting
window.getCartCount = function(){ return cartCountArr(readCartArr()); };
