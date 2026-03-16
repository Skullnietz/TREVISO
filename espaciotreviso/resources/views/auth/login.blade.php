<!DOCTYPE html>
<html lang="es" id="htmlRoot" class="dark">
<head>
  <meta charset="utf-8"/>
  <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
  <title>Treviso — Iniciar Sesión</title>
  <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700;900&display=swap" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>
  <script>
    tailwind.config = {
      darkMode: "class",
      theme: {
        extend: {
          colors: {
            primary:         "#32a5d7",
            "primary-hover": "#47bcea",
            accent:          "#8e989e",
            "dk-bg":         "#111c21",
            "dk-surface":    "#1a2428",
            "dk-border":     "#2d3f47",
            "dk-input":      "#243038",
            "dk-text":       "#F8F9FA",
            "lt-bg":         "#f1f5f9",
            "lt-surface":    "#ffffff",
            "lt-border":     "#e2e8f0",
            "lt-input":      "#f1f5f9",
            "lt-text":       "#1e293b",
          },
          fontFamily: { display: ["Inter","sans-serif"] },
        },
      },
    };
  </script>
  <style>
    .material-symbols-outlined { font-variation-settings:'FILL' 0,'wght' 400,'GRAD' 0,'opsz' 24 }
  </style>
  {{-- Aplica tema antes del primer render para evitar flash --}}
  <script>
    (function () {
      var dark = localStorage.getItem('theme') !== 'light';
      document.getElementById('htmlRoot').classList.toggle('dark', dark);
    })();
  </script>
</head>
<body class="bg-lt-bg dark:bg-dk-bg font-display transition-colors duration-200">

{{-- ── Toggle de tema (esquina superior derecha) ──────────────── --}}
<div class="fixed top-4 right-4 z-50">
  <button onclick="toggleTheme()" title="Cambiar tema"
          class="flex items-center justify-center w-9 h-9 rounded-xl
                 bg-lt-surface border border-lt-border text-accent
                 dark:bg-dk-surface dark:border-dk-border
                 hover:text-primary transition-colors shadow-md">
    <span class="material-symbols-outlined text-[20px]" id="themeIcon">light_mode</span>
  </button>
</div>

<div class="flex min-h-screen w-full items-center justify-center p-4">
  <div class="grid grid-cols-1 md:grid-cols-2 max-w-5xl w-full mx-auto
              bg-lt-surface dark:bg-dk-surface
              shadow-2xl rounded-2xl overflow-hidden
              border border-lt-border dark:border-dk-border">

    {{-- ── IZQUIERDA: formulario ──────────────────────────────── --}}
    <div class="flex flex-col justify-center p-8 sm:p-12">
      <div class="w-full max-w-sm mx-auto">

        {{-- Logo --}}
        <div class="flex justify-center mb-8">
          <span class="inline-flex items-center rounded-xl px-4 py-2
                       bg-[#1e7ea1] dark:bg-transparent transition-colors duration-200">
            <img src="{{ asset('img/logo_treviso.png') }}" alt="Treviso"
                 class="h-9 w-auto object-contain">
          </span>
        </div>

        <div class="text-center mb-8">
          <h1 class="text-2xl font-bold text-lt-text dark:text-dk-text">Bienvenido de nuevo</h1>
          <p class="text-accent mt-1.5 text-sm">Inicia sesión en tu cuenta</p>
        </div>

        {{-- Errores --}}
        @if($errors->any())
          <div class="mb-5 flex items-center gap-2 rounded-lg bg-red-50 border border-red-200 p-3
                      text-sm text-red-700 dark:bg-red-900/20 dark:border-red-800 dark:text-red-400">
            <span class="material-symbols-outlined text-[18px] flex-shrink-0">error</span>
            {{ $errors->first() }}
          </div>
        @endif

        <form method="POST" action="{{ route('login.post') }}" class="space-y-5">
          @csrf

          {{-- Usuario --}}
          <label class="flex flex-col gap-1.5">
            <span class="text-sm font-medium text-lt-text dark:text-dk-text">Usuario</span>
            <input
              type="text"
              name="login"
              value="{{ old('login') }}"
              autofocus
              required
              placeholder="Ingresa tu usuario"
              class="form-input w-full rounded-lg h-11 px-3 text-sm
                     bg-lt-input border border-lt-border text-lt-text placeholder:text-accent
                     dark:bg-dk-input dark:border-dk-border dark:text-dk-text
                     focus:outline-none focus:ring-2 focus:ring-primary/40 focus:border-primary
                     transition-colors"
            />
          </label>

          {{-- Contraseña --}}
          <label class="flex flex-col gap-1.5">
            <span class="text-sm font-medium text-lt-text dark:text-dk-text">Contraseña</span>
            <div class="flex rounded-lg overflow-hidden border border-lt-border dark:border-dk-border
                        focus-within:ring-2 focus-within:ring-primary/40 focus-within:border-primary transition-colors">
              <input
                id="password-input"
                type="password"
                name="password"
                required
                placeholder="Introduce tu contraseña"
                class="form-input flex-1 h-11 px-3 text-sm border-0 ring-0 rounded-none
                       bg-lt-input text-lt-text placeholder:text-accent
                       dark:bg-dk-input dark:text-dk-text
                       focus:outline-none focus:ring-0"
              />
              <button type="button" onclick="togglePass()"
                      class="px-3 text-accent hover:text-primary
                             bg-lt-input dark:bg-dk-input transition-colors">
                <span id="eye-icon" class="material-symbols-outlined text-[20px]">visibility</span>
              </button>
            </div>
          </label>

          <button
            type="submit"
            class="w-full h-11 rounded-lg bg-primary hover:bg-primary-hover
                   text-white text-sm font-bold tracking-wide
                   transition-colors duration-200 flex items-center justify-center gap-2"
          >
            <span class="material-symbols-outlined text-[18px]">login</span>
            Iniciar Sesión
          </button>
        </form>

      </div>
    </div>

    {{-- ── DERECHA: imagen decorativa ─────────────────────────── --}}
    <div
      class="hidden md:flex flex-col items-center justify-center p-12 bg-cover bg-center relative"
      style='background-image: linear-gradient(to top, rgba(17,28,33,0.92) 0%, rgba(50,165,215,0.7) 100%), url("https://lh3.googleusercontent.com/aida-public/AB6AXuDJhWPkiD9QLJWn2AETwL0f-fQC-Dh2n5wBK-PHYkMAbrok7uvzklrmk8gnaPdtL4T0sNrtpjcxcJyKrptMb_LuUNtknvQvG0g_aaVTpYRhVuyMY2XSfpKIemYV8TZLRfk2Lwo3XbozrsGMAMZAiseqCp-Tgwem7s9RIZZZBRu6ohtJefTithjwYPiuZL1vafmYSYhTnbh47XGOkPNbqOa3YKZrCAe4e61kzXZJLVdAxQ4OFkeM9rCmSIatnnBvtfiWHboIXt74Wnwi");'
    >
      <div class="text-center text-white">
        <h2 class="text-3xl font-black leading-tight tracking-tight">
          Simplificando tus finanzas.
        </h2>
        <h2 class="text-3xl font-black leading-tight tracking-tight mt-1">
          Potenciando tu futuro.
        </h2>
        <p class="mt-4 max-w-xs mx-auto text-base font-light text-white/80">
          Tu solución integral para la gestión financiera y contable.
        </p>
      </div>
    </div>

  </div>
</div>

<script>
  function togglePass() {
    var inp  = document.getElementById('password-input');
    var icon = document.getElementById('eye-icon');
    if (inp.type === 'password') { inp.type = 'text';     icon.textContent = 'visibility_off'; }
    else                         { inp.type = 'password'; icon.textContent = 'visibility'; }
  }

  function applyTheme(dark) {
    var html = document.getElementById('htmlRoot');
    var icon = document.getElementById('themeIcon');
    html.classList.toggle('dark', dark);
    if (icon) icon.textContent = dark ? 'light_mode' : 'dark_mode';
  }

  function toggleTheme() {
    var isDark = document.getElementById('htmlRoot').classList.contains('dark');
    localStorage.setItem('theme', isDark ? 'light' : 'dark');
    applyTheme(!isDark);
  }

  // Sincronizar icono al cargar
  (function () {
    var dark = localStorage.getItem('theme') !== 'light';
    applyTheme(dark);
  })();
</script>
</body>
</html>
