@extends('layouts.cabinet')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Înregistrare') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('cabinet.register') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Nume') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                         <div class="form-group row">
                            <label for="judet" class="col-md-4 col-form-label text-md-right">{{ __('Județ') }}</label>

                            <div class="col-md-6">
                                <select name="judet" class="form-control" >
                                    <option value="Alba">Alba</option>
                                    <option value="Arad">Arad</option>
                                    <option value="Arges">Arges</option>
                                    <option value="Bacau">Bacau</option>
                                    <option value="Bihor">Bihor</option>
                                    <option value="Bistrita Nasaud">Bistrita Nasaud</option>
                                    <option value="Botosani">Botosani</option>
                                    <option value="Brasov">Brasov</option>
                                    <option value="Braila">Braila</option>
                                    <option value="Bucuresti">Bucuresti</option>
                                    <option value="Buzau">Buzau</option>
                                    <option value="Caras Severin">Caras Severin</option>
                                    <option value="Calarasi">Calarasi</option>
                                    <option value="Cluj">Cluj</option>
                                    <option value="Constanta">Constanta</option>
                                    <option value="Covasna">Covasna</option>
                                    <option value="Dambovita">Dambovita</option>
                                    <option value="Dolj">Dolj</option>
                                    <option value="Galati">Galati</option>
                                    <option value="Giurgiu">Giurgiu</option>
                                    <option value="Gorj">Gorj</option>
                                    <option value="Harghita">Harghita</option>
                                    <option value="Hunedoara">Hunedoara</option>
                                    <option value="Ialomita">Ialomita</option>
                                    <option value="Iasi">Iasi</option>
                                    <option value="Ilfov">Ilfov</option>
                                    <option value="Maramures">Maramures</option>
                                    <option value="Mehedinti">Mehedinti</option>
                                    <option value="Mures">Mures</option>
                                    <option value="Neamt">Neamt</option>
                                    <option value="Olt">Olt</option>
                                    <option value="Prahova">Prahova</option>
                                    <option value="Satu Mare">Satu Mare</option>
                                    <option value="Salaj">Salaj</option>
                                    <option value="Sibiu">Sibiu</option>
                                    <option value="Suceava">Suceava</option>
                                    <option value="Teleorman">Teleorman</option>
                                    <option value="Timis">Timis</option>
                                    <option value="Tulcea">Tulcea</option>
                                    <option value="Vaslui">Vaslui</option>
                                    <option value="Valcea">Valcea</option>
                                    <option value="Vrancea">Vrancea</option>
                                </select>

                                    @if ($errors->has('judet'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('judet') }}</strong>
                                        </span>
                                    @endif
                            </div>
                       </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Parola') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Parola Reconfirmată') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>
                        {!! app('captcha')->render(); !!}
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Înregistrare') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
