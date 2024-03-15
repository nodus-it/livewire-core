<ul>
    @foreach($views as $view)
        <li><a href="{{route('show',['view'=>$view])}}">{{ $view }}</a></li>
    @endforeach
</ul>