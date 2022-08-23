<?php

if (!defined('ABSPATH'))
    exit;

/**
 * @var $header string
 * @var $submit_text string
 */
?>

<div class="pfs">
    <form action="#" class="pfs__form" id="pfs_form">
        <h2 class="pfs__header"><?= $header; ?></h2>

        <?php wp_nonce_field('_new_feedback', '_pfsnonce'); ?>

        <label class="pfs__label">
            Your name
            <input type="text" class="pfs__input" name="pfs_name" maxlength="50" placeholder="Name *" />
            <span class="pfs__error" data-field="pfs_name"></span>
        </label>

        <label class="pfs__label">
            Your email
            <input type="email" class="pfs__input" name="pfs_email" maxlength="50" placeholder="Email *" />
            <span class="pfs__error" data-field="pfs_email"></span>
        </label>

        <label class="pfs__label">
            Your phone
            <input type="text" class="pfs__input" name="pfs_phone" maxlength="25" placeholder="Phone *" />
            <span class="pfs__error" data-field="pfs_phone"></span>
        </label>

        <div class="pfs__summary" data-summary></div>

        <input type="submit" class="pfs__submit" value="<?= $submit_text; ?>">
    </form>
</div>