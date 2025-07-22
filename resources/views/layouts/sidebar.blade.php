<aside class="left-sidebar" data-sidebarbg="skin5">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav" class="pt-4">
                @includeWhen(Auth::user()->hasRole('admin') ,'layouts.partials.administrator')
                @includeWhen(Auth::user()->hasRole('secretary') ,'layouts.partials.administrator')
                @includeWhen(Auth::user()->hasRole('professor') ,'layouts.partials.professor')
                @includeWhen(Auth::user()->hasRole('student') ,'layouts.partials.student')
            </ul>
        </nav>
    </div>
</aside>