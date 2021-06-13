@extends('layouts.app')
@section('title')
    {{ $title }}
@endsection
@section('content')
    <style>
        form.example input[type=text] {
            padding: 10px;
            font-size: 17px;
            border: 1px solid grey;
            float: left;
            width: 80%;
            background: #f1f1f1;
            border-radius: 2px;
            border-right: none;
        }

        form.example button {
            float: left;
            width: 20%;
            padding: 10px;
            background: #2196F3;
            color: white;
            font-size: 17px;
            border: 1px solid grey;
            border-left: none;
            cursor: pointer;
            border-left: none;
            border-radius: 2px;
        }

        form.example button:hover {
            background: #0b7dda;
        }

        form.example::after {
            content: "";
            clear: both;
            display: table;
        }

    </style>
    <form class="example" action="/searching" method="GET" id="search">
        @csrf
        <input type="text" placeholder="Search By Category..." required name="search">
        <button type="submit"><i class="fa fa-search"></i></button>
    </form>


    @if (!$posts->count())
        There is no post till now. Login and write a new post now!!!
    @else

        <div class="">

            @foreach ($posts as $post)
                <div class="list-group">
                    <div class="col-md-4 mt-4">
                        <div class="card">
                            <div class="card-header">
                                <h3>{{ $post->title }} - {{ $post->category ? $post->category->name : 'Uncategorized' }}
                                </h3>
                                <p>{{ $post->created_at->format('M d,Y \a\t h:i a') }} By <a
                                        href="javascript:void(0);">{{ $post->author->name }}</a></p>
                            </div>
                            <div class="card-body">
                                {!! Str::limit($post->body, $limit = 500, $end = '.') !!}
                                <a href="{{ url('/' . $post->slug) }}" class="btn btn-primary btn-block">Read
                                    More</a>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="list-group-item">
                        <h3><a href="{{ url('/' . $post->slug) }}">{{ $post->title }}</a>
                            @if (!Auth::guest() && ($post->author_id == Auth::user()->id || Auth::user()->is_admin()))
                                @if ($post->active == '1')
                                    <button class="btn" style="float: right"><a
                                            href="{{ url('edit/' . $post->slug) }}">Edit
                                            Post</a></button>
                                @else
                                    <button class="btn" style="float: right"><a
                                            href="{{ url('edit/' . $post->slug) }}">Edit
                                            Draft</a></button>
                                @endif
                            @endif
                        </h3>
                        <p>{{ $post->created_at->format('M d,Y \a\t h:i a') }} By <a
                                href="javascript:void(0);">{{ $post->author->name }}</a></p>

                        
                    </div>

                    <div class="list-group-item">
                        <article>
                            {!! Str::limit($post->body, $limit = 1500, $end = '....... <a href=' . url('/' . $post->slug) . '>Read More</a>') !!}
                        </article>
                    </div> --}}
                </div>
            @endforeach
            {!! $posts->render() !!}
        </div>
    @endif
@endsection
