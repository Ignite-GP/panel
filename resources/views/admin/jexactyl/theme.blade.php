@extends('layouts.admin')
@include('partials/admin.ignite.nav', ['activeTab' => 'theme'])

@section('title')
    Theme Settings
@endsection

@section('content-header')
    <h1>ignite Appearance<small>Configure the theme for ignite.</small></h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.index') }}">Admin</a></li>
        <li class="active">ignite</li>
    </ol>
@endsection

@section('content')
    @yield('ignite::nav')
    <div class="row">
        <div class="col-xs-12">
            <form action="{{ route('admin.ignite.theme') }}" method="POST">
                <div class="box box-info
                ">
                    <div class="box-header with-border">
                        <h3 class="box-title">Admin Themes <small>The selection for ignite's theme.</small></h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label class="control-label">Admin Theme</label>
                                <div>
                                    <select name="theme:admin" class="form-control">
                                        <option @if ($admin == 'ignite') selected @endif value="ignite">Default Theme</option>
                                        <option @if ($admin == 'dark') selected @endif value="dark">Dark Theme</option>
                                        <option @if ($admin == 'light') selected @endif value="light">Light Theme</option>
                                        <option @if ($admin == 'blue') selected @endif value="blue">Blue Theme</option>
                                        <option @if ($admin == 'minecraft') selected @endif value="minecraft">Minecraft&#8482; Theme</option>
                                    </select>
                                    <p class="text-muted"><small>Determines the theme for ignite's Admin UI.</small></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {!! csrf_field() !!}
                <button type="submit" name="_method" value="PATCH" class="btn btn-default pull-right">Save Changes</button>
            </form>
        </div>
    </div>
@endsection
