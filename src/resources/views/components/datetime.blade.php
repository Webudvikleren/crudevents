@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('css/jquery.datetimepicker.min.css') }}">
@append

@section('scripts')
<script src="{{ asset('js/jquery.datetimepicker.full.min.js') }}"></script>
<script>
	jQuery('#event_start').datetimepicker({
		format: 'Y-m-d H:i',
	});

	jQuery('#event_end').datetimepicker({
		format: 'Y-m-d H:i',
	});
</script>
@append