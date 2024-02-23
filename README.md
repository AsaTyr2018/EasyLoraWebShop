# Generative AI Control Panel

The Generative AI Control Panel is a sophisticated Flask-based web application designed to manage and monitor services for Generative AIs like A1111, Fooocus, and Kohya. This tool enables easy control over AI services, including starting, stopping, and monitoring through an intuitive web interface. 
Designed to run on Linux dedicated Servers.

Tested OS: Ubuntu 22.04.3 LTS

## Features

- **Service Management**: Start, stop, and restart AI services seamlessly.
- **Log Aggregation**: Centralize bash logs for easy access and troubleshooting.
- **Real-Time Monitoring**: Watch service logs in real-time with Flask-SocketIO.
- **Gunicorn Integration**: Ensures smooth operation in production environments.

## Getting Started

### Prerequisites

- Python 3.6+
- Flask
- Flask-SocketIO
- Gunicorn
- Tailer

### Installation

1. Clone this repository to your machine.
2. Install dependencies:
   ```
   pip install Flask Flask-SocketIO gunicorn tailer
   ```
3. Set up `sudo_password` in `server.py` to enable service control commands. (Currently just a workaround. Never enter your Sudo Password in a python app/config!)

### Deployment

For development purposes, run the Flask app directly:
```
python server.py
```

## Service Configuration for AI Services and Flask Application

To manage both AI services and the Flask application, you will create systemd service files. Below are generalized examples for an AI service (e.g., Kohya) and the Flask application served by Gunicorn.

### AI Service Configuration Example

```ini
[Unit]
Description=Generic AI Service

[Service]
ExecStart=/path/to/ai_service/start_script.sh --options
User=genericuser
Restart=always
RestartSec=3
StandardOutput=append:/path/to/logs/ai_service.log
StandardError=append:/path/to/logs/ai_service_error.log

[Install]
WantedBy=multi-user.target
```

### Flask Application Service Configuration Example

```ini
[Unit]
Description=Gunicorn instance to serve Flask app
After=network.target

[Service]
User=genericuser
Group=genericgroup
WorkingDirectory=/path/to/flaskapp
ExecStart=/path/to/gunicorn -k eventlet -w 1 wsgi:app --bind 0.0.0.0:5000

[Install]
WantedBy=multi-user.target
```

### Adjustments

- Replace `/path/to/ai_service/start_script.sh`, `/path/to/logs/`, `/path/to/flaskapp`, and `/path/to/gunicorn` with the actual paths relevant to your project.
- Change `genericuser` and `genericgroup` to neutral user/group names suited for your deployment environment.

### Enabling and Starting Services

To enable and start each service:

```bash
sudo systemctl enable service_name.service
sudo systemctl start service_name.service
```

Replace `service_name.service` with the name of your service file (e.g., `ai_service.service` or `flaskapp.service`).

## Usage

- Access the web interface at `http://localhost:5000` (or your configured host and port).
- Control AI services directly from the dashboard.
- View and monitor real-time logs for active services.

## Acknowledgments

- Flask and Flask-SocketIO for backend and real-time communication.
- Gunicorn for production server deployment.
- The AI community for continuous inspiration.