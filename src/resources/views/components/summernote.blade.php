@section('css')
<link href="{{ asset('css/bootstrap-icons.css') }}" rel="stylesheet">
<link href="{{ asset('summernote/summernote.min.css') }}" rel="stylesheet">
@append

@section('scripts')
<script src="{{ asset('summernote/summernote.min.js') }}"></script>
<script>
function summernoteSubmit()
{
	$('#text').val($('#text').summernote('code'));
}

$(document).ready(function() {
	$('#text').summernote({
		minHeight: 250,
	});
});
</script>
@append