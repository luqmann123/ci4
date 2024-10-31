<nav>
    <ul class="pagination">
        <?php foreach ($pager->links() as $link): ?>
            <li class="page-item <?php echo $link['active'] ? 'active' : ''; ?>">
                <a class="page-link" href="<?php echo $link['uri']; ?>"><?php echo $link['title']; ?></a>
            </li>
        <?php endforeach; ?>
    </ul>
</nav>
