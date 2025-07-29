
<li class="sidebar-item">
    <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{ route('dashboard') }}" aria-expanded="false">
        <i class="mdi mdi-view-dashboard"></i>
        <span class="hide-menu">Tableaux de bord</span>
    </a>
</li>
<li class="sidebar-item">
    <a href="{{ route('students.show',auth()->user()->student->id) }}" class="sidebar-link">
        <i class="mdi mdi-account-box"></i>
        <span class="hide-menu"> Mon profile </span>
    </a>
</li>
<li class="sidebar-item">
    <a href="{{ route('student.course_today') }}" class="sidebar-link">
        <i class="mdi mdi-book-multiple"></i>
        <span class="hide-menu"> Cours d'aujourd'hui </span>
    </a>
</li>
<li class="sidebar-item">
    <a href="{{ route('student.courses') }}" class="sidebar-link">
        <i class="mdi mdi-book-multiple"></i>
        <span class="hide-menu"> Tous mes cours </span>
    </a>
</li>