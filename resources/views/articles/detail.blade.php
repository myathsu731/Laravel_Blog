@extends("layouts.app")
@section("content")
    <div class="container">
        <div class="card mb-2">
            <div class="card-body">
                <h5 class="card-title">{{ $article->title }}</h5>
                <div class="card-subtitle mb-2 text-muted small">
                    {{ $article->created_at->diffForHumans() }},
                    Category: <b>{{ $article->category->name }}</b>
                </div>
                <p class="card-text">{{ $article->body }}</p>
                <p class="card-text">
                    By <b>{{ $article->user->name }}</b>,
                    {{ $article->created_at->diffForHumans() }}
                </p>
                @if($loggedin_userid == $article->user_id)
                <a class="btn btn-warning"
                    onclick="return confirm('Are you sure?')"
                    href="{{ url("/articles/delete/$article->id") }}">
                    Delete
                </a>
                @endif
            </div>
        </div>
        <ul class="list-group">
            <li class="list-group-item active">
                <b>Comments ({{ count($article->comments) }})</b>
            </li>
            @foreach($article->comments as $comment)
            <li class="list-group-item">
                {{ $comment->content }}
                <div class="small mt-2">
                    By <b>{{ $comment->user->name }}</b>,
                    {{ $comment->created_at->diffForHumans() }}
                </div>
                @if($loggedin_userid == $comment->user_id)
                <div class="small mt-2">
                    <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#editComment">Edit</button>
                    <a class="btn btn-sm btn-warning"
                        onclick="return confirm('Are you sure?')"
                        href="{{ url("/comments/delete/$comment->id") }}">
                        Delete
                    </a>
                </div>
                <!-- Modal -->
                <div class="modal fade" id="editComment" tabindex="-1" role="dialog" aria-labelledby="editCommentTitle" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editCommentTitle">Edit Comment</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ url("/comments/update/$comment->id") }}">
                                    @csrf
                                    <input type="hidden" name="article_id" value="{{ $article->id }}">
                                    <textarea name="content" class="form-control mb-2">{{ $comment->content }}</textarea>
                                    <div class="modal-footer">
                                        <input type="submit" value="Update Comment" class="btn btn-secondary">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!--Modal-->
                @endif
            </li>
            @endforeach
        </ul>
        @auth
        <form action="{{ url('/comments/add') }}" method="post">
            @csrf
            <input type="hidden" name="article_id" value="{{ $article->id }}">
            <textarea name="content" class="form-control mb-2" placeholder="New Comment" id="myInput" autocomplete="off"></textarea>
            <input type="submit" value="Add Comment" class="disabled btn btn-secondary" id="myBtn">
        </form>
        @endauth
    </div>

    <script>
        let input = document.getElementById('myInput');
        let button = document.getElementById('myBtn');

        input.addEventListener('keyup', function(event){
            let val = event.target.value;  // input's current value

            if(val===''){
                button.classList.add('disabled')  // Add .disabled class
            } else {
                button.classList.remove('disabled');  // Remove .disabld class 
            }
        });
    </script>

@endsection
