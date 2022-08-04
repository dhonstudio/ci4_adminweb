<?= $this->extend($git_assets . 'ci4_views/template'); ?>

<?= $this->section('content'); ?>

<body id="reportsPage">
    <?= $this->include('layouts/topbar'); ?>

    <div class="container mt-4">
        <div class="row">
            <div class="col">
                <p class="text-white"><a href="<?= base_url('content') ?>">Websites</a> / <?= $webName ?> Pages</p>
            </div>
        </div>
        <div class="row tm-content-row">
            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 tm-block-col">
                <div class="tm-bg-primary-dark tm-block tm-block-products">

                    <div class="tm-product-table-container">
                        <table class="table table-hover tm-table-small tm-product-table">
                            <thead>
                                <tr>
                                    <th scope="col">&nbsp;</th>
                                    <th scope="col">PAGE NAME</th>
                                    <th scope="col">DATE MODIFIED</th>
                                </tr>
                            </thead>
                            <tbody id="pageList">
                                <?= $this->include('page_list'); ?>
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