$(function() {
    $('td input[type=checkbox]').parent().css('text-align', 'center');
    $('td input[type=checkbox]').change(function(e) {
        d = {
            'article_id': $(this).attr('article'),
            'active': $(this).is(':checked')
        }
        simpleResponse('/admin/set-article-active', d);
        return false;
    });
});