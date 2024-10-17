//PosSystem
const products = document.querySelectorAll('[data-behaviour="pos_product"]');
const cart = document.querySelector('[data-behaviour="pos_cart"]');
const increaseButtons = document.querySelectorAll('[data-behaviour="pos_product_increase"]');
const decreaseButtons = document.querySelectorAll('[data-behaviour="pos_product_decrease"]');
const totalPriceTag = document.querySelector('[data-behaviour="pos_total-price"]');
const clock = document.querySelector('[data-behaviour="pos_clock"]');
var cartdata = [];
var productdata = [];


if (products != null) {

    clearCart();

    console.log("products found");
    products.forEach((product) => {
        productdata.push({
            id: product.getAttribute('data-productid'),
            name: product.getAttribute('data-name'),
            price: product.getAttribute('data-price'),
            imageurl: product.getAttribute('data-imageurl')
        });
    });
    console.log(productdata);

    increaseButtons.forEach((button) => {
        button.addEventListener('click', () => {
            const productid = button.getAttribute('data-productid');
            addToCart(productid);
        });
    });

    decreaseButtons.forEach((button) => {
        button.addEventListener('click', () => {
            const productid = button.getAttribute('data-productid');
            removeFromCart(productid);
        });
    });

    setInterval(updateClock, 1000);
}

function addToCart(productid) {
    const product = productdata.find((product) => product.id === productid);
    if (cartdata[productid] === undefined) {
        cartdata[productid] = 1;
    } else {
        cartdata[productid] += 1;
    }
    renderCart();
}

function removeFromCart(productid) {
    if (cartdata[productid] === 1) {
        delete cartdata[productid];
    } else {
        cartdata[productid] -= 1;
    }
    renderCart();
}

function renderCart() {
    console.log("Cart: ", cartdata);
    var totalPrice = 0;
    totalPriceTag.textContent = totalPrice + ' €';

    if (cartdata.length > 0) {
        console.log("Cart: ", cartdata);
        cartdata.forEach(entry => {
            entryproduct = productdata[entry];
            entryamount = cartdata[entry];
            entrytotalprice = entryproduct.price * entryamount;
            //create new node for entry
            entryobject = document.createElement("div");
            entryobject.classList.add('product_list_entry');
            entryobject.innerHTML = `
                <div class="product_list_entry_image">
                    <img src="${entryproduct.imageurl}" alt="${entryproduct.name}">
                </div>
                <div class="product_list_entry_content">
                    <h3>${entryproduct.name}</h3>
                    <p>${entryproduct.price} * ${entryamount}</p>
                    <p>= ${entrytotalprice}</p>
                </div>
            `;
            cart.appendChild(entryobject);
            totalPrice += entrytotalprice;
        });
    } else {
        clearCart();
    }
}

function clearCart() {
    cart.innerHTML = '<p>Keine Produkte im Warenkorb</p>';
}

function updateClock() {
    const now = new Date();
    const hours = now.getHours().toString().padStart(2, '0');
    const minutes = now.getMinutes().toString().padStart(2, '0');
    const seconds = now.getSeconds().toString().padStart(2, '0');

    clock.textContent = `${now.getDate()}.${now.getMonth() + 1}.${now.getFullYear()} ${hours}:${minutes}:${seconds}`;
}
