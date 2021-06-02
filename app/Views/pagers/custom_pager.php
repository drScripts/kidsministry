<!-- <div class="d-flex flex-row-reverse bd-highlight">
    <nav aria-label="Page navigation example">
        <ul class="pagination pagination-sm">
            <li class="page-item"><a class="page-link" href="#">&laquo;</a></li>
            <li class="page-item active"><a class="page-link" href="#">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item"><a class="page-link" href="#">&raquo;</a></li>
        </ul>
    </nav>
</div> -->


<?php $pager->setSurroundCount(0) ?>
<div class="d-flex justify-content-center bd-highlight">
    <nav aria-label="Page navigation example">
        <ul class="pagination pagination-sm">
            <?php if ($pager->hasPrevious()) : ?>
            <li class="page-item">
                <a href="<?= $pager->getFirst() ?>" class="page-link" aria-label="<?= lang('Pager.first') ?>">
                    <span aria-hidden="true">
                        <?= lang('Pager.first') ?>
                    </span>
                </a>
            </li>
            <li class="page-item">
                <a href="<?= $pager->getPrevious() ?>" class="page-link" aria-label="<?= lang('Pager.previous') ?>">
                    <span aria-hidden="true">
                        &laquo;
                    </span>
                </a>
            </li>
            <?php endif ?>

            <?php foreach ($pager->links() as $link) : ?>
            <li class="page-item <?= $link['active'] ? 'active' : '' ?>">
                <a href="<?= $link['uri'] ?>" class="page-link">
                    <?= $link['title'] ?>
                </a>
            </li>
            <?php endforeach ?>

            <?php if ($pager->hasNext()) : ?>
            <li class="page-item">
                <a href="<?= $pager->getNext() ?>" class="page-link" aria-label="<?= lang('Pager.next') ?>">
                    <span aria-hidden="true">
                        &raquo;
                    </span>
                </a>
            </li>
            <li class="page-item">
                <a href="<?= $pager->getLast() ?>" class="page-link" aria-label="<?= lang('Pager.last') ?>">
                    <span aria-hidden="true">
                        <?= lang('Pager.last') ?>
                    </span>
                </a>
            </li>
            <?php endif ?>
        </ul>
    </nav>
</div>