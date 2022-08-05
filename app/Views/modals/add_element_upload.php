<div class="modal fade" id="addContentUploadModal" tabindex="-1" aria-labelledby="addContentUploadModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content tm-bg-primary-dark">
            <div class="modal-header">
                <h5 class="tm-block-title" id="addContentUploadModalLabel"></h5>
                <button type="button" class="close tm-block-title" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?= form_open_multipart('upload_content') ?>
            <div class="modal-body">
                <div class="row tm-edit-product-row">
                    <div class="col-xl-12 col-lg-12 col-md-12">
                        <!-- key -->
                        <input hidden name="key" id="keyInputUpload">
                        <input hidden name="accept" id="acceptUploadInput">

                        <!-- contentValue -->
                        <div class="form-group mb-3 ui-widget">
                            <label for="contentValueInput" id="contentUploadName"></label>
                            <br>
                            <img src="" width="102" id="imgUpload">
                            <input type="file" accept="image/jpeg" id="pictureFileInput" name="pictureFile" size="20" class="form-control validate" required />
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