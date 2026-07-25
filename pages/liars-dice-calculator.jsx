import { useState, useMemo } from "react";

// Binomial coefficient
function comb(n, k) {
  if (k < 0 || k > n) return 0;
  if (k === 0 || k === n) return 1;
  let result = 1;
  for (let i = 0; i < Math.min(k, n - k); i++) {
    result = (result * (n - i)) / (i + 1);
  }
  return result;
}

// P(exactly k successes out of n trials, probability p each)
function binomialPMF(n, k, p) {
  return comb(n, k) * Math.pow(p, k) * Math.pow(1 - p, n - k);
}

// P(at least k successes)
function binomialCDF(n, k, p) {
  let prob = 0;
  for (let i = k; i <= n; i++) {
    prob += binomialPMF(n, i, p);
  }
  return prob;
}

function DiceFace({ value, size = 32 }) {
  const dots = {
    1: [[50, 50]],
    2: [[28, 28], [72, 72]],
    3: [[28, 28], [50, 50], [72, 72]],
    4: [[28, 28], [72, 28], [28, 72], [72, 72]],
    5: [[28, 28], [72, 28], [50, 50], [28, 72], [72, 72]],
    6: [[28, 28], [72, 28], [28, 50], [72, 50], [28, 72], [72, 72]],
  };
  const r = size < 28 ? 6 : 8;
  return (
    <svg width={size} height={size} viewBox="0 0 100 100">
      <rect x="2" y="2" width="96" height="96" rx="14" fill="#f5f0e1"
        stroke="#3a2a1a" strokeWidth="3" />
      {(dots[value] || []).map(([cx, cy], i) => (
        <circle key={i} cx={cx} cy={cy} r={r} fill="#3a2a1a" />
      ))}
    </svg>
  );
}

function ProbBar({ probability, label, highlight }) {
  const pct = (probability * 100).toFixed(1);
  const color =
    probability >= 0.7 ? "#4a7c3f" :
    probability >= 0.45 ? "#b5922d" :
    probability >= 0.25 ? "#b06a2a" : "#8b3a3a";

  return (
    <div style={{
      display: "flex", alignItems: "center", gap: 10, padding: "6px 0",
      opacity: highlight ? 1 : 0.55,
      transition: "opacity 0.2s"
    }}>
      <span style={{
        fontFamily: "'Rye', serif", fontSize: 13, color: "#e8dcc8",
        minWidth: 50, textAlign: "right"
      }}>{label}</span>
      <div style={{
        flex: 1, height: 22, background: "rgba(0,0,0,0.35)",
        borderRadius: 3, overflow: "hidden", position: "relative",
        border: "1px solid rgba(232,220,200,0.15)"
      }}>
        <div style={{
          width: `${Math.max(pct, 1)}%`, height: "100%", background: color,
          borderRadius: 3, transition: "width 0.4s ease",
          boxShadow: `inset 0 1px 0 rgba(255,255,255,0.15)`
        }} />
        <span style={{
          position: "absolute", right: 8, top: "50%", transform: "translateY(-50%)",
          fontFamily: "'Courier Prime', monospace", fontSize: 12, fontWeight: 700,
          color: "#e8dcc8", textShadow: "0 1px 2px rgba(0,0,0,0.8)"
        }}>{pct}%</span>
      </div>
    </div>
  );
}

export default function LiarsDiceCalculator() {
  const [totalPlayers, setTotalPlayers] = useState(4);
  const [dicePerPlayer, setDicePerPlayer] = useState([5, 5, 5, 5]);
  const [myDice, setMyDice] = useState([1, 3, 3, 5, 6]);
  const [bidQty, setBidQty] = useState(4);
  const [bidFace, setBidFace] = useState(3);
  const [onesWild, setOnesWild] = useState(true);
  const [showAdvanced, setShowAdvanced] = useState(false);

  const updatePlayers = (count) => {
    const c = Math.max(2, Math.min(6, count));
    setTotalPlayers(c);
    setDicePerPlayer((prev) => {
      const next = [...prev];
      while (next.length < c) next.push(5);
      return next.slice(0, c);
    });
    setMyDice((prev) => {
      const myCount = dicePerPlayer[0] || 5;
      return prev.slice(0, myCount);
    });
  };

  const updateMyDiceCount = (count) => {
    const c = Math.max(1, Math.min(5, count));
    setDicePerPlayer((prev) => {
      const next = [...prev];
      next[0] = c;
      return next;
    });
    setMyDice((prev) => {
      const next = [...prev];
      while (next.length < c) next.push(1);
      return next.slice(0, c);
    });
  };

  const updateOpponentDice = (idx, count) => {
    const c = Math.max(1, Math.min(5, count));
    setDicePerPlayer((prev) => {
      const next = [...prev];
      next[idx] = c;
      return next;
    });
  };

  const setDie = (idx, val) => {
    setMyDice((prev) => {
      const next = [...prev];
      next[idx] = val;
      return next;
    });
  };

  const totalDice = dicePerPlayer.slice(0, totalPlayers).reduce((a, b) => a + b, 0);
  const unknownDice = totalDice - dicePerPlayer[0];

  // Count how many of my dice match the bid face (including wilds)
  const myMatches = myDice.reduce((count, d) => {
    if (d === bidFace) return count + 1;
    if (onesWild && bidFace !== 1 && d === 1) return count + 1;
    return count;
  }, 0);

  // Probability for unknown dice
  // If bidding on 1s when 1s are wild, only 1/6 chance (just the 1 itself)
  // Otherwise with wilds: 2/6 = 1/3 (the face + the 1)
  // Without wilds: 1/6
  const p = bidFace === 1
    ? 1 / 6
    : onesWild
      ? 2 / 6
      : 1 / 6;

  const results = useMemo(() => {
    const needed = bidQty - myMatches;
    const res = [];
    for (let q = Math.max(1, bidQty - 3); q <= Math.min(totalDice, bidQty + 5); q++) {
      const need = q - myMatches;
      const prob = need <= 0 ? 1 : need > unknownDice ? 0 : binomialCDF(unknownDice, need, p);
      res.push({ qty: q, prob });
    }
    return res;
  }, [bidQty, myMatches, unknownDice, p, totalDice]);

  const exactBidProb = (() => {
    const need = bidQty - myMatches;
    if (need <= 0) return 1;
    if (need > unknownDice) return 0;
    return binomialCDF(unknownDice, need, p);
  })();

  const spotOnProb = (() => {
    const need = bidQty - myMatches;
    if (need < 0 || need > unknownDice) return 0;
    return binomialPMF(unknownDice, need, p);
  })();

  const verdictColor =
    exactBidProb >= 0.7 ? "#4a7c3f" :
    exactBidProb >= 0.45 ? "#b5922d" :
    exactBidProb >= 0.25 ? "#b06a2a" : "#8b3a3a";

  const verdict =
    exactBidProb >= 0.7 ? "Safe bet, partner" :
    exactBidProb >= 0.45 ? "Coin flip — risky" :
    exactBidProb >= 0.25 ? "Bluffin' territory" : "You're lyin' through your teeth";

  return (
    <div style={{
      fontFamily: "'Courier Prime', monospace",
      background: `
        radial-gradient(ellipse at 30% 20%, rgba(120,80,30,0.3) 0%, transparent 60%),
        radial-gradient(ellipse at 70% 80%, rgba(60,30,10,0.4) 0%, transparent 60%),
        linear-gradient(175deg, #2a1a0e 0%, #1a1008 40%, #0f0a05 100%)
      `,
      color: "#e8dcc8",
      minHeight: "100vh",
      padding: "24px 16px",
      position: "relative"
    }}>
      {/* Grain overlay */}
      <div style={{
        position: "fixed", inset: 0, pointerEvents: "none", opacity: 0.04,
        backgroundImage: `url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)'/%3E%3C/svg%3E")`,
        backgroundSize: "128px 128px"
      }} />

      <div style={{ maxWidth: 520, margin: "0 auto", position: "relative" }}>
        {/* Header */}
        <div style={{ textAlign: "center", marginBottom: 28 }}>
          <link href="https://fonts.googleapis.com/css2?family=Rye&family=Courier+Prime:wght@400;700&display=swap" rel="stylesheet" />
          <div style={{
            fontFamily: "'Rye', serif", fontSize: 11, letterSpacing: 6,
            color: "#a08050", textTransform: "uppercase", marginBottom: 4
          }}>Red Dead Redemption</div>
          <h1 style={{
            fontFamily: "'Rye', serif", fontSize: 28, margin: "4px 0",
            color: "#e8dcc8",
            textShadow: "0 2px 8px rgba(0,0,0,0.6), 0 0 30px rgba(160,100,40,0.15)"
          }}>Liar's Dice</h1>
          <div style={{
            fontFamily: "'Rye', serif", fontSize: 11, letterSpacing: 4,
            color: "#a08050", textTransform: "uppercase"
          }}>Probability Calculator</div>
          <div style={{
            width: 120, height: 1, margin: "12px auto 0",
            background: "linear-gradient(90deg, transparent, #a08050, transparent)"
          }} />
        </div>

        {/* Game Setup */}
        <Section title="Game Setup">
          <Row label="Players">
            <Stepper value={totalPlayers} onChange={updatePlayers} min={2} max={6} />
          </Row>
          <Row label="My dice">
            <Stepper value={dicePerPlayer[0]} onChange={updateMyDiceCount} min={1} max={5} />
          </Row>
          <Row label="1s are wild">
            <button onClick={() => setOnesWild(!onesWild)} style={{
              background: onesWild ? "#4a7c3f" : "rgba(255,255,255,0.08)",
              border: "1px solid rgba(232,220,200,0.2)",
              borderRadius: 4, padding: "4px 14px", cursor: "pointer",
              fontFamily: "'Courier Prime', monospace", fontSize: 13,
              color: "#e8dcc8", transition: "all 0.2s"
            }}>{onesWild ? "ON" : "OFF"}</button>
          </Row>

          {/* Advanced: opponent dice counts */}
          <button onClick={() => setShowAdvanced(!showAdvanced)} style={{
            background: "none", border: "none", cursor: "pointer",
            color: "#a08050", fontFamily: "'Courier Prime', monospace",
            fontSize: 12, padding: "8px 0 0", display: "flex", alignItems: "center", gap: 6
          }}>
            {showAdvanced ? "▾" : "▸"} Opponent dice counts
          </button>
          {showAdvanced && (
            <div style={{ padding: "8px 0 0 12px" }}>
              {Array.from({ length: totalPlayers - 1 }, (_, i) => (
                <Row key={i} label={`Opponent ${i + 1}`}>
                  <Stepper value={dicePerPlayer[i + 1]} onChange={(v) => updateOpponentDice(i + 1, v)} min={1} max={5} />
                </Row>
              ))}
            </div>
          )}
        </Section>

        {/* My Hand */}
        <Section title="My Hand">
          <div style={{ display: "flex", gap: 10, justifyContent: "center", flexWrap: "wrap" }}>
            {myDice.map((d, i) => (
              <div key={i} style={{ textAlign: "center" }}>
                <div style={{ cursor: "pointer", transition: "transform 0.15s" }}
                  onClick={() => setDie(i, d >= 6 ? 1 : d + 1)}>
                  <DiceFace value={d} size={48} />
                </div>
                <div style={{
                  fontSize: 10, color: "#a08050", marginTop: 3,
                  fontFamily: "'Courier Prime', monospace"
                }}>tap</div>
              </div>
            ))}
          </div>
          <div style={{
            fontSize: 12, color: "#a08050", textAlign: "center", marginTop: 8,
            fontStyle: "italic"
          }}>
            Tap dice to change their value
          </div>
        </Section>

        {/* Current Bid */}
        <Section title="Current Bid">
          <div style={{
            display: "flex", alignItems: "center", justifyContent: "center",
            gap: 20, flexWrap: "wrap"
          }}>
            <div style={{ textAlign: "center" }}>
              <div style={{ fontSize: 11, color: "#a08050", marginBottom: 4 }}>QUANTITY</div>
              <Stepper value={bidQty} onChange={(v) => setBidQty(Math.max(1, Math.min(totalDice, v)))} min={1} max={totalDice} />
            </div>
            <div style={{
              fontFamily: "'Rye', serif", fontSize: 20, color: "#a08050", paddingTop: 16
            }}>×</div>
            <div style={{ textAlign: "center" }}>
              <div style={{ fontSize: 11, color: "#a08050", marginBottom: 4 }}>FACE VALUE</div>
              <div style={{ display: "flex", gap: 4 }}>
                {[1, 2, 3, 4, 5, 6].map((f) => (
                  <button key={f} onClick={() => setBidFace(f)} style={{
                    background: f === bidFace ? "rgba(160,100,40,0.3)" : "rgba(255,255,255,0.05)",
                    border: f === bidFace ? "2px solid #a08050" : "1px solid rgba(232,220,200,0.12)",
                    borderRadius: 5, padding: 3, cursor: "pointer",
                    transition: "all 0.2s"
                  }}>
                    <DiceFace value={f} size={30} />
                  </button>
                ))}
              </div>
            </div>
          </div>
          <div style={{
            textAlign: "center", marginTop: 12, fontFamily: "'Rye', serif",
            fontSize: 14, color: "#e8dcc8"
          }}>
            "{bidQty} {bidFace}{bidQty > 1 ? "'s" : ""}" — {totalDice} dice in play
            {onesWild && bidFace !== 1 && <span style={{ color: "#a08050" }}> (1s wild)</span>}
          </div>
        </Section>

        {/* Results */}
        <Section title="The Odds">
          {/* Verdict */}
          <div style={{
            textAlign: "center", padding: "14px 0 18px",
            borderBottom: "1px solid rgba(232,220,200,0.1)"
          }}>
            <div style={{
              fontFamily: "'Rye', serif", fontSize: 36, fontWeight: 700,
              color: verdictColor,
              textShadow: `0 0 20px ${verdictColor}44`
            }}>
              {(exactBidProb * 100).toFixed(1)}%
            </div>
            <div style={{
              fontFamily: "'Rye', serif", fontSize: 14, color: verdictColor,
              marginTop: 2
            }}>{verdict}</div>
            <div style={{
              fontSize: 11, color: "#a08050", marginTop: 6
            }}>
              Chance there are at least {bidQty}× <span style={{ display: "inline-flex", verticalAlign: "middle" }}><DiceFace value={bidFace} size={16} /></span> on the table
            </div>
            <div style={{
              fontSize: 11, color: "#706040", marginTop: 4
            }}>
              Spot-on chance (exactly {bidQty}): {(spotOnProb * 100).toFixed(1)}%
            </div>
            <div style={{
              fontSize: 11, color: "#706040", marginTop: 2
            }}>
              You have {myMatches} matching {myMatches === 1 ? "die" : "dice"} · {unknownDice} unknown {unknownDice === 1 ? "die" : "dice"} · p = {(p * 100).toFixed(1)}% per die
            </div>
          </div>

          {/* Distribution */}
          <div style={{ marginTop: 14 }}>
            <div style={{
              fontSize: 11, color: "#a08050", marginBottom: 8,
              fontFamily: "'Rye', serif", letterSpacing: 2, textTransform: "uppercase"
            }}>Probability by Quantity</div>
            {results.map(({ qty, prob }) => (
              <ProbBar
                key={qty}
                probability={prob}
                label={`${qty}×`}
                highlight={qty === bidQty}
              />
            ))}
          </div>
        </Section>

        {/* Footer */}
        <div style={{
          textAlign: "center", marginTop: 24, fontSize: 11,
          color: "#5a4a30", lineHeight: 1.6
        }}>
          Assumes random dice for opponents.
          <br />
          {onesWild ? "1s count as wild (matching any face)." : "1s are NOT wild."}
        </div>
      </div>
    </div>
  );
}

function Section({ title, children }) {
  return (
    <div style={{
      background: "rgba(255,255,255,0.03)",
      border: "1px solid rgba(232,220,200,0.08)",
      borderRadius: 6, padding: "16px 18px", marginBottom: 16
    }}>
      <div style={{
        fontFamily: "'Rye', serif", fontSize: 13, color: "#a08050",
        letterSpacing: 3, textTransform: "uppercase", marginBottom: 12,
        borderBottom: "1px solid rgba(232,220,200,0.08)", paddingBottom: 8
      }}>{title}</div>
      {children}
    </div>
  );
}

function Row({ label, children }) {
  return (
    <div style={{
      display: "flex", justifyContent: "space-between", alignItems: "center",
      padding: "5px 0"
    }}>
      <span style={{ fontSize: 14, color: "#c8b898" }}>{label}</span>
      {children}
    </div>
  );
}

function Stepper({ value, onChange, min, max }) {
  return (
    <div style={{ display: "flex", alignItems: "center", gap: 0 }}>
      <button onClick={() => onChange(value - 1)} disabled={value <= min} style={{
        width: 30, height: 30, background: "rgba(255,255,255,0.06)",
        border: "1px solid rgba(232,220,200,0.15)", borderRadius: "4px 0 0 4px",
        color: value <= min ? "#4a3a2a" : "#e8dcc8", cursor: value <= min ? "default" : "pointer",
        fontFamily: "'Rye', serif", fontSize: 16, display: "flex",
        alignItems: "center", justifyContent: "center"
      }}>−</button>
      <div style={{
        width: 36, height: 30, background: "rgba(0,0,0,0.3)",
        borderTop: "1px solid rgba(232,220,200,0.15)",
        borderBottom: "1px solid rgba(232,220,200,0.15)",
        display: "flex", alignItems: "center", justifyContent: "center",
        fontFamily: "'Courier Prime', monospace", fontSize: 16,
        fontWeight: 700, color: "#e8dcc8"
      }}>{value}</div>
      <button onClick={() => onChange(value + 1)} disabled={value >= max} style={{
        width: 30, height: 30, background: "rgba(255,255,255,0.06)",
        border: "1px solid rgba(232,220,200,0.15)", borderRadius: "0 4px 4px 0",
        color: value >= max ? "#4a3a2a" : "#e8dcc8", cursor: value >= max ? "default" : "pointer",
        fontFamily: "'Rye', serif", fontSize: 16, display: "flex",
        alignItems: "center", justifyContent: "center"
      }}>+</button>
    </div>
  );
}
