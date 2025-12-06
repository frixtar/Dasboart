<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-orange-50 to-amber-100 p-4">
        
        <div class="w-full max-w-md bg-white shadow-2xl rounded-2xl overflow-hidden">
            
            <div class="bg-gradient-to-r from-gray-700 to-gray-900 p-6 text-center">
                <svg class="w-12 h-12 text-orange-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path></svg>
                <h2 class="text-xl font-bold text-white">¿Olvidaste tu contraseña?</h2>
            </div>

            <div class="p-8">
                <p class="text-gray-600 text-sm mb-6 text-center">
                    No te preocupes. Indica tu correo electrónico y te enviaremos un enlace para restablecerla.
                </p>

                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <!-- Email -->
                    <div class="mb-6">
                        <label class="block text-gray-600 font-bold mb-2 text-xs uppercase tracking-wider">Correo Electrónico</label>
                        <input class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-orange-500 focus:ring-2 focus:ring-orange-200 outline-none bg-gray-50 transition"
                               type="email" name="email" :value="old('email')" required autofocus>
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-end mt-4 gap-4">
                         <a href="{{ route('login') }}" class="text-sm text-gray-500 hover:text-gray-900 font-bold">
                            Volver
                        </a>
                        
                        <button class="bg-orange-600 hover:bg-orange-700 text-white font-bold py-2 px-4 rounded-lg shadow-md transition">
                            Enviar Enlace
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>