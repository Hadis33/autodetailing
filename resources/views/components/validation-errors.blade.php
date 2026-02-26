@if ($errors->any())
    <div {{ $attributes }}>
        <div class="font-medium text-red-600">{{ __('Desila se greška.') }}</div>

        <ul class="mt-3 list-disc list-inside text-sm text-red-600">
            @foreach ($errors->all() as $error)
                <li>
                    @php
                        $translatedError = match (true) {
                            str_contains($error, 'validation.in') => 'Odabrana vrijednost nije validna.',
                            str_contains($error, 'validation.confirmed') => 'Lozinke se ne podudaraju.',
                            str_contains($error, 'validation.required') => 'Ovo polje je obavezno.',
                            str_contains($error, 'validation.email') => 'Unesite validnu email adresu.',
                            str_contains($error, 'validation.unique') => 'Ova email adresa je već registrovana.',
                            str_contains($error, 'validation.min') => 'Lozinka mora imati najmanje 8 karaktera.',
                            str_contains($error, 'validation.max') => 'Polje ima previše karaktera.',
                            str_contains($error, 'validation.string') => 'Polje mora biti tekst.',
                            str_contains($error, 'validation.numeric') => 'Polje mora biti broj.',
                            str_contains($error, 'validation.phone') => 'Unesite validan broj telefona.',
                            str_contains($error, 'role') => 'Odaberite validnu ovlast.',
                            str_contains($error, 'password') => 'Problem sa lozinkom.',
                            str_contains($error, 'auth.failed') => 'Netačni podaci.',
                            default => $error,
                        };
                    @endphp
                    {{ $translatedError }}
                </li>
            @endforeach
        </ul>
    </div>
@endif
