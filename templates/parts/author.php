<?php global $postData ?>
<?php if(!empty($postData['author_photo'])): ?>
    <div class="author-with-thumb">
        <div class="photo mr-2" style="background-image:url('<?= $postData['author_photo'] ?>')"></div>
        <span><?= sprintf('%s: %s', 'Автор', $postData['author']) ?></span>
    </div>
<?php else: ?>
    <div class="pre-icon md author"><?= sprintf('%s: %s', 'Автор', $postData['author']) ?></div>
<?php endif; ?>