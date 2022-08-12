<?php foreach ($elementList as $key => $web) : ?>
    <tr>
        <th scope="row"><input type="checkbox" /></th>
        <td><?= $web['contentName'] ?></td>
        <td><?= $web['contentValue'] ?></td>
        <td><?= date('F d, Y, H:i:s', strtotime($web['updated_at'])) ?></td>
        <td>
            <a href="#" data-key="<?= array_search($web['id_content'], array_column($allElementList, 'id_content')) + 1 ?>" data-toggle="modal" data-target="<?= $web['contentType'] == 'img' ? "#addContentUploadModal" : "#addContentModal" ?>" class="tm-product-delete-link editContentButton" style="color: white;">
                <i class="far fa-edit tm-product-delete-icon"></i>
            </a>
        </td>
    </tr>
<?php endforeach ?>

<script>
    $(".editContentButton")
        .click(function() {
            var key = $(this).data('key') - 1;

            var data = <?= json_encode($allElementList) ?>;

            pageKey = data[key].pageKey;
            contentName = data[key].contentName;
            contentValue = data[key].contentValue;
            contentType = data[key].contentType;

            $('#addContentModalLabel').html("Edit Element");
            $('#addContentUploadModalLabel').html("Edit Element");
            $('#keyInput').val(key + 1);
            $('#keyInputUpload').val(key + 1);

            $('#contentUploadName').html(contentName);

            if (contentType == "img") {
                $('#imgUpload').attr("src", "<?= base_url('public/uploads') ?>" + '/' + pageKey + '/' + contentValue);

                contentAccept = JSON.parse(data[key].contentAccept);
                finalContentAccept = new Array();
                contentAccept.forEach(element => {
                    finalContentAccept.push("image/" + element)
                });
                resultContentAccept = finalContentAccept.join(",")
                $('#acceptUploadInput').val(resultContentAccept);
                $('#pictureFileInput').attr("accept", resultContentAccept);
            }

            if (contentValue.length > 58) {
                $('#contentInputSection').html(`
                    <label for="contentValueInput" id="contentName">` + contentName + `</label>
                    <textarea rows="5" id="contentValueInput" name="contentValue" type="text" class="form-control validate" required >` + contentValue + `</textarea>
                `);
            } else {
                $('#contentInputSection').html(`
                    <label for="contentValueInput" id="contentName">` + contentName + `</label>
                    <input id="contentValueInput" name="contentValue" type="text" class="form-control validate" required value="` + contentValue + `" />
                `);
            }
        });
</script>