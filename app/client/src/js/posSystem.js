//PosSystem
const products = document.querySelectorAll('[data-behaviour="pos_product"]');
const cart = document.querySelector('[data-behaviour="pos_cart"]');
const increaseButtons = document.querySelectorAll('[data-behaviour="pos_product_increase"]');
const decreaseButtons = document.querySelectorAll('[data-behaviour="pos_product_decrease"]');
const productAmounts = document.querySelectorAll('[data-behaviour="pos_product_change"]');
const totalPriceTag = document.querySelector('[data-behaviour="pos_total-price"]');
const clock = document.querySelector('[data-behaviour="pos_clock"]');
const buybutton = document.querySelector('[data-behaviour="pos_buy"]');
var cartdata = [];
var productdata = [];

if (products.length > 0) {
    console.log("products found");

    clearCart();

    products.forEach((product) => {
        productdata.push({
            id: product.getAttribute('data-productid'),
            name: product.getAttribute('data-name'),
            price: product.getAttribute('data-price'),
            imageurl: product.getAttribute('data-imageurl')
        });
    });
    console.log(productdata);

    buybutton.addEventListener('click', () => {
        addSaleViaAPI();
    });

    productAmounts.forEach((productAmount) => {
        productAmount.value = 0;
        decreaseButtons.forEach((button) => {
            if (button.getAttribute('data-productid') == productAmount.getAttribute('data-productid')) {
                button.disabled = true;
            }
        });
        productAmount.addEventListener('change', () => {
            if (productAmount.value < 0 || isNaN(productAmount.value) || productAmount.value === '') {
                productAmount.value = 0;
            }
            const productid = productAmount.getAttribute('data-productid');
            const amount = parseInt(productAmount.value);
            const index = cartdata.findIndex((entry) => entry.id === productid);

            if (index >= 0) {
                cartdata[index].amount = amount;
                updateProductNumber(productid, amount);
                if (amount <= 0) {
                    cartdata.splice(index, 1);
                }
            } else {
                if (amount > 0) {
                    cartdata.push({
                        id: productid,
                        name: productdata.find((product) => product.id === productid).name,
                        price: productdata.find((product) => product.id === productid).price,
                        imageurl: productdata.find((product) => product.id === productid).imageurl,
                        amount: amount
                    });
                    updateProductNumber(productid, amount);
                }
            }
            renderCart();
        });
    });

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
        updateProductNumber(productid, cartdata[index].amount);
    } else {
        cartdata.push({
            id: productid,
            name: product.name,
            price: product.price,
            imageurl: product.imageurl,
            amount: 1
        });
        updateProductNumber(productid, 1);
    }

    renderCart();
}

function removeFromCart(productid) {
    const product = productdata.find((product) => product.id === productid);
    const index = cartdata.findIndex((entry) => entry.id === productid);

    if (index >= 0) {
        cartdata[index].amount--;
        console.log('Amount: ', cartdata[index].amount);
        updateProductNumber(productid, cartdata[index].amount);
        if (cartdata[index].amount <= 0) {
            cartdata.splice(index, 1);
            updateProductNumber(productid, 0);
        }
    } else {
        console.error('Product not found in cart');
        updateProductNumber(productid, 0);
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
                    <p>${entry.amount} * ${entry.price}€</p>
                    <p>= ${entrytotalprice}€</p>
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
    totalPriceTag.textContent = '0 €';
    productAmounts.forEach((productAmount) => {
        productAmount.value = 0;
    });
    decreaseButtons.forEach((button) => {
        button.disabled = true;
    });
    cartdata = [];
}

function updateClock() {
    const now = new Date();
    const hours = now.getHours().toString().padStart(2, '0');
    const minutes = now.getMinutes().toString().padStart(2, '0');
    const seconds = now.getSeconds().toString().padStart(2, '0');

    clock.textContent = `${now.getDate()}.${now.getMonth() + 1}.${now.getFullYear()} ${hours}:${minutes}:${seconds}`;
}

function updateProductNumber(productid, amount)
{
    productAmounts.forEach((productAmount) => {
        if (productAmount.getAttribute('data-productid') == productid) {
            productAmount.value = amount;
        }
    });

    if (amount <= 0) {
        decreaseButtons.forEach((button) => {
            if (button.getAttribute('data-productid') == productid) {
                button.disabled = true;
            }
        });
    } else {
        decreaseButtons.forEach((button) => {
            if (button.getAttribute('data-productid') == productid) {
                button.disabled = false;
            }
        });
    }
}

function addSaleViaAPI()
{
    if(cartdata.length <= 0)
    {
        console.error('No products in cart');
        return;
    }

    const sale = {
        products: cartdata,
        total: totalPriceTag.textContent
    };

    fetch('./api/addPOSSale', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(sale)
    })
    .then(response => response.json())
    .then(data => {
        console.log('Success:', data);
        clearCart();
    })
    .catch((error) => {
        console.error('Error:', error);
    });
}
