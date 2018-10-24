<div class="topics-wrapper">
    <ul class="nav nav-topics">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Topics</a>
            <div class="dropdown-menu">
                @foreach(App\Category::orderby('cat_name')->get() as $category)
                    <a class="dropdown-item" href="/stacks/{{$category->id}}/category">{{$category->cat_name}}</a>
                @endforeach
            </div>
        </li>
    </ul>
</div>
