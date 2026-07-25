#!/usr/bin/env python3
"""
═══════════════════════════════════════════════════════════════
  FNR FORMABLE NATIONS PARSER
  Converts Paradox script files into JavaScript data for the
  Formable Nations: Reworked web guide.
═══════════════════════════════════════════════════════════════

USAGE:
    python3 fnr_parser.py <input_file> [output_file] [--type fnr|vanilla]

EXAMPLES:
    python3 fnr_parser.py fnr_formable_countries.txt
    python3 fnr_parser.py fnr_formable_countries.txt assets/js/fnr_euv_data.js
    python3 fnr_parser.py vanilla_formables.txt assets/js/vanilla_euv_data.js --type vanilla

OUTPUT:
    A .js file containing a `const FORMABLES = [...]` or 
    `const VANILLA_FORMABLES = [...]` array that can be loaded
    by the formable nations guide page.

SUPPORTED FIELDS EXTRACTED:
    - tag, name, category, rank, level
    - requiredFraction, rule
    - cultures (individual + culture groups)
    - religions (individual + religion groups)
    - capitals (required capital locations)
    - provinces, areas, regions, locations, sub_continents
    - formEffects (rank upgrades, government changes, reforms)
    - excludedTags (tags that cannot form this nation)
"""

import re
import json
import sys
import os

# ═══════════════════════════════════════════════════════════════
#  CATEGORY NORMALIZATION
# ═══════════════════════════════════════════════════════════════
CATEGORY_MAP = {
    'modern':           'Modern',
    'non-historical':   'Non-Historical',
    'nonhistorical':    'Non-Historical',
    'non-history':      'Non-Historical',
    'historical':       'Historical',
    'history':          'Historical',
    'historial':        'Historical',
    'fantasy':          'Fantasy',
    'fantasy #':        'Fantasy',
    'althistory':       'Alt-History',
    'alt-history':      'Alt-History',
    'alt-historical':   'Alt-History',
    'alt history':      'Alt-History',
    'controversial':    'Controversial',
    'meme':             'Meme',
    '':                 'Uncategorized',
}

def normalize_category(raw: str) -> str:
    """Normalize messy category strings into clean labels."""
    low = raw.lower().strip()
    
    # Handle compound categories like "Us states (rank 3)"
    if 'us states' in low:
        return 'US States'
    
    # Handle parenthetical suffixes: "Fantasy (kill all hordes...)"
    for prefix in ['fantasy', 'non-historical', 'historical', 'alt-history', 'modern']:
        if low.startswith(prefix + ' (') or low.startswith(prefix + '('):
            return CATEGORY_MAP.get(prefix, prefix.title())
    
    if low.startswith('exists in'):
        return 'Historical'
    
    if low in CATEGORY_MAP:
        return CATEGORY_MAP[low]
    
    return raw.strip().title() if raw.strip() else 'Uncategorized'


def titlecase(s: str) -> str:
    """Title-case a cleaned identifier string."""
    return ' '.join(w.capitalize() for w in s.split())


def clean_id(s: str) -> str:
    """Clean an identifier: remove suffixes, replace underscores."""
    return s.replace('_culture', '').replace('_area', '').replace('_province', '').replace('_region', '').replace('_', ' ').strip()


# ═══════════════════════════════════════════════════════════════
#  BLOCK EXTRACTION
# ═══════════════════════════════════════════════════════════════
def extract_brace_block(lines: list, start: int) -> tuple:
    """
    Starting from a line containing '{', collect all lines until
    braces are balanced. Returns (block_lines, next_line_index).
    """
    brace_count = 0
    block = []
    i = start
    while i < len(lines):
        line = lines[i].rstrip()
        brace_count += line.count('{') - line.count('}')
        block.append(line)
        i += 1
        if brace_count <= 0:
            break
    return block, i


def is_commented(line: str) -> bool:
    """Check if a line is a PDX comment (starts with #)."""
    return line.strip().startswith('#')


# ═══════════════════════════════════════════════════════════════
#  FIELD EXTRACTORS
# ═══════════════════════════════════════════════════════════════
def extract_cultures(block_lines: list) -> list:
    """Extract all culture references (individual + groups)."""
    cultures = set()
    for line in block_lines:
        s = line.strip()
        if is_commented(s):
            continue
        # Individual cultures: culture = culture:french
        for m in re.findall(r'culture\s*=\s*culture:(\w+)', s):
            cultures.add(titlecase(clean_id(m)))
        # Culture groups: has_culture_group = culture_group:iberian_group
        for m in re.findall(r'has_culture_group\s*=\s*culture_group:(\w+)', s):
            group_name = clean_id(m).replace(' group', '')
            cultures.add(titlecase(group_name) + ' (Group)')
    return sorted(cultures)


def extract_religions(block_lines: list) -> list:
    """Extract all religion references (individual + groups)."""
    religions = set()
    for line in block_lines:
        s = line.strip()
        if is_commented(s):
            continue
        # Individual: religion = religion:catholic
        for m in re.findall(r'religion\s*=\s*religion:(\w+)', s):
            religions.add(titlecase(m.replace('_religion', '')))
        # Religion groups: religion.group = religion_group:christian
        for m in re.findall(r'religion(?:\.group)?\s*=\s*religion_group:(\w+)', s):
            religions.add(titlecase(m) + ' (Group)')
    return sorted(religions)


def extract_capitals(block_lines: list) -> list:
    """Extract required capital locations from allow block."""
    capitals = []
    for line in block_lines:
        s = line.strip()
        if is_commented(s):
            continue
        for m in re.findall(r'capital\s*=\s*location:(\w+)', s):
            capitals.append(titlecase(clean_id(m)))
    return capitals


def extract_list_field(block_text: str, field: str) -> list:
    """Extract a brace-delimited list field like: provinces = { a b c }"""
    pattern = field + r'\s*=\s*\{([^}]+)\}'
    m = re.search(pattern, block_text)
    if not m:
        return []
    items = [titlecase(clean_id(x)) for x in m.group(1).split() if x.strip()]
    return items


def extract_excluded_tags(block_lines: list) -> list:
    """Extract tags that are blocked from forming this nation (not = { tag = X })."""
    excluded = set()
    for line in block_lines:
        s = line.strip()
        if is_commented(s):
            continue
        # "not = { tag = BYZ }" or within allow block
        for m in re.findall(r'not\s*=\s*\{\s*tag\s*=\s*(\w+)', s, re.IGNORECASE):
            excluded.add(m)
    return sorted(excluded)


def extract_form_effects(block_lines: list) -> dict:
    """Extract notable formation effects."""
    effects = {}
    in_form_effect = False
    brace_depth = 0
    
    for line in block_lines:
        s = line.strip()
        if 'form_effect' in s and '{' in s:
            in_form_effect = True
            brace_depth = s.count('{') - s.count('}')
            continue
        if in_form_effect:
            brace_depth += s.count('{') - s.count('}')
            
            # Rank upgrade
            rank_m = re.search(r'rank\s*=\s*country_rank:rank_(\w+)', s)
            if rank_m:
                effects['rankUpgrade'] = titlecase(rank_m.group(1))
            
            # Government change
            gov_m = re.search(r'change_government_type\s*=\s*government_type:(\w+)', s)
            if gov_m:
                effects['governmentChange'] = titlecase(gov_m.group(1))
            
            # Reform
            reform_m = re.search(r'add_reform\s*=\s*government_reform:(\w+)', s)
            if reform_m:
                reform_name = reform_m.group(1).replace('fnr_', '').replace('_', ' ')
                effects.setdefault('reforms', []).append(titlecase(reform_name))
            
            # Stability
            stab_m = re.search(r'add_stability\s*=\s*(-?\d+)', s)
            if stab_m:
                effects['stabilityCost'] = int(stab_m.group(1))
            
            if brace_depth <= 0:
                in_form_effect = False
    
    return effects if effects else None


# ═══════════════════════════════════════════════════════════════
#  MAIN PARSER
# ═══════════════════════════════════════════════════════════════
def parse_formables(filepath: str) -> list:
    """Parse a PDX formable nations script file into a list of nation dicts."""
    
    with open(filepath, 'r', encoding='utf-8-sig') as f:
        raw = f.read()
    
    lines = raw.split('\n')
    nations = []
    current_rank = 0
    current_name = ''
    current_category = ''
    i = 0
    
    while i < len(lines):
        line = lines[i].rstrip()
        stripped = line.strip()
        
        # ── Track rank headers ──
        rank_m = re.match(r'^\t# Rank (\d+)', line)
        if rank_m:
            current_rank = int(rank_m.group(1))
            i += 1
            continue
        
        # ── Track nation name comments ──
        # Must be exactly 2 tabs deep: "\t\t# Name" or "\t\t# Name - Category"
        name_m = re.match(r'^\t\t# (.+)$', line)
        if name_m:
            full = name_m.group(1).strip()
            if ' - ' in full:
                parts = full.rsplit(' - ', 1)
                current_name = parts[0].strip()
                current_category = parts[1].strip()
            else:
                current_name = full
                current_category = ''
            i += 1
            continue
        
        # ── Detect formable block: TAG_f = { ──
        block_m = re.match(r'^\s+(\w+)_f\s*=\s*\{', line)
        if block_m:
            tag = block_m.group(1)
            block_lines, i = extract_brace_block(lines, i)
            block_text = '\n'.join(block_lines)
            
            # ── Build nation object ──
            nation = {
                'tag':   tag,
                'name':  current_name or tag,
                'category': normalize_category(current_category),
                'rank':  current_rank,
            }
            
            # Level
            level_m = re.search(r'level\s*=\s*(\d+)', block_text)
            if level_m:
                nation['level'] = int(level_m.group(1))
            
            # Required fraction
            frac_m = re.search(r'required_locations_fraction\s*=\s*([\d.]+)', block_text)
            if frac_m:
                nation['requiredFraction'] = float(frac_m.group(1))
            
            # Rule
            rule_m = re.search(r'rule\s*=\s*(\w+)', block_text)
            if rule_m:
                nation['rule'] = rule_m.group(1)
            
            # Cultures & culture groups
            nation['cultures'] = extract_cultures(block_lines)
            
            # Religions & religion groups
            nation['religions'] = extract_religions(block_lines)
            
            # Capitals
            nation['capitals'] = extract_capitals(block_lines)
            
            # Territory fields
            for field, key in [
                ('provinces', 'provinces'),
                ('areas', 'areas'),
                ('regions', 'regions'),
                ('locations', 'locations'),
                ('sub_continents', 'subContinents'),
            ]:
                vals = extract_list_field(block_text, field)
                if vals:
                    nation[key] = vals
            
            # Excluded tags
            excluded = extract_excluded_tags(block_lines)
            if excluded:
                nation['excludedTags'] = excluded
            
            # Form effects
            effects = extract_form_effects(block_lines)
            if effects:
                nation['formEffects'] = effects
            
            # FNR category variable detection
            fnr_vars = re.findall(r'has_variable\s*=\s*fnr_(\w+)_enabled', block_text)
            fnr_cats = [v for v in fnr_vars if v.lower() != tag.lower()]
            if fnr_cats and nation['category'] == 'Uncategorized':
                # Try to infer category from variable name
                var_cat_map = {
                    'modern': 'Modern',
                    'fantasy': 'Fantasy',
                    'nonhistorical': 'Non-Historical',
                    'historical': 'Historical',
                    'althistory': 'Alt-History',
                    'controversial': 'Controversial',
                }
                for vc in fnr_cats:
                    if vc in var_cat_map:
                        nation['category'] = var_cat_map[vc]
                        break
            
            nations.append(nation)
            continue
        
        i += 1
    
    return nations


# ═══════════════════════════════════════════════════════════════
#  OUTPUT GENERATION
# ═══════════════════════════════════════════════════════════════
def generate_js(nations: list, var_name: str = 'FORMABLES') -> str:
    """Generate a readable, well-formatted JavaScript file with the nations data array."""
    
    # Remove empty arrays to keep output clean
    cleaned = []
    for n in nations:
        obj = {}
        for k, v in n.items():
            if isinstance(v, list) and len(v) == 0:
                continue
            if v is None:
                continue
            obj[k] = v
        cleaned.append(obj)
    
    # Field ordering — controls the order fields appear in each entry
    FIELD_ORDER = [
        'tag', 'name', 'flag', 'category', 'rank', 'level',
        'requiredFraction', 'rule',
        'cultures', 'religions', 'capitals',
        'provinces', 'areas', 'regions', 'locations', 'subContinents',
        'excludedTags', 'formEffects',
        # Future expansion fields
        'description', 'missions', 'events', 'ideas', 'image', 'wikiUrl',
    ]
    
    def format_value(val, indent=2):
        """Format a JS value with readable indentation."""
        if isinstance(val, str):
            return json.dumps(val, ensure_ascii=False)
        if isinstance(val, bool):
            return 'true' if val else 'false'
        if isinstance(val, (int, float)):
            return str(val)
        if isinstance(val, list):
            if not val:
                return '[]'
            # Short arrays (all strings, fits on one line) → inline
            if all(isinstance(v, str) for v in val) and sum(len(v) for v in val) < 80:
                return '[' + ', '.join(json.dumps(v, ensure_ascii=False) for v in val) + ']'
            # Long arrays → multiline
            pad = '    ' * (indent + 1)
            items = (',\n' + pad).join(json.dumps(v, ensure_ascii=False) for v in val)
            return '[\n' + pad + items + '\n' + '    ' * indent + ']'
        if isinstance(val, dict):
            return format_obj(val, indent)
        return json.dumps(val, ensure_ascii=False)
    
    def format_obj(obj, indent=2):
        """Format a JS object with one field per line."""
        pad = '    ' * indent
        inner_pad = '    ' * (indent + 1)
        lines = []
        for k, v in obj.items():
            lines.append(f'{inner_pad}{json.dumps(k)}: {format_value(v, indent + 1)}')
        return '{\n' + ',\n'.join(lines) + '\n' + pad + '}'
    
    # Group by rank for readability
    by_rank = {}
    for n in cleaned:
        r = n.get('rank', 0)
        by_rank.setdefault(r, []).append(n)
    
    output_parts = []
    output_parts.append(f'const {var_name} = [')
    
    first_entry = True
    for rank in sorted(by_rank.keys()):
        rank_nations = by_rank[rank]
        output_parts.append(f'')
        output_parts.append(f'    // ═══════════════════════════════════════════')
        output_parts.append(f'    //  RANK {rank} ({len(rank_nations)} nations)')
        output_parts.append(f'    // ═══════════════════════════════════════════')
        
        for n in rank_nations:
            # Build ordered object
            ordered = {}
            for key in FIELD_ORDER:
                if key in n:
                    ordered[key] = n[key]
            # Any remaining keys not in FIELD_ORDER
            for key in n:
                if key not in ordered:
                    ordered[key] = n[key]
            
            comma = '' if first_entry else ','
            if not first_entry:
                # Close previous entry with comma
                pass
            
            # Nation comment
            cat_label = f' — {n.get("category", "")}' if n.get('category') else ''
            output_parts.append(f'')
            output_parts.append(f'    // {n.get("name", n.get("tag", "?"))}{cat_label}')
            
            # Build the object
            inner_lines = []
            for k, v in ordered.items():
                formatted = format_value(v, 2)
                inner_lines.append(f'        {json.dumps(k)}: {formatted}')
            
            entry = '    {\n' + ',\n'.join(inner_lines) + '\n    }'
            
            if first_entry:
                output_parts.append(entry)
                first_entry = False
            else:
                output_parts.append('    ,' + entry[4:])  # replace leading spaces with comma
    
    output_parts.append('];\n')
    
    return '\n'.join(output_parts)


def print_summary(nations: list):
    """Print a summary of parsed data."""
    from collections import Counter
    
    print(f'\n{"═" * 56}')
    print(f'  FNR PARSER — RESULTS')
    print(f'{"═" * 56}')
    print(f'  Total nations parsed:  {len(nations)}')
    print()
    
    # By rank
    ranks = Counter(n['rank'] for n in nations)
    print(f'  By Rank:')
    for r in sorted(ranks):
        print(f'    Rank {r}: {ranks[r]} nations')
    print()
    
    # By category
    cats = Counter(n['category'] for n in nations)
    print(f'  By Category:')
    for cat, count in cats.most_common():
        print(f'    {cat:20s} {count:>4}')
    print()
    
    # Nations with form effects
    with_effects = sum(1 for n in nations if n.get('formEffects'))
    print(f'  With form effects:     {with_effects}')
    
    # Nations with culture groups
    with_groups = sum(1 for n in nations if any('(Group)' in c for c in n.get('cultures', [])))
    print(f'  With culture groups:   {with_groups}')
    
    print(f'{"═" * 56}\n')


def generate_tooltips_template(nations: list) -> str:
    """Generate a JS tooltips file with empty entries for all reforms/effects."""
    
    # Collect all unique reform names and effects
    all_reforms = set()
    all_effects = set()
    
    for n in nations:
        fx = n.get('formEffects', {})
        if fx:
            if fx.get('rankUpgrade'):
                all_effects.add('Rank: ' + fx['rankUpgrade'])
            if fx.get('governmentChange'):
                all_effects.add('Gov: ' + fx['governmentChange'])
            for r in fx.get('reforms', []):
                all_reforms.add(r)
    
    lines = []
    lines.append('// ═══════════════════════════════════════════════════════')
    lines.append('//  FNR TOOLTIP DATA')
    lines.append('//  Auto-generated template — fill in descriptions and')
    lines.append('//  modifiers for each reform / effect.')
    lines.append('//')
    lines.append('//  Modifier types: "positive", "negative", "neutral"')
    lines.append('// ═══════════════════════════════════════════════════════')
    lines.append('')
    lines.append('// Merge into the TOOLTIPS object on the guide page.')
    lines.append('// Load this file AFTER the main page script.')
    lines.append('')
    
    # Reforms
    lines.append('// ── REFORMS (' + str(len(all_reforms)) + ') ──')
    for r in sorted(all_reforms):
        safe = json.dumps(r, ensure_ascii=False)
        lines.append(f'TOOLTIPS[{safe}] = {{')
        lines.append(f'    desc: "",')
        lines.append(f'    modifiers: [')
        lines.append(f'        // {{ text: "+10% Tax Income", type: "positive" }},')
        lines.append(f'        // {{ text: "-5% Stability", type: "negative" }},')
        lines.append(f'    ]')
        lines.append(f'}};')
        lines.append('')
    
    # Rank upgrades and government changes
    if all_effects:
        lines.append('// ── RANK & GOVERNMENT EFFECTS (' + str(len(all_effects)) + ') ──')
        for e in sorted(all_effects):
            safe = json.dumps(e, ensure_ascii=False)
            lines.append(f'TOOLTIPS[{safe}] = {{')
            lines.append(f'    desc: "",')
            lines.append(f'    modifiers: []')
            lines.append(f'}};')
            lines.append('')
    
    return '\n'.join(lines)


# ═══════════════════════════════════════════════════════════════
#  CLI
# ═══════════════════════════════════════════════════════════════
def main():
    # Parse arguments
    args = sys.argv[1:]
    
    if not args or '--help' in args or '-h' in args:
        print(__doc__)
        print()
        print('FLAGS:')
        print('  --type fnr|vanilla    Set output variable name (default: fnr)')
        print('  --tooltips            Also generate a tooltips template file')
        print('  --flags <dir>         Scan directory for flag PNGs and auto-assign')
        print('                        Expects files named TAG.png (e.g. PMSTN.png)')
        print()
        sys.exit(0)
    
    input_file = args[0]
    
    # Determine output file
    if len(args) >= 2 and not args[1].startswith('--'):
        output_file = args[1]
    else:
        base = os.path.splitext(os.path.basename(input_file))[0]
        output_file = base + '_data.js'
    
    # Determine type (fnr or vanilla)
    file_type = 'fnr'
    if '--type' in args:
        idx = args.index('--type')
        if idx + 1 < len(args):
            file_type = args[idx + 1]
    
    gen_tooltips = '--tooltips' in args
    
    # Flags directory
    flags_dir = None
    flags_prefix = ''
    if '--flags' in args:
        idx = args.index('--flags')
        if idx + 1 < len(args):
            flags_dir = args[idx + 1]
            # Optional web path prefix (relative to HTML file)
            if idx + 2 < len(args) and not args[idx + 2].startswith('--'):
                flags_prefix = args[idx + 2]
    
    var_name = 'FORMABLES' if file_type == 'fnr' else 'VANILLA_FORMABLES'
    
    # Parse
    print(f'Parsing: {input_file}')
    print(f'Type:    {file_type}')
    print(f'Output:  {output_file}')
    
    nations = parse_formables(input_file)
    print_summary(nations)
    
    # Scan for flag images
    if flags_dir:
        if os.path.isdir(flags_dir):
            available = {}
            for fname in os.listdir(flags_dir):
                if fname.lower().endswith('.png'):
                    tag = os.path.splitext(fname)[0]
                    available[tag] = fname
                    available[tag.upper()] = fname  # case-insensitive match
            
            matched = 0
            for n in nations:
                tag = n['tag']
                if tag in available:
                    web_path = flags_prefix + '/' + available[tag] if flags_prefix else available[tag]
                    n['flag'] = web_path
                    matched += 1
                elif tag.upper() in available:
                    web_path = flags_prefix + '/' + available[tag.upper()] if flags_prefix else available[tag.upper()]
                    n['flag'] = web_path
                    matched += 1
            
            print(f'  Flags: {matched}/{len(nations)} matched from {flags_dir}')
            missing = [n['tag'] for n in nations if 'flag' not in n]
            if missing and len(missing) <= 20:
                print(f'  Missing flags: {", ".join(missing)}')
            elif missing:
                print(f'  Missing flags: {len(missing)} nations without flag images')
        else:
            print(f'  Warning: flags directory not found: {flags_dir}')
    
    # Generate JS
    js_output = generate_js(nations, var_name)
    
    # Write
    with open(output_file, 'w', encoding='utf-8') as f:
        f.write(js_output)
    
    print(f'Written {len(js_output):,} bytes to {output_file}')
    print(f'Load in HTML with: <script src="{output_file}"></script>')
    
    # Generate tooltips template
    if gen_tooltips:
        tooltips_file = os.path.splitext(output_file)[0].replace('_data', '') + '_tooltips.js'
        tt_output = generate_tooltips_template(nations)
        with open(tooltips_file, 'w', encoding='utf-8') as f:
            f.write(tt_output)
        print(f'Tooltips template: {tooltips_file} ({len(tt_output):,} bytes)')
        
        # Count
        reform_count = sum(1 for n in nations for r in n.get('formEffects', {}).get('reforms', []))
        print(f'  {reform_count} reform references across all nations')
    
    print()


if __name__ == '__main__':
    main()
