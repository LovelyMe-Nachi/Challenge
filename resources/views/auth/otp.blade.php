<x-layout> 
    <x-slot name="title">Verify OTP</x-slot>
    <section class="form-container">
        <form action="{{ route('otp.verify') }}" method="POST">
            @csrf
            @method('POST')

            <h2>Verify OTP</h2>

            <x-inputs.text
                label="Enter Email"
                name="email"
                type="email"
                {{-- value="{{ old('email', $user->email) }}" --}}
                required
            />

            <x-inputs.text
                label="Enter OTP"
                name="otp"
                type="num"  
                required
            />

            <div class="form-group">
                <em class="confirm">Expired? <a href="{{ route('auth.email') }}">Click here to get new OTP </a></em>
            </div>

            <button type="submit">Verify Email</button>
        </form>

    </section>
</x-layout>