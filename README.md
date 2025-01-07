# Centus Test Task
This is a test task for job application at Centus.

## Technical requirements

> _Create a service that notifies users about specific weather conditions through a variety of
channels (email, plus one more of your choice). The alerts will focus on two specific weather
anomalies: high levels of precipitation and high UV index values._

### Tier 1
| **Requirement**                                     | Status          | Comment           |
|-----------------------------------------------------|-----------------|-----------------------|
| User can use your web-app to be notified via email  | ✅ | Via email and webpush |
| Covered with tests                                  | ✅ |                       |
| One-button docker setup (e.g. Sail-powered : D)     | ✅ | DDEV                  |

### Tier 2
| **Requirement**                           | Status          | Comment                                                     |
|-------------------------------------------|-----------------|-----------------------------------------------------------------|
| Auth/profile/etc. (e.g. Jetstream : D)    | ✅ | Jetsream and Livewire                                           |
| Custom threshold values for notifications | ✅ | \>= configuration is possible                                   |
| Notifications for multiple cities         | ✅ | User can multiple notifications for different cities and values |

### Tier 3
| **Requirement**                           | Status         | Comment                                                 |
|-------------------------------------------|----------------|---------------------------------------------------------|
| Take averages from multiple weather services    | ❌ | I've used only one self implemented fake weather service |
| Pause for X hours. | ✅ | It is possible to pause/resume receiving the alert      |
| Visually cohesive looking (not custom, just cohesive)         | ✅ | TaildwindCSS Livewire based components are used         |


## Outline

The following technologies and libraries were used in this project:

| **Technology**                            |                                 |
|-------------------------------------------|---------------------------------|
| **DDEV**                                  | Local environment container     |
| **Laravel 11**                            | Framework                       |
| **MariaDB**                               | Database                        |
| **Redis**                                 | Cache and queues                |
| **Jetstream & Livewire**                  | Auth/login + frontend templates |
| **Laravel Horizon**                       | Queue worker / status checking  |
| **laravel-notification-channels/webpush** | Laravel library for webpush     |

## Installation

1. _(Skip if already have DDEV installed)_ Install DDEV: https://ddev.readthedocs.io/en/stable/.
2. Start Docker daemon.
3. Go to the root of the project and execute the following commands:
```bash

# Start the project
ddev start

# Install dependencies
ddev composer update

# Run database migrations
ddev artisan migrate

# Seed the database locations table
ddev artisan db:seed

# Copy the .env file
cp .env.example .env

# Set the application key
ddev artisan key:generate

# Generate the VAPID keys
ddev artisan webpush:vapid

# Install JS dependencies
npm install

# Build the frontend
npm run build
```

## Bootstrapping
Run Laravel Horizon in a separate terminal tab and don't close it. This is required to process the queued jobs.
```bash
ddev artisan horizon
```

Open the browser and go to the following URL: http://centus-test-task.ddev.site, or use the following command.
```bash
ddev launch
```

## Commands
There are two commands available to test the notification system. Both of them require Laravel Horizon to be running.

### `WeatherUpdatePushCommand`
Makes a force push of a weather update with desired values. Users will be notified if the conditions are met.
```bash
ddev artisan centus:weather-update:push --location=London --uv=1 --precipitation=90 --temperature=22
```

### `WeatherUpdateWorkerCommand`
This is the worker command that triggers the `WeatherService`. It checks all the weather alert sunscriptions of all the users, checks the weather in a remote API weather service and sends notifications to the users.

If this was a real-world application this command would've been running in a cron job for every X minutes / hours.
```bash
ddev artisan centus:weather-update:worker
```

## Usage
1. Register a new user.
2. Login.
3. (Optional) Enable push notifications in the browser if this is your desired channel for receiving weather alerts.
4. (Optional) Run `ddev launch -m` to open  the Mailpit mailer if you want to see the email notifications.
4. Subscribe to a weather alert via the form.
5. Run the `WeatherUpdateWorkerCommand` command to test the notification system with randomly generated values.
6. (Optional) Run the `WeatherUpdatePushCommand` command to test the notification system with custom values.


