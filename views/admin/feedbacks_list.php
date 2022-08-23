<?php
/**
 * @var $feedbackListTable Feedback_List_Table
 */
?>

<div class="wrap">
    <h2><?= get_admin_page_title() ?></h2>

    <?php $feedbackListTable->display(); ?>
</div>