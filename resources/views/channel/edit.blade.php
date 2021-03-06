@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Channe') }}</div>

                <div class="card-body">
                    <livewire:channel.channel-edit :channel="$channel" />
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
