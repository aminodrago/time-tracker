<form class="text-center well submit-wait" data-message="<?= _('Please wait...'); ?>" method="post">
    <button type="submit" name="action" value="gitUpdate" class="btn btn-success">
        <i class="glyphicon glyphicon-refresh"></i>
        <?= _('Update source'); ?>
    </button>
</form>

<?php if ($action) { ?>
<pre><code><?= $response; ?></code></pre>
<?php } ?>

<div class="text-center">
    <a href="<?= url('/'); ?>" class="btn btn-info"><?= _('Back'); ?></a>
</div>