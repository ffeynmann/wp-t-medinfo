<?php global $comment; ?>
<div class="comment-publish-wrapper d-none" :class="{'d-block': updated}" data-id="<?= $comment->comment_ID ?>">
    <div class="inner">
        <div>
            Статус:
            <span v-if="!status">Неопубликовано</span>
            <span v-if="status">Опубликовано: <span v-html="status"></span></span>
        </div>

        <div class="button" v-html="buttonText" @click="publish" :disabled="busy"></div>
    </div>

</div>