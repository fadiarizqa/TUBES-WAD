<!-- resources/views/components/navbar.blade.php -->
<div class="navbar">
    <div class="navbar-left">
        <strong>Carikeun</strong>
    </div>
    <div class="navbar-right">
        <span>{{ Auth::user()->name }}</span>
        <a href="#"><i class="fa fa-user"></i></a>
    </div>
</div>
