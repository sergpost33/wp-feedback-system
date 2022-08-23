<?php

if (!defined('ABSPATH'))
    exit;

/**
 * @var $header string
 * @var $submit_text string
 *
 * @var $value_name string
 * @var $value_email string
 * @var $value_phone string
 */
?>

<div class="pfs">
    <form action="#" class="pfs__form">
        <h2 class="pfs__header"><?= $header; ?></h2>

        <label class="pfs__label">
            Your name
            <input type="text" class="pfs__input" name="pfs_name" maxlength="50" placeholder="Name *" value="<?= $value_name; ?>" required />
        </label>

        <label class="pfs__label">
            Your email
            <input type="email" class="pfs__input" name="pfs_email" maxlength="50" placeholder="Email *" value="<?= $value_email; ?>" required />
        </label>

        <label class="pfs__label">
            Your phone
            <input type="text" class="pfs__input" name="pfs_phone" maxlength="25" placeholder="Phone *" value="<?= $value_phone; ?>" required />
        </label>

        <input type="submit" class="pfs__submit" value="<?= $submit_text; ?>">
    </form>
</div>