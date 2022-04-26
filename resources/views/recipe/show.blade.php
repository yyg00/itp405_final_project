@extends('layouts.main')
@section('title', $recipe->recipe_name)
@section('content')
<div class="container mt-3 mb-3" style="width: 750px;">
    @if (session('success'))
    <div class="alert alert-success" role="alert">
        {{ session('success') }}
    </div>
    @endif
    <div class="row mt-3">
        <div class="d-flex justify-content-center">
            <span class="badge badge-pill bg-info" style="font-size: 11px; margin-right: 15px;">#{{$recipe->type->type_name}}</span>
            <span class="badge badge-pill bg-info" style="font-size: 11px;">#{{$recipe->cuisine->cuisine_name}}</span>
        </div>
        <h4 class="text-center mt-2">{{$recipe->recipe_name}}</h4>
        @if(!$favorited)
            {{-- @if(Auth::check()) --}}
            @can('create', App\Models\Favorite::class)
            <form method="post" action={{route('favorite.store', ['id' => $recipe->id])}} class="text-center"> 
                @csrf
                <button type="submit" class="btn btn-light" style="background: none; padding: 0px; border: none;">
            <i class="bi bi-bookmark-heart" style="color:red; font-size:13px;"> Add to Favorites</i>
                </button>
            </form>
            @else
                <div class="text-center" style="font-size:13px;"><a href="{{ route('login') }}">Login</a> to add it to your favorites</div>
            {{-- @endif --}}
            @endcan
        @else
            <form method="post" action={{route('favorite.delete', ['id' => $favorited->id])}} class="text-center"> 
                @csrf
                <button type="submit" class="btn btn-light" style="background: none; padding: 0px; border: none;">
            <i class="bi bi-bookmark-heart-fill" style="color:red; font-size:13px;"> Favorited</i>
                </button>
            </form>
        @endif
    </div>
    <div class="d-flex justify-content-around">
        <div>
            Author: {{$recipe->user ? $recipe->user->name : 'Guest'}}
        </div>
        <div>
            Published Time: {{date_format($recipe->created_at, 'm/d/Y')}}
        </div>
    </div>

    <div class="d-flex justify-content-around mt-3">
        <div>Serving(s): 
            {{$recipe->serving}}
        </div>
        <div>Cooking time: 
            {{$recipe->cooking_time}} minutes
        </div>
    </div>
    <hr/>
    <div class="row">
            <div id="myCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel"  style="">
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="0" class="active" aira-label="Slide 1"></button>
                    @for($i=0; $i<count($images); $i++)        
                    <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="{{$i+1}}" aria-label="Slide {{$i+2}}"></button>
                    @endfor
                </div>
                <div class="carousel-inner"  style="">
                    <div class="carousel-item active">
                        <img src="{{ Storage::disk('s3')->url($imageHeader->url) }}" class="d-block w-100" alt="{{$recipe->recipe_name}}" style="width:100%; height:auto; object-fit: cover; object-position:center;">
                    </div>
                @foreach($images as $image)
                <div class="carousel-item">
                    <img src="{{ Storage::disk('s3')->url($image->url) }}" class="d-block w-100" alt="{{$recipe->recipe_name}}" style="width:100%; height:auto; object-fit: cover; object-position:center;">
                </div>
                @endforeach
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#myCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#myCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>

    </div>
    <div class="row mt-3">
        <div class="col-4">
            <h6> Ingredients:</h6>
            <p>{{$recipe->ingredients}}</p>
        </div>
        <div class="col-8">
            <h6> Directions:</h6>
            <p>{{$recipe->directions}}</p>
        </div>
    </div>
    @if($recipe->notes)
    <hr />
    <div class="row mt-3">
        <h6>Notes from Author:</h6>
        <p>{{$recipe->notes}}</p>
    </div>
    @endif
    <hr />
    <div class="row">
            @if(count($comments) == 0)
                @can('create', App\Models\Comment::class)
                <div class="mb-3">

                    <form method="POST" action={{route('comment.store', ['id' => $recipe->id])}}>
                        @csrf
                        <div class="mb-3">
                        <label for="comment_body" class="form-label"></label>
                        <textarea class="form-control" id="comment_body" name="comment_body" placeholder="Be the first one to comment here...">{{old('comment_body')?old('comment_body'):''}}</textarea>
                        @error('comment_body')
                        <small class="text-danger">{{$message}}</small>
                        @enderror    
                        </div>
                        
                        <button type="submit" class="btn btn-success">Comment</button>
                    </form>

                </div> 
                @else
                    <p>No comment yet. <a href="{{ route('login') }}">Login</a> to leave a comment.</p>
                @endcan
            @else

            @can('create', App\Models\Comment::class)
            <div class="mb-3">
                <form method="POST" action={{route('comment.store', ['id' => $recipe->id])}}>
                    @csrf
                    <div class="mb-3">
                    <label for="comment_body" class="form-label"></label>
                    <textarea class="form-control" id="comment_body" name="comment_body" placeholder="Leave your comment here...">{{old('comment_body')?old('comment_body'):''}}</textarea>
                    @error('comment_body')
                    <small class="text-danger">{{$message}}</small>
                    @enderror
                    </div>

                    <button type="submit" class="btn btn-success text-right">Comment</button>
                </form>
            </div>
            @else
                <p><a href="{{ route('login') }}">Login</a> to leave a comment.</p>
            @endcan
                @foreach($comments as $comment)
                <div class="mb-3">
                    <div style="font-size:14px;" class="p-1 d-flex justify-content-between align-items-center">
                        <div >
                        By <span style="font-weight: bold;">{{$comment->user->name}}</span> on <span style="font-style:italic;font-color:rgb(139, 132, 132);">{{ date_format($comment->created_at, 'm/d/Y H:i') }}</span>
                        </div>
                    @canany(['update', 'delete'], $comment)
                        <div class="btn-group">
                            <button class="btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-three-dots" style="font-size: 11px;"></i>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#updateCommentModal_{{$comment->id}}"
                                    data-action="{{ route('comment.update', ['id' => $comment->id]) }}">Edit</a></li>
                                <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#deleteCommentModal_{{$comment->id}}"
                                    data-action="{{ route('comment.delete', ['id' => $comment->id]) }}">Delete</a>
                                </li>
                            </ul>
                        </div>
                        <div class="modal fade" id="updateCommentModal_{{$comment->id}}" data-backdrop="static" tabindex="-1" role="dialog"
                            aria-labelledby="updateCommentModalLabel" aria-hidden="true">
                              <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="updateCommentModalLabel">Edit Comment</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                  </div>
                                  <form method="post" action="{{ route('comment.update', ['id' => $comment->id]) }}">
                                    <div class="modal-body">
                                      @csrf
                                      <textarea class="form-control" name="edited_comment_body_{{$comment->id}}" placeholder="Edit your comment here...">{{ old("edited_comment_body_" . $comment->id, $comment->comment_body) }}</textarea>
                                     
                                      @error('edited_comment_body_' . $comment->id)
                                      <small class="text-danger">{{$message}}</small>
                                      @enderror
                                    </div>
                                    <script type="text/javascript">

                                        @if ($errors->has('edited_comment_body_' . $comment->id))
                                            $(document).ready(function () {
                                                $('#updateCommentModal_{{$comment->id}}').modal('show');
                                            });

                                        @endif
                                     </script>

                                    <div class="modal-footer">
                                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                      <button type="submit" class="btn btn-success">Edit</button>
                                    </div>
                                </form>
                                </div>
                              </div>
                        </div>


                        <div class="modal fade" id="deleteCommentModal_{{$comment->id}}" data-backdrop="static" tabindex="-1" role="dialog"
                            aria-labelledby="deleteCommentModalLabel" aria-hidden="true">
                              <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="deleteCommentModalLabel">Confirm deletion</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                  </div>
                                  <form method="post" action="{{ route('comment.delete', ['id' => $comment->id]) }}">
                                    <div class="modal-body">
                                      @csrf
                                      <p class="text-center">Are you sure you want to delete this comment?</p>
                                    </div>
                                    <div class="modal-footer">
                                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                      <button type="submit" class="btn btn-danger">Yes</button>
                                    </div>
                                </form>
                                </div>
                              </div>
                        </div>
                    @endcanany
                    </div>
                    <div class="p-1">
                        <p style="word-wrap: break-word;">
                        {{$comment->comment_body}}
                        </p>
                        <hr />
                    </div>
                    
                </div>
                @endforeach
                
            @endif
        </div>
</div>

@endsection