@extends('main')

@section('content')
        <a href="{{ route('news_list') }}">Новости</a>
        <h1>{{ $news->title }}</h1>
        <p>{{ $news->published_at }}</p>
        <p>{{ $news->text }}</p>
@endsection
