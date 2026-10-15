<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Login') - Sertifikasi Peserta</title>
    <!-- Offline Tailwind CSS & Lucide Icons -->
    <script src="{{ asset('vendor/tailwindcss/tailwindcss.js') }}"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        slate: {
                            750: '#293548',
                        }
                    }
                }
            }
        }
    </script>
    <script src="{{ asset('vendor/lucide/lucide.min.js') }}"></script>
</head>
<body class="h-full bg-slate-100 dark:bg-slate-900 text-slate-800 dark:text-slate-100 font-sans antialiased flex flex-col justify-between">
    <div class="min-h-full flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8 bg-white dark:bg-slate-800 p-8 rounded-xl shadow-lg border border-slate-200 dark:border-slate-700">
            @yield('content')
        </div>
    </div>
    <script>
        lucide.createIcons();
    </script>
</body>
</html>
