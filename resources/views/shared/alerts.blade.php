
@if (!empty($alerts))
    <div class="alerts text-left w-100">
        {{-- validation custom errors --}}
        @foreach ($alerts as $type => $message)
            <div class="alert alert-{{$type}} alert-dismissible fade show" role="alert">
                @if (is_array($message)) 
                <ul>
                    @foreach ($message as $msg)
                        <li>{{ $msg }}</li>
                    @endforeach
                </ul>
                @else
                    {{ $message }}
                @endif
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
            </div>
        @endforeach
    </div>
@endif