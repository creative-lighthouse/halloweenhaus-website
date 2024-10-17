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
    const index = cartdata.findIndex((entry) => entry.id === productid);

    if (index >= 0) {
        cartdata[index].amount++;
    } else {
        cartdata.push({
            id: productid,
            name: product.name,
            price: product.price,
            imageurl: product.imageurl,
            amount: 1
        });
    }

    renderCart();
}

function removeFromCart(productid) {
    const product = productdata.find((product) => product.id === productid);
    const index = cartdata.findIndex((entry) => entry.id === productid);
    if (index >= 0) {
        cartdata[index].amount--;
        if (cartdata[index].amount <= 0) {
            cartdata.splice(index, 1);
        }
    } else {
        console.error('Product not found in cart');
    }
    renderCart();
}

function renderCart() {
    console.log("Cart: ", cartdata);
    var totalPrice = 0;
    totalPriceTag.textContent = totalPrice + ' €';

    if (cartdata.length > 0) {
        cart.innerHTML = '';
        cartdata.forEach((entry) => {
            const product = productdata.find((product) => product.id === entry.id);
            const productElement = document.createElement('div');
            const entrytotalprice = parseFloat(entry.price) * entry.amount;
            productElement.classList.add('product_list_entry');
            productElement.innerHTML = `
                <div class="product_list_entry_image">
                    <img src="${product.imageurl}" alt="${product.name}">
                </div>
                <div class="product_list_entry_content">
                    <h3>${entry.name}</h3>
                    <p>${entry.price} * ${entry.amount}</p>
                    <p>= ${entrytotalprice}</p>
                </div>
            `;
            cart.appendChild(productElement);

            totalPrice += parseFloat(entry.price) * entry.amount;
            totalPriceTag.textContent = totalPrice + ' €';
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
