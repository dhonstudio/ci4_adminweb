<?= $this->extend($git_assets . 'ci4_views/template'); ?>

<?= $this->section('content'); ?>

<body id="reportsPage">
    <?= $this->include('layouts/topbar'); ?>

    <div class="container mt-5">
        <div class="row tm-content-row">
            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 tm-block-col">
                <div class="tm-bg-primary-dark tm-block tm-block-products">

                    <?= $this->include('modals/add_element'); ?>

                    <div class="tm-product-table-container">
                        <table class="table table-hover tm-table-small tm-product-table">
                            <thead>
                                <tr>
                                    <th scope="col">&nbsp;</th>
                                    <th scope="col">ELEMENT NAME</th>
                                    <th scope="col">VALUE</th>
                                    <th scope="col">DATE MODIFIED</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody id="elementList">
                                <?= $this->include('element_list'); ?>
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