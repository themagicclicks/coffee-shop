document.addEventListener('DOMContentLoaded', function() {
    //localStorage.removeItem('unbrandedCart');
    // Initialize Mobile Navigation (Sidenav)
    //var sidenavElems = document.querySelectorAll('.sidenav');
    //M.Sidenav.init(sidenavElems);
    const collapsibles = document.querySelectorAll('.collapsible');
    M.Collapsible.init(collapsibles, { accordion: true });
    // Initialize Form Select
    var selectElems = document.querySelectorAll('select');
    M.FormSelect.init(selectElems);
    const el = document.getElementById("checkout-tabs");
    const tabinstance = M.Tabs.init(el, {
        onShow: function(tab) {
          if (tab && tab.id) {
            // Update the URL hash without reloading the page
            history.replaceState(null, null, '#' + tab.id);
          }
        }
    });
    const goToAddressBtn = document.getElementById("go-to-address");
    if (goToAddressBtn) {
        goToAddressBtn.addEventListener("click", function (e) {
            e.preventDefault();
            tabinstance.select('address-step');
        });
    }

    var arrivalDate = document.querySelectorAll('.datepicker');
    M.Datepicker.init(arrivalDate, { 
        format: 'dd/mm/yyyy', 
        disableWeekends: true, 
        minDate: new Date(new Date().setDate(new Date().getDate() + 7)),
        container: document.body 
    });
    
    var callTimePicker = document.querySelector('.timepicker'); 

    if (callTimePicker) {
        let instance = M.Timepicker.init(callTimePicker, { 
            twelveHour: true
        });
    
        setTimeout(() => {
            let modal = document.querySelector('.timepicker-modal');
            if (modal) document.body.appendChild(modal);
        }, 100);
    }
    
    
    var requirements = document.querySelectorAll('textarea#specifics');
    M.CharacterCounter.init(requirements);
    
    const elems = document.querySelectorAll('.carousel');
    M.Carousel.init(elems, {
        fullWidth: true,
        indicators: true
    });
    document.body.style.opacity = "1";
    function equalizeHeights() {
        document.querySelectorAll('.container').forEach(container => {
            let lefts = container.querySelectorAll('.left');
            let rights = container.querySelectorAll('.right');
    
            let maxHeight = 0;
    
            lefts.forEach((left, index) => {
                let right = rights[index]; // Get corresponding .right
    
                if (left && right) {
                    // Reset height before recalculating
                    left.style.height = 'auto';
                    right.style.height = 'auto';
    
                    let currentMax = Math.max(left.offsetHeight, right.offsetHeight);
                    maxHeight = Math.max(maxHeight, currentMax); // Store overall max height
                }
            });
    
            // Apply the maxHeight
            lefts.forEach(left => left.style.height = maxHeight + "px");
            rights.forEach(right => right.style.height = maxHeight + "px");
    
            // Instead of setting height directly, use minHeight
            container.style.minHeight = maxHeight + "px";
        });
    }
    
    // Run on page load and resize
    equalizeHeights();
    window.addEventListener('resize', equalizeHeights);

    const captionEl = document.getElementById('caption');
const captionItems = document.querySelectorAll('#captions li');

    let captions = [];
    
    captionItems.forEach(item => {
      captions.push(item.innerHTML);
    });
    
    let index = 0;
    
    function showNextCaption() {
      captionEl.style.opacity = 0;
    
      setTimeout(() => {
        index = Math.floor(Math.random() * captions.length);
        captionEl.innerHTML = captions[index];
        captionEl.style.opacity = 1;
      }, 800);
    }
    
    // Initial load
    showNextCaption();
    
    // Cycle every 6 seconds
    setInterval(showNextCaption, 10000);
    
    const hamburger = document.querySelector('.hamburger');
    const menu = document.querySelector('.open-menu');
    
    hamburger.addEventListener('click', () => {
      menu.classList.toggle('active');
      hamburger.classList.toggle('active');
    });
    //shopping cart and unbranded products
   calculateVatPrice();
   switchVatPrice(); 
   //for detail page
   calculateSingleVatPrice();
   const tmr = window.setInterval(function() {
        let cart = JSON.parse(localStorage.getItem('unbrandedCart')) || [];
        const cartBtn = document.querySelector('a.cart-btn');
        //console.log(cart);
        if (cart.length > 0) {
            cartBtn.classList.remove('hidden');
            populateCart();  
        } else {
            cartBtn.classList.add('hidden');
        }
    }, 1000);
    const cartbutton = document.querySelector('.cart-btn');
    const cartbox = document.querySelector('.open-cart');
    
    cartbutton.addEventListener('click', () => {
      populateCart();  
      cartbox.classList.toggle('active');
      
    });
    
    const carttmr = setInterval(function() {
        let total = 0;
        document.querySelectorAll('ul.cart-items li').forEach(function(item) {
            let vpriceEl = item.querySelector('.vprice');
            let qtyEL = item.querySelector('.quantity-selector input');
            if (vpriceEl) {
                let priceText = vpriceEl.textContent.replace('£', '').trim();
                let qty = qtyEL.value;
                total += parseFloat(priceText)*qty || 0;
            }
        });
        document.querySelector('ul.totals li.total').innerHTML = '£' + total.toFixed(2);
        let vatInput = document.querySelector('ul.cart-items li input.ivat');
        let vat = vatInput ? parseFloat(vatInput.value) : 0;
        document.querySelector('ul.totals li.vat').innerHTML = "* Inclusive of a "+vat+"% VAT";
        
    }, 1000);
        function logScreenWidth() {
        console.log("Screen width: " + window.innerWidth + "px");
    }

    let addresses = JSON.parse(localStorage.getItem('savedAddresses')) || [];
    // Handle same-as-shipping toggle
      //document.getElementById('same-as-shipping').addEventListener('change', function () {
      //  const billing = document.getElementById('billing-address-list');
      //  billing.style.display = this.checked ? 'none' : 'block';
      //});
      const sameAsShipping = document.getElementById('same-as-shipping');

        if (sameAsShipping) {
          sameAsShipping.addEventListener('change', function () {
            const billing = document.getElementById('billing-address-list');
            if (billing) {
              billing.style.display = this.checked ? 'none' : 'block';
            }
          });
        }
    
      // Save new address
      const saveNewAddress = document.getElementById('save-new-address');
      if (saveNewAddress) {
          document.getElementById('save-new-address').addEventListener('click', function () {
            const newAddr = {
              id: Date.now(),
              label: document.getElementById('new-label').value,
              name: document.getElementById('new-name').value,
              line1: document.getElementById('new-line1').value,
              line2: document.getElementById('new-line2').value,
              city: document.getElementById('new-city').value,
              postcode: document.getElementById('new-postcode').value,
              country: 'UK'
            };
        
            addresses.push(newAddr);
            localStorage.setItem('savedAddresses', JSON.stringify(addresses));
            renderAddresses();
            M.toast({ html: 'Address saved successfully!', classes: 'green' });
          });
      }
      //the ratings
      document.querySelectorAll('a.rating').forEach(function(item) {

        let rating = parseFloat(item.textContent.trim()) || 0;
        let fullStars = Math.floor(rating);
        let hasHalf = rating % 1 >= 0.5;
        let maxStars = 5;
    
        item.innerHTML = '';
    
        for (let i = 0; i < fullStars; i++) {
            item.innerHTML += '<i class="small material-icons">star</i>';
        }
    
        if (hasHalf) {
            item.innerHTML += '<i class="small material-icons">star_half</i>';
        }
    
        let remaining = maxStars - fullStars - (hasHalf ? 1 : 0);
    
        for (let i = 0; i < remaining; i++) {
            item.innerHTML += '<i class="small material-icons">star_border</i>';
        }
    
    });
      // Move to review step
      const continueToReview = document.getElementById('continue-to-review');
      if (continueToReview) {
          document.getElementById('continue-to-review').addEventListener('click', function (e) {
            e.preventDefault();
            tabs.select('review-step');
          });
      }
      if(addresses){
        renderAddresses(addresses);
      }
      if(document.querySelector('.bespokeproducts.menu')) {
        menuOrganiser();
      }
      
      //rotateHtmlSlider();
      setInterval(rotateHtmlSlider, 6000);
});
window.addEventListener("load", function() {
    console.log("Page fully loaded!");
    //document.querySelector(".navy .container").classList.add("show");
    //document.querySelector(".block-first .container").classList.add("show");
    window.scrollTo(0, 0);
});
window.addEventListener('scroll', function () {
  const hero = document.querySelector('.hero');

  if (window.scrollY > 500) {
    hero.classList.add('bg-scroll');
  } else {
    hero.classList.remove('bg-scroll');
  }
});
window.addEventListener('resize', function(){
    console.log("Screen width: " + window.innerWidth + "px");
});
function adjustQuantity(button, delta) {
  const input = button.parentElement.querySelector('.quantity-input');
  let current = parseInt(input.value, 10);
  current = isNaN(current) ? 1 : current + delta;
  input.value = current < 1 ? 1 : current;
}
function addToCartFromPage(){
  const title = document.querySelector('h4.product-title').innerText;
  const quantity = parseInt(document.querySelector('.quantity-input').value);
  const sku = document.getElementById('sku').value;
  const vat = document.getElementById('vat-rate').value;
  const price = document.getElementById("product-price").innerHTML;
  const vprice = document.getElementById("calculated-vat-price").innerHTML;
  let vfprice = vprice.replace(' inc. VAT','');
  const image = document.querySelector('.carousel-item.active img').src;

  let cart = JSON.parse(localStorage.getItem('unbrandedCart')) || [];

  // Check if SKU already exists
  const existing = cart.find(product => product.sku === sku);
  if (existing) {
    existing.quantity += quantity;
  } else {
    cart.push({ title, vfprice, vat, quantity, sku, image });
  }

  localStorage.setItem('unbrandedCart', JSON.stringify(cart));

  const cartBtn = document.querySelector('a.cart-btn');
  if (cartBtn.classList.contains('hidden')) {
    cartBtn.classList.remove('hidden');
  }
  populateCart();
}
function addToCart(button) {
  const item = button.closest('.unbranded-product-item');
  const title = item.querySelector('h3').innerText;
  const quantity = parseInt(item.querySelector('.quantity-input').value);
  const sku = item.querySelector('.sku').value;
  const vat = item.querySelector('.vat').value;
  const vprice = item.querySelector('.vprice').innerHTML;
  let vfprice = vprice.replace(' inc. VAT','');
  //alert(vfprice);
  const image = item.querySelector('img').src;

  let cart = JSON.parse(localStorage.getItem('unbrandedCart')) || [];

  // Check if SKU already exists
  const existing = cart.find(product => product.sku === sku);
  if (existing) {
    existing.quantity += quantity;
  } else {
    cart.push({ title, vfprice, vat, quantity, sku, image });
  }

  localStorage.setItem('unbrandedCart', JSON.stringify(cart));

  const cartBtn = document.querySelector('a.cart-btn');
  if (cartBtn.classList.contains('hidden')) {
    cartBtn.classList.remove('hidden');
  }
  populateCart();
}

function calculateSingleVatPrice(){
    var vatInput = document.getElementById('vat-rate');
    var vatRate = vatInput ? parseFloat(vatInput.value) : 0;
    var priceElement = document.getElementById('product-price');
    var vpriceElement = document.getElementById('calculated-vat-price');
    if(priceElement) {
        // Strip currency symbol and text
        var priceText = priceElement.textContent.replace(/[^\d.]/g, '');
        var basePrice = parseFloat(priceText);

        if(!isNaN(basePrice)) {
            // Calculate VAT-inclusive price
            var vatMultiplier = 1 + (vatRate / 100);
            var priceWithVAT = (basePrice * vatMultiplier).toFixed(2);

            // Write it into h5.vprice
            var vpriceElement = document.getElementById('calculated-vat-price');
            if(vpriceElement) {
                vpriceElement.textContent = `${priceWithVAT} `;
            }
        }
    }
}
function calculateVatPrice(){
    document.querySelectorAll('ul.bespokeproducts.unbranded-packaging li').forEach(function(item) {
        // Get the VAT rate from the hidden input
        var vatInput = item.querySelector('input.vat');
        var vatRate = vatInput ? parseFloat(vatInput.value) : 0;
    
        // Get the base price from h5.price
        var priceElement = item.querySelector('h5.price');
        if(priceElement) {
            // Strip currency symbol and text
            var priceText = priceElement.textContent.replace(/[^\d.]/g, '');
            var basePrice = parseFloat(priceText);
    
            if(!isNaN(basePrice)) {
                // Calculate VAT-inclusive price
                var vatMultiplier = 1 + (vatRate / 100);
                var priceWithVAT = (basePrice * vatMultiplier).toFixed(2);
    
                // Write it into h5.vprice
                var vpriceElement = item.querySelector('h5.vprice');
                if(vpriceElement) {
                    vpriceElement.textContent = `£${priceWithVAT} inc. VAT`;
                }
            }
        }
    });
}
function switchVatPrice(){
    document.querySelectorAll('.switch.vat input[type="checkbox"]').forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
            // Loop through each product
            document.querySelectorAll('ul.bespokeproducts.unbranded-packaging li').forEach(function(item) {
                var priceExcl = item.querySelector('h5.price');
                var priceIncl = item.querySelector('h5.vprice');
    
                if (checkbox.checked) {
                    if(priceExcl) priceExcl.style.display = 'none';
                    if(priceIncl) priceIncl.style.display = 'block';
                } else {
                    if(priceExcl) priceExcl.style.display = 'block';
                    if(priceIncl) priceIncl.style.display = 'none';
                }
            });
        });
    });

}
function populateCart() {
  const cart = JSON.parse(localStorage.getItem('unbrandedCart')) || [];
  const cartList = document.querySelector('.open-cart .cart-items');
  cartList.innerHTML = '';

  if (cart.length === 0) {
    cartList.innerHTML = '<li class="empty">Your cart is empty.</li>';
    return;
  }

  cart.forEach((item, index) => {
    const li = document.createElement('li');
    li.innerHTML = `
      <div class="cart-item">
        <img src="${item.image}" alt="${item.title}" class="cart-thumb">
        <div class="cart-details">
          <h5 class="title">${item.title}</h5>
          <h5 class="vprice">${item.vfprice}</h5>
          <input type="hidden" class="ivat" value="${item.vat}">
          <div class="quantity-selector">
            <button onclick="updateQuantity(${index}, -1)">−</button>
            <input type="number" min="1" value="${item.quantity}" readonly>
            <button onclick="updateQuantity(${index}, 1)">+</button>
            
          </div>
        </div>
        <button class="remove-btn" onclick="removeFromCart(${index})">
          🗑️
        </button>
      </div>
    `;
    cartList.appendChild(li);
  });
}

function updateQuantity(index, delta) {
  let cart = JSON.parse(localStorage.getItem('unbrandedCart')) || [];
  if (!cart[index]) return;

  cart[index].quantity += delta;
  if (cart[index].quantity < 1) cart[index].quantity = 1;

  localStorage.setItem('unbrandedCart', JSON.stringify(cart));
  populateCart();
  paintCheckoutPage();
}

function removeFromCart(index) {
  let cart = JSON.parse(localStorage.getItem('unbrandedCart')) || [];
  cart.splice(index, 1);
  localStorage.setItem('unbrandedCart', JSON.stringify(cart));
  populateCart();
  paintCheckoutPage();
  if (cart.length === 0) {
    document.querySelector('a.cart-btn').classList.add('hidden');
  }
}
function paintCheckoutPage() {
    let cart = JSON.parse(localStorage.getItem('unbrandedCart')) || [];
    console.log(cart);

    document.querySelector('header').style.display = 'none';

    let carthtml = '<li class="collection-header"><h5>My Shopping Cart (<span class="noofitems">' + cart.length + ' items</span>)</h5></li>';
    let totalwithvat = 0;
    cart.forEach((item, index) => {
        let price = parseFloat(item.vfprice.replace('£','').trim()) || 0;
        totalwithvat += price*parseInt(item.quantity);
        carthtml += `
        <li class="collection-item avatar">
            <div class="row">
                <div class="col s9">
                    <img class="cartitemimage circle" src="${item.image}" alt="${item.title}">
                    <span class="title">${item.title}</span>
                    <div class="cart-price">£${parseFloat(item.vfprice.replace('£','').trim()).toFixed(2)}</div>
                </div>
                <div class="col s2">
                    <div class="input-field inline">
                        <div class="quantity-selector" style="display: flex; align-items: center; margin: 10px 0;">
                            <button class="quantity-btn" onclick="updateQuantity(${index}, -1)" style="padding:5px 10px;">−</button>
                            <input type="number" min="1" value="${item.quantity}" class="quantity-input" style="width:50px; text-align:center; margin: 0 5px;">
                            <button class="quantity-btn" onclick="updateQuantity(${index}, 1)" style="padding:5px 10px;">+</button>
                        </div>
                    </div>
                </div>
                <div class="col s1">    
                    <a href="#!" class="removefromcart secondary-content red-text" onclick="removeFromCart(${index})">🗑️</a>
                </div>
            </div>
        </li>`;
    });
    document.querySelector('#cart-step .price-total').innerHTML = '<h2 class="cart-total">Total Inclusive of VAT £'+totalwithvat.toFixed(2)+'</h2>';
    document.querySelector('ul.products-list-checkout').innerHTML = carthtml;
}
function renderAddresses(addresses) {
    let shippingContainer = document.getElementById('shipping-address-list');
    let billingContainer = document.getElementById('billing-address-list');
    if(shippingContainer && billingContainer){
        shippingContainer.innerHTML = '';
        billingContainer.innerHTML = '';
    
        if (addresses && addresses.length === 0) {
          shippingContainer.innerHTML = '<p>No saved addresses.</p>';
          billingContainer.innerHTML = '<p>No saved addresses.</p>';
          return;
        }
    
        addresses.forEach(addr => {
          let html = `
            <label>
              <input name="shipping" type="radio" value="${addr.id}" class="with-gap shipping-address">
              <span><strong>${addr.label}</strong>: ${addr.name}, ${addr.line1}, ${addr.city}, ${addr.postcode}</span>
            </label>
          `;
          shippingContainer.innerHTML += html;
    
          html = `
            <label>
              <input name="billing" type="radio" value="${addr.id}" class="with-gap billing-address">
              <span><strong>${addr.label}</strong>: ${addr.name}, ${addr.line1}, ${addr.city}, ${addr.postcode}</span>
            </label>
          `;
          billingContainer.innerHTML += html;
        });
    }
  }
  function rotateHtmlSlider() {

    const slider = document.querySelector('.htmlslider ul');
    if (!slider) return;

    const items = slider.querySelectorAll('li');
    if (items.length < 2) return;

    const first = items[0];

    // fade out
    first.style.opacity = '0';

    setTimeout(() => {

        first.style.display = 'none';
        first.style.zIndex = '0';

        // move first to end
        slider.appendChild(first);

        const newFirst = slider.querySelector('li:first-child');

        newFirst.style.display = 'block';
        newFirst.style.zIndex = '1';

        // prepare fade-in
        newFirst.style.opacity = '0';

        setTimeout(() => {
            newFirst.style.opacity = '1';
        }, 50);

    }, 600); // must match CSS transition time
}
function menuOrganiser(){
    const items = document.querySelectorAll('li[data-entity-type]');
    const container = items[0]?.parentElement;

    if (!items.length || !container) return;

    const groups = {};

    // Group items by entity type
    items.forEach(item => {
        const type = item.getAttribute('data-entity-type') || 'Other';

        if (!groups[type]) {
            groups[type] = [];
        }

        groups[type].push(item);
    });

    // Clear original list
    container.innerHTML = '';

    // Rebuild grouped sections
    Object.keys(groups).forEach(type => {

        // Section wrapper
        const section = document.createElement('div');
        section.className = 'menu-section';

        // Heading
        const heading = document.createElement('h4');
        heading.className = 'menu-section-title';
        heading.textContent = type;

        // New list
        const ul = document.createElement('ul');
        ul.className = 'menu-section-list';

        // Append items
        groups[type].forEach(item => {
            ul.appendChild(item);
        });

        // Build section
        section.appendChild(heading);
        section.appendChild(ul);

        // Add to container
        container.appendChild(section);
    });

}


