const FORMABLES = [

    // ═══════════════════════════════════════════
    //  RANK 1 (4 nations)
    // ═══════════════════════════════════════════

    // Pamiristan — Modern
    {
        "tag": "PMSTN",
        "name": "Pamiristan",
        "category": "Modern",
        "rank": 1,
        "level": 1,
        "requiredFraction": 0.9,
        "rule": "plausible",
        "cultures": ["Pamiri", "Tajik"],
        "capitals": ["Qalai Khumb"],
        "provinces": ["Darvaz", "Sighnan", "Badakhshan", "Qarategin", "Sarikol"]
    }

    // Ḥaššāšīyīn — Non-Historical
    ,{
        "tag": "ASSSN",
        "name": "Ḥaššāšīyīn",
        "category": "Non-Historical",
        "rank": 1,
        "level": 1,
        "requiredFraction": 0.9,
        "rule": "plausible",
        "cultures": ["Syriac"],
        "religions": ["Shia", "Sunni"],
        "capitals": ["Kafartab", "Homs"],
        "locations": ["Kafartab", "Masyaf", "Homs", "Hama"]
    }

    // County of Tripoli — Modern
    ,{
        "tag": "COTRP",
        "name": "County of Tripoli",
        "category": "Modern",
        "rank": 1,
        "level": 1,
        "requiredFraction": 0.9,
        "rule": "plausible",
        "cultures": ["French"],
        "religions": ["Catholic"],
        "capitals": ["Antioch"],
        "locations": ["Tripoli Syria", "Beirut", "Deir Qamar"]
    }

    // County of Edessa — Modern
    ,{
        "tag": "COEDS",
        "name": "County of Edessa",
        "category": "Modern",
        "rank": 1,
        "level": 1,
        "requiredFraction": 0.9,
        "rule": "plausible",
        "cultures": ["French"],
        "religions": ["Catholic"],
        "capitals": ["Antioch"],
        "provinces": ["Ar Ruha"],
        "locations": ["Dluk", "Ayntab", "Kaysun", "Samsat", "Kahta", "Gerger"]
    }

    // ═══════════════════════════════════════════
    //  RANK 2 (10 nations)
    // ═══════════════════════════════════════════

    // Ontario — Modern
    ,{
        "tag": "ONTRO",
        "name": "Ontario",
        "category": "Modern",
        "rank": 2,
        "level": 2,
        "requiredFraction": 0.87,
        "rule": "plausible",
        "cultures": ["English", "French"],
        "areas": ["Western Ontario", "Eastern Ontario", "Northern Ontario"]
    }

    // Prinicpality of Antioch — Modern
    ,{
        "tag": "POFAN",
        "name": "Prinicpality of Antioch",
        "category": "Modern",
        "rank": 2,
        "level": 2,
        "requiredFraction": 0.9,
        "rule": "plausible",
        "cultures": ["French"],
        "religions": ["Catholic"],
        "capitals": ["Antioch"],
        "provinces": ["Antakya", "Halab", "Latakia", "Hims"]
    }

    // Badakhshān — Modern
    ,{
        "tag": "BDKSN",
        "name": "Badakhshān",
        "category": "Modern",
        "rank": 2,
        "level": 2,
        "requiredFraction": 0.87,
        "rule": "plausible",
        "cultures": ["Pamiri", "Tajik"],
        "capitals": ["Fayzabad"],
        "areas": ["Badakhshan"]
    }

    // Baden-Alsace — Fantasy
    ,{
        "tag": "BDALS",
        "name": "Baden-Alsace",
        "category": "Fantasy",
        "rank": 2,
        "level": 2,
        "requiredFraction": 0.6,
        "rule": "plausible",
        "areas": ["Alsace", "Upper Rhine"]
    }

    // Arpitania — Fantasy
    ,{
        "tag": "ARPIT",
        "name": "Arpitania",
        "category": "Fantasy",
        "rank": 2,
        "level": 2,
        "requiredFraction": 0.07,
        "rule": "plausible",
        "cultures": ["Arpitan"],
        "areas": ["Savoy", "Piemonte"],
        "regions": ["France"]
    }

    // Polabia — Non-Historical
    ,{
        "tag": "POLBA",
        "name": "Polabia",
        "category": "Non-Historical",
        "rank": 2,
        "level": 2,
        "requiredFraction": 0.35,
        "rule": "plausible",
        "cultures": ["Polish (Group)"],
        "areas": ["Silesia"]
    }

    // Bremen-Verden — Historical
    ,{
        "tag": "BMNVD",
        "name": "Bremen-Verden",
        "category": "Historical",
        "rank": 2,
        "level": 2,
        "requiredFraction": 0.44,
        "rule": "plausible",
        "cultures": ["Lower Saxon"],
        "areas": ["Lower Saxony"]
    }

    // Ducal Prussia — Historical
    ,{
        "tag": "DCLPR",
        "name": "Ducal Prussia",
        "category": "Historical",
        "rank": 2,
        "level": 1,
        "requiredFraction": 1.0,
        "rule": "plausible",
        "cultures": ["Prussian"],
        "areas": ["Prussia"]
    }

    // Dacia — Non-Historical
    ,{
        "tag": "DACIA",
        "name": "Dacia",
        "category": "Non-Historical",
        "rank": 2,
        "level": 2,
        "requiredFraction": 0.7,
        "rule": "plausible",
        "cultures": ["Bulgarian", "Moldovan", "Wallachian"],
        "areas": ["Bulgaria", "Wallachia", "Moldavia"]
    }

    // Netherlands — Uncategorized
    ,{
        "tag": "NED",
        "name": "Netherlands",
        "category": "Uncategorized",
        "rank": 2,
        "level": 2,
        "requiredFraction": 0.3,
        "rule": "plausible",
        "cultures": ["Netherlandish (Group)"],
        "areas": ["Brabant", "Flanders", "Friesland", "Holland", "Wallonia"],
        "formEffects": {
            "governmentChange": "Republic"
        }
    }

    // ═══════════════════════════════════════════
    //  RANK 3 (129 nations)
    // ═══════════════════════════════════════════

    // Gobi — Modern
    ,{
        "tag": "KGOBI",
        "name": "Gobi",
        "category": "Modern",
        "rank": 3,
        "level": 3,
        "requiredFraction": 0.9,
        "rule": "plausible",
        "cultures": ["Oirat", "Tumed"],
        "areas": ["Western Gobi", "Southern Gobi", "Eastern Gobi"]
    }

    // Kham — Modern
    ,{
        "tag": "KKHAM",
        "name": "Kham",
        "category": "Modern",
        "rank": 3,
        "level": 3,
        "requiredFraction": 0.9,
        "rule": "plausible",
        "cultures": ["Khampa"],
        "areas": ["Kham"]
    }

    // Domé — Modern
    ,{
        "tag": "KDOME",
        "name": "Domé",
        "category": "Modern",
        "rank": 3,
        "level": 3,
        "requiredFraction": 0.9,
        "rule": "plausible",
        "cultures": ["Amdowa"],
        "areas": ["Amdo"]
    }

    // Outremer — Modern
    ,{
        "tag": "OTRMR",
        "name": "Outremer",
        "category": "Modern",
        "rank": 3,
        "level": 3,
        "requiredFraction": 0.9,
        "rule": "plausible",
        "cultures": ["French"],
        "religions": ["Catholic"],
        "capitals": ["Antioch"],
        "provinces": ["Ar Ruha", "Cyprus", "Antakya", "Halab", "Latakia", "Hims"],
        "areas": ["Levant"],
        "locations": ["Tripoli Syria", "Beirut", "Deir Qamar", "Dluk", "Ayntab", "Kaysun", "Samsat", "Kahta", "Gerger"]
    }

    // Macedonia (For Bactria) — Non-Historical
    ,{
        "tag": "BMCDN",
        "name": "Macedonia (For Bactria)",
        "category": "Non-Historical",
        "rank": 3,
        "level": 3,
        "requiredFraction": 1.0,
        "rule": "plausible",
        "areas": ["Macedonia", "Albania", "Northern Greece"],
        "formEffects": {
            "rankUpgrade": "Kingdom"
        }
    }

    // Persian Kingdom (For Bactria) — Non-Historical
    ,{
        "tag": "BPSNE",
        "name": "Persian Kingdom (For Bactria)",
        "category": "Non-Historical",
        "rank": 3,
        "level": 3,
        "requiredFraction": 1.0,
        "rule": "plausible",
        "regions": ["Persia"],
        "formEffects": {
            "rankUpgrade": "Kingdom"
        }
    }

    // Kingdom of Armenia (For Bactria) — Non-Historical
    ,{
        "tag": "ARMNA",
        "name": "Kingdom of Armenia (For Bactria)",
        "category": "Non-Historical",
        "rank": 3,
        "level": 3,
        "requiredFraction": 1.0,
        "rule": "plausible",
        "provinces": ["Khoy"],
        "areas": ["Armenian Highlands", "Armenia"],
        "formEffects": {
            "rankUpgrade": "Kingdom"
        }
    }

    // Kingdom of Chosen (For Japan) — Non-Historical
    ,{
        "tag": "CHSEN",
        "name": "Kingdom of Chosen (For Japan)",
        "category": "Non-Historical",
        "rank": 3,
        "level": 5,
        "requiredFraction": 1.0,
        "rule": "plausible",
        "regions": ["Korea"],
        "formEffects": {
            "rankUpgrade": "Kingdom"
        }
    }

    // Bactria — Non-Historical
    ,{
        "tag": "BACTR",
        "name": "Bactria",
        "category": "Non-Historical",
        "rank": 3,
        "level": 3,
        "requiredFraction": 0.01,
        "rule": "plausible",
        "cultures": ["Balti", "Burusho", "Chitrali", "Hazara", "Nuristani", "Ormur", "Pamiri", "Pashayi", "Shina", "Tajik"],
        "capitals": ["Fayzabad"],
        "provinces": ["Kunduz"],
        "areas": ["Badakhshan", "Upper Indus"],
        "formEffects": {
            "rankUpgrade": "Kingdom"
        }
    }

    // Ptolemaic Kingdom — Alt-History
    ,{
        "tag": "PTLMY",
        "name": "Ptolemaic Kingdom",
        "category": "Alt-History",
        "rank": 3,
        "level": 3,
        "requiredFraction": 0.8,
        "rule": "plausible",
        "cultures": ["Greek", "Greek (Group)", "Griko"],
        "provinces": ["Al Jifar"],
        "areas": ["Lower Egypt", "Upper Egypt", "Cyrenaica"],
        "formEffects": {
            "rankUpgrade": "Kingdom"
        }
    }

    // Rhineland — Alt-History
    ,{
        "tag": "RHLND",
        "name": "Rhineland",
        "category": "Alt-History",
        "rank": 3,
        "level": 3,
        "requiredFraction": 0.6,
        "rule": "plausible",
        "cultures": ["Moselle Franconian", "Rhine Alemannic", "Rhine Franconian", "Ripuarian Franconian"],
        "provinces": ["Taunus", "Untermain", "Sarregueminois"],
        "areas": ["Rhineland", "Upper Rhine", "Alsace"],
        "formEffects": {
            "stabilityCost": -5,
            "reforms": ["Gsctl Rheinkonfoderation"]
        }
    }

    // Baden-Wurttemberg — Alt-History
    ,{
        "tag": "BDWTB",
        "name": "Baden-Wurttemberg",
        "category": "Alt-History",
        "rank": 3,
        "level": 3,
        "requiredFraction": 0.9,
        "rule": "plausible",
        "cultures": ["Rhine Alemannic", "Swabian"],
        "provinces": ["Lower Alsace", "Schwarzwald", "Neckar", "Rhine Valley"],
        "formEffects": {
            "rankUpgrade": "Kingdom"
        }
    }

    // Magna Graecia (Greek Naples) — Alt-History
    ,{
        "tag": "MGGCA",
        "name": "Magna Graecia (Greek Naples)",
        "category": "Alt-History",
        "rank": 3,
        "level": 3,
        "requiredFraction": 0.8,
        "rule": "plausible",
        "cultures": ["Greek", "Greek (Group)", "Griko"],
        "provinces": ["Principato Ultra", "Principato Citra"],
        "areas": ["Sicily", "Basilicata", "Apulia"],
        "formEffects": {
            "rankUpgrade": "Kingdom"
        }
    }

    // Swabia (Kingdom — Historical
    ,{
        "tag": "SWBIA",
        "name": "Swabia (Kingdom",
        "category": "Historical",
        "rank": 3,
        "level": 3,
        "requiredFraction": 1.0,
        "rule": "plausible",
        "cultures": ["Swabian"],
        "areas": ["Swabia"],
        "formEffects": {
            "rankUpgrade": "Kingdom"
        }
    }

    // Felvidek (North Hungary) — Alt-History
    ,{
        "tag": "FLVDK",
        "name": "Felvidek (North Hungary)",
        "category": "Alt-History",
        "rank": 3,
        "level": 3,
        "requiredFraction": 0.85,
        "rule": "plausible",
        "cultures": ["Hungarian"],
        "areas": ["Slovakia"],
        "formEffects": {
            "rankUpgrade": "Kingdom"
        }
    }

    // Hephthalite Empire / White Huns — Alt-History
    ,{
        "tag": "HPEMP",
        "name": "Hephthalite Empire / White Huns",
        "category": "Alt-History",
        "rank": 3,
        "level": 3,
        "requiredFraction": 0.85,
        "rule": "plausible",
        "cultures": ["Turkic (Group)"],
        "areas": ["Transoxiana", "Zhetysu"],
        "formEffects": {
            "rankUpgrade": "Kingdom"
        }
    }

    // Zapadoslavia — Alt-History
    ,{
        "tag": "ZPDSL",
        "name": "Zapadoslavia",
        "category": "Alt-History",
        "rank": 3,
        "level": 3,
        "requiredFraction": 0.95,
        "rule": "plausible",
        "areas": [
            "Prussia",
            "Greater Poland",
            "Mazovia",
            "Central Poland",
            "Lesser Poland",
            "Silesia",
            "Moravia",
            "Bohemia",
            "Slovakia"
        ],
        "formEffects": {
            "rankUpgrade": "Kingdom"
        }
    }

    // Great Scotia — Alt-History
    ,{
        "tag": "GSCTL",
        "name": "Great Scotia",
        "category": "Alt-History",
        "rank": 3,
        "level": 3,
        "requiredFraction": 0.95,
        "rule": "plausible",
        "cultures": ["Scottish (Group)"],
        "areas": ["Scottish Lowlands", "Scottish Highlands", "Hebrides"],
        "locations": ["Ballycastle", "Carrickfergus", "Orkney", "Shetland"],
        "formEffects": {
            "rankUpgrade": "Kingdom",
            "reforms": ["Gsctl Nova Scotian Charter"]
        }
    }

    // Galicia-Lodomeria — Historical
    ,{
        "tag": "GLD",
        "name": "Galicia-Lodomeria",
        "category": "Historical",
        "rank": 3,
        "level": 3,
        "requiredFraction": 0.95,
        "rule": "plausible",
        "areas": ["Red Ruthenia"],
        "locations": ["Putna", "Storozhynets", "Cernauti", "Zalishchyky", "Cetatea Tetina"],
        "formEffects": {
            "rankUpgrade": "Kingdom"
        }
    }

    // Federal Republic of Central America — Historical
    ,{
        "tag": "FROCA",
        "name": "Federal Republic of Central America",
        "category": "Historical",
        "rank": 3,
        "level": 3,
        "requiredFraction": 1.0,
        "rule": "plausible",
        "cultures": ["Iberian (Group)", "Tayrona"],
        "areas": ["Sinu", "Suchiimma", "Caracas", "Apure", "Chunsa", "Caly", "Boiaca", "Panama"],
        "formEffects": {
            "rankUpgrade": "Kingdom"
        }
    }

    // Gran Columbia — Historical
    ,{
        "tag": "GCOLM",
        "name": "Gran Columbia",
        "category": "Historical",
        "rank": 3,
        "level": 3,
        "requiredFraction": 1.0,
        "rule": "plausible",
        "cultures": ["Iberian (Group)", "Tayrona"],
        "areas": ["Sinu", "Suchiimma", "Caracas", "Apure", "Chunsa", "Caly", "Boiaca", "Panama"],
        "formEffects": {
            "rankUpgrade": "Kingdom"
        }
    }

    // Babylon — Fantasy
    ,{
        "tag": "BBLON",
        "name": "Babylon",
        "category": "Fantasy",
        "rank": 3,
        "level": 3,
        "requiredFraction": 0.9,
        "rule": "plausible",
        "areas": ["Iraq Arabi", "Jazira", "Levant"],
        "locations": ["Hillah"],
        "formEffects": {
            "rankUpgrade": "Kingdom"
        }
    }

    // Serene Republic of Australia — Fantasy
    ,{
        "tag": "SROAU",
        "name": "Serene Republic of Australia",
        "category": "Fantasy",
        "rank": 3,
        "level": 3,
        "requiredFraction": 0.85,
        "rule": "plausible",
        "regions": ["Australia", "New Zealand"],
        "formEffects": {
            "rankUpgrade": "Kingdom"
        }
    }

    // Assyria — Fantasy
    ,{
        "tag": "ASYRI",
        "name": "Assyria",
        "category": "Fantasy",
        "rank": 3,
        "level": 3,
        "requiredFraction": 0.9,
        "rule": "plausible",
        "cultures": ["Syriac"],
        "provinces": ["Nusaybin", "Amadiya", "Bitlis"],
        "formEffects": {
            "rankUpgrade": "Kingdom"
        }
    }

    // Latin Empire — Non-Historical
    ,{
        "tag": "LTNEM",
        "name": "Latin Empire",
        "category": "Non-Historical",
        "rank": 3,
        "level": 3,
        "requiredFraction": 0.9,
        "rule": "plausible",
        "cultures": ["Greek (Group)", "Hellenic"],
        "religions": ["Catholic"],
        "provinces": [
            "Constantinople",
            "Kocaeli",
            "Biga",
            "Edirne",
            "Dardanelles",
            "Evros",
            "Lower Macedonia",
            "Chalkidiki",
            "Central Macedonia",
            "Thessaly",
            "Lemnos",
            "Chios"
        ],
        "locations": ["Iznik"],
        "formEffects": {
            "rankUpgrade": "Empire"
        }
    }

    // Oklahoma — US States
    ,{
        "tag": "OKLAH",
        "name": "Oklahoma",
        "category": "US States",
        "rank": 3,
        "level": 3,
        "requiredFraction": 1.0,
        "rule": "plausible",
        "cultures": ["British (Group)", "Cayas", "Hohokam", "Iberian (Group)", "Kitikitish", "Taovaya", "Tula"],
        "regions": ["Great Plains"],
        "locations": [
            "Tulsa",
            "Wewoka",
            "Washita",
            "Kiamichi",
            "Nanatsoho",
            "Tawehash",
            "Wakhakukdhin",
            "Headdhetanwan",
            "Pasukhdin",
            "Chikaskia",
            "Nixgu",
            "Oktahutchee",
            "Gulvau",
            "Hawaastatkiicu",
            "Guichita",
            "Nigitai",
            "Kicpahat",
            "Gulvau",
            "Honih Hiyo He"
        ]
    }

    // Alaska — Modern
    ,{
        "tag": "ALSKA",
        "name": "Alaska",
        "category": "Modern",
        "rank": 3,
        "level": 3,
        "requiredFraction": 0.7,
        "rule": "plausible",
        "regions": ["Alaska"]
    }

    // Missouri — US States
    ,{
        "tag": "MISSR",
        "name": "Missouri",
        "category": "US States",
        "rank": 3,
        "level": 3,
        "requiredFraction": 1.0,
        "rule": "plausible",
        "cultures": ["British (Group)", "Cahokia", "French (Group)", "Kahokiaki", "Kaskankaham", "Ponca", "Tsawi"],
        "areas": ["Missouri"]
    }

    // Flordia — US States
    ,{
        "tag": "FLRDA",
        "name": "Flordia",
        "category": "US States",
        "rank": 3,
        "level": 3,
        "requiredFraction": 1.0,
        "rule": "plausible",
        "cultures": ["Ais", "Apalachee", "Calusa", "Chatot", "Iberian (Group)", "Timucua", "Tocobaga"],
        "regions": ["Great Plains"],
        "locations": [
            "Tulsa",
            "Wewoka",
            "Washita",
            "Kiamichi",
            "Nanatsoho",
            "Tawehash",
            "Wakhakukdhin",
            "Headdhetanwan",
            "Pasukhdin",
            "Chikaskia",
            "Nixgu",
            "Oktahutchee",
            "Gulvau",
            "Hawaastatkiicu",
            "Guichita",
            "Nigitai",
            "Kicpahat",
            "Gulvau",
            "Honih Hiyo He"
        ]
    }

    // Georgia — US States
    ,{
        "tag": "GRGUS",
        "name": "Georgia",
        "category": "US States",
        "rank": 3,
        "level": 3,
        "requiredFraction": 1.0,
        "rule": "plausible",
        "cultures": [
            "Coosa",
            "Coweta",
            "Eufaula",
            "Guale",
            "Guwahiyi",
            "Hitchiti",
            "Iberian (Group)",
            "Oconee",
            "Osage",
            "Sawokli",
            "Tamathli",
            "Tuckabatchee"
        ],
        "areas": ["Georgia Us"]
    }

    // Alabama — US States
    ,{
        "tag": "ALBMA",
        "name": "Alabama",
        "category": "US States",
        "rank": 3,
        "level": 3,
        "requiredFraction": 1.0,
        "rule": "plausible",
        "cultures": ["Iberian (Group)", "Oconee"],
        "areas": ["Georgia Us"]
    }

    // South Carolina — US States
    ,{
        "tag": "SCRLA",
        "name": "South Carolina",
        "category": "US States",
        "rank": 3,
        "level": 3,
        "requiredFraction": 1.0,
        "rule": "plausible",
        "cultures": ["Iberian (Group)", "Oconee"],
        "areas": ["South Carolina"]
    }

    // North Carolina — US States
    ,{
        "tag": "NCRLA",
        "name": "North Carolina",
        "category": "US States",
        "rank": 3,
        "level": 3,
        "requiredFraction": 1.0,
        "rule": "plausible",
        "cultures": ["Iberian (Group)", "Oconee"],
        "areas": ["North Carolina"]
    }

    // Tennessee — US States
    ,{
        "tag": "TNNSS",
        "name": "Tennessee",
        "category": "US States",
        "rank": 3,
        "level": 3,
        "requiredFraction": 1.0,
        "rule": "plausible",
        "cultures": ["Iberian (Group)", "Oconee"],
        "areas": ["Tennessee"]
    }

    // Kentucky — US States
    ,{
        "tag": "KNTKY",
        "name": "Kentucky",
        "category": "US States",
        "rank": 3,
        "level": 3,
        "requiredFraction": 1.0,
        "rule": "plausible",
        "cultures": ["Iberian (Group)", "Oconee"],
        "areas": ["Tennessee"]
    }

    // Ohio — US States
    ,{
        "tag": "OHIOU",
        "name": "Ohio",
        "category": "US States",
        "rank": 3,
        "level": 3,
        "requiredFraction": 1.0,
        "rule": "plausible",
        "cultures": ["Iberian (Group)", "Oconee"],
        "areas": ["Ohio"]
    }

    // Virginia — US States
    ,{
        "tag": "VRGNA",
        "name": "Virginia",
        "category": "US States",
        "rank": 3,
        "level": 3,
        "requiredFraction": 1.0,
        "rule": "plausible",
        "cultures": ["Iberian (Group)", "Oconee"],
        "areas": ["Virginia"]
    }

    // West Virginia — US States
    ,{
        "tag": "WVGNA",
        "name": "West Virginia",
        "category": "US States",
        "rank": 3,
        "level": 3,
        "requiredFraction": 1.0,
        "rule": "plausible",
        "cultures": ["Iberian (Group)", "Oconee"],
        "areas": ["West Virginia"]
    }

    // Maryland — US States
    ,{
        "tag": "MRYLN",
        "name": "Maryland",
        "category": "US States",
        "rank": 3,
        "level": 3,
        "requiredFraction": 1.0,
        "rule": "plausible",
        "cultures": ["Iberian (Group)", "Oconee"],
        "areas": ["Maryland"]
    }

    // Pennsylvania — US States
    ,{
        "tag": "PNSLV",
        "name": "Pennsylvania",
        "category": "US States",
        "rank": 3,
        "level": 3,
        "requiredFraction": 1.0,
        "rule": "plausible",
        "cultures": ["Iberian (Group)", "Oconee"],
        "areas": ["Pennsylvania"]
    }

    // New Jersey — US States
    ,{
        "tag": "NWJSY",
        "name": "New Jersey",
        "category": "US States",
        "rank": 3,
        "level": 3,
        "requiredFraction": 1.0,
        "rule": "plausible",
        "cultures": ["Iberian (Group)", "Oconee"],
        "areas": ["New Jersey"]
    }

    // Louisiana — US States
    ,{
        "tag": "LOSNA",
        "name": "Louisiana",
        "category": "US States",
        "rank": 3,
        "level": 3,
        "requiredFraction": 1.0,
        "rule": "plausible",
        "cultures": ["Iberian (Group)", "Oconee"],
        "areas": ["Louisiana"]
    }

    // Arkansas — US States
    ,{
        "tag": "ARKNS",
        "name": "Arkansas",
        "category": "US States",
        "rank": 3,
        "level": 3,
        "requiredFraction": 1.0,
        "rule": "plausible",
        "cultures": ["Iberian (Group)", "Oconee"],
        "areas": ["Arkansas"]
    }

    // Iowa — US States
    ,{
        "tag": "IOWAU",
        "name": "Iowa",
        "category": "US States",
        "rank": 3,
        "level": 3,
        "requiredFraction": 1.0,
        "rule": "plausible",
        "cultures": ["Iberian (Group)", "Oconee"],
        "areas": ["Iowa"]
    }

    // California — US States
    ,{
        "tag": "CLFRN",
        "name": "California",
        "category": "US States",
        "rank": 3,
        "level": 3,
        "requiredFraction": 1.0,
        "rule": "plausible",
        "cultures": ["Iberian (Group)", "Oconee"],
        "areas": ["California"]
    }

    // Cascadia — US States
    ,{
        "tag": "CSCDA",
        "name": "Cascadia",
        "category": "US States",
        "rank": 3,
        "level": 3,
        "requiredFraction": 1.0,
        "rule": "plausible",
        "cultures": ["Iberian (Group)", "Oconee"],
        "areas": ["Cascadia"]
    }

    // Wyoming — US States
    ,{
        "tag": "WYMNG",
        "name": "Wyoming",
        "category": "US States",
        "rank": 3,
        "level": 3,
        "requiredFraction": 1.0,
        "rule": "plausible",
        "cultures": ["Iberian (Group)", "Oconee"],
        "areas": ["Badlands"]
    }

    // Texas — US States
    ,{
        "tag": "TEXAS",
        "name": "Texas",
        "category": "US States",
        "rank": 3,
        "level": 3,
        "requiredFraction": 1.0,
        "rule": "plausible",
        "cultures": ["Iberian (Group)", "Oconee"],
        "areas": ["Texas"]
    }

    // Michigan — US States
    ,{
        "tag": "MCHGN",
        "name": "Michigan",
        "category": "US States",
        "rank": 3,
        "level": 3,
        "requiredFraction": 1.0,
        "rule": "plausible",
        "cultures": ["Iberian (Group)", "Oconee"],
        "areas": ["Michigan"]
    }

    // Wisconsin — US States
    ,{
        "tag": "WSCNS",
        "name": "Wisconsin",
        "category": "US States",
        "rank": 3,
        "level": 3,
        "requiredFraction": 1.0,
        "rule": "plausible",
        "cultures": ["Iberian (Group)", "Oconee"],
        "areas": ["Wisconsin"]
    }

    // Washington — US States
    ,{
        "tag": "WSHNT",
        "name": "Washington",
        "category": "US States",
        "rank": 3,
        "level": 3,
        "requiredFraction": 1.0,
        "rule": "plausible",
        "cultures": ["Iberian (Group)", "Oconee"],
        "provinces": ["Olympic", "Cascadia"]
    }

    // Oregon — US States
    ,{
        "tag": "OREGN",
        "name": "Oregon",
        "category": "US States",
        "rank": 3,
        "level": 3,
        "requiredFraction": 1.0,
        "rule": "plausible",
        "cultures": ["Iberian (Group)", "Oconee"],
        "provinces": ["Oregon", "Chinook", "Molalla"]
    }

    // First Mexican Empire — Modern
    ,{
        "tag": "MEXCO",
        "name": "First Mexican Empire",
        "category": "Modern",
        "rank": 3,
        "level": 4,
        "requiredFraction": 0.67,
        "rule": "plausible",
        "cultures": ["Nahua"],
        "religions": ["Nahuatl"],
        "areas": ["Guachichil", "Tamaulipeco", "Culiacan", "Tahejoc", "Zacatecas"],
        "regions": ["Mesoamerica"],
        "locations": ["Sobaipuri", "Jocome"]
    }

    // Brandenburg-Prussia — Historical
    ,{
        "tag": "BNDPR",
        "name": "Brandenburg-Prussia",
        "category": "Historical",
        "rank": 3,
        "level": 2,
        "requiredFraction": 1.0,
        "rule": "plausible",
        "cultures": ["Brandenburgish", "Prussian"],
        "areas": ["Prussia", "Brandenburg"]
    }

    // Poland-Hungary — Alt-History
    ,{
        "tag": "PLHUN",
        "name": "Poland-Hungary",
        "category": "Alt-History",
        "rank": 3,
        "level": 3,
        "requiredFraction": 0.5,
        "rule": "plausible",
        "cultures": ["Hungarian", "Polish"],
        "provinces": ["Bresta"],
        "areas": [
            "Lesser Poland",
            "Central Poland",
            "Greater Poland",
            "Slovakia",
            "North Alfold",
            "Transdanubia",
            "South Alfold",
            "Transylvania",
            "Mazovia",
            "Red Ruthenia",
            "Volhynia"
        ]
    }

    // Hungary-Romania — Alt-History
    ,{
        "tag": "HNRMN",
        "name": "Hungary-Romania",
        "category": "Alt-History",
        "rank": 3,
        "level": 3,
        "requiredFraction": 0.5,
        "rule": "plausible",
        "cultures": ["Hungarian", "Romanian"],
        "provinces": ["Bresta"],
        "areas": [
            "Lesser Poland",
            "Central Poland",
            "Greater Poland",
            "Slovakia",
            "North Alfold",
            "Transdanubia",
            "South Alfold",
            "Transylvania",
            "Mazovia",
            "Red Ruthenia",
            "Volhynia"
        ]
    }

    // Camelot — Fantasy
    ,{
        "tag": "CMLOT",
        "name": "Camelot",
        "category": "Fantasy",
        "rank": 3,
        "level": 3,
        "requiredFraction": 0.65,
        "rule": "plausible",
        "cultures": ["Cornish"],
        "areas": ["West Country"]
    }

    // Great Moravia — Historical
    ,{
        "tag": "GMORV",
        "name": "Great Moravia",
        "category": "Historical",
        "rank": 3,
        "level": 3,
        "requiredFraction": 0.85,
        "rule": "plausible",
        "cultures": ["Moravian"],
        "religions": ["Christian (Group)", "Fnr_great_moravia_orthodox", "Hussite"],
        "areas": ["Moravia", "Bohemia", "Silesia"],
        "formEffects": {
            "rankUpgrade": "Kingdom",
            "reforms": ["Gmorv Heirs Of Nitra", "Gmorv Council Of Free Moravians"]
        }
    }

    // Gothia — Non-Historical
    ,{
        "tag": "GOTIA",
        "name": "Gothia",
        "category": "Non-Historical",
        "rank": 3,
        "level": 3,
        "requiredFraction": 0.65,
        "rule": "plausible",
        "cultures": ["Gothic"],
        "areas": ["Crimea", "Yedisan"]
    }

    // Basque Country — Non-Historical
    ,{
        "tag": "BASQU",
        "name": "Basque Country",
        "category": "Non-Historical",
        "rank": 3,
        "level": 3,
        "requiredFraction": 0.65,
        "rule": "plausible",
        "cultures": ["Basque"],
        "provinces": ["Bayonne"],
        "areas": ["Navarre"],
        "locations": ["Orthez", "Dax", "Tosse"]
    }

    // Balochistan — Modern
    ,{
        "tag": "BALCH",
        "name": "Balochistan",
        "category": "Modern",
        "rank": 3,
        "level": 3,
        "requiredFraction": 0.6,
        "rule": "plausible",
        "cultures": ["Iranian (Group)"],
        "areas": ["Baluchistan"]
    }

    // Great Sorbia — Non-Historical
    ,{
        "tag": "GSORB",
        "name": "Great Sorbia",
        "category": "Non-Historical",
        "rank": 3,
        "level": 3,
        "requiredFraction": 0.6,
        "rule": "plausible",
        "cultures": ["German (Group)"],
        "areas": ["Franconia", "Upper Saxony"]
    }

    // Sorbic Kingdom — Non-Historical
    ,{
        "tag": "KSORB",
        "name": "Sorbic Kingdom",
        "category": "Non-Historical",
        "rank": 3,
        "level": 3,
        "requiredFraction": 0.6,
        "rule": "plausible",
        "cultures": ["Sorbian"],
        "areas": ["Franconia", "Upper Saxony"]
    }

    // Kingdom of Hanover — Historical
    ,{
        "tag": "KOFHN",
        "name": "Kingdom of Hanover",
        "category": "Historical",
        "rank": 3,
        "level": 3,
        "requiredFraction": 0.76,
        "rule": "plausible",
        "cultures": ["German (Group)"],
        "areas": ["Lower Saxony"]
    }

    // Polynesia — Non-Historical
    ,{
        "tag": "POLNE",
        "name": "Polynesia",
        "category": "Non-Historical",
        "rank": 3,
        "level": 3,
        "requiredFraction": 0.26,
        "rule": "plausible",
        "cultures": ["Polynesian (Group)"],
        "areas": [
            "Hawaii",
            "Papahanaumokuakea",
            "Aono Raina",
            "Te Henua Enana",
            "Kuki Airani",
            "Tuhaa Pae",
            "Totaiete Ma",
            "Tuamotu",
            "Raeffsky",
            "Palliser",
            "Rapa Nui",
            "Pitcairn",
            "Rawaki",
            "Tuvalu",
            "Futuna",
            "Tonga",
            "Niue",
            "Tokelau",
            "Samoa"
        ],
        "regions": ["Polynesia"]
    }

    // Hawaii — Non-Historical
    ,{
        "tag": "HAWAI",
        "name": "Hawaii",
        "category": "Non-Historical",
        "rank": 3,
        "level": 3,
        "requiredFraction": 0.9,
        "rule": "plausible",
        "cultures": ["Kanaka Maoli", "Polynesian (Group)"],
        "areas": ["Hawaii"]
    }

    // Yugoslavia — Modern
    ,{
        "tag": "YGOSL",
        "name": "Yugoslavia",
        "category": "Modern",
        "rank": 3,
        "level": 3,
        "requiredFraction": 0.8,
        "rule": "plausible",
        "cultures": ["Slavic (Group)", "South Slavic (Group)"],
        "provinces": ["Vardar", "Illyria", "Prilep", "Lower Carniola"],
        "areas": ["Bosnia", "Slavonia", "Croatia", "Serbia"]
    }

    // Baltic States — Alt-History
    ,{
        "tag": "BLTST",
        "name": "Baltic States",
        "category": "Alt-History",
        "rank": 3,
        "level": 3,
        "requiredFraction": 0.8,
        "rule": "plausible",
        "cultures": ["German Baltic"],
        "areas": ["Baltic"]
    }

    // Alsace-Lorraine — Historical
    ,{
        "tag": "ALSLO",
        "name": "Alsace-Lorraine",
        "category": "Historical",
        "rank": 3,
        "level": 3,
        "requiredFraction": 0.6,
        "rule": "plausible",
        "cultures": ["Lorrain", "Rhine Alemannic"],
        "areas": ["Lorraine", "Alsace"]
    }

    // Belarus — Modern
    ,{
        "tag": "BLRUS",
        "name": "Belarus",
        "category": "Modern",
        "rank": 3,
        "level": 3,
        "requiredFraction": 0.85,
        "rule": "plausible",
        "cultures": ["Polatskian", "Smolenskian"],
        "provinces": ["Breslauja", "Svir"],
        "areas": ["White Ruthenia"]
    }

    // Belgium — Historical
    ,{
        "tag": "BLGUM",
        "name": "Belgium",
        "category": "Historical",
        "rank": 3,
        "level": 3,
        "requiredFraction": 0.44,
        "rule": "plausible",
        "cultures": ["Low Franconian", "Walloon"],
        "areas": ["Brabant", "Flanders"]
    }

    // Benelux — Non-Historical
    ,{
        "tag": "BNLUX",
        "name": "Benelux",
        "category": "Non-Historical",
        "rank": 3,
        "level": 3,
        "requiredFraction": 0.75,
        "rule": "plausible",
        "cultures": ["Frisian", "Low Franconian"],
        "areas": ["Brabant", "Flanders", "Holland", "Friesland"]
    }

    // Austria-Bavaria — Non-Historical
    ,{
        "tag": "ASTBV",
        "name": "Austria-Bavaria",
        "category": "Non-Historical",
        "rank": 3,
        "level": 3,
        "requiredFraction": 0.6,
        "rule": "plausible",
        "cultures": ["German (Group)"],
        "areas": ["Austria", "Upper Austria", "Styria", "Bavaria", "Salzburg", "Carinthia", "Slovenia", "Moravia"],
        "formEffects": {
            "rankUpgrade": "Kingdom"
        }
    }

    // Cisalpina — Historical
    ,{
        "tag": "CSPNA",
        "name": "Cisalpina",
        "category": "Historical",
        "rank": 3,
        "level": 3,
        "requiredFraction": 0.8,
        "rule": "plausible",
        "cultures": ["Italian (Group)", "Swiss (Group)"],
        "areas": ["Lombardy", "Emilia"]
    }

    // Commonwealth of England — Historical
    ,{
        "tag": "ENGCM",
        "name": "Commonwealth of England",
        "category": "Historical",
        "rank": 3,
        "level": 3,
        "requiredFraction": 0.99,
        "rule": "plausible",
        "cultures": ["British (Group)"],
        "areas": ["Home Counties", "East Anglia", "Midlands", "West Country"]
    }

    // Czechoslovakia — Modern
    ,{
        "tag": "CZSLO",
        "name": "Czechoslovakia",
        "category": "Modern",
        "rank": 3,
        "level": 3,
        "requiredFraction": 1.0,
        "rule": "plausible",
        "cultures": ["Czech", "Moravian", "Slovak"],
        "areas": ["Bohemia", "Moravia", "Slovakia"]
    }

    // Ukraine — Modern
    ,{
        "tag": "UKRNE",
        "name": "Ukraine",
        "category": "Modern",
        "rank": 3,
        "level": 3,
        "requiredFraction": 0.75,
        "rule": "plausible",
        "cultures": ["Cossack", "Halychian", "Polatskian", "Polesian", "Rusyn", "Ruthenian", "Severian", "Smolenskian", "Volhynian"],
        "regions": ["Ruthenia"]
    }

    // Donetsk Peoples Republic — Modern
    ,{
        "tag": "DNTPR",
        "name": "Donetsk Peoples Republic",
        "category": "Modern",
        "rank": 3,
        "level": 3,
        "requiredFraction": 0.9,
        "rule": "plausible",
        "cultures": ["Mishar", "Polish (Group)"],
        "regions": ["Steppes", "Ruthenia"]
    }

    // Emilia-Romagna — Alt-History
    ,{
        "tag": "EMLRO",
        "name": "Emilia-Romagna",
        "category": "Alt-History",
        "rank": 3,
        "level": 3,
        "requiredFraction": 0.8,
        "rule": "plausible",
        "cultures": ["Italian (Group)"],
        "areas": ["Emilia"]
    }

    // Hesse-Nassau — Alt-History
    ,{
        "tag": "HESNA",
        "name": "Hesse-Nassau",
        "category": "Alt-History",
        "rank": 3,
        "level": 3,
        "requiredFraction": 0.8,
        "rule": "plausible",
        "cultures": ["German (Group)"],
        "provinces": ["Sauerland"],
        "areas": ["Hesse"]
    }

    // Hanseatic League — Alt-History
    ,{
        "tag": "HNSLG",
        "name": "Hanseatic League",
        "category": "Alt-History",
        "rank": 3,
        "level": 3,
        "requiredFraction": 0.04,
        "rule": "plausible",
        "cultures": ["Aukstaitian", "Baltic (Group)", "Danish", "German (Group)", "Hanseatic", "Scandinavian (Group)"],
        "regions": ["North German", "Baltic", "Scandinavian", "Russian", "Great Britain"],
        "formEffects": {
            "rankUpgrade": "Kingdom",
            "reforms": ["Hnslg Territorial Hanseatic Federation", "Hnslg Centralized Merchant Republic"]
        }
    }

    // Kalmar Union — Historical
    ,{
        "tag": "KLMUN",
        "name": "Kalmar Union",
        "category": "Historical",
        "rank": 3,
        "level": 3,
        "requiredFraction": 0.75,
        "rule": "plausible",
        "cultures": ["Scandinavian (Group)"],
        "provinces": ["Halsingland", "Angermanland", "Vasterbotten"],
        "areas": ["Skaneland", "Gotaland", "Svealand", "Finland", "Nord Norge", "Syd Norge", "Iceland", "Denmark", "Holstein"],
        "locations": ["Simo", "Ranua", "Kuivaniemi", "Utajarvi", "Uleaborg", "Brahestad", "Siikalatva"]
    }

    // Lombardy — Alt-History
    ,{
        "tag": "LMBDY",
        "name": "Lombardy",
        "category": "Alt-History",
        "rank": 3,
        "level": 3,
        "requiredFraction": 0.9,
        "rule": "plausible",
        "cultures": ["Italian (Group)"],
        "areas": ["Lombardy"]
    }

    // Sardinia–Piedmont — Historical
    ,{
        "tag": "SDPDM",
        "name": "Sardinia–Piedmont",
        "category": "Historical",
        "rank": 3,
        "level": 3,
        "requiredFraction": 0.85,
        "rule": "plausible",
        "cultures": ["Italian (Group)"],
        "provinces": ["Punente", "Levante"],
        "areas": ["Lombardy", "Piemonte", "Sardinia"],
        "locations": ["Peschiera"]
    }

    // North Italian Confederation = alt-history — Alt-History
    ,{
        "tag": "NITAC",
        "name": "North Italian Confederation = alt-history",
        "category": "Alt-History",
        "rank": 3,
        "level": 3,
        "requiredFraction": 0.9,
        "rule": "plausible",
        "cultures": ["Italian (Group)"],
        "areas": ["Lombardy", "Emilia", "Piemonte", "Veneto", "Tuscany", "Liguria"]
    }

    // South Italian Confederation — Alt-History
    ,{
        "tag": "SITAC",
        "name": "South Italian Confederation",
        "category": "Alt-History",
        "rank": 3,
        "level": 3,
        "requiredFraction": 0.9,
        "rule": "plausible",
        "cultures": ["Italian (Group)"],
        "areas": ["Marche", "Lazio", "Abruzzo", "Campania", "Apulia", "Basilicata", "Sicily", "Sardinia"]
    }

    // Lombardy-Venetia — Historical
    ,{
        "tag": "LMBYV",
        "name": "Lombardy-Venetia",
        "category": "Historical",
        "rank": 3,
        "level": 3,
        "requiredFraction": 0.9,
        "rule": "plausible",
        "cultures": ["Italian (Group)"],
        "areas": ["Lombardy", "Veneto"]
    }

    // Lower Saxony — Alt-History
    ,{
        "tag": "LWSXY",
        "name": "Lower Saxony",
        "category": "Alt-History",
        "rank": 3,
        "level": 3,
        "requiredFraction": 0.8,
        "rule": "plausible",
        "cultures": ["Lower Saxon"],
        "areas": ["Lower Saxony"]
    }

    // Malta — Modern
    ,{
        "tag": "MALTA",
        "name": "Malta",
        "category": "Modern",
        "rank": 3,
        "level": 3,
        "requiredFraction": 1.0,
        "rule": "plausible",
        "cultures": ["Greek", "Maltese"],
        "locations": ["Malta"]
    }

    // Mercia — Alt-History
    ,{
        "tag": "MRCIA",
        "name": "Mercia",
        "category": "Alt-History",
        "rank": 3,
        "level": 3,
        "requiredFraction": 0.95,
        "rule": "plausible",
        "cultures": ["English"],
        "areas": ["Midlands"],
        "excludedTags": ["ENG"]
    }

    // Sweden-Norway — Historical
    ,{
        "tag": "SDNNW",
        "name": "Sweden-Norway",
        "category": "Historical",
        "rank": 3,
        "level": 3,
        "requiredFraction": 0.8,
        "rule": "plausible",
        "cultures": ["Scandinavian (Group)"],
        "areas": ["Skaneland", "Gotaland", "Svealand", "Norrland", "Syd Norge", "Nord Norge"]
    }

    // Turkey — Modern
    ,{
        "tag": "TURKY",
        "name": "Turkey",
        "category": "Modern",
        "rank": 3,
        "level": 5,
        "requiredFraction": 0.85,
        "rule": "plausible",
        "cultures": ["Turkish"],
        "regions": ["Anatolia"],
        "excludedTags": ["TUR"],
        "formEffects": {
            "rankUpgrade": "Kingdom"
        }
    }

    // Caucasia — Alt-History
    ,{
        "tag": "CCASA",
        "name": "Caucasia",
        "category": "Alt-History",
        "rank": 3,
        "level": 3,
        "requiredFraction": 0.68,
        "rule": "plausible",
        "cultures": ["Caucasian (Group)"],
        "regions": ["Caucasus"]
    }

    // Korea — Modern
    ,{
        "tag": "KOREA",
        "name": "Korea",
        "category": "Modern",
        "rank": 3,
        "level": 3,
        "requiredFraction": 1.0,
        "rule": "plausible",
        "cultures": ["Confucian (Group)"],
        "regions": ["Korea"]
    }

    // Afghanistan — Modern
    ,{
        "tag": "AFGAN",
        "name": "Afghanistan",
        "category": "Modern",
        "rank": 3,
        "level": 3,
        "requiredFraction": 0.8,
        "rule": "plausible",
        "cultures": ["Afghan", "Iranian (Group)"],
        "areas": ["Sistan", "Baluchistan"]
    }

    // Mingrelia — Historical
    ,{
        "tag": "MNGRL",
        "name": "Mingrelia",
        "category": "Historical",
        "rank": 3,
        "level": 3,
        "requiredFraction": 0.68,
        "rule": "plausible",
        "cultures": ["Caucasian (Group)"],
        "regions": ["Caucasus"]
    }

    // North Korea — Modern
    ,{
        "tag": "NKORA",
        "name": "North Korea",
        "category": "Modern",
        "rank": 3,
        "level": 3,
        "requiredFraction": 1.0,
        "rule": "plausible",
        "cultures": ["Confucian (Group)"],
        "areas": ["Gwanseo", "Haeseo", "Gwanbuk"]
    }

    // South Korea — Modern
    ,{
        "tag": "SKORA",
        "name": "South Korea",
        "category": "Modern",
        "rank": 3,
        "level": 3,
        "requiredFraction": 1.0,
        "rule": "plausible",
        "cultures": ["Confucian (Group)"],
        "areas": ["Honam", "Hoseo", "Yeongnam", "Gyeonggi", "Gwandong"]
    }

    // Brunei Darussalam — Modern
    ,{
        "tag": "BNDSM",
        "name": "Brunei Darussalam",
        "category": "Modern",
        "rank": 3,
        "level": 3,
        "requiredFraction": 0.9,
        "rule": "plausible",
        "religions": ["Sunni"],
        "provinces": ["Baram", "Upper Brunei", "Lower Brunei", "Kudat", "Lower Rajang", "Upper Rajang", "Kinabatangan"]
    }

    // Philippines — Modern
    ,{
        "tag": "FILPN",
        "name": "Philippines",
        "category": "Modern",
        "rank": 3,
        "level": 3,
        "requiredFraction": 0.67,
        "rule": "plausible",
        "cultures": ["British (Group)", "French (Group)", "German (Group)", "Iberian (Group)"],
        "areas": ["Luzon", "Visayas", "Mindanao"]
    }

    // Philippines (Native variant) — Historical
    ,{
        "tag": "FLPNN",
        "name": "Philippines (Native variant)",
        "category": "Historical",
        "rank": 3,
        "level": 3,
        "requiredFraction": 0.67,
        "rule": "plausible",
        "cultures": ["Austronesian (Group)"],
        "areas": ["Luzon", "Visayas", "Mindanao"]
    }

    // Saudi Arabia — Modern
    ,{
        "tag": "SAUDI",
        "name": "Saudi Arabia",
        "category": "Modern",
        "rank": 3,
        "level": 3,
        "requiredFraction": 0.7,
        "rule": "plausible",
        "cultures": ["Arabian (Group)"],
        "regions": ["Arabia"]
    }

    // Sulawesi — Alt-History
    ,{
        "tag": "SULAW",
        "name": "Sulawesi",
        "category": "Alt-History",
        "rank": 3,
        "level": 3,
        "requiredFraction": 0.75,
        "rule": "plausible",
        "areas": ["Celebes"]
    }

    // Taiping — Non-Historical
    ,{
        "tag": "TPING",
        "name": "Taiping",
        "category": "Non-Historical",
        "rank": 3,
        "level": 3,
        "requiredFraction": 0.51,
        "rule": "plausible",
        "cultures": ["Chinese (Group)", "Mongolian (Group)"],
        "religions": ["Catholic", "Fnr_god_worshipping_society_taiping"],
        "areas": ["Zhejiang", "Fujian", "Jiangxi", "Jiangnan", "Guangdong", "Hubei", "Hunan", "Guangxi", "Huaidong"],
        "excludedTags": ["c"]
    }

    // Tengoku — Fantasy
    ,{
        "tag": "TNGKU",
        "name": "Tengoku",
        "category": "Fantasy",
        "rank": 3,
        "level": 3,
        "requiredFraction": 0.9,
        "rule": "plausible",
        "religions": ["Catholic"],
        "regions": ["Japan"]
    }

    // United Arab Republic — Modern
    ,{
        "tag": "UNARR",
        "name": "United Arab Republic",
        "category": "Modern",
        "rank": 3,
        "level": 3,
        "requiredFraction": 0.9,
        "rule": "plausible",
        "cultures": ["Armenian", "Lower Egyptian", "Syriac", "Upper Egyptian"],
        "provinces": ["Hims", "Halab", "Antakya"],
        "regions": ["Egypt"]
    }

    // Vietnam — Modern
    ,{
        "tag": "VTNAM",
        "name": "Vietnam",
        "category": "Modern",
        "rank": 3,
        "level": 3,
        "requiredFraction": 0.8,
        "rule": "plausible",
        "cultures": ["Austroasiatic (Group)", "Austronesian (Group)"],
        "areas": ["Red River", "Champa", "Red River Delta"]
    }

    // Burma — Modern
    ,{
        "tag": "BURMA",
        "name": "Burma",
        "category": "Modern",
        "rank": 3,
        "level": 3,
        "requiredFraction": 0.6,
        "rule": "plausible",
        "cultures": ["Burmese"],
        "areas": ["Irrawady", "Hill", "Kachin", "Arakhan", "Irrawady Delta", "Shan Highland"]
    }

    // Ceylon — Modern
    ,{
        "tag": "CYLON",
        "name": "Ceylon",
        "category": "Modern",
        "rank": 3,
        "level": 3,
        "requiredFraction": 0.95,
        "rule": "plausible",
        "cultures": ["Sinhalese", "Tamil"],
        "areas": ["Sailan"]
    }

    // Chad — Modern
    ,{
        "tag": "ACHAD",
        "name": "Chad",
        "category": "Modern",
        "rank": 3,
        "level": 3,
        "requiredFraction": 0.95,
        "rule": "plausible",
        "cultures": ["Kanembu"],
        "areas": ["Kanem"]
    }

    // Madagascar — Modern
    ,{
        "tag": "MDGSC",
        "name": "Madagascar",
        "category": "Modern",
        "rank": 3,
        "level": 3,
        "requiredFraction": 0.9,
        "rule": "plausible",
        "cultures": ["Malagasy (Group)"],
        "regions": ["Madagascar"]
    }

    // Manchuria — Non-Historical
    ,{
        "tag": "MNCRA",
        "name": "Manchuria",
        "category": "Non-Historical",
        "rank": 3,
        "level": 3,
        "requiredFraction": 0.4,
        "rule": "plausible",
        "cultures": ["Jurchen (Group)", "Tungusic (Group)"],
        "regions": ["Manchuria"]
    }

    // Beta Israel — Non-Historical
    ,{
        "tag": "BISRA",
        "name": "Beta Israel",
        "category": "Non-Historical",
        "rank": 3,
        "level": 3,
        "requiredFraction": 0.85,
        "rule": "plausible",
        "provinces": ["Akele Guzai", "Hamasien", "Serae", "Enderta", "Tigray", "Bazin"],
        "locations": ["Massawa", "Waldeba", "Dahlak", "Buri", "Dallol", "Edd"]
    }

    // Israel — Controversial
    ,{
        "tag": "ISREL",
        "name": "Israel",
        "category": "Controversial",
        "rank": 3,
        "level": 3,
        "requiredFraction": 0.4,
        "rule": "plausible",
        "cultures": ["Beyte Yisrael", "Sephardi"],
        "areas": ["Levant"]
    }

    // Palestine — Controversial
    ,{
        "tag": "PLSTN",
        "name": "Palestine",
        "category": "Controversial",
        "rank": 3,
        "level": 3,
        "requiredFraction": 0.4,
        "rule": "plausible",
        "cultures": ["Bedouin", "Levantine"],
        "areas": ["Levant"]
    }

    // Alpland — Fantasy
    ,{
        "tag": "ALPLN",
        "name": "Alpland",
        "category": "Fantasy",
        "rank": 3,
        "level": 3,
        "requiredFraction": 0.65,
        "rule": "plausible",
        "cultures": ["Arpitan", "Italian (Group)", "Swiss (Group)"],
        "provinces": ["Pinzgau", "Salzburger Land", "Pongau", "Upper Styria", "Traungau", "Dignois", "Aosta", "Oberwallis", "Bern"],
        "areas": ["Eastern Switzerland", "Savoy", "Tirol", "Carinthia"],
        "locations": [
            "Puget Theniers",
            "Nice",
            "Ventimiglia",
            "Albenga",
            "Susa",
            "Varallo",
            "Domodossola",
            "Locarno",
            "Bellinzona",
            "Montreux",
            "Chiavenna",
            "Bormio",
            "Tresivio",
            "Pieve",
            "Tolmezzo",
            "Tolmin",
            "Bled",
            "Skofja Loka",
            "Waidhofen",
            "Scheibbs",
            "Lilienfeld"
        ],
        "formEffects": {
            "rankUpgrade": "Kingdom",
            "governmentChange": "Republic"
        }
    }

    // The Rhine Confederation — Historical
    ,{
        "tag": "RCONF",
        "name": "The Rhine Confederation",
        "category": "Historical",
        "rank": 3,
        "level": 3,
        "requiredFraction": 1.0,
        "rule": "plausible",
        "cultures": ["German (Group)"],
        "provinces": [
            "Rhine Valley",
            "Schwarzwald",
            "Kraichgau",
            "Odenwald",
            "Taunus",
            "Westerwald",
            "Bergisches Land",
            "Sauerland",
            "Lippe",
            "Schwerin",
            "Brunswick",
            "Altmark",
            "Saale",
            "Leipziger Bucht",
            "Erzgebirge",
            "Flaming",
            "Niederlausitz",
            "Oberlausitz",
            "Elbtal",
            "Wetterau",
            "Spessart",
            "Vogelsberg",
            "Hessen Bergland",
            "Thuringer Becken",
            "Vogtland",
            "Thuringer Wald",
            "Leine",
            "Harz",
            "Hanover",
            "Unterinntal",
            "Oberinntal",
            "Salzburger Land",
            "Vorarlberg"
        ],
        "areas": ["Franconia", "Bavaria", "Swabia", "Mecklenburg"],
        "locations": [
            "Heidelberg",
            "Darmstadt",
            "Offenbach",
            "Dusseldorf",
            "Luneburg",
            "Ebstorf",
            "Fallingbostel",
            "Buckeburg",
            "Neustadt Am Rubenberge",
            "Essen",
            "Bochum",
            "Recklinghausen",
            "Dortmund",
            "Hamm",
            "Magdeburg",
            "Calbe",
            "Celle",
            "Winsen Aller",
            "Isenhagen",
            "Uelzen",
            "Dannenberg",
            "Luchow",
            "Halberstadt",
            "Quedlinburg",
            "Bernburg",
            "Scharding",
            "Ried",
            "St Georgen",
            "Braunau",
            "Brixen",
            "Bruneck",
            "Sterzing",
            "Bischofshofen",
            "Saalfelden",
            "Mittersill",
            "Bruneck"
        ]
    }

    // Kingdom of Aquitaine — Fantasy
    ,{
        "tag": "AQUIT",
        "name": "Kingdom of Aquitaine",
        "category": "Fantasy",
        "rank": 3,
        "level": 3,
        "requiredFraction": 0.65,
        "rule": "plausible",
        "cultures": ["Gascon"],
        "areas": ["Gascony", "Guyenne", "Limousin", "Poitou"]
    }

    // Occitania — Fantasy
    ,{
        "tag": "OCCIT",
        "name": "Occitania",
        "category": "Fantasy",
        "rank": 3,
        "level": 3,
        "requiredFraction": 0.35,
        "rule": "plausible",
        "cultures": ["French (Group)"],
        "areas": ["Gascony", "Guyenne", "Languedoc"]
    }

    // Balkan League — Alt-History
    ,{
        "tag": "BLKLG",
        "name": "Balkan League",
        "category": "Alt-History",
        "rank": 3,
        "level": 3,
        "requiredFraction": 0.5,
        "rule": "plausible",
        "cultures": ["Slavic (Group)", "South Slavic (Group)"],
        "areas": ["Bosnia", "Slavonia", "Croatia", "Serbia", "Albania", "Macedonia", "Bulgaria", "Thrace", "Northern Greece"]
    }

    // Illyria — Fantasy
    ,{
        "tag": "ILYRA",
        "name": "Illyria",
        "category": "Fantasy",
        "rank": 3,
        "level": 3,
        "requiredFraction": 0.5,
        "rule": "plausible",
        "cultures": ["Slavic (Group)", "South Slavic (Group)"],
        "provinces": ["Illyria", "Prilep", "Lower Carniola"],
        "areas": ["Bosnia", "Slavonia", "Croatia", "Serbia"],
        "locations": ["Kruje", "Debar", "Skopje", "Tirana", "Durres"]
    }

    // Bosnia-Serbia — Controversial
    ,{
        "tag": "BSSER",
        "name": "Bosnia-Serbia",
        "category": "Controversial",
        "rank": 3,
        "level": 3,
        "requiredFraction": 0.75,
        "rule": "plausible",
        "cultures": ["Slavic (Group)", "South Slavic (Group)"],
        "areas": ["Bosnia", "Serbia"]
    }

    // Cordoba — Non-Historical
    ,{
        "tag": "CDOBA",
        "name": "Cordoba",
        "category": "Non-Historical",
        "rank": 3,
        "level": 3,
        "requiredFraction": 0.44,
        "rule": "plausible",
        "cultures": ["Iberian (Group)", "Maghrebi (Group)"],
        "religions": ["Muslim (Group)"],
        "areas": ["Andalusia", "Granada", "Extremadura", "Murcia"]
    }

    // East Slavia — Alt-History
    ,{
        "tag": "ESLAV",
        "name": "East Slavia",
        "category": "Alt-History",
        "rank": 3,
        "level": 3,
        "requiredFraction": 0.35,
        "rule": "plausible",
        "cultures": ["Cossack", "Halychian", "Polatskian", "Polesian", "Rusyn", "Ruthenian", "Severian", "Smolenskian", "Volhynian"],
        "regions": ["Ruthenia", "Steppes", "Baltic", "Russian"],
        "formEffects": {
            "rankUpgrade": "Kingdom"
        }
    }

    // Frieslande — Alt-History
    ,{
        "tag": "FIESL",
        "name": "Frieslande",
        "category": "Alt-History",
        "rank": 3,
        "level": 3,
        "requiredFraction": 1.0,
        "rule": "plausible",
        "cultures": ["Frisian"],
        "areas": ["Friesland"]
    }

    // Kingdom of God — Fantasy
    ,{
        "tag": "KOGOD",
        "name": "Kingdom of God",
        "category": "Fantasy",
        "rank": 3,
        "level": 3,
        "requiredFraction": 0.35,
        "rule": "plausible",
        "cultures": ["Italian (Group)"],
        "regions": ["Italy"]
    }

    // Langobards — Non-Historical
    ,{
        "tag": "LNGBD",
        "name": "Langobards",
        "category": "Non-Historical",
        "rank": 3,
        "level": 3,
        "requiredFraction": 0.85,
        "rule": "plausible",
        "cultures": ["Italian (Group)"],
        "regions": ["Italy"]
    }

    // Macedonia — Non-Historical
    ,{
        "tag": "MACED",
        "name": "Macedonia",
        "category": "Non-Historical",
        "rank": 3,
        "level": 3,
        "requiredFraction": 0.75,
        "rule": "plausible",
        "cultures": ["Greek (Group)", "Hellenic"],
        "provinces": ["North Epirus"],
        "areas": ["Macedonia", "Northern Greece"],
        "excludedTags": ["BYZ"]
    }

    // Pontus — Non-Historical
    ,{
        "tag": "PONTU",
        "name": "Pontus",
        "category": "Non-Historical",
        "rank": 3,
        "level": 3,
        "requiredFraction": 0.75,
        "rule": "plausible",
        "cultures": ["Pontic Greek"],
        "areas": ["Pontus", "Crimea", "Matrega"]
    }

    // ═══════════════════════════════════════════
    //  RANK 4 (49 nations)
    // ═══════════════════════════════════════════

    // Sassanids — Fantasy
    ,{
        "tag": "SSNID",
        "name": "Sassanids",
        "category": "Fantasy",
        "rank": 4,
        "level": 4,
        "requiredFraction": 0.35,
        "rule": "plausible",
        "provinces": ["Qatar", "Julfar", "Batina"],
        "areas": ["Iraq Arabi", "Jazira", "Shirvan", "Armenia", "Armenian Highlands", "Georgia"],
        "regions": ["Persia"],
        "locations": ["Kazimah", "Qurain", "Ash Shuaybah", "Jannah", "Al Jubayl", "Al Qatif", "Sayhat", "Manama", "Al Uqayr"],
        "formEffects": {
            "rankUpgrade": "Empire"
        }
    }

    // North German Confederation — Historical
    ,{
        "tag": "NGCFD",
        "name": "North German Confederation",
        "category": "Historical",
        "rank": 4,
        "level": 4,
        "requiredFraction": 0.85,
        "rule": "plausible",
        "cultures": ["German (Group)"],
        "provinces": ["Holstein", "Slesvig", "Sonderjylland", "Arnskrone", "#", "Silesia", "Zagan", "Glogow", "Legnica", "Swidnica", "Wroclaw"],
        "areas": [
            "Hesse",
            "Upper Saxony",
            "Brandenburg",
            "Lower Saxony",
            "Westphalia",
            "Rhineland",
            "Holstein",
            "Pomerania",
            "Prussia",
            "Mecklenburg"
        ],
        "locations": ["Zlotow", "Wyrzysk", "Naklo"],
        "formEffects": {
            "rankUpgrade": "Empire"
        }
    }

    // South German Confederation — Historical
    ,{
        "tag": "SGCFD",
        "name": "South German Confederation",
        "category": "Historical",
        "rank": 4,
        "level": 4,
        "requiredFraction": 0.8,
        "rule": "plausible",
        "cultures": ["Danube Bavarian"],
        "provinces": ["Istria"],
        "areas": [
            "Bavaria",
            "Upper Austria",
            "Austria",
            "Styria",
            "Carinthia",
            "Moravia",
            "Bohemia",
            "Swabia",
            "Salzburg",
            "Tirol",
            "Franconia",
            "Slovenia",
            "Upper Rhine",
            "Alsace"
        ],
        "formEffects": {
            "rankUpgrade": "Empire"
        }
    }

    // Elbian Federation — Alt-History
    ,{
        "tag": "ELBNF",
        "name": "Elbian Federation",
        "category": "Alt-History",
        "rank": 4,
        "level": 4,
        "requiredFraction": 0.8,
        "rule": "plausible",
        "provinces": ["Arnskrone", "Koslin", "Pyritz", "Stettin", "Oberlausitz", "Elbtal"],
        "areas": ["Bohemia", "Moravia", "Silesia", "Brandenburg"],
        "formEffects": {
            "rankUpgrade": "Empire"
        }
    }

    // Hyperborea — Uncategorized
    ,{
        "tag": "HPBRA",
        "name": "Hyperborea",
        "category": "Uncategorized",
        "rank": 4,
        "level": 4,
        "requiredFraction": 0.65,
        "rule": "plausible",
        "regions": ["East Siberia", "West Siberia", "Alaska"],
        "formEffects": {
            "rankUpgrade": "Empire"
        }
    }

    // Assyrian Empire — Fantasy
    ,{
        "tag": "ASYRE",
        "name": "Assyrian Empire",
        "category": "Fantasy",
        "rank": 4,
        "level": 4,
        "requiredFraction": 0.9,
        "rule": "plausible",
        "cultures": ["Fnr Semitic", "Syriac"],
        "areas": ["Levant", "Armenian Highlands"],
        "regions": ["Crescent"],
        "formEffects": {
            "rankUpgrade": "Empire"
        }
    }

    // Japan — Modern
    ,{
        "tag": "JAPAN",
        "name": "Japan",
        "category": "Modern",
        "rank": 4,
        "level": 4,
        "requiredFraction": 1.0,
        "rule": "plausible",
        "provinces": ["Southern Sakhalin"],
        "regions": ["Japan"]
    }

    // Empire of Japan — Modern
    ,{
        "tag": "EOJPN",
        "name": "Empire of Japan",
        "category": "Modern",
        "rank": 4,
        "level": 5,
        "requiredFraction": 1.0,
        "rule": "plausible",
        "capitals": ["Toshima Kanto"],
        "provinces": ["Southern Sakhalin"],
        "regions": ["Japan", "Korea"],
        "formEffects": {
            "rankUpgrade": "Empire"
        }
    }

    // Angevin Empire — Alt-History
    ,{
        "tag": "AGEVN",
        "name": "Angevin Empire",
        "category": "Alt-History",
        "rank": 4,
        "level": 4,
        "requiredFraction": 0.65,
        "rule": "plausible",
        "cultures": ["British (Group)"],
        "provinces": ["Glamorgan", "Brecon", "Dublin", "Wexford"],
        "areas": ["Home Counties", "East Anglia", "West Country", "Midlands", "Northumbria", "Brittany", "Normandy", "Anjou"],
        "locations": ["Pembroke", "Fishguard", "Berwick", "Naas", "Navan", "Drogheda", "Dundalk"],
        "formEffects": {
            "rankUpgrade": "Empire"
        }
    }

    // Austrian Empire — Historical
    ,{
        "tag": "AUSEM",
        "name": "Austrian Empire",
        "category": "Historical",
        "rank": 4,
        "level": 4,
        "requiredFraction": 0.75,
        "rule": "plausible",
        "cultures": ["German (Group)"],
        "areas": [
            "Austria",
            "Upper Austria",
            "Styria",
            "#bavaria",
            "Salzburg",
            "Carinthia",
            "Slovenia",
            "Croatia",
            "Slavonia",
            "Transdanubia",
            "North Alfold",
            "South Alfold",
            "Slovakia",
            "Moravia",
            "Transylvania",
            "Veneto",
            "Lombardy",
            "Tirol",
            "Bohemia",
            "#lesser Poland",
            "#red Ruthenia"
        ],
        "regions": ["#north German", "#south German"],
        "formEffects": {
            "rankUpgrade": "Empire"
        }
    }

    // Bulgaria — Modern
    ,{
        "tag": "BLGEM",
        "name": "Bulgaria",
        "category": "Modern",
        "rank": 4,
        "level": 4,
        "requiredFraction": 0.6,
        "rule": "plausible",
        "cultures": ["Bulgarian"],
        "areas": ["Bulgaria", "Serbia", "Thrace", "Macedonia"],
        "formEffects": {
            "rankUpgrade": "Empire"
        }
    }

    // French Empire — Historical
    ,{
        "tag": "FNCEM",
        "name": "French Empire",
        "category": "Historical",
        "rank": 4,
        "level": 4,
        "requiredFraction": 0.98,
        "rule": "plausible",
        "cultures": ["Celtic (Group)", "French (Group)"],
        "provinces": ["Pumonte", "Cismonte", "Antakya", "Hims", "Halab", "Latakia"],
        "areas": ["Tunis", "Algiers", "Atlas High Plateau", "Tunis"],
        "regions": ["France"],
        "formEffects": {
            "rankUpgrade": "Empire"
        }
    }

    // German Empire — Historical
    ,{
        "tag": "GMNEM",
        "name": "German Empire",
        "category": "Historical",
        "rank": 4,
        "level": 5,
        "requiredFraction": 0.85,
        "rule": "plausible",
        "cultures": ["German (Group)"],
        "provinces": ["Holstein", "Slesvig", "Sonderjylland", "Arnskrone"],
        "areas": [
            "Swabia",
            "Franconia",
            "Upper Rhine",
            "Hesse",
            "Upper Saxony",
            "Brandenburg",
            "Lower Saxony",
            "Westphalia",
            "Rhineland",
            "Holstein",
            "Pomerania",
            "Prussia",
            "Mecklenburg",
            "Bavaria",
            "Silesia"
        ],
        "locations": ["Zlotow", "Wyrzysk", "Naklo"],
        "formEffects": {
            "rankUpgrade": "Empire"
        }
    }

    // Italian Empire — Modern
    ,{
        "tag": "ITNEM",
        "name": "Italian Empire",
        "category": "Modern",
        "rank": 4,
        "level": 4,
        "requiredFraction": 0.9,
        "rule": "plausible",
        "cultures": ["Italian (Group)"],
        "areas": ["Albania"],
        "regions": ["Italy"],
        "formEffects": {
            "rankUpgrade": "Empire"
        }
    }

    // Kyivan Rus — Non-Historical
    ,{
        "tag": "KYVRU",
        "name": "Kyivan Rus",
        "category": "Non-Historical",
        "rank": 4,
        "level": 4,
        "requiredFraction": 0.65,
        "rule": "plausible",
        "cultures": ["Cossack", "Halychian", "Polatskian", "Polesian", "Rusyn", "Ruthenian", "Severian", "Smolenskian", "Volhynian"],
        "provinces": ["Karachev", "Kozelsk", "Masalsk", "Rzhev"],
        "areas": ["Lithuania", "Zaporizhzhia", "Yedisan", "West Novgorod", "Smolensk", "East Novgorod"],
        "regions": ["Ruthenia"],
        "locations": ["Kuvshinovo", "Torzhok", "Bernovo", "Gorodok", "Zubtsov"]
    }

    // Russian Empire — Historical
    ,{
        "tag": "RUSEM",
        "name": "Russian Empire",
        "category": "Historical",
        "rank": 4,
        "level": 4,
        "requiredFraction": 0.88,
        "rule": "plausible",
        "cultures": ["Russian (Group)"],
        "regions": ["Russian", "Ural", "Steppes", "Ruthenia"],
        "formEffects": {
            "rankUpgrade": "Empire"
        }
    }

    // Russian Federation — Modern
    ,{
        "tag": "RUFED",
        "name": "Russian Federation",
        "category": "Modern",
        "rank": 4,
        "level": 4,
        "requiredFraction": 0.85,
        "rule": "plausible",
        "cultures": ["Russian (Group)"],
        "regions": ["Russian", "Ural", "Steppes", "Ruthenia"],
        "formEffects": {
            "rankUpgrade": "Empire"
        }
    }

    // Serbian Empire — Historical
    ,{
        "tag": "SRBEM",
        "name": "Serbian Empire",
        "category": "Historical",
        "rank": 4,
        "level": 4,
        "requiredFraction": 0.6,
        "rule": "plausible",
        "cultures": ["Serbian"],
        "areas": ["Northern Greece", "Serbia", "Albania", "Macedonia"],
        "formEffects": {
            "rankUpgrade": "Empire"
        }
    }

    // Swedish Empire — Historical
    ,{
        "tag": "SWDEM",
        "name": "Swedish Empire",
        "category": "Historical",
        "rank": 4,
        "level": 4,
        "requiredFraction": 0.95,
        "rule": "plausible",
        "cultures": ["Scandinavian (Group)"],
        "provinces": [
            "Lopskaya",
            "Vodskaya",
            "Estonia",
            "Rotalia",
            "North Livonia",
            "Tartu",
            "Inner Livonia",
            "South Livonia",
            "Vorpommern",
            "Elbmarch",
            "Jamtland",
            "Korela"
        ],
        "areas": ["Skaneland", "Gotaland", "Svealand", "Norrland", "Finland"],
        "locations": ["Wismar"],
        "formEffects": {
            "rankUpgrade": "Empire"
        }
    }

    // The United Kingdom — Modern
    ,{
        "tag": "UKKDM",
        "name": "The United Kingdom",
        "category": "Modern",
        "rank": 4,
        "level": 4,
        "requiredFraction": 0.75,
        "rule": "plausible",
        "cultures": ["British (Group)"],
        "regions": ["Great Britain", "Ireland"]
    }

    // Wendish Empire — Alt-History
    ,{
        "tag": "WNDEM",
        "name": "Wendish Empire",
        "category": "Alt-History",
        "rank": 4,
        "level": 4,
        "requiredFraction": 0.7,
        "rule": "plausible",
        "cultures": ["Polish (Group)"],
        "provinces": ["Neumark", "Uckermark", "Grodno"],
        "areas": ["Pomerania", "Mecklenburg"],
        "regions": ["Baltic"],
        "formEffects": {
            "rankUpgrade": "Empire"
        }
    }

    // Armenian Empire — Non-Historical
    ,{
        "tag": "AMNAE",
        "name": "Armenian Empire",
        "category": "Non-Historical",
        "rank": 4,
        "level": 4,
        "requiredFraction": 0.75,
        "rule": "plausible",
        "cultures": ["Armenian"],
        "regions": ["Caucasus"],
        "formEffects": {
            "rankUpgrade": "Empire"
        }
    }

    // Arabian Empire — Fantasy
    ,{
        "tag": "ARABE",
        "name": "Arabian Empire",
        "category": "Fantasy",
        "rank": 4,
        "level": 4,
        "requiredFraction": 0.75,
        "rule": "plausible",
        "cultures": ["Arabian (Group)", "Arabic (Group)"],
        "regions": ["Arabia", "Crescent"],
        "formEffects": {
            "rankUpgrade": "Empire"
        }
    }

    // Goguryeo — Non-Historical
    ,{
        "tag": "GGURY",
        "name": "Goguryeo",
        "category": "Non-Historical",
        "rank": 4,
        "level": 4,
        "requiredFraction": 0.95,
        "rule": "plausible",
        "cultures": ["Confucian (Group)"],
        "regions": ["Korea"]
    }

    // Himalayan Empire — Fantasy
    ,{
        "tag": "HMLAY",
        "name": "Himalayan Empire",
        "category": "Fantasy",
        "rank": 4,
        "level": 4,
        "requiredFraction": 0.35,
        "rule": "plausible",
        "cultures": ["Indo Aryan (Group)", "Tibeto Burman (Group)"],
        "provinces": ["Kangra", "Punjab Hills"],
        "areas": ["Nepal", "Upper Indus", "Monyul"],
        "regions": ["Tibet"],
        "formEffects": {
            "rankUpgrade": "Empire"
        }
    }

    // Omani Empire — Historical
    ,{
        "tag": "OMANE",
        "name": "Omani Empire",
        "category": "Historical",
        "rank": 4,
        "level": 4,
        "requiredFraction": 1.0,
        "rule": "plausible",
        "cultures": ["Omani"],
        "areas": ["Oman"],
        "locations": ["Mirbat"],
        "formEffects": {
            "rankUpgrade": "Empire"
        }
    }

    // Tibetan Empire — Non-Historical
    ,{
        "tag": "TBETE",
        "name": "Tibetan Empire",
        "category": "Non-Historical",
        "rank": 4,
        "level": 4,
        "requiredFraction": 0.8,
        "rule": "plausible",
        "cultures": ["Tibeto Burman (Group)"],
        "regions": ["Tibet"],
        "formEffects": {
            "rankUpgrade": "Empire"
        }
    }

    // Chola Empire — Non-Historical
    ,{
        "tag": "CHOLA",
        "name": "Chola Empire",
        "category": "Non-Historical",
        "rank": 4,
        "level": 4,
        "requiredFraction": 0.3,
        "rule": "plausible",
        "cultures": ["Tamil"],
        "areas": ["Tamil Land", "Malabar", "Andhra", "Orissa", "Bengal"],
        "formEffects": {
            "rankUpgrade": "Empire"
        }
    }

    // Abyssinia — Alt-History
    ,{
        "tag": "ABYSA",
        "name": "Abyssinia",
        "category": "Alt-History",
        "rank": 4,
        "level": 4,
        "requiredFraction": 0.95,
        "rule": "plausible",
        "cultures": ["Amhara"],
        "regions": ["Ethiopia"]
    }

    // Adriatic Empire — Fantasy
    ,{
        "tag": "ADREM",
        "name": "Adriatic Empire",
        "category": "Fantasy",
        "rank": 4,
        "level": 4,
        "requiredFraction": 0.65,
        "rule": "plausible",
        "cultures": ["Albanian", "Bosnian", "Croatian", "Emilian", "Friulian", "Median", "Neapolitan", "Serbian", "Venetian"],
        "provinces": [
            "Ferrara",
            "Gorizia",
            "Romagna",
            "Urbino",
            "Marche",
            "Zeta",
            "Lower Carniola",
            "Illyria",
            "Abruzzo Citra",
            "Abruzzo Ultra",
            "Molise",
            "Capitanata",
            "Bari",
            "Otranto",
            "Hum"
        ],
        "areas": ["Veneto", "Croatia"],
        "locations": ["Slunj"],
        "formEffects": {
            "rankUpgrade": "Empire"
        }
    }

    // Anglo-Dutch Union — Fantasy
    ,{
        "tag": "ANDUH",
        "name": "Anglo-Dutch Union",
        "category": "Fantasy",
        "rank": 4,
        "level": 4,
        "requiredFraction": 0.75,
        "rule": "plausible",
        "cultures": ["English", "Frisian", "Low Franconian"],
        "areas": [
            "Home Counties",
            "East Anglia",
            "West Country",
            "Northumbria",
            "Midlands",
            "Flanders",
            "Holland",
            "Friesland",
            "Brabant",
            "Wallonia"
        ]
    }

    // Catholica Russica — Fantasy
    ,{
        "tag": "CATRU",
        "name": "Catholica Russica",
        "category": "Fantasy",
        "rank": 4,
        "level": 4,
        "requiredFraction": 0.5,
        "rule": "plausible",
        "cultures": ["Russian (Group)", "Slavic (Group)"],
        "religions": ["Catholic"],
        "regions": ["Russian", "Ural", "Steppes", "Ruthenia"],
        "formEffects": {
            "rankUpgrade": "Empire"
        }
    }

    // Celtic Union — Alt-History
    ,{
        "tag": "CTUNN",
        "name": "Celtic Union",
        "category": "Alt-History",
        "rank": 4,
        "level": 4,
        "requiredFraction": 0.65,
        "rule": "plausible",
        "cultures": ["Celtic (Group)"],
        "provinces": ["Cornwall", "Devon"],
        "areas": ["Brittany", "Wales", "Scottish Lowlands", "Scottish Highlands", "Hebrides", "Galicia"],
        "regions": ["Ireland"]
    }

    // Dual Monarchy — Alt-History
    ,{
        "tag": "DLMON",
        "name": "Dual Monarchy",
        "category": "Alt-History",
        "rank": 4,
        "level": 4,
        "requiredFraction": 0.9,
        "rule": "plausible",
        "cultures": ["British (Group)", "French (Group)"],
        "areas": [
            "West Country",
            "Home Counties",
            "East Anglia",
            "Midlands",
            "Northumbria",
            "Wales",
            "Brittany",
            "Normandy",
            "Anjou",
            "Guyenne",
            "Gascony",
            "Languedoc",
            "Poitou",
            "Limousin",
            "Ile De France",
            "Orleanais"
        ],
        "regions": ["Ireland"],
        "locations": ["Mann"],
        "formEffects": {
            "rankUpgrade": "Empire"
        }
    }

    // Franco-Iberian Empire — Fantasy
    ,{
        "tag": "FNCIB",
        "name": "Franco-Iberian Empire",
        "category": "Fantasy",
        "rank": 4,
        "level": 4,
        "requiredFraction": 0.67,
        "rule": "plausible",
        "cultures": ["French (Group)", "Iberian (Group)"],
        "regions": ["France", "Iberia"],
        "formEffects": {
            "rankUpgrade": "Empire"
        }
    }

    // Gallic Empire — Non-Historical
    ,{
        "tag": "GLCEM",
        "name": "Gallic Empire",
        "category": "Non-Historical",
        "rank": 4,
        "level": 4,
        "requiredFraction": 0.6,
        "rule": "plausible",
        "cultures": ["Celtic (Group)", "Fnr Gallo Roman", "French"],
        "religions": ["Fnr_gallo_roman"],
        "regions": ["France"],
        "formEffects": {
            "rankUpgrade": "Empire"
        }
    }

    // Tarraconensis — Fantasy
    ,{
        "tag": "TRCNS",
        "name": "Tarraconensis",
        "category": "Fantasy",
        "rank": 4,
        "level": 3,
        "requiredFraction": 0.85,
        "rule": "plausible",
        "cultures": ["Iberian (Group)"],
        "regions": ["Iberia"],
        "formEffects": {
            "rankUpgrade": "Kingdom"
        }
    }

    // Britannia — Fantasy
    ,{
        "tag": "BRTNA",
        "name": "Britannia",
        "category": "Fantasy",
        "rank": 4,
        "level": 3,
        "requiredFraction": 0.85,
        "rule": "plausible",
        "cultures": ["British (Group)"],
        "areas": ["West Country", "Home Counties", "East Anglia", "Wales", "Midlands"],
        "formEffects": {
            "rankUpgrade": "Kingdom"
        }
    }

    // Hungarian Empire — Alt-History
    ,{
        "tag": "HNGEM",
        "name": "Hungarian Empire",
        "category": "Alt-History",
        "rank": 4,
        "level": 4,
        "requiredFraction": 0.85,
        "rule": "plausible",
        "cultures": ["Hungarian (Group)"],
        "regions": ["Carpathia"],
        "formEffects": {
            "rankUpgrade": "Empire"
        }
    }

    // Iberian Empire/Union — Fantasy
    ,{
        "tag": "IBNEM",
        "name": "Iberian Empire/Union",
        "category": "Fantasy",
        "rank": 4,
        "level": 4,
        "requiredFraction": 0.85,
        "rule": "plausible",
        "cultures": ["Iberian (Group)"],
        "regions": ["Iberia"],
        "formEffects": {
            "rankUpgrade": "Empire"
        }
    }

    // Italian Merchant Alliance — Alt-History
    ,{
        "tag": "ITMCH",
        "name": "Italian Merchant Alliance",
        "category": "Alt-History",
        "rank": 4,
        "level": 3,
        "requiredFraction": 0.25,
        "rule": "plausible",
        "cultures": ["Italian (Group)"],
        "regions": ["Italy"]
    }

    // Jagiellonian Empire — Non-Historical
    ,{
        "tag": "JGLNN",
        "name": "Jagiellonian Empire",
        "category": "Non-Historical",
        "rank": 4,
        "level": 4,
        "requiredFraction": 0.4,
        "rule": "plausible",
        "cultures": [
            "Cossack",
            "Halychian",
            "Polatskian",
            "Polesian",
            "Polish",
            "Polish (Group)",
            "Rusyn",
            "Ruthenian",
            "Severian",
            "Smolenskian",
            "Volhynian"
        ],
        "areas": ["Bohemia", "Moravia"],
        "regions": ["Ruthenia", "Baltic", "Carpathia"],
        "formEffects": {
            "rankUpgrade": "Empire"
        }
    }

    // Ummayad Caliphate — Non-Historical
    ,{
        "tag": "UMAYA",
        "name": "Ummayad Caliphate",
        "category": "Non-Historical",
        "rank": 4,
        "level": 5,
        "requiredFraction": 0.35,
        "rule": "plausible",
        "cultures": ["Arabic (Group)", "Iberian (Group)", "Iranian (Group)", "Maghrebi (Group)"],
        "religions": ["Sunni"],
        "areas": ["Cilicia"],
        "regions": ["Crescent", "Caucasus", "Persia", "Egypt", "Maghreb", "Iberia"],
        "formEffects": {
            "rankUpgrade": "Empire"
        }
    }

    // Rashidun Caliphate — Non-Historical
    ,{
        "tag": "RSHDN",
        "name": "Rashidun Caliphate",
        "category": "Non-Historical",
        "rank": 4,
        "level": 4,
        "requiredFraction": 0.35,
        "rule": "plausible",
        "cultures": ["Arabic (Group)", "Iberian (Group)", "Iranian (Group)", "Maghrebi (Group)"],
        "provinces": ["Cyprus"],
        "areas": ["Tripolitania"],
        "regions": ["Crescent", "Caucasus", "Persia", "Egypt"],
        "formEffects": {
            "rankUpgrade": "Empire"
        }
    }

    // Abbasid Caliphate — Non-Historical
    ,{
        "tag": "ABSID",
        "name": "Abbasid Caliphate",
        "category": "Non-Historical",
        "rank": 4,
        "level": 4,
        "requiredFraction": 0.35,
        "rule": "plausible",
        "cultures": ["Arabic (Group)", "Iberian (Group)", "Iranian (Group)", "Maghrebi (Group)"],
        "provinces": ["Cyprus", "Crete"],
        "regions": ["Crescent", "Caucasus", "Persia", "Egypt"],
        "formEffects": {
            "rankUpgrade": "Empire"
        }
    }

    // Fatimid Caliphate — Non-Historical
    ,{
        "tag": "FTMID",
        "name": "Fatimid Caliphate",
        "category": "Non-Historical",
        "rank": 4,
        "level": 4,
        "requiredFraction": 0.45,
        "rule": "plausible",
        "cultures": ["Arabic (Group)", "Iberian (Group)", "Iranian (Group)", "Maghrebi (Group)"],
        "areas": ["Levant", "Hedjaz", "Tripolitania", "Tunis", "Sicily", "Cyrenaica", "Lower Egypt", "Sinai", "Upper Egypt"],
        "formEffects": {
            "rankUpgrade": "Empire"
        }
    }

    // East Francia — Non-Historical
    ,{
        "tag": "KOGER",
        "name": "East Francia",
        "category": "Non-Historical",
        "rank": 4,
        "level": 4,
        "requiredFraction": 0.7,
        "rule": "plausible",
        "cultures": ["German (Group)"],
        "provinces": ["Altmark", "Thuringer Wald", "Lower Carinthia", "Upper Styria", "Pongau", "Salzburger Land", "Odenwald"],
        "areas": [
            "Holstein",
            "Lower Saxony",
            "Westphalia",
            "Hesse",
            "Franconia",
            "Bavaria",
            "Swabia",
            "Austria",
            "Upper Austria",
            "Slovenia"
        ]
    }

    // Lusitanian Empire — Non-Historical
    ,{
        "tag": "LUSIT",
        "name": "Lusitanian Empire",
        "category": "Non-Historical",
        "rank": 4,
        "level": 4,
        "requiredFraction": 0.95,
        "rule": "plausible",
        "cultures": ["Portuguese"],
        "areas": ["North Portugal", "South Portugal", "Galicia"],
        "formEffects": {
            "rankUpgrade": "Empire"
        }
    }

    // North Sea Empire — Non-Historical
    ,{
        "tag": "NOSEM",
        "name": "North Sea Empire",
        "category": "Non-Historical",
        "rank": 4,
        "level": 4,
        "requiredFraction": 0.75,
        "rule": "plausible",
        "cultures": ["British (Group)", "Scandinavian (Group)"],
        "areas": ["Home Counties", "Midlands", "East Anglia", "Northumbria", "Denmark", "Skaneland", "Syd Norge", "Nord Norge"],
        "formEffects": {
            "rankUpgrade": "Empire"
        }
    }

    // ═══════════════════════════════════════════
    //  RANK 5 (12 nations)
    // ═══════════════════════════════════════════

    // Austro-Hungarian Empire — Historical
    ,{
        "tag": "ASHNG",
        "name": "Austro-Hungarian Empire",
        "category": "Historical",
        "rank": 5,
        "level": 5,
        "requiredFraction": 0.9,
        "rule": "plausible",
        "cultures": ["German (Group)"],
        "provinces": ["Sanok", "Drohobych", "Zhydachiv", "Halych", "Pocutia", "Nowy Sacz"],
        "areas": [
            "Austria",
            "Upper Austria",
            "Styria",
            "Salzburg",
            "Carinthia",
            "Slovenia",
            "Croatia",
            "Slavonia",
            "Transdanubia",
            "North Alfold",
            "South Alfold",
            "Slovakia",
            "Moravia",
            "Transylvania",
            "Tirol",
            "Bosnia",
            "Bohemia"
        ],
        "locations": ["Kotor"],
        "formEffects": {
            "rankUpgrade": "Empire",
            "reforms": ["Ashng Hungarian Compromise", "Ashng Imperial And Royal Administration"]
        }
    }

    // British Empire — Historical
    ,{
        "tag": "BISHE",
        "name": "British Empire",
        "category": "Historical",
        "rank": 5,
        "level": 6,
        "requiredFraction": 0.8,
        "rule": "plausible",
        "cultures": ["British (Group)"],
        "provinces": [
            "Cyprus",
            "Gharbiyya",
            "Dakahliyya",
            "Sharqiyya",
            "Cairo",
            "Bahnasa",
            "Minya",
            "Asyut",
            "Qusiyya",
            "Red Sea Coast",
            "Ciid",
            "Guban",
            "Maakhir",
            "Minnetonka",
            "Northern Vancouver",
            "Southern Vancouver",
            "Halkomelem",
            "Strathcona",
            "Chilcotin",
            "Columbia Basin",
            "North Shuswap",
            "South Shuswap",
            "East Shuswap",
            "North Ktunaxa"
        ],
        "areas": [
            "Falklands",
            "Kerema",
            "Milne",
            "Tinputz",
            "Temotu",
            "Athabasca",
            "Columbia Interior",
            "Yukon",
            "Saskatchewan",
            "Red River",
            "Superior",
            "Orissa",
            "Bengal",
            "Arakhan",
            "Assam",
            "Hill",
            "Irrawady Delta",
            "Irrawady",
            "Kachin",
            "Jharkhand",
            "Chota Nagpur",
            "Mithila",
            "Bhojpur",
            "Doab",
            "Awadh",
            "Rokhilkhand",
            "Punjab",
            "Rajputana",
            "Gujarat",
            "Saurashtra",
            "Sindh"
        ],
        "regions": ["Great Britain", "Deccan", "Central India", "Ireland", "Australia", "New Zealand", "Canada", "East Coast"],
        "locations": [
            "Gibraltar",
            "Ciudadela De Menorca",
            "Malta",
            "Zakynthos",
            "Rashid",
            "Damanhur",
            "Ramsis",
            "Kharibta",
            "Tarrana",
            "Wadi El Natrun",
            "Similkameen",
            "Q Espiea",
            "Snk Mip",
            "Illecillewaet",
            "Spaxomin",
            "Okanagan",
            "Akisq Nuk",
            "Bermuda",
            "Mauritius"
        ],
        "formEffects": {
            "rankUpgrade": "Empire"
        }
    }

    // Eastern Roman Empire — Non-Historical
    ,{
        "tag": "EASRE",
        "name": "Eastern Roman Empire",
        "category": "Non-Historical",
        "rank": 5,
        "level": 5,
        "requiredFraction": 0.6,
        "rule": "plausible",
        "cultures": ["Greek (Group)", "Hellenic"],
        "religions": ["Christian (Group)", "Hellenism"],
        "capitals": ["Constantinople"],
        "areas": [
            "Thrace",
            "Macedonia",
            "Bulgaria",
            "Northern Greece",
            "Morea",
            "Serbia",
            "Albania",
            "Aegean Archipelago",
            "Levant",
            "Sinai",
            "Lower Egypt",
            "Upper Egypt",
            "Cyrenaica"
        ],
        "regions": ["Anatolia"],
        "formEffects": {
            "rankUpgrade": "Empire"
        }
    }

    // Western Roman Empire — Non-Historical
    ,{
        "tag": "WESRE",
        "name": "Western Roman Empire",
        "category": "Non-Historical",
        "rank": 5,
        "level": 5,
        "requiredFraction": 0.6,
        "rule": "plausible",
        "cultures": ["French (Group)", "Iberian (Group)", "Italian (Group)"],
        "provinces": ["Trentino", "Kert"],
        "areas": [
            "Algiers",
            "Tunis",
            "Tripolitania",
            "Western Switzerland",
            "Central Switzerland",
            "Slovenia",
            "Croatia",
            "Slavonia",
            "Bosnia"
        ],
        "regions": ["France", "Iberia", "Italy"],
        "locations": ["Lasko", "Celje", "Al Mazamma", "Badis", "Tizgane", "Tetouan", "Tazroute", "Asilah", "Ceuta", "Tangier"],
        "formEffects": {
            "rankUpgrade": "Empire"
        }
    }

    // European Union — Modern
    ,{
        "tag": "EUROP",
        "name": "European Union",
        "category": "Modern",
        "rank": 5,
        "level": 5,
        "requiredFraction": 0.34,
        "rule": "plausible",
        "cultures": [
            "Bohemian (Group)",
            "British (Group)",
            "French (Group)",
            "German (Group)",
            "Iberian (Group)",
            "Italian (Group)",
            "Polish (Group)"
        ],
        "provinces": ["Lower Macedonia", "Chalkidiki", "Central Macedonia", "Raseiniai", "Upyte", "Donegal"],
        "areas": [
            "Silesia",
            "Prussia",
            "Central Poland",
            "Greater Poland",
            "Mazovia",
            "Lesser Poland",
            "Slovakia",
            "Transdanubia",
            "North Alfold",
            "South Alfold",
            "Transylvania",
            "Wallachia",
            "Bulgaria",
            "Thrace",
            "Northern Greece",
            "Morea",
            "Baltic",
            "Denmark",
            "Skaneland",
            "Gotaland",
            "Svealand",
            "Norrland",
            "Finland",
            "Munster",
            "Connaught",
            "Leinster"
        ],
        "regions": ["France", "Iberia", "North German", "South German", "Italy"],
        "formEffects": {
            "rankUpgrade": "Empire"
        }
    }

    // Soviet Union — Modern
    ,{
        "tag": "SOVET",
        "name": "Soviet Union",
        "category": "Modern",
        "rank": 5,
        "level": 5,
        "requiredFraction": 0.92,
        "rule": "plausible",
        "cultures": ["Russian (Group)"],
        "regions": ["Russian", "Ural", "Steppes", "Ruthenia"],
        "formEffects": {
            "rankUpgrade": "Empire"
        }
    }

    // Empire of China — Modern
    ,{
        "tag": "CNAEM",
        "name": "Empire of China",
        "category": "Modern",
        "rank": 5,
        "level": 5,
        "requiredFraction": 0.78,
        "rule": "plausible",
        "cultures": ["Chinese (Group)"],
        "regions": ["North China", "East China", "South China", "West China", "Tibet"],
        "formEffects": {
            "rankUpgrade": "Empire"
        }
    }

    // Peoples Republic of China — Modern
    ,{
        "tag": "PRCCN",
        "name": "Peoples Republic of China",
        "category": "Modern",
        "rank": 5,
        "level": 5,
        "requiredFraction": 0.85,
        "rule": "plausible",
        "cultures": ["Chinese (Group)"],
        "regions": ["North China", "East China", "South China", "West China", "Tibet"]
    }

    // Republic of China — Modern
    ,{
        "tag": "ROCCN",
        "name": "Republic of China",
        "category": "Modern",
        "rank": 5,
        "level": 5,
        "requiredFraction": 0.76,
        "rule": "plausible",
        "cultures": ["Chinese (Group)"],
        "regions": ["North China", "East China", "South China", "West China", "Tibet"]
    }

    // The Horde — Fantasy
    ,{
        "tag": "HORDE",
        "name": "The Horde",
        "category": "Fantasy",
        "rank": 5,
        "level": 5,
        "requiredFraction": 0.8,
        "rule": "plausible",
        "cultures": ["Mongolian"],
        "regions": ["Steppes"],
        "subContinents": ["Central Asia"]
    }

    // Carolingian Empire — Non-Historical
    ,{
        "tag": "CAROL",
        "name": "Carolingian Empire",
        "category": "Non-Historical",
        "rank": 5,
        "level": 5,
        "requiredFraction": 0.6,
        "rule": "plausible",
        "cultures": ["French (Group)"],
        "regions": ["France", "North German", "South German", "Italy"],
        "formEffects": {
            "rankUpgrade": "Empire",
            "reforms": ["Carol Centers Of Realm"]
        }
    }

    // Macedonian Empire — Non-Historical
    ,{
        "tag": "MCDEM",
        "name": "Macedonian Empire",
        "category": "Non-Historical",
        "rank": 5,
        "level": 5,
        "requiredFraction": 0.69,
        "rule": "plausible",
        "cultures": ["Greek (Group)", "Hellenic"],
        "religions": ["Christian (Group)", "Hellenism"],
        "areas": [
            "Macedonia",
            "Northern Greece",
            "Thrace",
            "Bulgaria",
            "Armenian Highlands",
            "Eastern Khorasan",
            "Badakhshan"
        ],
        "regions": ["Crescent", "Persia", "Egypt", "Anatolia"],
        "excludedTags": ["BYZ"],
        "formEffects": {
            "rankUpgrade": "Empire"
        }
    }
];
