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
    const tabinstance = el ? M.Tabs.init(el, {
        onShow: function(tab) {
          if (tab && tab.id) {
            history.replaceState(null, null, '#' + tab.id);
          }
        }
    }) : null;
    const goToAddressBtn = document.getElementById("go-to-address");
    if (goToAddressBtn) {
        goToAddressBtn.addEventListener("click", function (e) {
            e.preventDefault();
            if (tabinstance) {
                tabinstance.select('address-step');
            }
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
    normalizeFrontendFormFieldIds();
    initMaterializeTextFieldLabels();
    
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
	if (!window.matchMedia("(max-width: 768px)").matches) {
		equalizeHeights();
		window.addEventListener('resize', equalizeHeights);
	}
    

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
    const downloadMenuBtn = document.querySelector('.download-menu-btn');
    if (downloadMenuBtn) {
        downloadMenuBtn.addEventListener('click', function (event) {
            event.preventDefault();
            openMenuPdf();
        });
    }
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

    let addresses = getSavedGuestAddresses();
    const sameAsShipping = document.getElementById('same-as-shipping');

    if (sameAsShipping) {
      sameAsShipping.addEventListener('change', function () {
        toggleBillingAddressVisibility(this.checked);
      });
      toggleBillingAddressVisibility(sameAsShipping.checked);
    }

    const saveNewAddress = document.getElementById('save-new-address');
    if (saveNewAddress) {
      saveNewAddress.addEventListener('click', function (e) {
        e.preventDefault();
        const createdAddress = createGuestAddressFromForm();
        if (!createdAddress) {
          return;
        }

        addresses = getSavedGuestAddresses();
        renderAddresses(addresses);
        setSelectedGuestAddresses(createdAddress.id, createdAddress.id);
        if (sameAsShipping) {
          sameAsShipping.checked = true;
          toggleBillingAddressVisibility(true);
        }
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
            continueCheckoutToPayment(tabinstance, sameAsShipping);
          });
      }
      if(addresses){
        renderAddresses(addresses);
      }
      initCheckoutDemoStage(tabinstance);
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
  if (!hero) {
    return;
  }

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

function openMenuPdf() {
  const menuTemplate = document.getElementById('menu-pdf-template');
  if (!menuTemplate || typeof window.html2pdf === 'undefined') {
    return;
  }

  const printable = menuTemplate.cloneNode(true);
  printable.removeAttribute('id');
  printable.style.position = 'static';
  printable.style.left = '0';
  printable.style.top = '0';
  printable.style.width = '210mm';
  printable.style.opacity = '1';
  printable.style.pointerEvents = 'auto';
  printable.style.zIndex = '1';
  printable.style.display = 'block';
  document.body.appendChild(printable);

  const options = {
    margin: [4, 4, 4, 4],
    filename: 'willow-cup-menu.pdf',
    image: { type: 'jpeg', quality: 0.98 },
    html2canvas: {
      scale: 2,
      useCORS: true,
      backgroundColor: '#f9f4ed'
    },
    jsPDF: {
      unit: 'mm',
      format: 'a4',
      orientation: 'portrait'
    },
    pagebreak: {
      mode: ['css', 'legacy'],
      avoid: ['.menu-pdf-header', '.menu-pdf-section', '.menu-pdf-item', '.menu-pdf-footer']
    }
  };

  window.html2pdf().set(options).from(printable).outputPdf('bloburl').then(function (pdfUrl) {
    window.open(pdfUrl, '_blank', 'noopener');
  }).catch(function () {
    if (window.M && typeof window.M.toast === 'function') {
      M.toast({ html: 'Menu PDF could not be generated right now.', classes: 'red darken-2' });
    }
  }).finally(function () {
    printable.remove();
  });
}

function normalizeSiteAssetUrl(url) {
  const rawUrl = String(url || '').trim();
  if (!rawUrl) {
    return '';
  }

  const currentSite = String(window.SITE_URL || '').trim();
  if (!currentSite) {
    return rawUrl;
  }

  const normalizedCurrentSite = currentSite.replace(/\/+$/, '/');
  const normalizedUrl = rawUrl.replace(/\\/g, '/');
  let currentOrigin = '';
  let currentPathname = '';
  let currentProjectPath = '';

  try {
    const parsedCurrentSite = new URL(normalizedCurrentSite, window.location.origin);
    currentOrigin = parsedCurrentSite.origin;
    currentPathname = parsedCurrentSite.pathname || '/';
    currentProjectPath = currentPathname.replace(/\/+$/, '/');
  } catch (error) {
    currentOrigin = window.location.origin || '';
  }

  const knownBases = [
    'https://aperiq.in/fiverr/coffee-shop/',
    'http://aperiq.in/fiverr/coffee-shop/',
    'https://www.aperiq.in/fiverr/coffee-shop/',
    'http://www.aperiq.in/fiverr/coffee-shop/',
    'http://127.0.0.1/coffee-shop/',
    'https://127.0.0.1/coffee-shop/',
    'http://localhost/coffee-shop/',
    'https://localhost/coffee-shop/'
  ];

  for (let index = 0; index < knownBases.length; index += 1) {
    const knownBase = knownBases[index];
    if (normalizedUrl.indexOf(knownBase) === 0) {
      return normalizedCurrentSite + normalizedUrl.substring(knownBase.length);
    }
  }

  if (/^https?:\/\//i.test(normalizedUrl)) {
    try {
      const parsedUrl = new URL(normalizedUrl);
      if (currentOrigin && parsedUrl.origin === currentOrigin && currentProjectPath) {
        const projectFolder = currentProjectPath.split('/').filter(Boolean).pop() || '';
        const marker = '/' + projectFolder + '/';
        const markerIndex = parsedUrl.pathname.indexOf(marker);
        if (markerIndex >= 0) {
          return currentOrigin + currentProjectPath + parsedUrl.pathname.substring(markerIndex + marker.length) + (parsedUrl.search || '') + (parsedUrl.hash || '');
        }
      }
    } catch (error) {
      return rawUrl;
    }
  }

  if (normalizedUrl.indexOf('media/') === 0 || normalizedUrl.indexOf('images/') === 0 || normalizedUrl.indexOf('documents/') === 0) {
    return normalizedCurrentSite + normalizedUrl.replace(/^\/+/, '');
  }

  if (normalizedUrl.charAt(0) === '/' && currentOrigin && currentProjectPath) {
    const projectFolder = currentProjectPath.split('/').filter(Boolean).pop() || '';
    if (projectFolder) {
      const marker = '/' + projectFolder + '/';
      const markerIndex = normalizedUrl.indexOf(marker);
      if (markerIndex >= 0) {
        return currentOrigin + currentProjectPath + normalizedUrl.substring(markerIndex + marker.length);
      }
    }
  }

  return rawUrl;
}

function normalizeCartProduct(product) {
  if (!product || typeof product !== 'object') {
    return product;
  }

  return Object.assign({}, product, {
    image: normalizeSiteAssetUrl(product.image || '')
  });
}

function getStoredCartProducts() {
  let cart = [];

  try {
    cart = JSON.parse(localStorage.getItem('unbrandedCart')) || [];
  } catch (error) {
    cart = [];
  }

  const normalizedCart = cart.map(normalizeCartProduct);
  const wasChanged = JSON.stringify(cart) !== JSON.stringify(normalizedCart);
  if (wasChanged) {
    localStorage.setItem('unbrandedCart', JSON.stringify(normalizedCart));
  }

  return normalizedCart;
}

function addToCartFromPage(){
  const title = document.querySelector('h4.product-title').innerText;
  const quantity = parseInt(document.querySelector('.quantity-input').value);
  const sku = document.getElementById('sku').value;
  const vat = document.getElementById('vat-rate').value;
  const price = document.getElementById("product-price").innerHTML;
  const vprice = document.getElementById("calculated-vat-price").innerHTML;
  let vfprice = vprice.replace(' inc. VAT','');
  const image = normalizeSiteAssetUrl(document.querySelector('.carousel-item.active img').src);

  let cart = getStoredCartProducts();

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
  const image = normalizeSiteAssetUrl(item.querySelector('img').src);

  let cart = getStoredCartProducts();

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
  const cart = getStoredCartProducts();
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
  let cart = getStoredCartProducts();
  if (!cart[index]) return;

  cart[index].quantity += delta;
  if (cart[index].quantity < 1) cart[index].quantity = 1;

  localStorage.setItem('unbrandedCart', JSON.stringify(cart));
  populateCart();
  paintCheckoutPage();
}

function removeFromCart(index) {
  let cart = getStoredCartProducts();
  cart.splice(index, 1);
  localStorage.setItem('unbrandedCart', JSON.stringify(cart));
  populateCart();
  paintCheckoutPage();
  if (cart.length === 0) {
    document.querySelector('a.cart-btn').classList.add('hidden');
  }
}
function paintCheckoutPage() {
    let cart = getStoredCartProducts();
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
function getSavedGuestAddresses() {
    try {
        return JSON.parse(localStorage.getItem('savedAddresses')) || [];
    } catch (error) {
        return [];
    }
}

function saveGuestAddresses(addresses) {
    localStorage.setItem('savedAddresses', JSON.stringify(addresses || []));
}

function getCheckoutAddressSelection() {
    try {
        return JSON.parse(localStorage.getItem('guestCheckoutSelection')) || {};
    } catch (error) {
        return {};
    }
}

function saveCheckoutAddressSelection(selection) {
    localStorage.setItem('guestCheckoutSelection', JSON.stringify(selection || {}));
}

function clearAddressFormFields() {
    ['new-label', 'new-name', 'new-line1', 'new-line2', 'new-city', 'new-postcode'].forEach(function (fieldId) {
        const field = document.getElementById(fieldId);
        if (field) {
            field.value = '';
        }
    });
}

function collectGuestAddressFormValues() {
    const values = {
        label: (document.getElementById('new-label') || {}).value || '',
        name: (document.getElementById('new-name') || {}).value || '',
        line1: (document.getElementById('new-line1') || {}).value || '',
        line2: (document.getElementById('new-line2') || {}).value || '',
        city: (document.getElementById('new-city') || {}).value || '',
        postcode: (document.getElementById('new-postcode') || {}).value || '',
        country: 'UK'
    };

    values.label = values.label.trim();
    values.name = values.name.trim();
    values.line1 = values.line1.trim();
    values.line2 = values.line2.trim();
    values.city = values.city.trim();
    values.postcode = values.postcode.trim();
    if (!values.label) {
        values.label = 'Guest Address';
    }

    return values;
}

function createGuestAddressFromForm() {
    const address = collectGuestAddressFormValues();
    if (!address.name || !address.line1 || !address.city || !address.postcode) {
        M.toast({ html: 'Please complete name, address line 1, city and postcode.', classes: 'red darken-2' });
        return null;
    }

    address.id = Date.now();
    const addresses = getSavedGuestAddresses();
    addresses.push(address);
    saveGuestAddresses(addresses);
    clearAddressFormFields();
    return address;
}

function toggleBillingAddressVisibility(hidden) {
    const billing = document.getElementById('billing-address-list');
    if (billing) {
        billing.style.display = hidden ? 'none' : 'block';
    }
}

function setSelectedGuestAddresses(shippingId, billingId) {
    saveCheckoutAddressSelection({
        shipping: shippingId || '',
        billing: billingId || ''
    });
}

function resolveSelectedGuestAddresses(sameAsShippingChecked) {
    const addresses = getSavedGuestAddresses();
    const shipping = document.querySelector('input.shipping-address:checked');
    const billing = document.querySelector('input.billing-address:checked');
    const shippingId = shipping ? shipping.value : '';
    const billingId = sameAsShippingChecked ? shippingId : (billing ? billing.value : '');

    return {
        shippingId: shippingId,
        billingId: billingId,
        shippingAddress: addresses.find(function (address) { return String(address.id) === String(shippingId); }) || null,
        billingAddress: addresses.find(function (address) { return String(address.id) === String(billingId); }) || null
    };
}

function formatGuestAddress(address) {
    if (!address) {
        return '<p>No address selected.</p>';
    }

    return '<strong>' + address.label + '</strong><br>'
        + address.name + '<br>'
        + address.line1 + '<br>'
        + (address.line2 ? address.line2 + '<br>' : '')
        + address.city + '<br>'
        + address.postcode + '<br>'
        + address.country;
}

function getCheckoutPaymentPaneId() {
    if (document.getElementById('payment-step')) {
        return 'payment-step';
    }
    if (document.getElementById('review-step')) {
        return 'review-step';
    }
    return 'payment-step';
}

function ensureCheckoutPaymentPane() {
    const tabs = document.getElementById('checkout-tabs');
    if (!tabs) {
        return null;
    }

    let paneId = getCheckoutPaymentPaneId();
    let pane = document.getElementById(paneId);

    if (!pane) {
        paneId = 'payment-step';
        const contentRoot = tabs.parentElement ? tabs.parentElement.parentElement : null;
        if (contentRoot) {
            pane = document.createElement('div');
            pane.id = paneId;
            pane.className = 'col s12';
            contentRoot.appendChild(pane);
        }
    }

    if (!tabs.querySelector('a[href="#' + paneId + '"]')) {
        const tabItem = document.createElement('li');
        tabItem.className = 'tab col s4';
        tabItem.innerHTML = '<a href="#' + paneId + '"><i class="material-icons">payment</i><span>Payment</span></a>';
        tabs.appendChild(tabItem);
    }

    const trigger = tabs.querySelector('a[href="#' + paneId + '"]');
    if (trigger) {
        trigger.innerHTML = '<i class="material-icons">payment</i><span>Payment</span>';
    }

    return paneId;
}

function renderCheckoutPaymentStage(selectedAddresses) {
    const paymentPaneId = ensureCheckoutPaymentPane();
    if (!paymentPaneId) {
        return;
    }

    const paymentPane = document.getElementById(paymentPaneId);
    if (!paymentPane) {
        return;
    }

    const cart = JSON.parse(localStorage.getItem('unbrandedCart')) || [];
    const total = cart.reduce(function (sum, item) {
        const unitPrice = parseFloat(String(item.vfprice || '').replace(/[^0-9.\-]/g, '')) || 0;
        const quantity = parseInt(item.quantity || 0, 10) || 0;
        return sum + (unitPrice * quantity);
    }, 0);

    paymentPane.innerHTML = ''
        + '<div class="paypal-demo-checkout">'
        + '  <div class="row">'
        + '    <div class="col s12 m7">'
        + '      <div class="paypal-demo-card">'
        + '        <h4>PayPal Checkout</h4>'
        + '        <p>This demo shows the guest checkout payment stage. Addresses are stored in your browser only.</p>'
        + '        <div class="paypal-demo-addresses">'
        + '          <div class="paypal-demo-address"><h6>Shipping Address</h6>' + formatGuestAddress(selectedAddresses.shippingAddress) + '</div>'
        + '          <div class="paypal-demo-address"><h6>Billing Address</h6>' + formatGuestAddress(selectedAddresses.billingAddress) + '</div>'
        + '        </div>'
        + '      </div>'
        + '    </div>'
        + '    <div class="col s12 m5">'
        + '      <div class="paypal-demo-summary">'
        + '        <div class="paypal-demo-summary__brand">PayPal</div>'
        + '        <h5>Order Summary</h5>'
        + '        <p>' + cart.length + ' item(s) ready for checkout.</p>'
        + '        <div class="paypal-demo-summary__total">Â£' + total.toFixed(2) + '</div>'
        + '        <button type="button" id="pay-and-place-order" class="btn large blue darken-2 waves-effect waves-light">Pay And Place Order</button>'
        + '        <p class="paypal-demo-summary__note">Demo only. No real transaction is processed here.</p>'
        + '      </div>'
        + '    </div>'
        + '  </div>'
        + '</div>';

    const payButton = document.getElementById('pay-and-place-order');
    if (payButton) {
        payButton.addEventListener('click', function () {
            alert("The Demo Doesn't Guide Users through Real Payment");
        });
    }
}

function continueCheckoutToPayment(tabinstance, sameAsShippingCheckbox) {
    const sameAsShippingChecked = !!(sameAsShippingCheckbox && sameAsShippingCheckbox.checked);
    let addresses = getSavedGuestAddresses();

    if (!addresses.length) {
        const createdAddress = createGuestAddressFromForm();
        if (createdAddress) {
            addresses = getSavedGuestAddresses();
            setSelectedGuestAddresses(createdAddress.id, createdAddress.id);
            if (sameAsShippingCheckbox) {
                sameAsShippingCheckbox.checked = true;
                toggleBillingAddressVisibility(true);
            }
        }
    }

    const selectedAddresses = resolveSelectedGuestAddresses(sameAsShippingChecked);
    if (!selectedAddresses.shippingAddress) {
        M.toast({ html: 'Please save and choose a shipping address before payment.', classes: 'red darken-2' });
        return;
    }

    if (!sameAsShippingChecked && !selectedAddresses.billingAddress) {
        M.toast({ html: 'Please choose a billing address or use the same as shipping option.', classes: 'red darken-2' });
        return;
    }

    if (sameAsShippingChecked) {
        selectedAddresses.billingAddress = selectedAddresses.shippingAddress;
        selectedAddresses.billingId = selectedAddresses.shippingId;
    }

    saveCheckoutAddressSelection({
        shipping: selectedAddresses.shippingId,
        billing: selectedAddresses.billingId
    });
    renderCheckoutPaymentStage(selectedAddresses);

    const paymentPaneId = ensureCheckoutPaymentPane();
    if (tabinstance && paymentPaneId) {
        tabinstance.select(paymentPaneId);
    }
}

function initCheckoutDemoStage() {
    const tabs = document.getElementById('checkout-tabs');
    if (!tabs) {
        return;
    }

    ensureCheckoutPaymentPane();
    const selection = getCheckoutAddressSelection();
    const addresses = getSavedGuestAddresses();
    const shippingAddress = addresses.find(function (address) { return String(address.id) === String(selection.shipping || ''); }) || null;
    const billingAddress = addresses.find(function (address) { return String(address.id) === String(selection.billing || ''); }) || shippingAddress;

    if (shippingAddress) {
        renderCheckoutPaymentStage({
            shippingAddress: shippingAddress,
            billingAddress: billingAddress
        });
    }
}

function renderAddresses(addresses) {
    let shippingContainer = document.getElementById('shipping-address-list');
    let billingContainer = document.getElementById('billing-address-list');
    if(shippingContainer && billingContainer){
        shippingContainer.innerHTML = '';
        billingContainer.innerHTML = '';
        const selection = getCheckoutAddressSelection();
    
        if (addresses && addresses.length === 0) {
          shippingContainer.innerHTML = '<p>No saved addresses.</p>';
          billingContainer.innerHTML = '<p>No saved addresses.</p>';
          return;
        }
    
        addresses.forEach(addr => {
          let html = `
            <label>
              <input name="shipping" type="radio" value="${addr.id}" class="with-gap shipping-address" ${String(selection.shipping || '') === String(addr.id) ? 'checked' : ''}>
              <span><strong>${addr.label}</strong>: ${addr.name}, ${addr.line1}, ${addr.city}, ${addr.postcode}</span>
            </label>
          `;
          shippingContainer.innerHTML += html;
    
          html = `
            <label>
              <input name="billing" type="radio" value="${addr.id}" class="with-gap billing-address" ${String(selection.billing || '') === String(addr.id) ? 'checked' : ''}>
              <span><strong>${addr.label}</strong>: ${addr.name}, ${addr.line1}, ${addr.city}, ${addr.postcode}</span>
            </label>
          `;
          billingContainer.innerHTML += html;
        });

        document.querySelectorAll('input.shipping-address').forEach(function (input) {
            input.addEventListener('change', function () {
                const currentSelection = getCheckoutAddressSelection();
                saveCheckoutAddressSelection({
                    shipping: input.value,
                    billing: currentSelection.billing || input.value
                });
            });
        });

        document.querySelectorAll('input.billing-address').forEach(function (input) {
            input.addEventListener('change', function () {
                const currentSelection = getCheckoutAddressSelection();
                saveCheckoutAddressSelection({
                    shipping: currentSelection.shipping || '',
                    billing: input.value
                });
            });
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




function getTableOrderStorageKey() {
    return 'willowCupTableOrder';
}

function getTableOrderContext() {
    const params = new URLSearchParams(window.location.search);
    const table = parseInt(params.get('table') || '0', 10);
    return {
        table: Number.isFinite(table) && table > 0 ? table : 0,
        isMenuPage: window.location.pathname.toLowerCase().indexOf('/menu') !== -1
    };
}

function readStoredTableOrder() {
    try {
        const raw = localStorage.getItem(getTableOrderStorageKey());
        if (!raw) {
            return null;
        }

        const parsed = JSON.parse(raw);
        if (!parsed || !parsed.expires_at) {
            localStorage.removeItem(getTableOrderStorageKey());
            return null;
        }

        if (Date.now() > parsed.expires_at) {
            localStorage.removeItem(getTableOrderStorageKey());
            return null;
        }

        return parsed;
    } catch (error) {
        localStorage.removeItem(getTableOrderStorageKey());
        return null;
    }
}

function sanitizeOrderText(value) {
    return String(value || '')
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#39;');
}

function writeStoredTableOrder(order) {
    localStorage.setItem(getTableOrderStorageKey(), JSON.stringify(order));
}

function clearStoredTableOrder() {
    localStorage.removeItem(getTableOrderStorageKey());
    updateOrderButtonVisibility();
}

function updateOrderButtonVisibility() {
    const orderBtn = document.querySelector('a.order-btn');
    if (!orderBtn) {
        return;
    }

    const order = readStoredTableOrder();
    if (order && order.items && order.items.length) {
        orderBtn.classList.remove('hidden');
        orderBtn.setAttribute('title', 'Order saved for table #' + order.table);
    } else {
        orderBtn.classList.add('hidden');
        orderBtn.removeAttribute('title');
    }
}

function parseMenuItemPrice(item) {
    const priceElement = item.querySelector('h5.price, h5.vprice');
    if (!priceElement) {
        return 0;
    }

    const numeric = parseFloat((priceElement.textContent || '').replace(/[^0-9.\-]/g, ''));
    return Number.isFinite(numeric) ? numeric : 0;
}

function normalizeStoredOrderCustomer(order) {
    return {
        ordered_by: order && order.ordered_by ? String(order.ordered_by) : '',
        ordered_from_phone: order && order.ordered_from_phone ? String(order.ordered_from_phone) : ''
    };
}

function buildMenuOrderItem(item, quantity) {
    const link = item.querySelector('a[data-id]');
    const titleElement = item.querySelector('h3');
    const imageElement = item.querySelector('img');
    return {
        item_id: parseInt(link ? (link.getAttribute('data-id') || '0') : '0', 10) || 0,
        title: titleElement ? titleElement.textContent.trim() : 'Menu Item',
        quantity: Math.max(1, quantity),
        unit_price: parseMenuItemPrice(item),
        image: imageElement ? imageElement.getAttribute('src') || '' : ''
    };
}

function mergeOrderItems(existingItems, newItem) {
    const items = Array.isArray(existingItems) ? existingItems.slice() : [];
    const match = items.find(function (item) {
        return Number(item.item_id || 0) === Number(newItem.item_id || 0) && String(item.title || '') === String(newItem.title || '');
    });

    if (match) {
        match.quantity = Number(match.quantity || 0) + Number(newItem.quantity || 0);
    } else {
        items.push(newItem);
    }

    return items;
}

function orderStatusDefaults(order) {
    return {
        success: true,
        order_entity_id: order ? Number(order.order_entity_id || 0) : 0,
        order_closed: false,
        order_closed_and_paid: false,
        order_items_html: order && order.preview_html ? order.preview_html : '',
        order_total: order ? String(order.order_total || '0.00') : '0.00',
        table: order ? String(order.table || '') : '',
        ordered_by: order ? String(order.ordered_by || '') : '',
        ordered_from_phone: order ? String(order.ordered_from_phone || '') : '',
        order_close_time: ''
    };
}

function fetchCurrentOrderStatus(order) {
    if (!order || !Number(order.order_entity_id || 0)) {
        return Promise.resolve(orderStatusDefaults(order));
    }

    return fetch((window.SITE_URL || '/') + 'menu_order_status.php?order_entity_id=' + encodeURIComponent(String(order.order_entity_id)), {
        method: 'GET',
        credentials: 'same-origin'
    }).then(function (response) {
        return response.json().then(function (data) {
            return { ok: response.ok, data: data };
        });
    }).then(function (result) {
        if (!result.ok || !result.data || !result.data.success) {
            return orderStatusDefaults(order);
        }
        return result.data;
    }).catch(function () {
        return orderStatusDefaults(order);
    });
}

function persistTableOrder(context, items, existingOrderId, customerDetails) {
    const customer = customerDetails || { ordered_by: '', ordered_from_phone: '' };
    const payload = new URLSearchParams();
    payload.set('table', String(context.table));
    payload.set('order_entity_id', String(existingOrderId || 0));
    payload.set('items', JSON.stringify(items || []));
    payload.set('ordered_by', String(customer.ordered_by || ''));
    payload.set('ordered_from_phone', String(customer.ordered_from_phone || ''));

    return fetch((window.SITE_URL || '/') + 'menu_order_save.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'
        },
        body: payload.toString()
    }).then(function (response) {
        return response.json().then(function (data) {
            return { ok: response.ok, data: data };
        });
    }).then(function (result) {
        if (!result.ok || !result.data || !result.data.success) {
            throw new Error((result.data && result.data.message) ? result.data.message : 'Unable to save order.');
        }

        const orderRecord = {
            order_entity_id: result.data.order_entity_id,
            order_id: result.data.order_id,
            table: context.table,
            items: items,
            order_total: result.data.order_total,
            preview_html: result.data.preview_html || '',
            ordered_by: result.data.ordered_by || customer.ordered_by || '',
            ordered_from_phone: result.data.ordered_from_phone || customer.ordered_from_phone || '',
            expires_at: Date.now() + (24 * 60 * 60 * 1000)
        };
        writeStoredTableOrder(orderRecord);
        updateOrderButtonVisibility();
        return orderRecord;
    });
}

function toastOrderMessage(message, cssClass) {
    if (window.M && typeof window.M.toast === 'function') {
        M.toast({ html: message, classes: cssClass || 'brown' });
    }
}

function getEffectiveOrderCustomer(order, status) {
    const stored = normalizeStoredOrderCustomer(order);
    return {
        ordered_by: status && status.ordered_by ? String(status.ordered_by) : stored.ordered_by,
        ordered_from_phone: status && status.ordered_from_phone ? String(status.ordered_from_phone) : stored.ordered_from_phone
    };
}

function renderStoredOrderItems(order, allowRemoval) {
    const items = Array.isArray(order && order.items) ? order.items : [];
    if (!items.length) {
        return '<li class="empty-order">No items in this order yet.</li>';
    }

    return items.map(function (item, index) {
        const lineTotal = (Number(item.quantity || 0) * Number(item.unit_price || 0)).toFixed(2);
        const removeButton = allowRemoval
            ? '<button type="button" class="btn-flat red-text order-remove-item" data-order-index="' + index + '"><i class="material-icons">delete</i></button>'
            : '';
        return ''
            + '<li class="stored-order-item">'
            + '  <div class="stored-order-item__main">'
            + '    <div class="stored-order-item__title">' + item.title + '</div>'
            + '    <div class="stored-order-item__meta">Qty ' + item.quantity + ' x $' + Number(item.unit_price || 0).toFixed(2) + '</div>'
            + '  </div>'
            + '  <div class="stored-order-item__side">'
            + '    <strong>$' + lineTotal + '</strong>'
            +      removeButton
            + '  </div>'
            + '</li>';
    }).join('');
}

function calculateStoredOrderTotal(order) {
    const items = Array.isArray(order && order.items) ? order.items : [];
    return items.reduce(function (sum, item) {
        return sum + (Number(item.quantity || 0) * Number(item.unit_price || 0));
    }, 0).toFixed(2);
}

function confirmStartNewOrder() {
    return window.confirm('This order has already been closed and paid. Would you like to start a new order?');
}

function confirmMoveOrderToTable(nextTable) {
    return window.confirm('You have moved to table ' + nextTable + '. Do you want to keep your current order and move it to this table?');
}

function createOrderModalShell(extraClass) {
    const overlay = document.createElement('div');
    overlay.className = 'order-modal-overlay';
    overlay.innerHTML = ''
        + '<div class="order-modal ' + (extraClass || '') + '"></div>';
    return overlay;
}

function openStoredOrderDialog(order, status) {
    const allowRemoval = !status.order_closed && !status.order_closed_and_paid;
    const isPaid = !!status.order_closed_and_paid;
    const isConfirmed = !!status.order_closed && !isPaid;
    const overlay = createOrderModalShell('order-modal--wide');
    const dialog = overlay.querySelector('.order-modal');
    const total = calculateStoredOrderTotal(order);
    const statusClass = isPaid ? 'is-paid' : (isConfirmed ? 'is-confirmed' : 'is-open');
    const customer = getEffectiveOrderCustomer(order, status);
    const statusMessage = isPaid
        ? 'This order has been closed and paid. You cannot add more items to it.'
        : (isConfirmed
            ? 'Order is confirmed and in progress. You can add more items, but existing items cannot be removed.'
            : 'You can review and adjust this order before it is confirmed.');

    dialog.innerHTML = ''
        + '<button type="button" data-close class="order-modal__close">&times;</button>'
        + '<h5 class="order-modal__title">Order #' + (order.order_id || order.order_entity_id) + '</h5>'
        + '<p class="order-modal__subtitle">Table #' + order.table + '</p>'
        + '<div class="order-modal__customer">'
        + '  <div><strong>Name:</strong> ' + sanitizeOrderText(customer.ordered_by || 'Guest') + '</div>'
        + '  <div><strong>Phone:</strong> ' + sanitizeOrderText(customer.ordered_from_phone || '-') + '</div>'
        + '</div>'
        + '<div class="order-status-banner ' + statusClass + '">' + statusMessage + '</div>'
        + '<ul class="order-items-list">' + renderStoredOrderItems(order, allowRemoval) + '</ul>'
        + '<div class="order-modal__footer">'
        + '  <strong class="order-modal__total">Total: $' + total + '</strong>'
        + '  <div class="order-modal__actions">'
        +       (isPaid ? '<button type="button" data-new-order class="btn brown">Start New Order</button>' : '')
        + '    <button type="button" data-close-footer class="btn-flat">Close</button>'
        + '  </div>'
        + '</div>';

    function closeDialog() {
        overlay.remove();
    }

    overlay.addEventListener('click', function (event) {
        if (event.target === overlay || event.target.hasAttribute('data-close') || event.target.hasAttribute('data-close-footer')) {
            closeDialog();
        }
    });

    overlay.querySelectorAll('.order-remove-item').forEach(function (button) {
        button.addEventListener('click', function () {
            const index = parseInt(button.getAttribute('data-order-index') || '-1', 10);
            if (!Number.isInteger(index) || index < 0) {
                return;
            }

            const nextItems = (order.items || []).filter(function (_, itemIndex) {
                return itemIndex !== index;
            });
            persistTableOrder({ table: order.table }, nextItems, order.order_entity_id, customer).then(function (updatedOrder) {
                closeDialog();
                if (!updatedOrder.items.length) {
                    clearStoredTableOrder();
                    toastOrderMessage('Order is now empty.', 'brown');
                    return;
                }
                fetchCurrentOrderStatus(updatedOrder).then(function (updatedStatus) {
                    openStoredOrderDialog(updatedOrder, updatedStatus);
                });
            }).catch(function (error) {
                toastOrderMessage(error.message || 'Unable to update order.', 'red darken-2');
            });
        });
    });

    const newOrderButton = overlay.querySelector('[data-new-order]');
    if (newOrderButton) {
        newOrderButton.addEventListener('click', function () {
            clearStoredTableOrder();
            closeDialog();
            toastOrderMessage('You can now start a new order.', 'brown');
        });
    }

    document.body.appendChild(overlay);
}

function openMenuOrderDialog(item, context) {
    let quantity = 1;
    const existingOrder = readStoredTableOrder();
    const customer = normalizeStoredOrderCustomer(existingOrder);
    const overlay = createOrderModalShell('order-modal--compact');
    const dialog = overlay.querySelector('.order-modal');
    const titleNode = item.querySelector('h3');
    const itemTitle = titleNode ? titleNode.textContent.trim() : 'Menu Item';

    dialog.innerHTML = ''
        + '<button type="button" data-close class="order-modal__close">&times;</button>'
        + '<h5 class="order-modal__title">Add To Order</h5>'
        + '<p class="order-modal__subtitle">Table #' + context.table + '</p>'
        + '<div class="order-modal__item-name">' + itemTitle + '</div>'
        + '<div class="order-modal__customer-fields">'
        + '  <div class="input-field order-modal__field">'
        + '    <input id="order-customer-name" type="text" data-customer-name value="' + sanitizeOrderText(customer.ordered_by) + '" required>'
        + '    <label for="order-customer-name" class="active">Your Name</label>'
        + '  </div>'
        + '  <div class="input-field order-modal__field">'
        + '    <input id="order-customer-phone" type="tel" data-customer-phone value="' + sanitizeOrderText(customer.ordered_from_phone) + '" required>'
        + '    <label for="order-customer-phone" class="active">Phone Number</label>'
        + '  </div>'
        + '</div>'
        + '<div class="order-qty-picker">'
        + '  <button type="button" data-minus class="btn-flat order-qty-picker__button">-</button>'
        + '  <input type="number" min="1" value="1" data-qty class="order-qty-picker__input">'
        + '  <button type="button" data-plus class="btn-flat order-qty-picker__button">+</button>'
        + '</div>'
        + '<div class="order-modal__actions order-modal__actions--end">'
        + '  <button type="button" data-cancel class="btn-flat">Cancel</button>'
        + '  <button type="button" data-confirm class="btn brown">Add To Order</button>'
        + '</div>';

    const qtyInput = overlay.querySelector('[data-qty]');
    const nameInput = overlay.querySelector('[data-customer-name]');
    const phoneInput = overlay.querySelector('[data-customer-phone]');
    function closeDialog() { overlay.remove(); }
    function syncQty(next) {
        quantity = Math.max(1, parseInt(next || '1', 10) || 1);
        qtyInput.value = String(quantity);
    }
    function getCustomerDetails() {
        return {
            ordered_by: nameInput ? nameInput.value.trim() : '',
            ordered_from_phone: phoneInput ? phoneInput.value.trim() : ''
        };
    }

    overlay.addEventListener('click', function (event) {
        if (event.target === overlay || event.target.hasAttribute('data-close') || event.target.hasAttribute('data-cancel')) {
            closeDialog();
        }
    });
    overlay.querySelector('[data-minus]').addEventListener('click', function () { syncQty(quantity - 1); });
    overlay.querySelector('[data-plus]').addEventListener('click', function () { syncQty(quantity + 1); });
    qtyInput.addEventListener('input', function () { syncQty(qtyInput.value); });
    overlay.querySelector('[data-confirm]').addEventListener('click', function () {
        const customerDetails = getCustomerDetails();
        if (!customerDetails.ordered_by || !customerDetails.ordered_from_phone) {
            toastOrderMessage('Please enter your name and phone number to place this order.', 'red darken-2');
            if (!customerDetails.ordered_by && nameInput) {
                nameInput.focus();
            } else if (phoneInput) {
                phoneInput.focus();
            }
            return;
        }
        submitTableOrder(item, context, quantity, false, customerDetails).finally(closeDialog);
    });

    document.body.appendChild(overlay);
    qtyInput.focus();
    qtyInput.select();
}

function submitTableOrder(item, context, quantity, forceNewOrder, customerDetails) {
    const existingOrder = readStoredTableOrder();
    const shouldReuseExisting = !forceNewOrder && existingOrder && Number(existingOrder.table) === Number(context.table);
    const newItem = buildMenuOrderItem(item, quantity);
    const customer = customerDetails || normalizeStoredOrderCustomer(existingOrder);

    if (!shouldReuseExisting) {
        return persistTableOrder(context, [newItem], 0, customer).then(function () {
            toastOrderMessage('Order saved for table #' + context.table, 'green darken-1');
        }).catch(function (error) {
            toastOrderMessage(error.message || 'Unable to save order.', 'red darken-2');
        });
    }

    return fetchCurrentOrderStatus(existingOrder).then(function (status) {
        if (status.order_closed_and_paid) {
            if (!confirmStartNewOrder()) {
                return;
            }
            clearStoredTableOrder();
            return submitTableOrder(item, context, quantity, true, customer);
        }

        const mergedItems = mergeOrderItems(existingOrder.items || [], newItem);
        return persistTableOrder(context, mergedItems, existingOrder.order_entity_id, customer).then(function () {
            toastOrderMessage('Order saved for table #' + context.table, 'green darken-1');
        });
    }).catch(function (error) {
        toastOrderMessage(error.message || 'Unable to save order.', 'red darken-2');
    });
}

function maybePromptForMovedTable(context) {
    const storedOrder = readStoredTableOrder();
    if (!storedOrder || !context.isMenuPage || context.table <= 0) {
        return;
    }

    if (Number(storedOrder.table) === Number(context.table)) {
        return;
    }

    fetchCurrentOrderStatus(storedOrder).then(function (status) {
        if (status.order_closed_and_paid) {
            if (confirmStartNewOrder()) {
                clearStoredTableOrder();
                toastOrderMessage('Your previous order is closed. You can start a new order for table #' + context.table + '.', 'brown');
            }
            return;
        }

        if (!confirmMoveOrderToTable(context.table)) {
            return;
        }

        const customer = getEffectiveOrderCustomer(storedOrder, status);
        persistTableOrder(context, storedOrder.items || [], storedOrder.order_entity_id, customer).then(function () {
            toastOrderMessage('Your order has been moved to table #' + context.table + '.', 'green darken-1');
        }).catch(function (error) {
            toastOrderMessage(error.message || 'Unable to move this order to the new table.', 'red darken-2');
        });
    });
}

function injectMenuOrderButtons(context) {
    document.querySelectorAll('ul.bespokeproducts.menu li[data-entity-type], .menu-section-list li[data-entity-type]').forEach(function (item) {
        if (item.querySelector('.menu-order-btn')) {
            return;
        }

        const anchor = item.querySelector('a[data-id]');
        const mediaShell = anchor ? anchor.querySelector('div') : null;
        if (!anchor || !mediaShell) {
            return;
        }

        const button = document.createElement('button');
        button.type = 'button';
        button.className = 'menu-order-btn btn-floating waves-effect waves-light brown';
        button.setAttribute('aria-label', 'Order this item');
        button.innerHTML = '<i class="material-icons">add</i>';
        button.addEventListener('click', function (event) {
            event.preventDefault();
            event.stopPropagation();
            openMenuOrderDialog(item, context);
        });
        mediaShell.appendChild(button);
    });
}

function handleOrderIconClick(event) {
    event.preventDefault();
    const order = readStoredTableOrder();
    if (!order) {
        updateOrderButtonVisibility();
        toastOrderMessage('No active order found.', 'brown');
        return;
    }

    fetchCurrentOrderStatus(order).then(function (status) {
        if (status.order_closed_and_paid && !order.items.length) {
            if (confirmStartNewOrder()) {
                clearStoredTableOrder();
                toastOrderMessage('You can now start a new order.', 'brown');
            }
            return;
        }

        openStoredOrderDialog(order, status);
    });
}

function initTableMenuOrdering() {
    const context = getTableOrderContext();
    updateOrderButtonVisibility();

    const orderBtn = document.querySelector('a.order-btn');
    if (orderBtn) {
        orderBtn.addEventListener('click', handleOrderIconClick);
    }

    if (!context.isMenuPage || context.table <= 0) {
        return;
    }

    maybePromptForMovedTable(context);
    injectMenuOrderButtons(context);
}

document.addEventListener('DOMContentLoaded', initTableMenuOrdering);

function initMaterializeTextFieldLabels() {
    if (window.M && typeof window.M.updateTextFields === 'function') {
        window.M.updateTextFields();
    }

    document.querySelectorAll('.input-field label[for]').forEach(function(label) {
        if (label.dataset.labelBound === '1') {
            return;
        }

        label.dataset.labelBound = '1';
        label.addEventListener('click', function() {
            var targetId = label.getAttribute('for');
            if (!targetId) {
                return;
            }

            var field = null;
            var inputField = label.closest('.input-field');
            if (inputField) {
                field = inputField.querySelector('#' + cssEscapeIdentifier(targetId) + ', input, textarea, select');
            }
            if (!field) {
                field = document.getElementById(targetId);
            }
            if (!field) {
                return;
            }

            label.classList.add('active');
            field.focus();
            window.setTimeout(function() {
                label.classList.add('active');
                field.focus();
                if (window.M && typeof window.M.updateTextFields === 'function') {
                    window.M.updateTextFields();
                }
            }, 0);
        });
    });
}

function normalizeFrontendFormFieldIds() {
    document.querySelectorAll('.input-field label[for]').forEach(function(label, labelIndex) {
        var targetId = label.getAttribute('for');
        if (!targetId) {
            return;
        }

        var inputField = label.closest('.input-field');
        if (!inputField) {
            return;
        }

        var field = inputField.querySelector('#' + cssEscapeIdentifier(targetId) + ', input, textarea, select');
        if (!field) {
            return;
        }

        var uniqueId = targetId + '--fld-' + labelIndex;
        field.id = uniqueId;
        label.setAttribute('for', uniqueId);
    });
}

function cssEscapeIdentifier(value) {
    if (window.CSS && typeof window.CSS.escape === 'function') {
        return window.CSS.escape(value);
    }
    return String(value).replace(/([ #;?%&,.+*~\\':"!^$[\]()=>|\/@])/g, '\\$1');
}
