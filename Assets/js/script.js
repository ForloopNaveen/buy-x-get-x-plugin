
jQuery(document).ready(function($) {
    const wrapper1 = document.querySelector("#wrapper");

    function toggleDropdown(wrapper) {
        wrapper.classList.toggle("active");
    }

    const searchInp = document.getElementById('search');
    const productList = document.getElementById('product-list');
    const products = Array.from(productList.querySelectorAll('.bxgx-values'));
    const selectedProductsContainer = document.getElementById('selected-products-container');

    let productsToEnable = [];
    let productsToDisable = [];

    function searchProducts(searchInput, productsList) {
        const searchVal = searchInput.value.trim().toLowerCase();

        productsList.forEach(product => {
            const productTitle = product.textContent.toLowerCase();
            const productItem = product.closest('li');

            if (productTitle.includes(searchVal)) {
                productItem.style.display = 'block';
            } else {
                productItem.style.display = 'none';

            }
        });
    }

    function selectProduct(product) {
        const productId = product.getAttribute('data-set');
        const productTitle = product.textContent;


        if (!productsToEnable.includes(productId)) {
            productsToEnable.push(productId);
        }





        const selectedProductElem = document.createElement('div');
        selectedProductElem.classList.add('selected-product');
        selectedProductElem.setAttribute('data-set', productId);
        selectedProductElem.innerHTML = `${productTitle} <i class='bx bx-x remove-icon'></i>`;


        selectedProductsContainer.appendChild(selectedProductElem);


        product.style.display = 'none';
    }

    function removeProduct(productElem) {
        const productId = productElem.getAttribute('data-set');


        if (!productsToDisable.includes(productId)) {
            productsToDisable.push(productId);
        }




        productElem.remove();


        const productInList = productList.querySelector(`.bxgx-values[data-set="${productId}"]`);
        productInList.style.display = 'block';
    }

    searchInp.addEventListener('keyup', function() {
        searchProducts(this, products);
    });

    productList.addEventListener('click', function(event) {
        const target = event.target;
        if (target.classList.contains('bxgx-values')) {
            selectProduct(target);
        }
    });

    selectedProductsContainer.addEventListener('click', function(event) {
        const target = event.target;
        if (target.classList.contains('remove-icon')) {
            removeProduct(target.closest('.selected-product'));
        }
    });

    let dropDownBtn = document.getElementById('drop-down');
    dropDownBtn.addEventListener("click", () => toggleDropdown(wrapper1));

    $('#product-form').on('submit', function(event) {

        event.preventDefault();

        jQuery.ajax({
            url: buyXGetXData.ajax_url,
            method: 'POST',
            data: {
                action: 'update_buy_x_get_x',
                products_to_enable: productsToEnable,
                products_to_disable: productsToDisable,
            },
            success: function(response) {
                if(response) {
                    createToast('success', 'bx bx-happy-alt', 'Success', response.data.message);
                }else{
                    createToast('error', 'bx bx-error', 'Error', 'An error occurred');

                }
            },

        });
    });

    function createToast(type, icon, title, text) {
        let newToast = document.createElement('div');
        newToast.classList.add('toast', type);
        newToast.innerHTML = `
        <i class='${icon}'></i>
        <div class="toast-content">
            <div class="title">${title}</div>
            <span class="toast-msg">${text}</span>
        </div>
        <i class='bx bx-x' style="cursor: pointer" onclick="(this.parentElement).remove()"></i>
    `;
        document.querySelector('.notification').appendChild(newToast);


        newToast.timeOut = setTimeout(function () {
            newToast.remove();
        }, 5000);
    }


    const initiallyEnabledProducts = JSON.parse(buyXGetXData.initiallyEnabledProducts);
    initiallyEnabledProducts.forEach(product => {
        const selectedProductElem = document.createElement('div');
        selectedProductElem.classList.add('selected-product');
        selectedProductElem.setAttribute('data-set', product.id);
        selectedProductElem.innerHTML = `${product.title} <i class='bx bx-x remove-icon' style="font-size: 16px"></i>`;
        selectedProductsContainer.appendChild(selectedProductElem);

        // Hide the product from the list
        const productInList = productList.querySelector(`.bxgx-values[data-set="${product.id}"]`);
        if (productInList) {
            productInList.style.display = 'none';
        }
    });
});
