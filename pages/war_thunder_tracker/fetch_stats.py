#!/usr/bin/env python3
"""
War Thunder Stat Fetcher
========================
Fetches your War Thunder profile and outputs a JSON file
that the static HTML dashboard reads.

Usage:
    pip install wt-profile-tool
    python fetch_stats.py --nick "YourNickname"

The output file (wt_stats.json) goes in the same directory
as your index.html on GitHub Pages.
"""

import argparse
import json
import sys
import os
from datetime import datetime, timezone

def fetch_and_save(nickname: str, output_path: str = "wt_stats.json"):
    try:
        from wt_profile_tool import WTPTClient
    except ImportError:
        print("ERROR: wt-profile-tool not installed.")
        print("Run: pip install wt-profile-tool")
        sys.exit(1)

    client = WTPTClient(random_ua=True)

    print(f"Fetching profile for '{nickname}'...")

    try:
        profile = client.get_player_profile_by_nickname(nickname)
    except ValueError:
        print(f"ERROR: Player '{nickname}' not found. Check spelling (case-sensitive).")
        sys.exit(1)
    except Exception as e:
        print(f"ERROR: Failed to fetch profile: {e}")
        sys.exit(1)

    # -- Parse base info --
    base = profile.base_info
    level = profile.level_info

    data = {
        "fetched_at": datetime.now(timezone.utc).isoformat(),
        "player": {
            "nickname": base.nick,
            "user_id": base.user_id,
            "title": base.title,
            "clan_tag": base.clan_tag,
            "clan_name": base.clan_name,
            "level": level.level,
            "exp": level.exp_has,
        },
        "modes": {},
        "vehicles": [],
    }

    # -- Map battle_type enum to human-readable names --
    MODE_NAMES = {
        0: "arcade",
        1: "realistic",
        2: "simulator",
        3: "tank_arcade",
        4: "tank_realistic",
        5: "air_arcade",
        6: "air_realistic",
        7: "ship_arcade",
        8: "ship_realistic",
        9: "tank_simulator",
        10: "air_simulator",
        11: "ship_simulator",
    }

    # -- Parse common_statistic (per-mode aggregate stats) --
    for stat in profile.common_statistic:
        bt = stat.battle_type
        if bt is None:
            continue
        mode_key = MODE_NAMES.get(bt.value, f"unknown_{bt.value}")

        pvp = stat.pvp_played
        lb = stat.leaderboard

        mode_data = {
            "kills": stat.kills,
            "deaths": stat.deaths,
            "kd_ratio": round(stat.kills / stat.deaths, 2) if stat.deaths else 0,
            "effectiveness": stat.effectiveness,
            "rating": stat.rating,
            "pvp": {},
            "leaderboard": {},
        }

        if pvp:
            victories = pvp.victories or 0
            finished = pvp.finished or 0
            mode_data["pvp"] = {
                "victories": victories,
                "finished": finished,
                "win_rate": round((victories / finished) * 100, 1) if finished else 0,
                "air_kills": pvp.target_air or 0,
                "ground_kills": pvp.target_ground or 0,
                "naval_kills": pvp.target_naval or 0,
            }

        if lb:
            for field_name in [
                "victories_battles", "ground_kills", "air_kills",
                "flyouts", "time_pvp_played", "pvp_ratio",
                "deaths", "average_score", "naval_kills",
            ]:
                item = getattr(lb, field_name, None)
                if item:
                    mode_data["leaderboard"][field_name] = {
                        "value_total": item.value_total,
                        "place_total": item.place_total,
                        "value_month": item.value_month,
                        "place_month": item.place_month,
                    }

        data["modes"][mode_key] = mode_data

    # -- Parse battle_list (per-vehicle stats) --
    for v in profile.battle_list:
        bt = v.battle_type
        mode_key = MODE_NAMES.get(bt.value, "unknown") if bt else "unknown"

        battles = v.battles or 0
        victories = v.victories or 0
        deaths = v.deaths or 0
        air_kills = v.air_kills or 0
        ground_kills = v.ground_kills or 0
        naval_kills = v.naval_kills or 0
        flyouts = v.flyouts or 0
        total_kills = air_kills + ground_kills + naval_kills

        data["vehicles"].append({
            "id": v.id,
            "mode": mode_key,
            "battles": battles,
            "victories": victories,
            "win_rate": round((victories / battles) * 100, 1) if battles else 0,
            "deaths": deaths,
            "flyouts": flyouts,
            "air_kills": air_kills,
            "ground_kills": ground_kills,
            "naval_kills": naval_kills,
            "total_kills": total_kills,
            "kd_ratio": round(total_kills / deaths, 2) if deaths else 0,
            "exp": v.online_exp_total or 0,
        })

    # Sort vehicles by total battles played (descending)
    data["vehicles"].sort(key=lambda x: x["battles"], reverse=True)

    # -- Preserve manual_stats from existing file --
    # This way your hand-edited nuke count etc. survives re-fetches
    if os.path.exists(output_path):
        try:
            with open(output_path, "r") as f:
                old_data = json.load(f)
            if "manual_stats" in old_data:
                data["manual_stats"] = old_data["manual_stats"]
                print("  Preserved manual_stats from existing file.")
        except Exception:
            pass

    if "manual_stats" not in data:
        data["manual_stats"] = {
            "nukes": 0,
            "favorite_vehicle": "",
            "notes": ""
        }

    # Write JSON
    with open(output_path, "w") as f:
        json.dump(data, f, indent=2)

    print(f"Stats saved to {output_path}")
    print(f"  Player: {data['player']['nickname']} (Level {data['player']['level']})")
    print(f"  Modes found: {len(data['modes'])}")
    print(f"  Vehicles found: {len(data['vehicles'])}")


if __name__ == "__main__":
    parser = argparse.ArgumentParser(description="Fetch War Thunder stats")
    parser.add_argument("--nick", required=True, help="Your War Thunder nickname (case-sensitive)")
    parser.add_argument("--output", default="wt_stats.json", help="Output JSON path")
    args = parser.parse_args()

    fetch_and_save(args.nick, args.output)
