@if(session()->get("show_suggest"))
    <script src="{{ asset("js/feedback.js") }}"></script>
    <script type="text/javascript">ask("{{ route("appeal") }}");</script>
@endif
