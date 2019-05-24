@extends('partials.layout')

@section('title', Lang::get('app.home.title'))

@section('content')
  <div class="row">
    <div class="card col-12">
      <div class="card-body">
        <h3>Euclidiana y Bayes<small class="text-muted"> @lang('app.home.description')</small></h3>
        <div class="separator-alt"></div>
        <div class="row">
          <!-- Learning styles -->
          <div class="col-12 col-md-4 my-2">
            <div class="card text-center bg-light">
              <div class="card-body">
                <h5 class="card-title mb-0">
                  <i class="fas fa-book fa-2x mb-2"></i><br>
                  <a class="home-link" href="{{ route('styles') }}">@lang('app.styles')</a>
                </h5>
                <div class="separator"></div>
                <h6 class="card-subtitle my-2 text-muted">@lang('app.stylesDescr')</h6>
              </div>
            </div>
          </div>
          <!-- Campus -->
          <div class="col-12 col-md-4 my-2">
            <div class="card text-center bg-light">
              <div class="card-body">
                <h5 class="card-title mb-0">
                  <i class="fas fa-building fa-2x mb-2"></i><br>
                  <a class="home-link" href="{{ route('campus') }}">@lang('app.campus')</a>
                </h5>
                <div class="separator"></div>
                <h6 class="card-subtitle my-2 text-muted">@lang('app.campusDescr')</h6>
              </div>
            </div>
          </div>
          <!-- Gender -->
          <div class="col-12 col-md-4 my-2">
            <div class="card text-center bg-light">
              <div class="card-body">
                <h5 class="card-title mb-0">
                  <i class="fas fa-transgender fa-2x mb-2"></i><br>
                  <a class="home-link" href="{{ route('gender') }}">@lang('app.gender')</a>
                </h5>
                <div class="separator"></div>
                <h6 class="card-subtitle my-2 text-muted">@lang('app.genderDescr')</h6>
              </div>
            </div>
          </div>
          <!-- Learning Style -->
          <div class="col-12 col-md-4 my-2">
            <div class="card text-center bg-light">
              <div class="card-body">
                <h5 class="card-title mb-0">
                  <i class="fas fa-graduation-cap fa-2x mb-2"></i><br>
                  <a class="home-link" href="{{ route('style') }}">@lang('app.learningStyle')</a>
                </h5>
                <div class="separator"></div>
                <h6 class="card-subtitle my-2 text-muted">@lang('app.learningStyleDescr')</h6>
              </div>
            </div>
          </div>
          <!-- Professor's type -->
          <div class="col-12 col-md-4 my-2">
            <div class="card text-center bg-light">
              <div class="card-body">
                <h5 class="card-title mb-0">
                  <i class="fas fa-user fa-2x mb-2"></i><br>
                  <a class="home-link" href="{{ route('professor') }}">@lang('app.professorType')</a>
                </h5>
                <div class="separator"></div>
                <h6 class="card-subtitle my-2 text-muted">@lang('app.professorTypeDescr')</h6>
              </div>
            </div>
          </div>
          <!-- Network -->
          <div class="col-12 col-md-4 my-2">
            <div class="card text-center bg-light">
              <div class="card-body">
                <h5 class="card-title mb-0">
                  <i class="fas fa-cloud fa-2x mb-2"></i><br>
                  <a class="home-link" href="{{ route('network') }}">@lang('app.networkClass')</a>
                </h5>
                <div class="separator"></div>
                <h6 class="card-subtitle my-2 text-muted">@lang('app.networkClassDescr')</h6>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection