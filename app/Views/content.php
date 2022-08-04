<?= $this->extend($git_assets . 'ci4_views/template'); ?>

<?= $this->section('content'); ?>

<body id="reportsPage">
    <?= $this->include('layouts/topbar'); ?>

    <div class="container mt-5">
        <div class="row tm-content-row">
            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 tm-block-col">
                <div class="tm-bg-primary-dark tm-block tm-block-products">
                    <!-- <a href="#" class="btn btn-primary btn-block text-uppercase mb-3" id="addWebsiteButton" data-toggle="modal" data-target="#addWebsiteModal">Add Website</a> -->

                    <?= $this->include('modals/add_website'); ?>

                    <div class="tm-product-table-container">
                        <table class="table table-hover tm-table-small tm-product-table">
                            <thead>
                                <tr>
                                    <th scope="col">&nbsp;</th>
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
        </div>
    </div>

    <?= $this->include('layouts/footer'); ?>

    <script>
        $(function() {
            $(".tm-product-name").on("click", function() {
                window.location.href = "edit-product.html";
            });
        });
    </script>
</body>

<?= $this->endSection(); ?>