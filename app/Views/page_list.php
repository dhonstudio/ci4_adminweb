<?php foreach ($pageList as $key => $page) : ?>
    <tr>
        <th scope="row"><input type="checkbox" /></th>
        <td>
            <a href="<?= base_url('/element/' . $page['webKey'] . '/' . $page['pageKey']) ?>" style="color: white;">
                <?= $page['pageName'] ?>
            </a>
        </td>
        <td><?= date('F d, Y, H:i:s', strtotime($page['updated_at'])) ?></td>
    </tr>
<?php endforeach ?>