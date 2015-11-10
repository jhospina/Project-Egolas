<footer>

</footer>


{{-- Include all compiled plugins (below), or include individual files as needed --}}
{{ HTML::script('assets/plugins/bootstrap/js/bootstrap.js') }}
{{ HTML::script('assets/plugins/bootstrap-submenu/js/bootstrap-submenu.js') }}
{{ HTML::script('assets/plugins/switchery/switchery.js') }}
{{ HTML::script('assets/js/bootstrap-tooltip.js') }}


<script>
    /*
     $(document).ready(function () {
     
     $("#menu-list .submenu-item").hide();
     
     $("#menu-list .menu-item").click(function () {
     $(".submenu-item." + $(this).attr("id")).slideToggle();
     });
     });*/

</script>

<script>


    var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
    elems.forEach(function (html) {
        var switchery = new Switchery(html, {secondaryColor: '#FF5656', className: "switchery switchery-small"});

    });

</script>

<script>
    jQuery(".tooltip-left").tooltip({placement: "left"});
    jQuery(".tooltip-top").tooltip({placement: "top"});
    jQuery(".tooltip-right").tooltip({placement: "right"});
    jQuery(".tooltip-bottom").tooltip({placement: "bottom"});
</script>



{{--OTROS SCRIPTS--}}
@yield("script")


@if(isset($path))
{{App\System\Library\Complements\Util::getImportJScriptCurrent($path)}}
@endif

</body>

</html>