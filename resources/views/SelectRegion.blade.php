@extends('layout.layout')
@section('content')
    <div class="back">
        <a href="{{ route('login') }}">
            <i class="fa-thin fa-arrow-left-long text-white mt-5 ms-5"></i>
        </a>
    </div>
    <section class="bisnis_unit">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="card shadow-2-strong" style="border-radius: 1rem;">
                        <div class="card-body p-5 text-center">

                            <h1 class="card-title " style="color: black">Tell us about your
                                Region</h1> <br>
                            <div class="icon_mobile">
                                <img style=""src="images/icon_mobile.png" class="icon" alt="Phone image">
                            </div>
                            <h5 style="color: "> What’s your Business unit name?</h5>
                            <div class="form-outline mb-4">
                                <form action="{{ route('SelectedRegion') }}"
                                    class="d-flex justify-content-center flex-column w-100 pt-3" method="POST">
                                    @csrf
                                    <select class="form-select form-select-lg mb-3" aria-label=".form-select-lg example"
                                        name="Region">

                                        <option value="">Select Region</option>
                                        @foreach ($Region as $u)
                                            <option value="{{ $u->id_region}}">{{ $u->region_name}}</option>
                                        @endforeach
                                    </select>
                                    <button class="btn btn-lg btn-block btn-primary" style="background-color: #1E4A58;"
                                        type="submit"> Continue</button>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if ($message = session('success'))
            <script>
                Swal.fire({
                    position: 'top-mid',
                    icon: 'success',
                    title: '{{ $message }}',
                    showConfirmButton: false,
                    timer: 2000
                })
            </script>
        @endif
    </section>
