@extends('layout')
@section('title', __('devices.show', ['name' => $device->name, 'model' => $device->type]))

@section('content')

    <x-model-show>

        <x-slot:header>{{ __('devices.profile', ['model' => $device->type]) }}</x-slot:header>

        <x-dl-div>
            <x-slot:dt>{{ __('common.mac') }}</x-slot:dt>
            {{ $device->mac }}
        </x-dl-div>

        <x-dl-div>
            <x-slot:dt>{{ __('common.name') }}</x-slot:dt>
            {{ $device->name }}
        </x-dl-div>

        <x-dl-div>
            <x-slot:dt>{{ __('common.description') }}</x-slot:dt>
            {{ $device->description ?? '--' }}
        </x-dl-div>

        <x-dl-div>
            <x-slot:dt>{{ __('common.status') }}</x-slot:dt>
            @if ($device->enabled)
                <span class="text-green-500 align-bottom">
                    <x-hi-check-circle />
                    {{ __('common.enabled') }}
                </span>
            @else
                <span class="text-red-500 align-bottom">
                    <x-hi-x-circle />
                    {{ __('common.disabled') }}
                </span>
            @endif
        </x-dl-div>

        <x-dl-div>
            <x-slot:dt>{{ __('common.valid_from') }}</x-slot:dt>
            {{ $device->valid_from ?? '--' }}
        </x-dl-div>

        <x-dl-div>
            <x-slot:dt>{{ __('common.valid_to') }}</x-slot:dt>
            {{ $device->valid_to ?? '--' }}
        </x-dl-div>

        <x-slot:footer>
            <div class="md:grow md:text-left">{{ __('common.created_by') }}
                @if ($device->oldestHistory)
                    <x-a href="{{ route('users.show', $device->oldestHistory->user) }}">
                        {{ $device->oldestHistory->user->name }}</x-a>
                @else
                    {{ __('common.unknown') }}
                @endif
                {{ __('common.at') }}
                @if ($device->oldestHistory)
                    {{ $device->oldestHistory->created_at }} ({{ $device->created_at->diffForHumans() }}).
                @else
                    {{ $device->created_at }}
                @endif
            </div>
            <div class="md:grow md:text-right">{{ __('common.updated_by') }}
                @if ($device->latestHistory)
                    <x-a href="{{ route('users.show', $device->latestHistory->user) }}">
                        {{ $device->latestHistory->user->name }}</x-a>
                @else
                    {{ __('common.unknown') }}
                @endif
                {{ __('common.at') }}
                @if ($device->latestHistory)
                    {{ $device->latestHistory->updated_at }} ({{ $device->updated_at->diffForHumans() }}).
                @else
                    {{ $device->updated_at }}
                @endif
            </div>
        </x-slot:footer>

    </x-model-show>

    <div>
        <x-button-link href="{{ route('devices.index') }}">{{ __('common.back') }}</x-button-link>
        @can('update', $device)
            <x-button-link href="{{ route('devices.edit', $device) }}" color="yellow">{{ __('common.edit') }}</x-button-link>
        @endcan
        @can('delete', $device)
            <x-form-delete action="{{ route('devices.destroy', $device) }}" model="{{ $device->category->type }}"
                name="{{ $device->name }}" />
        @endcan
    </div>
@endsection
