
<form method="post" autocomplete="off">

<ul class="pager">
    <li class="previous pull-left">
        {{ link_to("robots", "&larr; Go Back") }}
    </li>
    <li class="pull-right">
        {{ submit_button("Save", "class": "btn btn-success") }}
    </li>
</ul>

{{ content() }}

<div class="center scaffold">
    <h2>Create a Robot</h2>

    <div class="clearfix">
        <label for="name">Name</label>
        {{ form.render("name") }}
    </div>

    <div class="clearfix">
        <label for="type">Type</label>
        {{ form.render("type") }}
    </div>

    <div class="clearfix">
        <label for="year">Year</label>
        {{ form.render("year") }}
    </div>

    <div class="clearfix">
        <label for="partList">Parts</label>
        {{ form.render("partList") }}
    </div>

</div>

</form>

<script>
$(document).ready(function() {
    $("input#partList").tagsinput({
        typeahead: {
            source: function(query) {
                return $.getJSON('/parts/all.json');
            }
        }
    });

    $('input#tags').tagsinput({});
});
</script>