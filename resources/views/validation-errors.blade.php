<?php if ($errors): $errors = \Vnn\Keyper\Keyper::create($errors->toArray()) ?>
<?php if ($errors->get($name)): ?>
<div class="alert alert-danger">
    <?= implode(', ', $errors->get($name)) ?>
</div>
<?php endif; ?>
<?php endif; ?>