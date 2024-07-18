jQuery(document).ready(function($) {
    const wrapper1 = document.querySelector("#wrapper"),
        selectBtn1 = wrapper1.querySelector(".select-btn"),
        searchInp1 = document.getElementById('search'),
        productList1 = document.getElementById('product-list'),
        products1 = Array.from(productList1.querySelectorAll('.bxgx-values'));

    function toggleDropdown(wrapper) {
        wrapper.classList.toggle("active");
    }

    const searchInp = document.getElementById('search');
    const productList = document.getElementById('product-list');
    const products = Array.from(productList.querySelectorAll('.bxgx-values'));

    function searchProducts(searchInput, productsList) {
        const searchVal = searchInput.value.trim().toLowerCase();

        productsList.forEach(product => {
            const productTitle = product.parentElement.textContent.toLowerCase();
            const productItem = product.closest('li');

            if (productTitle.includes(searchVal)) {
                productItem.style.display = 'block';
            } else {
                productItem.style.display = 'none';
            }
        });
    }

    searchInp.addEventListener('keyup', function() {
        searchProducts(this, products);
    });

    // Toggle dropdown on button click
    selectBtn1.addEventListener("click", () => toggleDropdown(wrapper1));

    // Search products in the list


    // Handle form submission
    $('#product-form').on('submit', function(event) {
        event.preventDefault();

        var selectedProducts = [];
        var unselectedProducts = [];
        $('input[name="selected_products[]"]').each(function() {
            if ($(this).is(':checked')) {
                selectedProducts.push($(this).val());
            } else {
                unselectedProducts.push($(this).val());
            }
        });

        $.ajax({
            url: buyXGetXData.ajax_url,
            method: 'POST',
            data: {
                action: 'update_buy_x_get_x_products',
                selected_products: selectedProducts,
                unselected_products: unselectedProducts,

            },
            success: function(response) {
                if (response.success) {
                    createToast('success', 'bx bx-happy-alt','Success',response.data.message)
                } else if(response.error) {
                    createToast('warning', 'bx bxs-meh-alt','Warning', response.data.message)
                }
            },
            error: function() {
                createToast('warning', 'bx bxs-meh-alt','Warning','An error occurred while processing the request.') ;
            }
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

        // Auto remove after 5 seconds
        newToast.timeOut = setTimeout(function () {
            newToast.remove();
        }, 5000);
    }
});


