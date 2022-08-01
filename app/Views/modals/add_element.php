<div class="modal fade" id="addContentModal" tabindex="-1" aria-labelledby="addContentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content tm-bg-primary-dark">
            <div class="modal-header">
                <h5 class="tm-block-title" id="addContentModalLabel"></h5>
                <button type="button" class="close tm-block-title" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" class="tm-edit-product-form" id="addContentForm">
                <div class="modal-body">
                    <div class="row tm-edit-product-row">
                        <div class="col-xl-12 col-lg-12 col-md-12">
                            <!-- key -->
                            <input hidden name="key" id="keyInput">

                            <!-- contentValue -->
                            <div class="form-group mb-3 ui-widget" id="contentInputSection">
                                <label for="contentValueInput" id="contentName"></label>
                                <input id="contentValueInput" name="contentValue" type="text" class="form-control validate" required />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $("#addContentForm")
        .submit(function(event) {
            event.preventDefault();

            var $form = $(this);
            var serializedData = $form.serialize();

            if ($('#keyInput').val() > 0)
                var url = '<?= base_url('edit_content') ?>';
            else
                var url = '<?= base_url('add_content') ?>';

            $.ajax({
                url: url,
                type: 'post',
                data: serializedData,
                success: function() {
                    $('#addContentModal').modal('hide');
                    $("#elementList").load('<?= base_url() ?>' + "/element_list/" + '<?= $webKey ?>');
                }
            });
        });
</script>