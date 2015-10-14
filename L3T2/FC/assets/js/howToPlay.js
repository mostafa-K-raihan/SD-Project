<script>
$(document).on('click', '#refresh', function () {
    var $link = $('li.active a[data-toggle="tab"]');
    $link.parent().removeClass('active');
    var tabLink = $link.attr('href');
    $('#mainTabs a[href="' + tabLink + '"]').tab('show');
});
</script>
	   
