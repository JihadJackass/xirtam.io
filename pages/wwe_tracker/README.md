# Matchbook

*Card subject to change.*

A WWE watch ledger. Every Raw, SmackDown, NXT and pay-per-view since 1985 —
around 8,500 episodes — generated from each show's broadcast history rather than
stored as a list. Tick what you've seen, search by wrestler, follow a rivalry
from first promo to blow-off.

One HTML file. No build step, no dependencies, no server.

---

## Putting it online

Upload `index.html`, then Settings → Pages → Deploy from a branch → `main` →
`/ (root)`.

`index.html` is the document a web server returns for a bare directory URL, so
named that the app answers at `yoursite.github.io/repo/`. Rename it if you'd
rather it lived elsewhere — nothing inside depends on the filename.

Keep `.nojekyll` so GitHub serves the file untouched.

**Host it even if you're the only user.** Opening the file by double-clicking
gives you a `file://` page, which browsers treat as an untrusted origin: Web
Crypto is restricted and storage is unreliable. Over HTTPS everything behaves.

---

## Signing in

Profiles exist so two people sharing a browser get separate ledgers. Pick an ID
of four to six letters and numbers, like `L22A1`.

Your ledger is encrypted with **AES-256-GCM** under a key stretched from your
password with **PBKDF2**, 180,000 rounds of SHA-256. The password is never
stored, not even hashed — a wrong one derives a different key and the
authentication tag fails. That's what "sign in failed" means here.

Ticking **Keep me signed in** wraps that key with a device key held in
IndexedDB and marked non-extractable, so scripts can't read it out. Copying
your browser storage to another machine gets an attacker nothing.

**There is no password reset.** No server holds a copy. Take
Data → **Download recovery key** before you need it, and treat that file as
carefully as the password itself.

---

## Filling in the data

The catalogue is *generated* — dates come from each show's broadcast history,
not from a database. That gets the shape right and the details wrong, so three
importers fix it. All of them are in the **Data** tab.

### Weekly episodes — TVmaze

**No account, no API key.** Press *Import Raw*, *Import SmackDown* or
*Import NXT*. One request returns every episode of the show: air dates, titles,
recap text and stills. This is the same source Plex uses.

TMDB is available as an alternative under *Use TMDB instead*, but it needs a
free key. If their signup returns a CloudFront 403, that's their bot protection
and nothing this app can route around — use TVmaze.

**Reconciliation.** The importer also reports episodes this app generated that
the source has no record of, and episodes the source lists that were never
generated. Applying it is opt-in, never hides anything you've marked watched,
and is undoable. This is the proper fix for numbering drift.

### Event cards — Wikipedia

*Fill in all events* reads the results table out of each pay-per-view article's
source and writes the full card, plus the description and the real date.

Wikipedia is excellent for events and nearly useless for weekly television.
TVmaze is the reverse. Between them the catalogue fills out.

The run is deliberately slow — roughly two requests per event with a backoff
that honours `Retry-After`. Anonymous clients get rate-limited hard otherwise.
If a run comes back thin, the log breaks down *why*: no article, wrong article,
no results table, or rate limited.

### Episode numbering — anchors

The generator assumes a weekly show never missed its slot. Raw did, often
enough to run **20 episodes ahead of reality by 2012**. Anchors pin numbering to
dates you know are right and spread the correction between them. Two are built
in; add more under Data → Episode numbering.

Where two weeks end up sharing a number, that row is marked **"Number approx."**
rather than inventing a confident wrong answer.

### Manual corrections

Data → *Add match cards* takes `show,date,title,card`:

```
event,2009-06-28,The Bash 2009,CM Punk vs Jeff Hardy World Heavyweight Title
```

Matching rows are corrected in place, new dates are added, and everything in the
card column becomes searchable.

---

## Data files in this repo

Optional. The app works without them, and they load for every profile on every
device — version-controlled rather than trapped in one browser.

| File | Holds |
|---|---|
| `data/catalogue.json` | Episode corrections: `show`, `date`, `title`, `card`, `description` |
| `data/feuds.json` | Rivalries: `who[]`, `from`, `to`, `shows[]`, `note` |
| `data/anchors.json` | Numbering anchors: `show`, `num`, `date` |

Data → **Export corrections** writes `catalogue.json` from whatever you've
already fixed by hand.

---

## What it does

**Ledger** — every episode in broadcast order. Click the tick to mark watched;
click anywhere else to open the episode inline with its card, description,
still, rating and notes. Star things, queue them, or mark them *not interested*
so they leave your completion percentage.

**Search** — understands wrestlers, not just titles. `cm punk vs jeff hardy`
intersects their roster tenures and narrows to the window a match was possible
in. Nicknames and old ring names resolve (`hbk`, `taker`, `prince devitt`), and
ambiguous surnames offer both (`hardy` → Jeff or Matt). Add a year to narrow it.

**On Now** — what's airing, with a live countdown, converted from US Eastern to
your timezone including daylight saving. Projected about six months ahead.

**Roster** — 329 wrestlers back to Bruno Sammartino in 1963, filterable by
Hall of Fame, active, passed, or era. Each has tenure, the episodes that aired
during their run, how many you've watched, and their rivalries. Portraits and
biographies come from Wikipedia, fetched automatically.

**Rivalries** — 64 seeded storylines. Open one for every episode inside it,
add the lot to your watchlist, or spotlight them inside the full ledger.

**Binge mode** — one episode, full screen. Space to tick, R to reroll, N for
not interested.

**Stats** — completion by decade, hours watched and remaining, your pace over
the last 30 and 90 days, longest streak, and a projected finish date.

Sixteen themes. Widescreen. Choose which tab opens first.

---

## Moving between devices

Storage is per browser and per origin, so your phone starts empty and the
hosted copy is separate from any local one.

Data → **Copy transfer code** on one device, paste and apply on the other.
Carries ticks, ratings, cards, portraits and watchlist. Or use
**Download backup** for a file.

---

## Known limits

- **Weekly match cards don't exist in any free source.** Wikipedia has events;
  TVmaze and TMDB have episode metadata but never "X defeated Y". Only
  Cagematch has weekly cards, and it has no API and no CORS headers, so a
  browser cannot read it. That would need a local script writing to
  `data/catalogue.json`.
- Event dates other than WrestleMania start as estimates, marked **Est. date**
  until an importer confirms them.
- Roster tenures, Hall of Fame flags and dates of death were written from
  memory. The shape is right; individual months won't always be.
- Everything above is editable.

---

## Credits

Episode data from [TVmaze](https://www.tvmaze.com) and, optionally,
[TMDB](https://www.themoviedb.org). Event cards, biographies and portraits from
[Wikipedia](https://en.wikipedia.org), CC BY-SA.

This product uses the TMDB API but is not endorsed or certified by TMDB.

Not affiliated with WWE. Trademarks belong to their owners.
