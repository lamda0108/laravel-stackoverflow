<div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <h2>{{ $answersCount . " " . Str::plural('Answer', $question->answers_count)}}</h2>                     
                    </div>
                    <hr>

                    @include('layouts._messages')

                    @foreach($answers as $answer)
                        <div class="media">
                            <!-- vote controls -->
                            <div class="d-flex flex-column vote-controls">
                                    <a title="This answer is useful" href="" class="vote-up">
                                        <i class="fas fa-caret-up fa-3x"></i>
                                    </a>
                                    <span class="votes-count">1230</span>
                                    <a title="This answer is not useful" class="vote-down off" href="">
                                    <i class="fas fa-caret-down fa-3x"></i>
                                    </a>
                                    @can('accept', $answer)
                                        <a title="Mark this answer as best answer" class="{{$answer->status}} mt-2" 
                                        onclick="event.preventDefault(); document.getElementById('accept-answer-{{$answer->id}}').submit();">
                                            <i class="fas fa-check fa-2x"></i>                   
                                        </a>
                                        <form action="{{route('answer.accept', $answer->id)}}" 
                                            id="accept-answer-{{$answer->id}}" method="POST"
                                            style="display:none;">
                                        @csrf
                                        </form>  
                                    @else
                                        <!-- if this answer is marked as the best answer, every user can see a green tick -->
                                        @if($answer->is_best)
                                            <a title="The question owner acceptd this answer as the vest answer" class="{{$answer->status}} mt-2" >
                                                <i class="fas fa-check fa-2x"></i>                   
                                            </a>
                                        @endif
                                    @endcan  
                             </div>
                            <!-- end of vote controls -->
                            <div class="media-body">
                                {!! $answer->body_html !!}
                                <div class="float-right">
                                    <span class="text-muted">
                                        Answered {{$answer->created_date}}                                       
                                    </span>
                                    <div class="media mt-2">
                                        <a href="{{$answer->user->url}}" class="pr-2">
                                            <img src="{{$answer->user->avatar}}" alt="">
                                        </a>
                                        <div class="media-body mt-1">
                                            <a href="{{$answer->user->url}}">
                                                {{$answer->user->name}}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                    @endforeach
                </div>
            </div>
        </div>
    </div>