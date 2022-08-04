<?php foreach ($websiteList as $key => $web) : ?>
    <tr>
        <th scope="row"><input type="checkbox" /></th>
        <td>
            <a href="<?= base_url('/page/' . $web['webKey']) ?>" style="color: white;">
                <?= $web['webName'] ?>
            </a>
        </td>
        <td><?= date('F d, Y, H:i:s', strtotime($web['created_at'])) ?></td>
    </tr>
<?php endforeach ?>