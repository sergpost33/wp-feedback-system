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
            <?= __("Your name", "pfs"); ?>
            <input type="text" class="pfs__input" name="pfs_name" maxlength="50"
                   placeholder="<?= __("Name *", "pfs"); ?>"/>
            <span class="pfs__error" data-field="pfs_name"></span>
        </label>

        <label class="pfs__label">
            <?= __("Your email", "pfs"); ?>
            <input type="email" class="pfs__input" name="pfs_email" maxlength="50"
                   placeholder="<?= __("Email *", "pfs"); ?>"/>
            <span class="pfs__error" data-field="pfs_email"></span>
        </label>

        <label class="pfs__label">
            <?= __("Your phone", "pfs"); ?>
            <input type="tel" class="pfs__input" name="pfs_phone" maxlength="25"
                   placeholder="<?= __("Phone *", "pfs"); ?>"/>
            <span class="pfs__error" data-field="pfs_phone"></span>
        </label>

        <div class="pfs__summary" data-summary></div>

        <input type="submit" class="pfs__submit" value="<?= $submit_text; ?>">
    </form>
</div>