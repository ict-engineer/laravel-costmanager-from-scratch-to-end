@extends('layouts.setlayout')

@section('contentcss')
@endsection

@section('content')
<div class="wrap-set pt-3 pb-3 pl-2 pr-2" style="min-width: 100%;min-height: 100%;">
    <div class="description">
    </div>
</div>
@endsection

@section('contentjs')
<script>
    var term = {!! $term !!};
    $('.description').html(term.description);
</script>
@endsection

