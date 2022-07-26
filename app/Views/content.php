<?= $this->extend($git_assets . 'ci4_views/template'); ?>

<?= $this->section('content'); ?>

<body id="reportsPage">
    <?= $this->include('layouts/topbar'); ?>

    <div class="container mt-5">
        <div class="row tm-content-row">
            <div class="col-sm-12 col-md-12 col-lg-8 col-xl-8 tm-block-col">
                <div class="tm-bg-primary-dark tm-block tm-block-products">
                    <a href="#" class="btn btn-primary btn-block text-uppercase mb-3" id="addWebsiteButton" data-toggle="modal" data-target="#addWebsiteModal">Add Website</a>

                    <?= $this->include('modals/add_website'); ?>

                    <div class="tm-product-table-container">
                        <table class="table table-hover tm-table-small tm-product-table">
                            <thead>
                                <tr>
                                    <th scope="col">WEBSITE NAME</th>
                                    <th scope="col">DATE CREATED</th>
                                </tr>
                            </thead>
                            <tbody id="websiteList">
                                <?= $this->include('website_list'); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-12 col-lg-4 col-xl-4 tm-block-col">
                <div class="tm-bg-primary-dark tm-block tm-block-product-categories">
                    <h2 class="tm-block-title">Product Categories</h2>
                    <div class="tm-product-table-container">
                        <table class="table tm-table-small tm-product-table">
                            <tbody>
                                <tr>
                                    <td class="tm-product-name">Product Category 1</td>
                                    <td class="text-center">
                                        <a href="#" class="tm-product-delete-link">
                                            <i class="far fa-trash-alt tm-product-delete-icon"></i>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="tm-product-name">Product Category 2</td>
                                    <td class="text-center">
                                        <a href="#" class="tm-product-delete-link">
                                            <i class="far fa-trash-alt tm-product-delete-icon"></i>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="tm-product-name">Product Category 3</td>
                                    <td class="text-center">
                                        <a href="#" class="tm-product-delete-link">
                                            <i class="far fa-trash-alt tm-product-delete-icon"></i>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="tm-product-name">Product Category 4</td>
                                    <td class="text-center">
                                        <a href="#" class="tm-product-delete-link">
                                            <i class="far fa-trash-alt tm-product-delete-icon"></i>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="tm-product-name">Product Category 5</td>
                                    <td class="text-center">
                                        <a href="#" class="tm-product-delete-link">
                                            <i class="far fa-trash-alt tm-product-delete-icon"></i>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="tm-product-name">Product Category 6</td>
                                    <td class="text-center">
                                        <a href="#" class="tm-product-delete-link">
                                            <i class="far fa-trash-alt tm-product-delete-icon"></i>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="tm-product-name">Product Category 7</td>
                                    <td class="text-center">
                                        <a href="#" class="tm-product-delete-link">
                                            <i class="far fa-trash-alt tm-product-delete-icon"></i>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="tm-product-name">Product Category 8</td>
                                    <td class="text-center">
                                        <a href="#" class="tm-product-delete-link">
                                            <i class="far fa-trash-alt tm-product-delete-icon"></i>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="tm-product-name">Product Category 9</td>
                                    <td class="text-center">
                                        <a href="#" class="tm-product-delete-link">
                                            <i class="far fa-trash-alt tm-product-delete-icon"></i>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="tm-product-name">Product Category 10</td>
                                    <td class="text-center">
                                        <a href="#" class="tm-product-delete-link">
                                            <i class="far fa-trash-alt tm-product-delete-icon"></i>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="tm-product-name">Product Category 11</td>
                                    <td class="text-center">
                                        <a href="#" class="tm-product-delete-link">
                                            <i class="far fa-trash-alt tm-product-delete-icon"></i>
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- table container -->
                    <button class="btn btn-primary btn-block text-uppercase mb-3">
                        Add new category
                    </button>
                </div>
            </div>
        </div>
    </div>
    <footer class="tm-footer row tm-mt-small">
        <div class="col-12 font-weight-light">
            <p class="text-center text-white mb-0 px-4 small">
                Copyright &copy; <b>2018</b> All rights reserved.

                Design: <a rel="nofollow noopener" href="https://templatemo.com" class="tm-footer-link">Template Mo</a>
            </p>
        </div>
    </footer>

    <script src="<?= $assets . 'vendor/templatemo_524_product_admin/' ?>js/jquery-3.3.1.min.js"></script>
    <!-- https://jquery.com/download/ -->
    <script src="<?= $assets . 'vendor/templatemo_524_product_admin/' ?>js/bootstrap.min.js"></script>
    <!-- https://getbootstrap.com/ -->
    <script>
        $(function() {
            $(".tm-product-name").on("click", function() {
                window.location.href = "edit-product.html";
            });
        });
    </script>
</body>

<?= $this->endSection(); ?>