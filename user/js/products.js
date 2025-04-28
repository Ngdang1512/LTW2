document.querySelector('.apply-filters').addEventListener('click', function() {
    const products = document.querySelectorAll('.product');
    
    // Lấy các giá trị từ các checkbox
    const priceFilters = Array.from(document.querySelectorAll('.filter-section:nth-child(1) input:checked')).map(checkbox => checkbox.value);
    const brandFilters = Array.from(document.querySelectorAll('.filter-section:nth-child(2) input:checked')).map(checkbox => checkbox.value);
    
    let anyProductVisible = false; // Biến để kiểm tra có sản phẩm nào hiển thị

    // Lọc sản phẩm
    products.forEach(product => {
        const productTitle = product.querySelector('.product-title').textContent; // Lấy tên sản phẩm
        const productPriceText = product.querySelector('p').textContent; // Lấy giá sản phẩm
        const productPrice = parseInt(productPriceText.replace(/\D/g, '')); // Chuyển đổi giá từ chuỗi sang số nguyên
        
        console.log(`Product Title: ${productTitle}, Product Price: ${productPrice}`); // Kiểm tra giá trị

        // Kiểm tra điều kiện lọc
        let showProduct = true;

        // Kiểm tra giá
        if (priceFilters.length > 0) {
            showProduct = priceFilters.some(filter => {
                if (filter === 'under-500000' && productPrice < 500000) return true;
                if (filter === '500000-1000000' && productPrice >= 500000 && productPrice < 1000000) return true;
                if (filter === '1000000-2000000' && productPrice >= 1000000 && productPrice < 2000000) return true;
                if (filter === '2000000-3000000' && productPrice >= 2000000 && productPrice < 3000000) return true;
                if (filter === 'above-3000000' && productPrice >= 3000000) return true;
                return false;
            });
        }

        // Kiểm tra thương hiệu
        if (showProduct && brandFilters.length > 0) {
            showProduct = brandFilters.some(brand => productTitle.includes(brand));
        }

        // Hiện hoặc ẩn sản phẩm
        product.style.display = showProduct ? 'block' : 'none';
        
        // Kiểm tra xem có sản phẩm nào được hiển thị không
        if (showProduct) {
            anyProductVisible = true;
        }
    });

    // Hiển thị thông báo nếu không có sản phẩm nào được tìm thấy
    const noResults = document.querySelector('.no-results');
    if (!anyProductVisible) {
        noResults.style.display = 'block'; // Hiện thông báo không tìm thấy kết quả
    } else {
        noResults.style.display = 'none'; // Ẩn thông báo nếu có sản phẩm
    }

    // Cuộn về đầu trang
    window.scrollTo({
        top: 0,
        behavior: 'smooth' // Cuộn mượt mà
    });
});