<div class="modal fade" id="addWebsiteModal" tabindex="-1" aria-labelledby="addWebsiteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content tm-bg-primary-dark">
            <div class="modal-header">
                <h5 class="tm-block-title" id="addWebsiteModalLabel">Add Website</h5>
                <button type="button" class="close tm-block-title" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" class="tm-edit-product-form" id="addWebsiteForm">
                <div class="modal-body">
                    <div class="row tm-edit-product-row">
                        <div class="col-xl-12 col-lg-12 col-md-12">
                            <!-- key -->
                            <input hidden name="key" id="keyInput">

                            <!-- websiteName -->
                            <div class="form-group mb-3 ui-widget">
                                <label for="websiteName">Website Name</label>
                                <input id="websiteNameInput" name="websiteName" type="text" class="form-control validate" required />
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
    $("#addWebsiteForm")
        .submit(function(event) {
            event.preventDefault();

            var $form = $(this);
            var serializedData = $form.serialize();

            if ($('#keyInput').val() > 0)
                var url = '<?= base_url('edit_transaction') ?>';
            else
                var url = '<?= base_url('add_website') ?>';

            $.ajax({
                url: url,
                type: 'post',
                data: serializedData,
                success: function() {
                    $('#addWebsiteModal').modal('hide');
                    $("#websiteList").load('<?= base_url() ?>' + "/website_list");
                }
            });
        });
</script>