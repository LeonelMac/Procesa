<form id="agregarUsuarioModal" method="POST" action="{{ route('usuarios.guardar') }}" novalidate>
    @csrf
    <!-- Nombres -->
    <div class="row mb-3">
        <label for="nombres" class="col-md-4 col-form-label text-md-end">{{ __('Nombre') }}</label>
        <div class="col-md-6">
            <input id="nombres" type="text" class="form-control @error('nombres') is-invalid @enderror" name="nombres"
                value="{{ old('nombres') }}" required>
            @error('nombres')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>

    <!-- Apellido Paterno -->
    <div class="row mb-3">
        <label for="apellidoP" class="col-md-4 col-form-label text-md-end">{{ __('Apellido Paterno') }}</label>
        <div class="col-md-6">
            <input id="apellidoP" type="text" class="form-control @error('apellidoP') is-invalid @enderror"
                name="apellidoP" value="{{ old('apellidoP') }}" required>
            @error('apellidoP')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>

    <!-- Apellido Materno -->
    <div class="row mb-3">
        <label for="apellidoM" class="col-md-4 col-form-label text-md-end">{{ __('Apellido Materno') }}</label>
        <div class="col-md-6">
            <input id="apellidoM" type="text" class="form-control @error('apellidoM') is-invalid @enderror"
                name="apellidoM" value="{{ old('apellidoM') }}" required>
            @error('apellidoM')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>

    <!-- Email -->
    <div class="row mb-3">
        <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Correo Electrónico') }}</label>
        <div class="col-md-6">
            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                name="email" value="{{ old('email') }}" required>
            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>

    <!-- Rol -->
    <div class="row mb-3">
        <label for="rol" class="col-md-4 col-form-label text-md-end">{{ __('Rol') }}</label>
        <div class="col-md-6">
            <select id="rol" class="form-control @error('rol') is-invalid @enderror" name="rol" required>
                <option value="">Seleccione un rol</option>
                @foreach ($roles as $rol)
                    <option value="{{ $rol->id_rolusuarios }}">{{ $rol->rolusuarios }}</option>
                @endforeach
            </select>
            @error('rol')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>

    <!-- Municipio -->
    <div class="row mb-3">
        <label for="municipio" class="col-md-4 col-form-label text-md-end">{{ __('Municipio') }}</label>
        <div class="col-md-6">
            <select id="municipio" class="form-control @error('municipio') is-invalid @enderror" name="municipio"
                required>
                <option value="">Seleccione un municipio</option>
                @foreach ($municipios as $municipio)
                    <option value="{{ $municipio->idmunicipio }}">{{ $municipio->municipio }}</option>
                @endforeach
            </select>
            @error('municipio')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>

    <!-- Dirección -->
    <div class="row mb-3">
        <label for="direccion" class="col-md-4 col-form-label text-md-end">{{ __('Dirección') }}</label>
        <div class="col-md-6">
            <input id="direccion" type="text" class="form-control @error('direccion') is-invalid @enderror"
                name="direccion" value="{{ old('direccion') }}" required>
            @error('direccion')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>

    <!-- Teléfono -->
    <div class="row mb-3">
        <label for="telefono" class="col-md-4 col-form-label text-md-end">{{ __('Teléfono') }}</label>
        <div class="col-md-6">
            <input id="telefono" type="text" class="form-control @error('telefono') is-invalid @enderror"
                name="telefono" value="{{ old('telefono') }}" required maxlength="10" pattern="[0-9]{10}"
                title="Debe ingresar un número de 10 dígitos">
            @error('telefono')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>

    <div class="row mb-0">
        <div class="col-md-6 offset-md-4">
            <button id="guardar" name="guardar" type="submit" class="btn btn-success">
                {{ __('Guardar') }}
            </button>
        </div>
    </div>
</form>
