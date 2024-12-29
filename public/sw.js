self.addEventListener('push', function(event) {
    console.log('Push received:', event);

    if (event.data) {
        let data = event.data.json();
        console.log('Push data:', data);

        const options = {
            body: data.body,
            icon: 'favicon.png',
            data: data.data,
            actions: data.actions,
            vibrate: [100, 50, 100]
        };

        event.waitUntil(
            self.registration.showNotification(data.title, options)
                .then(() => {
                    console.log('Notification shown successfully');
                })
                .catch(error => {
                    console.error('Error showing notification:', error);
                })
        );
    }
});
