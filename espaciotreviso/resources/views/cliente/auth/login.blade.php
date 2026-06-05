<!DOCTYPE html>
<html class="light" lang="es">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Treviso - Iniciar Sesion</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700;900&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        "primary": "#32a5d7",
                        "secondary": "#47bcea",
                        "accent": "#8e989e",
                        "background-light": "#f4f7f9",
                        "background-dark": "#111c21",
                    },
                    fontFamily: { "display": ["Inter", "sans-serif"] },
                },
            },
        }
    </script>
</head>
<body class="bg-background-light font-display">
    <div class="flex min-h-screen items-center justify-center p-4">
        <div class="grid grid-cols-1 md:grid-cols-2 max-w-5xl w-full bg-white shadow-xl rounded-xl overflow-hidden">
            <div class="flex flex-col justify-center p-8 sm:p-12 lg:p-16">
                <div class="w-full max-w-md mx-auto">
                    <div class="flex items-center gap-4 text-gray-900 mb-8 justify-center">
                        <div class="size-8 text-primary">
                            <svg fill="none" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
                                <path d="M24 45.8096C19.6865 45.8096 15.4698 44.5305 11.8832 42.134C8.29667 39.7376 5.50128 36.3314 3.85056 32.3462C2.19985 28.361 1.76794 23.9758 2.60947 19.7452C3.451 15.5145 5.52816 11.6284 8.57829 8.5783C11.6284 5.52817 15.5145 3.45101 19.7452 2.60948C23.9758 1.76795 28.361 2.19986 32.3462 3.85057C36.3314 5.50129 39.7376 8.29668 42.134 11.8833C44.5305 15.4698 45.8096 19.6865 45.8096 24L24 24L24 45.8096Z" fill="currentColor"></path>
                            </svg>
                        </div>
                        <h2 class="text-2xl font-bold tracking-tight">Treviso</h2>
                    </div>
                    <div class="text-center mb-8">
                        <h1 class="text-2xl font-bold text-gray-900">Bienvenido</h1>
                        <p class="text-accent mt-2">Accede a tu portal de facturas</p>
                    </div>

                    <form method="POST" action="{{ route('cliente.login.post') }}" class="space-y-6">
                        @csrf
                        @if ($errors->any())
                            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg">
                                <span>{{ $errors->first() }}</span>
                            </div>
                        @endif

                        <label class="flex flex-col">
                            <p class="text-gray-900 text-sm font-medium pb-2">Correo Electronico</p>
                            <input name="email" type="email" required autofocus class="form-input rounded-lg text-gray-900 border border-gray-300 bg-background-light focus:border-primary focus:ring-2 focus:ring-primary/50 h-12 p-3 text-base" placeholder="tu@email.com" value="{{ old('email') }}"/>
                        </label>

                        <label class="flex flex-col">
                            <p class="text-gray-900 text-sm font-medium pb-2">Contrasena</p>
                            <input name="password" required type="password" class="form-input rounded-lg text-gray-900 border border-gray-300 bg-background-light focus:border-primary focus:ring-2 focus:ring-primary/50 h-12 p-3 text-base" placeholder="Tu contrasena"/>
                        </label>

                        <button type="submit" class="flex w-full items-center justify-center rounded-lg h-12 px-5 bg-primary text-white text-base font-bold hover:bg-secondary transition-colors">
                            Iniciar Sesion
                        </button>
                    </form>

                    <p class="text-center text-sm text-accent mt-6">
                        <a href="{{ route('admin.login') }}" class="text-primary hover:text-secondary font-medium">Acceso administrador</a>
                    </p>
                </div>
            </div>
            <div class="hidden md:flex flex-col items-center justify-center p-12 bg-gradient-to-br from-primary to-secondary">
                <div class="text-center text-white">
                    <h1 class="text-4xl font-black leading-tight">Simplificando tus finanzas.</h1>
                    <h2 class="text-4xl font-black leading-tight mt-1">Potenciando tu futuro.</h2>
                    <p class="mt-4 max-w-sm mx-auto text-lg font-light opacity-90">Tu portal de consulta de facturas y situacion fiscal.</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
