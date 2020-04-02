@extends('admin.layout')

@section('main')
{{ json_encode($questionaires) }}
@endsection

@push('scripts')
<script type="text/javascript">
    
</script>

@endpush