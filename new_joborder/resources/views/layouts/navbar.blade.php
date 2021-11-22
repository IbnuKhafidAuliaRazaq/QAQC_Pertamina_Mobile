<header class="topheader" id="top">
    <div class="fix-width">
    
        @if(!empty(Auth::user()))
        <nav class="navbar navbar-expand-md navbar-light p-l-0">
            <!-- Logo will be here -->
            <a class="navbar-brand" href="index.html"></a>
            <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation"> <span class="navbar-toggler-icon"></span> </button>
            <!-- This is the navigation menu -->
            @if(Auth::user()->level == 1)
                <?php $level = 'user'; ?>
            @endif
            @if(Auth::user()->level == 2)
                <?php $level = 'leader'; ?>
            @endif
            @if(Auth::user()->level == 3)
                <?php $level = 'inspector'; ?>
            @endif
            @if(Auth::user()->level == 4)
                <?php $level = 'manager'; ?>
            @endif
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav ml-auto stylish-nav">
                    <li class="ml-3"><a href="{{ url('/settings') }}">Settings</a></li>
                    <li class="ml-3"><a href="javascript:void" onclick="location.reload()">Refresh</a></li>
                    <li class="ml-3"><a href="{{ url($level) }}">Home</a></li>
                    <li class="ml-3">{{ Auth::user()->fullname }}</li>
                    <li class="ml-3">
                        <a href="javascript:void" onclick="document.getElementById('logout-form').submit();;"> Log Out</a>
                    </li>
                </ul>
            </div>
        </nav>
        @endif
    </div>
</header>
<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>