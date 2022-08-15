@extends('dashboard.layout.main')
@section('container')
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-6">
                    <div class="au-card m-b-30">
                        <div class="au-card-inner">
                            <h3 class="title-2 m-b-40">Yearly Sales</h3>
                            <canvas id="sales-chart"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="au-card m-b-30">
                        <div class="au-card-inner">
                            <h3 class="title-2 m-b-40">Team Commits</h3>
                            <canvas id="team-chart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="copyright">
                        <p>Copyright © 2022 PERTAMINA RU VI BALONGAN.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
