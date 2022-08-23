jQuery(document).ready(function ($) {
    $('body').on('submit', '#pfs_form', function (event) {
        event.preventDefault();
        const form = $(this);

        form.find('[data-field]').empty();
        hide_summary(form);

        $.post(
            PFS.ajax_url,
            {
                action: "pfs_add_feedback",
                data: form.serialize()
            },
            function (response) {
                if (response.success) {
                    form.trigger('reset');

                    form.find('[data-summary]').addClass('success').text(response.data.message).show();

                    setTimeout(hide_summary, 2500, form);
                } else {
                    for (let field in response.data.errors) {
                        form.find('[data-field="' + field + '"]').text(response.data.errors[field]);
                    }

                    form.find('[data-summary]').addClass('error').text(response.data.message).show();
                }
            }
        );
    });
});

function hide_summary(form) {
    form.find('[data-summary]').removeClass('error success').empty().hide();
}