@if(Hunt\User::developer(Auth::user()->email))
    <li>
        <a href="/settings/token">Personal Access Token</a>
    </li>
@endif