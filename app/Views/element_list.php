<?php foreach ($elementList as $key => $web) : ?>
    <tr>
        <td>
            <a href="<?= base_url('/element/' . $web['webKey']) ?>" style="color: white;">
                <?= $web['contentName'] ?>
            </a>
        </td>
        <td><?= date('F d, Y, H:i:s', strtotime($web['created_at'])) ?></td>
    </tr>
<?php endforeach ?>