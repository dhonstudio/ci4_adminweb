<?php foreach ($elementList as $key => $web) : ?>
    <tr>
        <th scope="row"><input type="checkbox" /></th>
        <td><?= $web['contentName'] ?></td>
        <td><?= $web['contentValue'] ?></td>
        <td><?= date('F d, Y, H:i:s', strtotime($web['updated_at'])) ?></td>
        <td>
            <a href="#" data-key="<?= array_search($web['id_content'], array_column($elementList, 'id_content')) + 1 ?>" data-toggle="modal" data-target="#addContentModal" class="tm-product-delete-link editContentButton" style="color: white;">
                <i class="far fa-edit tm-product-delete-icon"></i>
            </a>
        </td>
    </tr>
<?php endforeach ?>

<script>
    $(".editContentButton")
        .click(function() {
            var key = $(this).data('key') - 1;

            var data = <?= json_encode($elementList) ?>;

            contentName = data[key].contentName;
            contentValue = data[key].contentValue;

            $('#addContentModalLabel').html("Edit Element");
            $('#keyInput').val(key + 1);
            if (data[key].contentValue.length > 58) {
                $('#contentInputSection').html(`
                    <label for="contentValueInput" id="contentName">` + data[key].contentName + `</label>
                    <textarea rows="5" id="contentValueInput" name="contentValue" type="text" class="form-control validate" required >` + data[key].contentValue + `</textarea>
                `);
            } else {
                $('#contentInputSection').html(`
                    <label for="contentValueInput" id="contentName">` + data[key].contentName + `</label>
                    <input id="contentValueInput" name="contentValue" type="text" class="form-control validate" required value="` + data[key].contentValue + `" />
                `);
            }
        });
</script>