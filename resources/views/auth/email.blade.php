<x-layout> 
    <x-slot name="title">Verify Email</x-slot>
    <section class="form-container">
        <form action="{{ route('send.otp') }}" method="POST">
            @csrf
            @method('POST')

            <h2>Verify Email</h2>

            <x-inputs.text
                label="Enter Email"
                name="email"
                type="email"
                {{-- value="{{ old('email', $user->email) }}" --}}
                required
            />
            <button type="submit">Verify Email</button>
        </form>
    </section>
</x-layout>