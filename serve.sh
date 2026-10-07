#!/bin/sh
# Run visualHUD locally with PHP's built-in web server.
# Requires PHP 7.4+ with the zip extension.
#
#   ./serve.sh              # http://localhost:8000
#   PORT=9000 ./serve.sh    # http://localhost:9000
#
# The HUD templates use short open tags (<? ... ?>), so they are enabled here.
cd "$(dirname "$0")" || exit 1

HOST="${HOST:-127.0.0.1}"
PORT="${PORT:-8000}"

echo "visualHUD: http://localhost:$PORT/"
exec php \
  -d short_open_tag=On \
  -d display_errors=stderr \
  -d error_reporting="E_ALL & ~E_DEPRECATED & ~E_WARNING & ~E_NOTICE" \
  -S "$HOST:$PORT" -t .
