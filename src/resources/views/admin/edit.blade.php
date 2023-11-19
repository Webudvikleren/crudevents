@extends('layout.app')
@section('meta_title', trans('crudevents::event.edit'))

@section('content')
<h1>{{ trans('crudevents::event.edit') }}</h1>
@include('crudevents::admin.form')
@endsection

@include('crudevents::components.datetime')
@include('crudevents::components.summernote')