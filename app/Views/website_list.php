<?php foreach ($websiteList as $key => $web) : ?>
    <tr>
        <td><?= $web['webName'] ?></td>
        <td><?= date('F d, Y, H:i:s', strtotime($web['created_at'])) ?></td>
    </tr>
<?php endforeach ?>