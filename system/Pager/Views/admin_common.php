<?php $pager->setSurroundCount(2) ?>

<div class="ui right floated pagination menu">
	<?php if ($pager->hasPrevious()) : ?>
	<a class="icon item" href="<?= $pager->getFirst() ?>">首页</a>
	<a class="item" href="<?= $pager->getPrevious() ?>"><i class="left chevron icon"></i></a>
	<?php endif ?>

	<?php foreach ($pager->links() as $link) : ?>
	<a class="item <?= $link['active'] ? 'active' : '' ?>" href="<?= $link['uri'] ?>"><?= $link['title'] ?></a>
	<?php endforeach ?>

	<?php if ($pager->hasNext()) : ?>
	<a class="icon item" href="<?= $pager->getNext() ?>"><i class="right chevron icon"></i></a>
	<a class="icon item" href="<?= $pager->getLast() ?>">末页</a>
	<?php endif ?>
</div>