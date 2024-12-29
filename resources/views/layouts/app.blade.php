<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ strtoupper(config('app.name')) }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Styles -->
        @livewireStyles
    </head>
    <body class="font-sans antialiased">
        <x-banner />

        <div class="min-h-screen bg-gray-100">
            @livewire('navigation-menu')

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

        @stack('modals')

        @livewireScripts

        <script>
            console.log(Notification.permission, 'Current permission state');

            const enablePushNotificationsButton = document.getElementById('enable-push-notifications-button');
            if (Notification.permission === 'granted') {
                enablePushNotificationsButton.classList.add('hidden');
            } else {
                enablePushNotificationsButton.classList.remove('hidden');
            }

            enablePushNotificationsButton.addEventListener('click', async () => {
                enablePushNotificationsButton.classList.add('hidden');
                try {
                    console.log('Requesting permission to enable push notifications...');
                    const permission = await Notification.requestPermission();
                    console.log('Permission:', permission);

                    if (permission === 'granted') {
                        const registration = await navigator.serviceWorker.ready;
                        const subscription = await registration.pushManager.subscribe({
                            userVisibleOnly: true,
                            applicationServerKey: "{{ config('webpush.vapid.public_key') }}"
                        });

                        console.log('Push subscription:', subscription);

                        await axios.post('/push-subscription', {
                            subscription: subscription.toJSON()
                        });

                        enablePushNotificationsButton.classList.add('hidden');
                        Notification.requestPermission().then(permission => {
                            if (permission === 'granted') {
                                new Notification('Hooray!', {
                                    body: 'You have enabled push notifications.',
                                    icon: 'favicon.png'
                                });
                                console.log('Push notifications enabled.');
                            } else {
                                console.log('Push notifications denied.');
                            }
                        });
                    } else {
                        enablePushNotificationsButton.classList.remove('hidden');
                    }
                } catch (error) {
                    enablePushNotificationsButton.classList.remove('hidden');
                    console.error('Error:', error);
                    alert('Error enabling push notifications: ' + error.message);
                }
            });


            if ('serviceWorker' in navigator && 'PushManager' in window) {
                console.log('Service Worker and Push are supported');

                window.addEventListener('load', async function() {
                    try {
                        console.log('Registering service worker...');
                        const registration = await navigator.serviceWorker.register('/sw.js');
                        console.log('ServiceWorker registration successful:', registration);

                        const permission = await Notification.requestPermission();
                        console.log('Notification permission:', permission);

                        if (permission === 'granted') {
                            const subscription = await registration.pushManager.subscribe({
                                userVisibleOnly: true,
                                applicationServerKey: "{{ config('webpush.vapid.public_key') }}"
                            });
                            console.log('Push subscription:', subscription);

                            // Send subscription to server
                            await axios.post('/push-subscription', {
                                subscription: subscription.toJSON()
                            });
                            console.log('Subscription sent to server');
                        }
                    } catch (error) {
                        console.error('Service Worker registration failed:', error);
                    }
                });
            } else {
                console.warn('Push messaging is not supported');
            }
        </script>

    </body>
</html>
