<div class="navbar">
    <a class="btn btn-primary" href="/tasks/new">Add New Task</a>
</div>
<table class="table table-bordered tasks-table">
    <thead>
    <tr>
        <th>ID</th>
        <th><a href="<?= $links['username']['url'] ?>">Username<?= ($links['username']['icon']) ? '&nbsp;&nbsp;&nbsp;<i class="glyphicon ' . $links['username']['icon'] . '"></i>' : '' ?></a></th>
        <th><a href="<?= $links['email']['url'] ?>">Email<?= ($links['email']['icon']) ? '&nbsp;&nbsp;&nbsp;<i class="glyphicon ' . $links['email']['icon'] . '"></i>' : '' ?></a></th>
        <th>Text</th>
        <th>Image</th>
        <th><a href="<?= $links['done']['url'] ?>">Done<?= ($links['done']['icon']) ? '&nbsp;&nbsp;&nbsp;<i class="glyphicon ' . $links['done']['icon'] . '"></i>' : '' ?></a></th>
        <?php if ($userId): ?>
            <th>Edit</th>
        <?php endif ?>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($tasks as $task): ?>
        <tr>
            <td><?= $task->id ?></td>
            <td><?= $task->username ?></td>
            <td><?= $task->email ?></td>
            <td><?= $task->text ?></td>
            <td><?= ($task->image) ? '<img src="'.$task->image.'" class="task-image">' : '' ?></td>
            <td>
            <?php if ($task->done == 1): ?>
                <span class="label label-success"><i class="glyphicon glyphicon-ok"></i>&nbsp;&nbsp;&nbsp;Done</span>
            <?php else: ?>
                <span class="label label-warning"><i class="glyphicon glyphicon-time"></i>&nbsp;&nbsp;&nbsp;In progress</span>
            <?php endif; ?>
            </td>
            <?php if ($userId): ?>
                <td><a class="btn btn-primary" href="/tasks/<?= $task->id ?>">Edit</a></td>
            <?php endif ?>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<div class="navbar">
    <?php if ($links['prev']['active']): ?>
        <a class="btn btn-primary" href="<?= $links['prev']['url'] ?>" title="Prev">&laquo;</a>
    <?php else: ?>
        <div class="btn btn-default" disabled="disabled">&laquo;</div>
    <?php endif ?>
    &nbsp;&nbsp;&nbsp;
    <?= $page ?> / <?= $pagesCount ?>
    &nbsp;&nbsp;&nbsp;
    <?php if ($links['next']['active']): ?>
        <a class="btn btn-primary" href="<?= $links['next']['url'] ?>" title="Next">&raquo;</a>
    <?php else: ?>
        <div class="btn btn-default" disabled="disabled">&raquo;</div>
    <?php endif ?>
</div>
