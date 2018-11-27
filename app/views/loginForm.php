<div class="col-xs-12 col-sm-6">
<h3>Log In</h3>
<?php if (isset($errors)): ?>
    <div class="alert alert-danger"><?= $errors ?></div>
<?php endif ?>
<form id="form-logn" action="/login" method="post">
    <div class="form-group">
        <label for="fld_login">Login</label>
        <input type="text" class="form-control" id="fld_login" name="login" value="<?= $fields['login'] ?>">
    </div>
    <div class="form-group">
        <label for="fld_password">Password</label>
        <input type="password" class="form-control" id="fld_password" name="password">
    </div>
    <button type="submit" class="btn btn-primary">Login</button>
</form>
</div>