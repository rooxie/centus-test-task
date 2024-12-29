# Centus Test Task
This is a test task for job application at Centus.

## Technical requirements

### Outline
> _Create a service that notifies users about specific weather conditions through a variety of
channels (email, plus one more of your choice). The alerts will focus on two specific weather
anomalies: high levels of precipitation and high UV index values._
> 
### Tier 1
| **Requirement**                                     | Status          | Description           |
|-----------------------------------------------------|-----------------|-----------------------|
| User can use your web-app to be notified via email  | ✅ | Via email and webpush |
| Covered with tests                                  | ❌ |                       |
| One-button docker setup (e.g. Sail-powered : D)     | ✅ | DDEV                  |

### Tier 2
| **Requirement**                           | Status          | Description                                                     |
|-------------------------------------------|-----------------|-----------------------------------------------------------------|
| Auth/profile/etc. (e.g. Jetstream : D)    | ✅ | Jetsream and Livewire                                           |
| Custom threshold values for notifications | ✅ | \>= configuration is possible                                   |
| Notifications for multiple cities         | ✅ | User can multiple notifications for different cities and values |

### Tier 3
| **Requirement**                           | Status         | Description                                             |
|-------------------------------------------|----------------|---------------------------------------------------------|
| Take averages from multiple weather services    | ❌ | I've used only one self implemented fake weather service |
| Pause for X hours. | ✅ | It is possible to pause/start receiving the alert       |
| Visually cohesive looking (not custom, just cohesive)         | ✅ | TaildwindCSS Livewire based components are used         |


## Installation

The project with the following technology stack:

| **Technology** |                   |
|----------|-------------------|
| **DDEV**     | Local environment |
| **Laravel**  | Framework         |
| **MySQL**    | Database          |
| **Redis**    | Cache and queues  |

### Installation

1. _(Skip if already have DDEV installed)_ Install DDEV: https://ddev.readthedocs.io/en/stable/.
2. Start Docker daemon.
3. Run `ddev start` in the project root.
4. Run `ddev composer update` in the project root.
5. Run `ddev composer reinitialize` for performing the database migrations and seeding.

