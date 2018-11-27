<?php $action = isset($action) ? $action : '' ?>
<h3><?= ($action == 'edit') ? 'Edit Task' : 'Add new task' ?></h3>
<?php if (isset($errors)): ?>
<div class="alert alert-danger"><?= $errors ?></div>
<?php endif ?>
<form id="form-task-add" action="<?= ($action == 'edit') ? '/tasks/' . $fields['id'] : '/tasks/new' ?>" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="fld_username">Username</label>
        <input type="text" class="form-control" id="fld_username" name="username" value="<?= $fields['username'] ?>" <?= ($action == 'edit') ? 'disabled' : '' ?>>
    </div>
    <div class="form-group">
        <label for="fld_email">Email</label>
        <input type="text" class="form-control" id="fld_email" name="email" value="<?= $fields['email'] ?>" <?= ($action == 'edit') ? 'disabled' : '' ?>>
    </div>
    <div class="form-group">
        <label for="fld_text">Text</label>
        <textarea rows="8" class="form-control" id="fld_text" name="text"><?= $fields['text'] ?></textarea>
    </div>
    <div class="form-group">
        <label for="fld_image">Image</label><br>
        <?php if ($action == 'edit'): ?>
            <?php if ($fields['image']): ?>
                <img src="<?= $fields['image'] ?>" style="max-width: 320px; max-height: 240px;">
            <?php else: ?>
                [no image]
            <?php endif ?>
        <?php else: ?>
            <input type="file" class="form-control" id="fld_image" name="image">
        <?php endif ?>
    </div>
    <div class="form-group">
        <label for="fld_done"><input type="checkbox" id="fld_done" name="done" <?= ($fields['done']) ? 'checked' : '' ?> value="1"> Done</label>
    </div>

    <button type="submit" class="btn btn-primary">Save</button>
    <div class="btn btn-default pull-right js-preview">Preview</div>
</form>

<div id="myModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Task Preview</h4>
            </div>
            <div class="modal-body">
                <table class="table">
                    <tr>
                        <td>Username:</td>
                        <td class="js-preview-username"></td>
                    </tr>
                    <tr>
                        <td>Email:</td>
                        <td class="js-preview-email"></td>
                    </tr>
                    <tr>
                        <td>Text:</td>
                        <td class="js-preview-text"></td>
                    </tr>
                    <tr>
                        <td>Image:</td>
                        <td class="js-preview-image">
                            <?php if ($action == 'edit'): ?>
                                <?php if ($fields['image']): ?>
                                    <img src="<?= $fields['image'] ?>" style="max-width: 320px; max-height: 240px;">
                                <?php else: ?>
                                    [no image]
                                <?php endif ?>
                            <?php else: ?>
                                [no image]
                            <?php endif ?>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>