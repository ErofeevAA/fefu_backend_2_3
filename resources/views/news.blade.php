@extends('main')

@section('content')
        <h1>Новости</h1>
        @foreach($news as $n)
            <a href="{{ route('news_item', ['slug' => $n->slug]) }}">{{ $n->title }}</a>
            <p>{{ $n->published_at }}</p>
            @if ($n->description !== null)
                <p>{{ $n->description }}</p>
            @endif
        @endforeach
        {{ $news->links() }}
@endsection
