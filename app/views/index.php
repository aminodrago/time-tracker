<?= View::make('sub-fact-add')->with([
    'activities' => $activities,
    'tags' => $tags
])->render(); ?>

<form method="get" class="row">
    <input type="hidden" name="sort" value="<?= $sort; ?>" />

    <?php if ($I->admin) { ?>

    <div class="col-sm-2 form-group">
        <select name="user" class="form-control filter">
            <option value=""><?= _('All Users'); ?></option>
            <?php foreach ($users as $user) { ?>
            <option value="<?= $user->id; ?>" <?= ($filter['user'] == $user->id) ? 'selected' : ''; ?>><?= $user->name; ?></option>
            <?php } ?>
        </select>
    </div>

    <?php } else {?>

    <div class="col-sm-2 form-group">
        <input type="text" class="form-control" value="<?= $I->name; ?>" readonly disabled />
    </div>

    <?php } ?>

    <div class="col-sm-3 form-group">
        <select name="activity" class="form-control filter">
            <option value=""><?= _('All Projects'); ?></option>
            <?php foreach ($activities as $activity) { ?>
            <option value="<?= $activity->id; ?>" <?= ($filter['activity'] == $activity->id) ? 'selected' : ''; ?>><?= $activity->name; ?></option>
            <?php } ?>
        </select>
    </div>

    <div class="col-sm-2 form-group">
        <select name="tag" class="form-control filter">
            <option value=""><?= _('All Tags'); ?></option>
            <?php foreach ($tags as $tag) { ?>
            <option value="<?= $tag->id; ?>" <?= ($filter['tag'] == $tag->id) ? 'selected' : ''; ?>><?= $tag->name; ?></option>
            <?php } ?>
        </select>
    </div>

    <div class="col-sm-2 form-group">
        <input type="search" name="description" value="<?= $filter['description']; ?>" class="form-control filter" placeholder="<?= _('Search in description'); ?>">
    </div>

    <div class="col-sm-3 form-group">
        <div class="input-daterange input-group">
            <input type="text" class="form-control filter" name="first" value="<?= $filter['first'] ? $filter['first']->format('d/m/Y') : ''; ?>" placeholder="<?= _('Start date'); ?>" />
            <span class="input-group-addon"><?= _('to'); ?></span>
            <input type="text" class="form-control filter" name="last" value="<?= $filter['last'] ? $filter['last']->format('d/m/Y') : ''; ?>" placeholder="<?= _('End date'); ?>" />
        </div>
    </div>
</form>

<table class="table table-hover facts-table">
    <thead>
        <tr>
            <th class="column-user"><?= _('User'); ?></th>
            <th class="column-activity"><?= _('Activity'); ?></th>
            <th class="column-tag"><?= _('Tags'); ?></th>
            <th class="text-center column-start">
                <a href="<?= \App\Libs\Utils::url('sort', ($sort === 'start-desc') ? 'start-asc' : 'start-desc'); ?>"><?= _('Start time'); ?></a>
            </th>
            <th class="text-center column-end">
                <a href="<?= \App\Libs\Utils::url('sort', ($sort === 'end-desc') ? 'end-asc' : 'end-desc'); ?>"><?= _('End time'); ?></a>
            </th>
            <th class="text-center column-time">
                <a href="<?= \App\Libs\Utils::url('sort', ($sort === 'total-desc') ? 'total-asc' : 'total-desc'); ?>"><?= _('Total time'); ?></a>
            </th>
        </tr>
    </thead>

    <tbody>
        <?php
        foreach ($facts as $fact) {
            echo View::make('sub-fact-tr')->with('fact', $fact)->render();
        }
        ?>
    </tbody>

    <tfoot>
        <tr>
            <td colspan="6"><strong class="pull-right"><?= sprintf(_('Total time: %s'), $total_time); ?></strong></td>
        </tr>
    </tfoot>
</table>

<?= View::make('sub-fact-edit')->with([
    'activities' => $activities,
    'tags' => $tags
])->render(); ?>

<div class="text-center">
    <?php
    if (($rows !== -1) && ($facts->getLastPage() > 1)) {
        echo $facts->appends(Input::all())->links();
    }
    ?>

    <?php
    echo '<p>';

    echo ($rows === 20) ? '<strong>' : '';
    echo '<a href="'.\App\Libs\Utils::url('rows', 20).'">'._('20').'</a>';
    echo ($rows === 20) ? '</strong>' : '';

    echo ' | '.(($rows === 50) ? '<strong>' : '');
    echo '<a href="'.\App\Libs\Utils::url('rows', 50).'">'._('50').'</a>';
    echo ($rows === 50) ? '</strong>' : '';

    echo ' | '.(($rows === 100) ? '<strong>' : '');
    echo '<a href="'.\App\Libs\Utils::url('rows', 100).'">'._('100').'</a>';
    echo ($rows === 100) ? '</strong>' : '';

    echo ' | '.(($rows === -1) ? '<strong>' : '');
    echo '<a href="'.\App\Libs\Utils::url('rows', -1).'">'._('All').'</a>';
    echo ($rows === -1) ? '</strong>' : '';

    echo ' | <a href="'.\App\Libs\Utils::url('export', 'csv').'">'._('Export as CSV').'</a>';

    if ($I->admin) {
        echo ' | <a href="'.url('/dump-sql').'">'._('Dump SQL').'</a>';
    }

    echo '</p>';
    ?>
</div>
