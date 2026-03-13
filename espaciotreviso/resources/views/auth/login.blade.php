<!DOCTYPE html>
<html class="light" lang="es">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Treviso - Iniciar Sesión</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700;900&amp;display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#32a5d7",
                        "secondary": "#47bcea",
                        "accent": "#8e989e",
                        "background-light": "#f4f7f9",
                        "background-dark": "#111c21",
                    },
                    fontFamily: {
                        "display": ["Inter", "sans-serif"]
                    },
                    borderRadius: {
                        "DEFAULT": "0.5rem",
                        "lg": "0.75rem",
                        "xl": "1rem",
                        "full": "9999px"
                    },
                },
            },
        }
    </script>
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24
        }
    </style>
</head>
<body class="bg-background-light dark:bg-background-dark font-display">
    <div class="relative flex min-h-screen w-full flex-col group/design-root overflow-x-hidden">
        <div class="flex-grow flex items-center justify-center p-4">
            <div class="grid grid-cols-1 md:grid-cols-2 max-w-6xl w-full mx-auto bg-white dark:bg-background-dark shadow-xl rounded-xl overflow-hidden">
                <!-- Left side: Login form -->
                <div class="flex flex-col justify-center p-8 sm:p-12 lg:p-16">
                    <div class="w-full max-w-md mx-auto">
                        <div class="flex items-center gap-4 text-[#0e161b] dark:text-white mb-8 justify-center">
                            <div class="size-8 text-primary">
                                <svg fill="none" viewbox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M24 45.8096C19.6865 45.8096 15.4698 44.5305 11.8832 42.134C8.29667 39.7376 5.50128 36.3314 3.85056 32.3462C2.19985 28.361 1.76794 23.9758 2.60947 19.7452C3.451 15.5145 5.52816 11.6284 8.57829 8.5783C11.6284 5.52817 15.5145 3.45101 19.7452 2.60948C23.9758 1.76795 28.361 2.19986 32.3462 3.85057C36.3314 5.50129 39.7376 8.29668 42.134 11.8833C44.5305 15.4698 45.8096 19.6865 45.8096 24L24 24L24 45.8096Z" fill="currentColor"></path>
                                </svg>
                            </div>
                            <h2 class="text-2xl font-bold tracking-tight">Treviso</h2>
                        </div>
                        <div class="text-center mb-8">
                            <h1 class="text-2xl font-bold text-[#0e161b] dark:text-white">Bienvenido de nuevo</h1>
                            <p class="text-accent mt-2">Inicia sesión en tu cuenta</p>
                        </div>
                        
                        <form method="POST" action="{{ route('login.post') }}" class="space-y-6">
                            @csrf
                            
                            @if ($errors->any())
                                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                                    <span class="block sm:inline">{{ $errors->first() }}</span>
                                </div>
                            @endif

                            <label class="flex flex-col">
                                <p class="text-[#0e161b] dark:text-gray-300 text-sm font-medium pb-2">Usuario / Correo Electrónico</p>
                                <input name="login" required autofocus class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-lg text-[#0e161b] dark:text-white focus:outline-0 focus:ring-2 focus:ring-primary/50 border border-gray-300 dark:border-gray-600 bg-background-light dark:bg-gray-800 focus:border-primary h-12 placeholder:text-accent p-3 text-base font-normal" placeholder="Tu usuario o email" value="{{ old('login') }}"/>
                            </label>
                            
                            <label class="flex flex-col">
                                <p class="text-[#0e161b] dark:text-gray-300 text-sm font-medium pb-2">Contraseña</p>
                                <div class="flex w-full flex-1 items-stretch rounded-lg">
                                    <input name="password" required class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-lg text-[#0e161b] dark:text-white focus:outline-0 focus:ring-2 focus:ring-primary/50 border border-gray-300 dark:border-gray-600 bg-background-light dark:bg-gray-800 focus:border-primary h-12 placeholder:text-accent p-3 rounded-r-none border-r-0 pr-2 text-base font-normal" placeholder="Introduce tu contraseña" type="password" value=""/>
                                    <div class="text-accent flex border border-gray-300 dark:border-gray-600 bg-background-light dark:bg-gray-800 items-center justify-center pr-3 rounded-r-lg border-l-0">
                                        <span class="material-symbols-outlined cursor-pointer">visibility</span>
                                    </div>
                                </div>
                            </label>
                            
                            <div class="flex items-center justify-between">
                                <div></div>
                                <a class="text-sm font-medium text-primary hover:text-secondary" href="#">¿Olvidaste tu contraseña?</a>
                            </div>
                            
                            <button type="submit" class="flex w-full min-w-[84px] cursor-pointer items-center justify-center overflow-hidden rounded-lg h-12 px-5 bg-primary text-white text-base font-bold tracking-wide hover:bg-secondary transition-colors duration-300">
                                <span class="truncate">Iniciar Sesión</span>
                            </button>
                        </form>
                        
                    </div>
                </div>
                <!-- Right side: Image and Slogan -->
                <div class="hidden md:flex flex-col items-center justify-center p-12 bg-cover bg-center" data-alt="Oficina moderna con gráficos financieros y una calculadora." style='background-image: linear-gradient(to top, rgba(50, 165, 215, 0.8) 0%, rgba(71, 188, 234, 0.5) 100%), url("https://lh3.googleusercontent.com/aida-public/AB6AXuDJhWPkiD9QLJWn2AETwL0f-fQC-Dh2n5wBK-PHYkMAbrok7uvzklrmk8gnaPdtL4T0sNrtpjcxcJyKrptMb_LuUNtknvQvG0g_aaVTpYRhVuyMY2XSfpKIemYV8TZLRfk2Lwo3XbozrsGMAMZAiseqCp-Tgwem7s9RIZZZBRu6ohtJefTithjwYPiuZL1vafmYSYhTnbh47XGOkPNbqOa3YKZrCAe4e61kzXZJLVdAxQ4OFkeM9rCmSIatnnBvtfiWHboIXt74Wnwi");'>
                    <div class="text-center text-white">
                        <h1 class="text-4xl font-black leading-tight tracking-tight">
                            Simplificando tus finanzas.
                        </h1>
                        <h2 class="text-4xl font-black leading-tight tracking-tight mt-1">
                            Potenciando tu futuro.
                        </h2>
                        <p class="mt-4 max-w-sm mx-auto text-lg font-light">
                            Tu solución integral para la gestión financiera y contable.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
