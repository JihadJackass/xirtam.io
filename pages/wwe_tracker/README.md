# Card Subject to Change

A WWE watch ledger. Every Raw, SmackDown, NXT and pay-per-view since 1985,
generated from each show's broadcast history rather than stored as a list.
Tick what you've seen, search by wrestler, keep your own match cards.

## Putting it on GitHub Pages

1. Create a repository — public, since GitHub Pages needs that on free accounts.
2. Upload `index.html` and `.nojekyll` to the root.
3. Settings → Pages → Source: **Deploy from a branch** → `main` → `/ (root)` → Save.
4. Wait a minute. It appears at `https://YOURNAME.github.io/REPO/`.

That's the whole deployment. No build step, no dependencies, one file.

## Why hosting it beats opening the file directly

Opening `index.html` by double-clicking gives you a `file://` page, and Chrome
treats that as an untrusted origin. Web Crypto is restricted and localStorage is
unreliable, which is why the app warns you there. GitHub Pages serves over HTTPS,
so encryption and storage both behave normally. Host it even if you're the only
person who'll ever use it.

## Where your data lives

In your browser, not in the repository. Nothing you tick is ever uploaded.

- The ledger is encrypted with AES-256-GCM under a key stretched from your
  password with PBKDF2 (180,000 rounds, SHA-256).
- "Keep me signed in" wraps that key with a device key held in IndexedDB and
  marked non-extractable, so scripts can't read it out. Signing out erases it.
- The site being public means anyone can *visit*. They get an empty ledger.
  They cannot see yours.

## Moving between devices

There's no server, so there's no sync. Data is per-browser, per-origin — your
phone and your laptop are separate ledgers, and the local file is separate from
the hosted one.

Data → **Download backup** on one, **Restore from backup** on the other.

## If you forget your password

Nobody can reset it. There is no server holding a copy, and the password itself
is never stored. Data → **Download recovery key** before you need it, and keep
backups. The recovery key opens the profile without the password, so treat that
file exactly as carefully as the password.

## Corrections

The catalogue is generated, so it drifts. Pre-emptions and holiday shifts can
put a weekly episode a week out, and every pay-per-view date except WrestleMania
is an estimate, marked "Est. date" in the ledger.

Data → paste rows as `show,date,title,card`:

```
event,2009-06-28,The Bash 2009,CM Punk vs Jeff Hardy World Heavyweight Title
raw,2001-06-25,Raw Is War,Stone Cold beer bath
```

Matching rows get corrected in place; new dates get added. Everything in the
card column becomes searchable, which is what turns "cm punk vs jeff hardy"
from a 45-event shortlist into a single row.
