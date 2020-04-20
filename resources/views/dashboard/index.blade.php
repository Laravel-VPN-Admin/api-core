@extends('layouts.app')

@section('title')
  Dashboard
@endsection

@section('header')
  <div class="page-header">
    <div class="row align-items-center">
      <div class="col-auto">
        <!-- Page pre-title -->
        <div class="page-pretitle">
          Overview
        </div>
        <h2 class="page-title">
          Dashboard
        </h2>
      </div>
      <!-- Page title actions -->
      <div class="col-auto ml-auto d-print-none">
                <span class="d-none d-sm-inline">
                  <a href="#" class="btn btn-secondary">
                    New view
                  </a>
                </span>
        <a href="#" class="btn btn-primary ml-3 d-none d-sm-inline-block" data-toggle="modal" data-target="#modal-report">
          <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
            <path stroke="none" d="M0 0h24v24H0z"></path>
            <line x1="12" y1="5" x2="12" y2="19"></line>
            <line x1="5" y1="12" x2="19" y2="12"></line>
          </svg>
          Create new report
        </a>
        <a href="#" class="btn btn-primary ml-3 d-sm-none btn-icon" data-toggle="modal" data-target="#modal-report" aria-label="Create new report">
          <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
            <path stroke="none" d="M0 0h24v24H0z"></path>
            <line x1="12" y1="5" x2="12" y2="19"></line>
            <line x1="5" y1="12" x2="19" y2="12"></line>
          </svg>
        </a>
      </div>
    </div>
  </div>
@endsection

@section('content')
  <div class="row row-deck row-cards">
    <div class="col-sm-6 col-lg-3">
      <div class="card">
        <div class="card-body">
          <div class="d-flex align-items-center">
            <div class="subheader">Total Users</div>
            <div class="ml-auto lh-1">
              <div class="dropdown">
                <a class="dropdown-toggle text-muted" href="#" id="dropdownMenuButton" data-toggle="dropdown"
                   aria-haspopup="true" aria-expanded="false">
                  Last 7 days
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                  <a class="dropdown-item active" href="#">Last 7 days</a>
                  <a class="dropdown-item" href="#">Last 30 days</a>
                  <a class="dropdown-item" href="#">Last 3 months</a>
                </div>
              </div>
            </div>
          </div>
          <div class="h1 mb-3">123</div>
          <div class="d-flex mb-2">
            <div>Rate</div>
            <div class="ml-auto">
                      <span class="text-green d-inline-flex align-items-center lh-1">
                        7% <svg xmlns="http://www.w3.org/2000/svg" class="icon ml-1" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                          <path stroke="none" d="M0 0h24v24H0z"></path>
                          <polyline points="3 17 9 11 13 15 21 7"></polyline>
                          <polyline points="14 7 21 7 21 14"></polyline>
                        </svg>
                      </span>
            </div>
          </div>
          <div class="progress progress-sm">
            <div class="progress-bar bg-blue" style="width: 75%" role="progressbar" aria-valuenow="75" aria-valuemin="0"
                 aria-valuemax="100">
              <span class="sr-only">75% Complete</span>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-sm-6 col-lg-3">
      <div class="card">
        <div class="card-body">
          <div class="d-flex align-items-center">
            <div class="subheader">Total Servers</div>
          </div>
          <div class="h1 mb-3">2</div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('modals')

@endsection

@section('css')

@endsection

@section('js')
  Dashboard
@endsection