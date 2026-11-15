# Park & Joy – Natural Park Platform

Final combined project of the 2nd year of the TeSP in Programação de Sistemas de Informação (IPL), 2022/23.

*Park & Joy* is a platform for an amusement / natural park. It brings together the work of three courses in one system:

| Module | Course | Part of the project |
|--------|--------|---------------------|
| **AMSI** | Acesso Móvel a Sistemas de Informação | Android mobile app (`app/`) |
| **PLSI** | Plataformas de Sistemas de Informação | Web frontend, backoffice and REST API (`web_adv/`) |
| **SIS** | Serviços de Interoperabilidade de Sistemas | MQTT (Mosquitto) messaging between the web platform and the mobile app |

## Architecture

```
┌──────────────────┐   REST (JSON)   ┌───────────────────────────┐
│  Android app     │ ◄─────────────► │  Yii2 API  (web_adv/api)  │
│  (app/)          │                 └─────────────┬─────────────┘
│                  │                               │
│                  │   MQTT          ┌─────────────┴─────────────┐      ┌────────┐
│                  │ ◄────────────── │  Backend / Frontend (Yii2)│ ───► │ MySQL  │
└──────────────────┘ broker.emqx.io  └───────────────────────────┘      └────────┘
```

- The **backoffice** and **frontend** read and write the MySQL database `psi_park`.
- The **REST API** gives the mobile app access to the same data.
- When news is created, updated or deleted, the web platform publishes a JSON message over **MQTT** (`broker.emqx.io:1883`, topics `INSERT` / `UPDATE` / `DELETE`). The app subscribes to those topics and updates its local SQLite cache in real time.

## Features

**Web frontend (visitors)**
- Sign up / login and profile
- Browse activities and events, mark favourites, and join or leave activities
- Tickets, the park store and products, news, and reports/suggestions

**Backoffice (staff)**
- Role-based access (RBAC) for Admin and Manager
- Manage users, activities and activity types, events, tickets, store and products, news, and report topics

**Mobile app**
- Login / register, with the API server's IP set on the login screen
- Activities, events, favourites, tickets (with QR codes), store and products, news, reports, and user info
- Offline cache in SQLite and live news through MQTT

## Tech stack

- **Web:** PHP ≥ 7.4, Yii 2 Advanced template, Bootstrap 4, MySQL, phpMQTT, Codeception
- **Mobile:** Java, Android SDK 31 (min 21), Volley, Glide, Eclipse Paho MQTT, ZXing, SQLite

## Repository structure

```
NaturalPark/
├── web_adv/              # Yii2 application
│   ├── api/              #   REST API (module v1)
│   ├── backend/          #   Backoffice (+ mosquitto/phpMQTT.php)
│   ├── frontend/         #   Public website
│   ├── common/           #   Shared models and config
│   └── console/          #   Migrations (incl. RBAC)
├── app/                  # Android Studio project
├── psi_park.sql          # Database schema + sample data
└── psi_park_teste.sql    # Test database
```

## Setup

### Web platform

1. Install dependencies:
   ```bash
   cd web_adv
   composer install
   ```
2. Generate the local config files by running `php init` and choosing **Development**.
3. Run `psi_park.sql` on MySQL to create the `psi_park` database, then set the connection in `web_adv/common/config/main-local.php` (`mysql:host=localhost;dbname=psi_park`).
4. Serve `web_adv` from your local server (WAMP / XAMPP):
   - Frontend: `http://localhost/web_adv/frontend/web/`
   - Backend: `http://localhost/web_adv/backend/web/site/login`
   - API: expose `web_adv/api/web` on port **8081** (for example with an Apache virtual host), so it answers at `http://<IP>:8081/v1/...`.

### Mobile app

1. Open `app/` in **Android Studio** and let Gradle sync.
2. Run the app on an emulator or device that can reach the API machine.
3. On the login screen, set the IP of the machine serving the API.

## REST API overview (`/v1/...`)

`atividades`, `tipo-atividades`, `eventos` (`latest`, `{id}/atividades`), `novidades` (`latest`), `tickets` (`{id}/seccoes`, `{id}/remove`), `users` (`register`, `{id}/tickets`, `{id}/favoritos`, favourite and participation actions), `lojas` (`produtos`), `reports`, `topico-reports`, `participars`, `auths`.
