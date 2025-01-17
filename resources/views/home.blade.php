@extends('layouts.app')

@section('content')
<style>
    .dashboard {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    padding: 20px;
}
.box {
    width: 150px;
    height: 100px;
    display: flex;
    justify-content: center;
    align-items: center;
    border: 2px solid #007bff;
    border-radius: 8px;
    cursor: pointer;
    transition: transform 0.3s;
}
.box:hover {
    transform: scale(1.05);
    background-color: #007bff;
    color: #fff;
}

</style>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>
                <div class="dashboard">
                    <div class="box" onclick="openForm('citizenship')">Citizenship</div>
                    <div class="box" onclick="openForm('license')">Driving License</div>
                    <div class="box" onclick="openForm('voter')">Voter Card</div>
                    <div class="box" onclick="openForm('pan')">PAN ID</div>
                    <div class="box" onclick="openForm('plus2')">+2 Details</div>
                    <div class="box" onclick="openForm('birthcertificate')">Birth Certificate</div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function openForm(type) {
        window.location.href = `home/${type}`;
    }
</script>

@endsection
