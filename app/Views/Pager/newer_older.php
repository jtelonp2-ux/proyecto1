<?php $pager->setSurroundCount(0); ?>

<nav>
    <?php if ($pager->hasPrevious()) : ?>
        <a href="<?= $pager->getPrevious() ?>"><?= lang('App.newer') ?></a>
    <?php endif ?>

    <?php if ($pager->hasNext()) : ?>
        <a href="<?= $pager->getNext() ?>"><?= lang('App.older') ?></a>
    <?php endif ?>
</nav>