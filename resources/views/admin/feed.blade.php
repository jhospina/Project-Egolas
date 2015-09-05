@extends("ui/templates/gen")


@section("content")

FEED
<div id="feed">

</div>

<script>

    var i = 1;
            jQuery(document).ready(function(){
    initFeed();
    });</script>

<script>
            function initFeed() {
            jQuery.ajax({
            type: "GET",
                    url: "{{URL::to('/searcher/auto/track/production/2')}}",
                    data: {},
                    success: function (data) {
                        i++;
                    jQuery("#feed").append("<div>Proceso # " + i + "</div>");
                            setTimeout(function () {
                            initFeed();
                            }, 10000);
                    }}, "html");
            }
</script>

@stop