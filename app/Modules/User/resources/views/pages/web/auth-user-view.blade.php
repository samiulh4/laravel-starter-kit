@extends('layouts.web')

@section('style')
    <style>
        /* main {
                margin-top: 100px;
            } */
    </style>
@endsection

@section('content')
    <section>
         <div class="container">
            <div class="row">
                <div class="col-md-12">
                    {{-- <h2 class="mb-4">User Profile</h2> --}}
                     <x-alert type="success">
                        Data saved successfully!
                    </x-alert>
                    <x-forms.input />
                </div>
            </div>
         </div>
    </section>
@endsection
