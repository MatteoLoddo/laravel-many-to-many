<html>
  <p> Ciao {{$user->name}}</p>

  <p> hai appena creato un post : <strong>{{$post->title}}</strong> </p>

  <p>VIsualizza post</p>
  <div>
    <a href="{{route('admin.posts.show', $post->slug)}}">Vai al post!</a>
  </div>


</html>