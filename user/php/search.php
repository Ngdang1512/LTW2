<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Cửa hàng bán vợt và phụ kiện cầu lông" />
    <title>Badminton Racket Store</title>

    <!-- CSS -->
    <link rel="stylesheet" href="/user/css/reset.css" />
    <link rel="stylesheet" href="/user/css/index.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous"><!DOCTYPE html>
<html lang="en">
<body>
        <!-- search.php -->
    <div class="container mt-5 mb-3"> <!-- Changed mt-4 to mt-5 for more top margin -->
        <div class="row justify-content-end"> <!-- Use Bootstrap row and justify-content-end to align to the right -->
            <div class="col-md-4"> <!-- Use Bootstrap column to control width on medium screens and up -->
                <form class="d-flex" id="search-form" style="margin-top: -30px;"> <!-- Use d-flex for flexbox layout -->
                    <input class="form-control me-2" type="search" placeholder="Tìm kiếm sản phẩm..." aria-label="Search" id="search-input"> <!-- Bootstrap form-control and margin -->
                    <button class="btn btn-outline-secondary" type="submit" id="search-button"> <!-- Bootstrap button classes -->
                        <i class="fa-solid fa-magnifying-glass"></i> <!-- FontAwesome icon -->
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Search Results Section (Optional - depending on how results are displayed) -->
    <div id="search-results" class="container mt-4" style="display: none;">
        <h3>Kết quả tìm kiếm</h3> <!-- Kept the original heading from user/php/search.php -->
        <div id="results-list" class="row">
            <!-- Search results will be displayed here -->
        </div>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>