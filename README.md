# Live Demo
[https://namad.github.io/visualHUD/](https://namad.github.io/visualHUD/)

# Running locally

The editor is static HTML/JS. HUD downloads (`download.php`, `download_presets.php`)
need PHP 7.4+ with the `zip` extension.

```sh
./serve.sh               # http://localhost:8000
PORT=9000 ./serve.sh     # another port
```

`serve.sh` starts PHP's built-in server with short open tags enabled, which the
HUD templates in `templates/` require. To use Apache/nginx + PHP-FPM instead,
point the document root at this directory and set `short_open_tag = On`.

On Debian/Ubuntu: `sudo apt install php-cli php-zip`. On macOS: `brew install php`.

## Optional settings (environment variables)

| Variable | Purpose | Default |
| --- | --- | --- |
| `VHUD_TEMP_DIR` | Where generated zip files are written | `<system temp>/visualhud` |
| `VHUD_DB_HOST`, `VHUD_DB_USER`, `VHUD_DB_PASS`, `VHUD_DB_NAME` | MySQL for the "custom HUDs created" counter | counter disabled |

`index.html` is served as static HTML, so the number shown in the toolbar stays 0
even with a database configured; `get_counter.php` returns the stored value.
The counter table, if you want it:

```sql
CREATE TABLE downloads_count (`name` VARCHAR(32) PRIMARY KEY, `count` INT NOT NULL DEFAULT 0);
```

The Feedback form posts to `contact.php`, which is not part of this repository.

# Widescreen

Every HUD element has a **Widescreen → Anchor** setting, written to each `menuDef`
as Quake Live's `widescreen` keyword:

| Anchor | Value | Behaviour |
| --- | --- | --- |
| Left | `widescreen 1` | stays attached to the left edge |
| Center | `widescreen 2` | stays centered |
| Right | `widescreen 3` | stays attached to the right edge |
| Stretch | `widescreen 0` | old 4:3 behaviour, stretched across the screen |
| Auto (default) | — | picked from the element's position: full-width elements stretch, otherwise left/center/right third of the 640×480 grid |

HUDs saved before this setting existed use Auto. The editor canvas still shows the 4:3 layout.
