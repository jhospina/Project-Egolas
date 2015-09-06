<footer>

</footer>

{{-- Include all compiled plugins (below), or include individual files as needed --}}
{{ HTML::script('assets/plugins/bootstrap/js/bootstrap.js') }}
{{ HTML::script('assets/plugins/bootstrap-submenu/js/bootstrap-submenu.js') }}
{{ HTML::script('assets/js/bootstrap-tooltip.js') }}


{{--OTROS SCRIPTS--}}
@yield("script")
</body>

</html>