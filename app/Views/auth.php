<?= $this->extend($git_assets . 'ci4_views/template'); ?>

<?= $this->section('content'); ?>

<body>
    <div class="container tm-mt-big tm-mb-big">
        <div class="row">
            <div class="col-12 mx-auto tm-login-col">
                <div class="tm-bg-primary-dark tm-block tm-block-h-auto">
                    <div class="row">
                        <div class="col-12 text-center">
                            <h2 class="tm-block-title mb-4">Welcome to Dashboard, Login</h2>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-12">

                            <form method="post" class="tm-login-form" action="<?= base_url('auth') ?>" id="loginForm">
                                <div class="form-group">
                                    <label for="username">Username</label>
                                    <input name="username" type="text" class="form-control validate" id="username" value="" />
                                </div>
                                <div class="form-group mt-3">
                                    <label for="password">Password</label>
                                    <input name="password" type="password" class="form-control validate" id="password" value="" />
                                </div>
                                <div class="form-group mt-4">
                                    <button type="submit" class="btn btn-primary btn-block text-uppercase">
                                        Login
                                    </button>
                                </div>
                            </form>

                            <a href="<?= base_url('register') ?>">
                                <button class="mt-5 btn btn-primary btn-block text-uppercase">
                                    Register
                                </button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Warning Modal -->
    <div class="modal fade" id="warningModal" tabindex="-1" role="dialog" aria-labelledby="warningModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body text-center">
                    ...
                </div>
            </div>
        </div>
    </div>

    <?= $this->include('layouts/footer'); ?>

    <script>
        $("#loginForm")
            .submit(function(event) {
                event.preventDefault();

                if ($("#username").val() == '') {
                    $('.modal-body').html('Username needed');
                    $('#warningModal').modal('show');
                } else if ($("#password").val() == '') {
                    $('.modal-body').html('Password needed');
                    $('#warningModal').modal('show');
                } else {
                    var $form = $(this);
                    var serializedData = $form.serialize();

                    var url = '<?= base_url('auth') ?>';

                    $.ajax({
                        url: url,
                        type: 'post',
                        data: serializedData,
                        success: function(preresult) {
                            result = JSON.parse(preresult);
                            if (result.code == 0) {
                                $('.modal-body').html(result.message);
                                $('#warningModal').modal('show');
                            } else {
                                $('.modal-body').html(result.message);
                                $('#warningModal').modal('show');

                                _changeInterval = setInterval(function() {
                                    $('#warningModal').modal('hide');
                                    window.location.href = "<?= base_url() ?>";
                                    clearInterval(_changeInterval)
                                }, 2000);
                            }
                        }
                    });
                }
            });
    </script>
</body>

<?= $this->endSection(); ?>