@if(User::current()->id && User::current()->id != $user->id)
<a href="#" class="label bg-violet t-white {{User::current()->doesFollow($user->id) ? 'js-unfollow' : 'js-follow'}}" data-user-id="{{$user->id}}">{!!User::current()->doesFollow($user->id) ? '<i class="fa fa-eye-slash"></i> Unfollow' : '<i class="fa fa-eye"></i> Follow!'!!}</a>
@endif