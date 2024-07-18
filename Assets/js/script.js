jQuery(document).ready(function($) {
    const wrapper1 = document.querySelector("#wrapper"),
         selectBtn1 = wrapper1.querySelector(".select-btn"),
         searchInp1 = document.getElementById('search'),
         productList1 = document.getElementById('product-list'),
         selectedProductList1 = document.getElementById('selected-product-list'),
         selectedProductsInput1 = document.getElementById('selected_products_input'),
         products1 = Array.from(productList1.querySelectorAll('.bxgx-values'));

    const wrapper2 = document.querySelector("#wrapper2"),
        selectBtn2 = wrapper2.querySelector(".select-btn"),
        searchInp2 = document.getElementById('search2'),
        productList2 = document.getElementById('product-list2'),
        selectedProductList2 = document.getElementById('selected-product-list2'),
        selectedProductsInput2 = document.getElementById('unselected_products_input'),
        products2 = Array.from(productList2.querySelectorAll('.bxgx-values'));

    let selectedProducts = [];
    let unselectedProducts = [];

    function toggleDropdown(wrapper) {
        wrapper.classList.toggle("active");
    }

    function searchProducts(searchInp, products) {
        const searchVal = searchInp.value.toLowerCase();
        products.forEach(product => {
            const text = product.textContent.toLowerCase();
            if (text.startsWith(searchVal)) {
                product.style.display = 'block';
            } else {
                product.style.display = 'none';
            }
        });
    }

    function addProduct(product, selectedList, selectedArray, inputField) {
        if (!selectedArray.includes(product.dataset.id)) {
            selectedArray.push(product.dataset.id);
            const selectedProduct = document.createElement('li');
            selectedProduct.dataset.id = product.dataset.id;
            selectedProduct.innerHTML = `
                ${product.textContent}
                <button class="remove-btn" onclick="removeProduct('${product.dataset.id}', '${selectedList.id}', '${inputField.id}')">&times;</button>
            `;
            selectedList.appendChild(selectedProduct);
            updateSelectedProductsInput(selectedArray, inputField);
        }
    }

    function updateSelectedProductsInput(selectedArray, inputField) {
        inputField.value = selectedArray.join(',');
    }

    window.removeProduct = function(productId, selectedListId, inputFieldId) {
        const selectedList = document.getElementById(selectedListId);
        const inputField = document.getElementById(inputFieldId);

        if (selectedListId === 'selected-product-list') {
            selectedProducts = selectedProducts.filter(id => id !== productId);
        } else {
            unselectedProducts = unselectedProducts.filter(id => id !== productId);
        }

        const productToRemove = selectedList.querySelector(`li[data-id="${productId}"]`);
        if (productToRemove) {
            productToRemove.remove();
        }

        if (selectedListId === 'selected-product-list') {
            updateSelectedProductsInput(selectedProducts, inputField);
        } else {
            updateSelectedProductsInput(unselectedProducts, inputField);
        }
    }

    // This is the call back functions for drop down menu for both select and unselect
    selectBtn1.addEventListener("click", () => toggleDropdown(wrapper1));
    selectBtn2.addEventListener("click", () => toggleDropdown(wrapper2));

    // This is the search scripting call back function for both selected and unselected
    searchInp1.addEventListener("keyup", () => searchProducts(searchInp1, products1));
    searchInp2.addEventListener("keyup", () => searchProducts(searchInp2, products2));

    // This is the call back function for display selected or unselected product in the selected or unselected area
    products1.forEach(product => {
        product.addEventListener('click', () => addProduct(product, selectedProductList1, selectedProducts, selectedProductsInput1));
    });

    products2.forEach(product => {
        product.addEventListener('click', () => addProduct(product, selectedProductList2, unselectedProducts, selectedProductsInput2));
    });

    // this is the ajax form submission for selected products
    $('#product-form').on('submit', function(event) {
        event.preventDefault();

        const selectedProducts = $('#selected_products_input').val();
        if (selectedProducts) {
            $.ajax({
                url: BxgxScript.ajax_url,
                method: 'POST',
                data: {
                    action: 'bxgx_save_products',
                    selected_products: selectedProducts
                },
                success: function(response) {

                    createToast("success", "bx bxs-check-circle","Success",response);
                    },
                error: function (xhr, status, error) {
                    createToast("error", "bx bxs-error","Warning",error);

                }
            });
        } else {
            createToast("info", "bx bxs-info-circle", "Info", "Please select at least one product to unselect.");
        }
    });

    $('#unselect-product-form').on('submit', function(event) {
        event.preventDefault();

        const unselectedProducts = $('#unselected_products_input').val();
        if (unselectedProducts) {
            $.ajax({
                url: BxgxScript.ajax_url,
                method: 'POST',
                data: {
                    action: 'bxgx_save_products',
                    unselected_products: unselectedProducts
                },
                success: function(response) {
                    createToast("success", "bx bxs-check-circle","Success",response);

                },
                error: function(xhr, status, error) {
                    createToast("error", "bx bxs-error","Warning",error);


                }
            });
        } else {
            createToast("info", "bx bxs-info-circle", "Info", "Please select at least one product to unselect.");

        }
    });

    // this is the scripting for menu
    let menuList1 = document.getElementById("menu-list1");
    let menuList2 = document.getElementById("menu-list2");

    menuList1.addEventListener("click", () => {
        document.getElementById('menu1').style.display = "block";
        document.getElementById('menu2').style.display = "none";
    });

    menuList2.addEventListener("click", () => {
        document.getElementById('menu1').style.display = "none";
        document.getElementById('menu2').style.display = "block";
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
        <i class='bx bx-x' onclick="(this.parentElement).remove()"></i>
    `;
    document.querySelector('.notification').appendChild(newToast);

    // Auto remove after 5 seconds
    newToast.timeOut = setTimeout(function() {
        newToast.remove();
    }, 5000);
}