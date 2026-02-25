// Achievement Manager Scripts
// Xirtam 3 — Noah Gamble

// ─────────────────────────────────────────────────────────────────────────────
// MODULE-SCOPE UTILITIES
// These live outside DOMContentLoaded so any function can call them.
// filterAchievements and exportAchievements were previously trapped inside
// loadSteamAchievements (BUG-04 fix — see previous revision).
// ─────────────────────────────────────────────────────────────────────────────

/**
 * Updates the profile strip (Zone 1 of the sidebar) with the given data.
 * This is the ONLY function that should write to #profile-info.
 * JS must never call innerHTML on .game-list or anything above #left-panel.
 *
 * @param {{ name: string, avatar: string }|null} profile
 *   Pass a profile object to show connected state, or null to reset to
 *   the signed-out placeholder.
 */
function updateProfileStrip(profile) {
    const avatarEl  = document.getElementById("steam-avatar");
    const nameEl    = document.getElementById("steam-name");
    const statusEl  = document.getElementById("profile-status");
    const infoEl    = document.getElementById("profile-info");

    if (!avatarEl || !nameEl || !statusEl || !infoEl) return;

    if (profile) {
        avatarEl.src          = profile.avatar || "";
        nameEl.textContent    = profile.name   || "Unknown";
        statusEl.textContent  = "● Connected";
        infoEl.classList.add("is-connected");
    } else {
        avatarEl.src          = "";
        nameEl.textContent    = "Not Connected";
        statusEl.textContent  = "○ Sign in via Steam";
        infoEl.classList.remove("is-connected");
    }
}

/**
 * Filters the achievement list by name or description.
 * Handles both Steam achievements (DOM-based visibility toggle) and
 * custom achievements (re-renders from localStorage).
 *
 * @param {string} gameName  - Current game name (used for custom achievement lookup).
 * @param {string} filterText - Lowercased search string.
 */
function filterAchievements(gameName, filterText) {
    // Steam list — show/hide existing DOM nodes
    const steamList = document.getElementById("steam-achievements");
    if (steamList) {
        steamList.querySelectorAll(".achievement-item").forEach(item => {
            const name = item.querySelector("h4")?.textContent.toLowerCase() || "";
            const desc = item.querySelector("p")?.textContent.toLowerCase()  || "";
            item.style.display = (name.includes(filterText) || desc.includes(filterText))
                ? "" : "none";
        });
    }

    // Custom list — re-render filtered subset
    const customList = document.getElementById("custom-achievements-list");
    if (!customList) return;

    customList.innerHTML = "";
    const customAchievements = JSON.parse(localStorage.getItem("customAchievements")) || {};
    const gameAchievements   = customAchievements[gameName] || [];
    const filtered           = gameAchievements.filter(ach =>
        ach.name.toLowerCase().includes(filterText) ||
        ach.description.toLowerCase().includes(filterText)
    );

    if (filtered.length > 0) {
        filtered.forEach((ach, index) => {
            customList.appendChild(buildCustomAchievementItem(ach, index, gameName));
        });
    } else {
        customList.innerHTML = "<li style='color:var(--color-text-muted);font-size:12px'>No achievements match your filter.</li>";
    }
}

/**
 * Exports all custom achievements from localStorage as a downloadable JSON file.
 */
function exportAchievements() {
    const data        = localStorage.getItem("customAchievements") || "{}";
    const dataStr     = "data:text/json;charset=utf-8," + encodeURIComponent(data);
    const anchor      = document.createElement("a");
    anchor.setAttribute("href", dataStr);
    anchor.setAttribute("download", "achievements_export_" + Date.now() + ".json");
    document.body.appendChild(anchor);
    anchor.click();
    anchor.remove();
}

/**
 * Inserts the filter input and import/export buttons into the right panel,
 * directly below the Achievement List heading. Removes any existing filter
 * container first so it is safe to call on every game switch.
 *
 * @param {string} gameName - Passed through to filterAchievements().
 */
function insertFilterUI(gameName) {
    const existing = document.getElementById("filter-container");
    if (existing) existing.remove();

    const achievementContainer = document.querySelector(".achievement-container");
    const titleElement         = achievementContainer?.querySelector("h2");
    if (!titleElement) {
        console.error("Achievement List title element not found.");
        return;
    }

    const filterContainer = document.createElement("div");
    filterContainer.id    = "filter-container";
    filterContainer.innerHTML = `
        <input type="text" id="achievement-filter-input" placeholder="Filter achievements...">
        <button id="apply-achievement-filter">Filter</button>
        <div class="import-export-buttons">
            <button id="import-json">Import JSON</button>
            <button id="export-json">Export JSON</button>
        </div>
    `;

    titleElement.insertAdjacentElement("afterend", filterContainer);

    document.getElementById("apply-achievement-filter").addEventListener("click", function () {
        const filterText = document.getElementById("achievement-filter-input").value.trim().toLowerCase();
        filterAchievements(gameName, filterText);
    });

    // BUG-02 fix: ID now matches the button in the HTML above
    document.getElementById("export-json").addEventListener("click", function () {
        exportAchievements();
    });
}

/**
 * Builds a single custom achievement <li> element with edit/remove/toggle buttons.
 * Extracted into its own function so both loadCustomAchievements and
 * filterAchievements can reuse it without duplicating markup.
 *
 * @param {object} ach    - Achievement data object.
 * @param {number} index  - Index in the game's achievement array.
 * @param {string} gameName
 * @returns {HTMLLIElement}
 */
function buildCustomAchievementItem(ach, index, gameName) {
    const li       = document.createElement("li");
    const classes  = ["achievement-item", "is-custom"];
    if (ach.completed) classes.push("is-completed");
    li.className   = classes.join(" ");

    li.innerHTML = `
        <img src="${ach.image}" class="achievement-icon" alt="${ach.name}">
        <div class="achievement-details">
            <h4>${ach.name}</h4>
            <p>${ach.description}</p>
            <span>${ach.completed ? "✔ Completed" : "❌ Not Completed"}</span>
        </div>
        <div class="achievement-actions">
            <button class="edit-achievement">Edit</button>
            <button class="remove-achievement">Remove</button>
            <button class="toggle-completion-achievement">
                ${ach.completed ? "Mark Incomplete" : "Mark Complete"}
            </button>
        </div>
    `;

    li.querySelector(".edit-achievement").addEventListener("click", function () {
        document.getElementById("custom-achievement-name").value        = ach.name;
        document.getElementById("custom-achievement-description").value = ach.description;
        document.getElementById("custom-achievement-image").value       = "";
        removeAchievement(gameName, index);
    });

    li.querySelector(".remove-achievement").addEventListener("click", function () {
        removeAchievement(gameName, index);
    });

    li.querySelector(".toggle-completion-achievement").addEventListener("click", function () {
        toggleAchievementCompletion(gameName, index);
    });

    return li;
}

/**
 * Loads a Steam user profile AND the user's owned game library in one shot.
 * Saves both to localStorage, then updates the profile strip.
 *
 * Two API calls are made in parallel:
 *   1. ISteamUser/GetPlayerSummaries  — avatar + display name
 *   2. IPlayerService/GetOwnedGames   — full game library with names
 *
 * NOTE: GetOwnedGames requires the target profile to be set to public
 * in Steam privacy settings, otherwise it returns an empty games array.
 *
 * @param {string} steamID - The user's 64-bit Steam ID.
 * @param {string} apiKey  - Steam Web API key.
 */
async function loadSteamProfile(steamID, apiKey) {
    const proxy = "https://corsproxy.io/?";

    const profileUrl = proxy + encodeURIComponent(
        `https://api.steampowered.com/ISteamUser/GetPlayerSummaries/v2/?key=${apiKey}&steamids=${steamID}`
    );
    const gamesUrl = proxy + encodeURIComponent(
        `https://api.steampowered.com/IPlayerService/GetOwnedGames/v1/?key=${apiKey}&steamid=${steamID}&include_appinfo=true&include_played_free_games=true`
    );

    // Show a loading hint in the status line while requests are in flight
    const statusEl = document.getElementById("profile-status");
    if (statusEl) statusEl.textContent = "◌ Loading...";

    try {
        // Fire both requests in parallel — no need to wait for one before the other
        const [profileRes, gamesRes] = await Promise.all([
            fetch(profileUrl),
            fetch(gamesUrl)
        ]);

        if (!profileRes.ok) throw new Error(`Profile request failed: ${profileRes.status}`);
        if (!gamesRes.ok)   throw new Error(`Games request failed: ${gamesRes.status}`);

        const profileData = await profileRes.json();
        const gamesData   = await gamesRes.json();

        // ── Profile ───────────────────────────────────────────────────────────
        const players = profileData.response?.players;
        if (!players || players.length === 0) {
            alert("⚠ Steam profile not found. Double-check your Steam ID.");
            if (statusEl) statusEl.textContent = "○ Sign in via Steam";
            return;
        }

        const player = players[0];
        const profile = {
            steamID: steamID,
            avatar:  player.avatarfull,
            name:    player.personaname
        };
        localStorage.setItem("steamProfile", JSON.stringify(profile));

        // ── Game library ──────────────────────────────────────────────────────
        const rawGames = gamesData.response?.games || [];

        if (rawGames.length === 0) {
            // Profile found but games empty — almost always a privacy setting
            console.warn("⚠ No games returned — Steam profile may be set to private.");
        }

        // Normalise to appid + name only, sorted alphabetically
        const games = rawGames
            .map(g => ({ appid: g.appid, name: g.name }))
            .sort((a, b) => a.name.localeCompare(b.name));

        localStorage.setItem("steamGames", JSON.stringify(games));
        console.log(`✅ Loaded ${games.length} games for ${profile.name}`);

        // ── Update UI ─────────────────────────────────────────────────────────
        updateProfileStrip(profile);

        const gameCount = games.length > 0
            ? `${games.length} game${games.length !== 1 ? "s" : ""} loaded`
            : "No games found — check Steam privacy settings";

        alert(`✅ Signed in as ${profile.name}\n${gameCount}`);

    } catch (error) {
        console.error("❌ Error loading Steam profile:", error);
        if (statusEl) statusEl.textContent = "○ Sign in via Steam";
        alert("Failed to load Steam profile. Check your Steam ID and try again.\n\nIf the problem persists, corsproxy.io may be temporarily unavailable.");
    }
}

// ─────────────────────────────────────────────────────────────────────────────
// DOMContentLoaded — event wiring and panel rendering
// leftPanel is declared once here (BUG-03 fix).
// ─────────────────────────────────────────────────────────────────────────────
document.addEventListener("DOMContentLoaded", function () {
    const apiKey        = "B221B9B37FB61109794F719AEBA0268F"; // TODO: move to server-side proxy
    const leftPanel     = document.getElementById("left-panel");
    const savedProfile  = JSON.parse(localStorage.getItem("steamProfile"));
    const signOutButton = document.getElementById("sign-out");

    // Restore profile strip on page load if a session is saved
    if (savedProfile) {
        updateProfileStrip(savedProfile);
    }

    // ── Sign Out ──────────────────────────────────────────────────────────────
    // BUG-05 fix: removed the broken fetch POST to a static .txt file.
    // Sign-out only needs to clear localStorage and redirect.
    if (signOutButton) {
        signOutButton.addEventListener("click", function () {
            localStorage.removeItem("steamProfile");
            updateProfileStrip(null);
            // Reset the nav panel to the default instructions state
            leftPanel.innerHTML = `
                <h3>Instructions</h3>
                <p>Search your Steam ID or add a Non-Steam game to get started.</p>
            `;
            // Clear the achievement list
            const steamList  = document.getElementById("steam-achievements");
            const customList = document.getElementById("custom-achievements-list");
            if (steamList)  steamList.innerHTML  = "";
            if (customList) customList.innerHTML = "";
            const filterContainer = document.getElementById("filter-container");
            if (filterContainer) filterContainer.remove();
        });
    }

    // ── Steam ID Search ───────────────────────────────────────────────────────
    document.getElementById("open-steam-settings").addEventListener("click", function () {
        leftPanel.innerHTML = `
            <h3>Steam Profile</h3>
            <label for="steam-id-input">Steam ID</label>
            <input type="text" id="steam-id-input" placeholder="Enter your 64-bit Steam ID" />
            <button id="search-steam-profile">Search</button>
        `;

        document.getElementById("search-steam-profile").addEventListener("click", function () {
            const steamID = document.getElementById("steam-id-input").value.trim();
            if (steamID) {
                loadSteamProfile(steamID, apiKey);
            } else {
                alert("Please enter a Steam ID.");
            }
        });
    });

    // ── Game Selection ────────────────────────────────────────────────────────
    document.getElementById("open-game-selection").addEventListener("click", function () {
        showGameSelectionMenu();
    });

    // ── Home button ───────────────────────────────────────────────────────────
    document.getElementById("home-button").addEventListener("click", function () {
        window.location.href = "../index.html";
    });

    // ─────────────────────────────────────────────────────────────────────────
    // PANEL RENDERING FUNCTIONS
    // All functions below write only to #left-panel (Zone 2) or the right
    // panel — never to #profile-info (Zone 1).
    // ─────────────────────────────────────────────────────────────────────────

    /**
     * Renders the game type picker (Steam vs Non-Steam) in the left panel
     * and clears the right panel achievement list.
     */
    function showGameSelectionMenu() {
        leftPanel.innerHTML = `
            <h3>Select Game Type</h3>
            <button id="load-steam-games">🎮 Steam Games</button>
            <button id="load-non-steam-games">📂 Non-Steam Games</button>
        `;

        // Clear right panel
        const steamList  = document.getElementById("steam-achievements");
        const customList = document.getElementById("custom-achievements-list");
        if (steamList)  steamList.innerHTML  = "";
        if (customList) customList.innerHTML = "";
        const filterContainer = document.getElementById("filter-container");
        if (filterContainer) filterContainer.remove();

        document.getElementById("load-steam-games").addEventListener("click", displaySteamGames);
        document.getElementById("load-non-steam-games").addEventListener("click", displayNonSteamGames);
    }

    /**
     * Renders the user's Steam game library in the left panel.
     * Reads from localStorage key "steamGames".
     */
    function displaySteamGames() {
        leftPanel.innerHTML = "";

        const backBtn = showBackButton(showGameSelectionMenu);
        leftPanel.appendChild(backBtn);

        const heading = document.createElement("h3");
        heading.textContent = "Steam Games";
        leftPanel.appendChild(heading);

        const steamGames = JSON.parse(localStorage.getItem("steamGames")) || [];

        if (steamGames.length === 0) {
            const msg = document.createElement("p");
            msg.textContent = "No Steam games found. Load your Steam profile first.";
            leftPanel.appendChild(msg);
            return;
        }

        steamGames.forEach(game => {
            const btn = document.createElement("button");
            btn.textContent = game.name;
            btn.classList.add("game-btn");
            btn.addEventListener("click", function () {
                const steamID = JSON.parse(localStorage.getItem("steamProfile"))?.steamID;
                if (steamID && game.appid) {
                    loadSteamAchievements(steamID, game.appid, displaySteamGames);
                } else {
                    console.error("❌ Steam ID or AppID missing");
                }
            });
            leftPanel.appendChild(btn);
        });
    }

    /**
     * Renders the non-Steam game list in the left panel.
     * Each entry has a click-to-open button and a remove icon.
     */
    function displayNonSteamGames() {
        leftPanel.innerHTML = "";

        const backBtn = showBackButton(showGameSelectionMenu);
        leftPanel.appendChild(backBtn);

        const heading = document.createElement("h3");
        heading.textContent = "Non-Steam Games";
        leftPanel.appendChild(heading);

        const addBtn = document.createElement("button");
        addBtn.textContent = "+ Add Game";
        addBtn.addEventListener("click", function () {
            const gameName = prompt("Enter Non-Steam Game Name:");
            if (gameName) {
                let nonSteamGames = JSON.parse(localStorage.getItem("nonSteamGames")) || [];
                if (!nonSteamGames.includes(gameName)) {
                    nonSteamGames.push(gameName);
                    localStorage.setItem("nonSteamGames", JSON.stringify(nonSteamGames));
                }
                displayNonSteamGames();
            }
        });
        leftPanel.appendChild(addBtn);

        const nonSteamGames = JSON.parse(localStorage.getItem("nonSteamGames")) || [];

        if (nonSteamGames.length === 0) {
            const msg = document.createElement("p");
            msg.textContent = "No games yet. Add one above.";
            leftPanel.appendChild(msg);
            return;
        }

        const gameList = document.createElement("ul");
        gameList.classList.add("non-steam-game-list");

        nonSteamGames.forEach((game, index) => {
            const gameItem      = document.createElement("li");
            gameItem.classList.add("non-steam-game-item");

            const gameContainer = document.createElement("div");
            gameContainer.classList.add("game-container");

            const gameButton = document.createElement("button");
            gameButton.textContent = game;
            gameButton.classList.add("game-btn");
            gameButton.addEventListener("click", function () {
                setupCustomAchievements(game);
            });

            const removeIcon = document.createElement("span");
            removeIcon.innerHTML = "❌";
            removeIcon.classList.add("remove-game-icon");
            removeIcon.addEventListener("click", function (e) {
                e.stopPropagation();
                removeNonSteamGame(index);
            });

            gameContainer.appendChild(gameButton);
            gameContainer.appendChild(removeIcon);
            gameItem.appendChild(gameContainer);
            gameList.appendChild(gameItem);
        });

        leftPanel.appendChild(gameList);
    }

    /**
     * Removes a non-Steam game by index and refreshes the list.
     * @param {number} index
     */
    function removeNonSteamGame(index) {
        let nonSteamGames = JSON.parse(localStorage.getItem("nonSteamGames")) || [];
        if (index >= 0 && index < nonSteamGames.length) {
            nonSteamGames.splice(index, 1);
            localStorage.setItem("nonSteamGames", JSON.stringify(nonSteamGames));
            displayNonSteamGames();
        }
    }

    /**
     * Fetches and renders Steam achievements for a given game.
     * Cards receive .is-steam and (if earned) .is-completed classes.
     *
     * @param {string}   steamID
     * @param {string|number} appID
     * @param {Function} previousPage - Called on error to navigate back.
     */
    async function loadSteamAchievements(steamID, appID, previousPage) {
        const achievementsList = document.getElementById("steam-achievements");
        if (!achievementsList) {
            console.error("❌ 'steam-achievements' element not found!");
            return;
        }
        achievementsList.innerHTML = "";

        const proxyUrl = "https://corsproxy.io/?";

        if (!steamID || !appID || !apiKey) {
            console.error("❌ Missing required Steam API parameters!");
            return;
        }

        const schemaUrl = proxyUrl + encodeURIComponent(
            `https://api.steampowered.com/ISteamUserStats/GetSchemaForGame/v2/?key=${apiKey}&appid=${appID}`
        );

        try {
            const schemaResponse = await fetch(schemaUrl);
            if (!schemaResponse.ok) throw new Error(`Schema request failed: ${schemaResponse.status}`);

            const schemaData = await schemaResponse.json();
            if (
                !schemaData.game ||
                !schemaData.game.availableGameStats ||
                !schemaData.game.availableGameStats.achievements
            ) {
                alert("⚠ This game has no Steam achievements. You can add custom ones instead.");
                showCustomAchievementsMenu(String(appID));
                return;
            }

            const playerUrl = proxyUrl + encodeURIComponent(
                `https://api.steampowered.com/ISteamUserStats/GetPlayerAchievements/v1/?key=${apiKey}&steamid=${steamID}&appid=${appID}`
            );

            const playerResponse = await fetch(playerUrl);
            if (!playerResponse.ok) throw new Error(`Player achievements request failed: ${playerResponse.status}`);

            const playerData = await playerResponse.json();
            if (!playerData.playerstats?.achievements) {
                alert("⚠ No achievements found for this game.");
                return;
            }

            const playerAchievements = playerData.playerstats.achievements;
            const schemaAchievements = schemaData.game.availableGameStats.achievements;

            playerAchievements.forEach(playerAch => {
                const schemaAch = schemaAchievements.find(a => a.name === playerAch.apiname);
                if (!schemaAch) return;

                const li = document.createElement("li");
                // is-steam distinguishes these from custom cards visually
                // is-completed triggers the green glow treatment
                const classes = ["achievement-item", "is-steam"];
                if (playerAch.achieved) classes.push("is-completed");
                li.className = classes.join(" ");

                li.innerHTML = `
                    <img src="${schemaAch.icon}" class="achievement-icon" alt="${schemaAch.displayName}">
                    <div class="achievement-details">
                        <h4>${schemaAch.displayName}</h4>
                        <p>${schemaAch.description || "No description available."}</p>
                        <span>${playerAch.achieved ? "✔ Completed" : "❌ Not Completed"}</span>
                    </div>
                `;
                achievementsList.appendChild(li);
            });

            // BUG-04 fix: insertFilterUI now called here after Steam achievements render
            insertFilterUI(String(appID));

            console.log("✅ Steam achievements loaded.");
        } catch (error) {
            console.error("❌ Error fetching achievements:", error);
            alert("⚠ Failed to load achievements. Please try again.");
            if (previousPage) previousPage();
        }
    }

    /**
     * Initialises localStorage for a game if needed, then opens its custom menu.
     * @param {string} gameName
     */
    function setupCustomAchievements(gameName) {
        let customAchievements = JSON.parse(localStorage.getItem("customAchievements")) || {};
        if (!customAchievements[gameName]) {
            customAchievements[gameName] = [];
            localStorage.setItem("customAchievements", JSON.stringify(customAchievements));
        }
        showCustomAchievementsMenu(gameName);
    }

    /**
     * Renders the custom achievement add/import form in the left panel,
     * loads existing achievements into the right panel, and inserts the filter UI.
     * @param {string} gameName
     */
    function showCustomAchievementsMenu(gameName) {
        leftPanel.innerHTML = `
            <h3>Custom — ${gameName}</h3>
            <button class="back-btn" id="custom-back-btn">⬅ Back</button>
            <h4>Add Achievement</h4>
            <label for="custom-achievement-name">Name</label>
            <input type="text" id="custom-achievement-name" placeholder="Achievement name">
            <label for="custom-achievement-description">Description</label>
            <textarea id="custom-achievement-description" placeholder="What does the player need to do?"></textarea>
            <label for="custom-achievement-image">Image URL (optional)</label>
            <input type="text" id="custom-achievement-image" placeholder="https://...">
            <label for="custom-achievement-image-upload">Or upload an image</label>
            <input type="file" id="custom-achievement-image-upload" accept="image/*">
            <button id="save-custom-achievement">💾 Save Achievement</button>
            <button id="import-achievements">📂 Import from JSON</button>
        `;

        document.getElementById("custom-back-btn").addEventListener("click", displayNonSteamGames);

        document.getElementById("save-custom-achievement").addEventListener("click", function () {
            saveCustomAchievement(gameName);
        });

        document.getElementById("import-achievements").addEventListener("click", function () {
            importCustomAchievements(gameName);
        });

        loadCustomAchievements(gameName);
        insertFilterUI(gameName);
    }

    /**
     * Reads the form, validates, and saves a new custom achievement to localStorage.
     * Supports both image URL and file upload. After saving, refreshes the list.
     * @param {string} gameName
     */
    function saveCustomAchievement(gameName) {
        const name        = document.getElementById("custom-achievement-name").value.trim();
        const description = document.getElementById("custom-achievement-description").value.trim();
        const imageURL    = document.getElementById("custom-achievement-image").value.trim();
        const fileInput   = document.getElementById("custom-achievement-image-upload");

        if (!name || !description) {
            alert("Achievement name and description are required.");
            return;
        }

        function persist(imageSrc) {
            let store = JSON.parse(localStorage.getItem("customAchievements")) || {};
            if (Array.isArray(store)) store = {}; // migrate old format
            if (!store[gameName]) store[gameName] = [];

            store[gameName].push({ name, description, image: imageSrc, completed: false });
            localStorage.setItem("customAchievements", JSON.stringify(store));

            // Clear form
            document.getElementById("custom-achievement-name").value        = "";
            document.getElementById("custom-achievement-description").value = "";
            document.getElementById("custom-achievement-image").value       = "";
            fileInput.value = "";

            loadCustomAchievements(gameName);
        }

        if (fileInput.files?.[0]) {
            const reader    = new FileReader();
            reader.onload   = e => persist(e.target.result);
            reader.readAsDataURL(fileInput.files[0]);
        } else if (imageURL) {
            persist(imageURL);
        } else {
            persist("default-achievement.png");
        }
    }

    /**
     * Reads custom achievements for a game from localStorage and renders them
     * in the right panel using buildCustomAchievementItem().
     * @param {string} gameName
     */
    function loadCustomAchievements(gameName) {
        const achievementsList = document.getElementById("custom-achievements-list");
        if (!achievementsList) return;

        achievementsList.innerHTML = "";
        const store           = JSON.parse(localStorage.getItem("customAchievements")) || {};
        const gameAchievements = store[gameName] || [];

        if (gameAchievements.length > 0) {
            gameAchievements.forEach((ach, index) => {
                achievementsList.appendChild(buildCustomAchievementItem(ach, index, gameName));
            });
        } else {
            achievementsList.innerHTML =
                "<li style='color:var(--color-text-muted);font-size:12px;padding:8px 0'>No custom achievements yet.</li>";
        }
    }

    /**
     * Removes a custom achievement by index and refreshes the list.
     * @param {string} gameName
     * @param {number} achievementIndex
     */
    function removeAchievement(gameName, achievementIndex) {
        let store = JSON.parse(localStorage.getItem("customAchievements")) || {};
        if (store[gameName]) {
            store[gameName].splice(achievementIndex, 1);
            localStorage.setItem("customAchievements", JSON.stringify(store));
            loadCustomAchievements(gameName);
        }
    }

    /**
     * Toggles the completed flag on a custom achievement and refreshes the list.
     * @param {string} gameName
     * @param {number} achievementIndex
     */
    function toggleAchievementCompletion(gameName, achievementIndex) {
        let store = JSON.parse(localStorage.getItem("customAchievements")) || {};
        if (store[gameName]?.[achievementIndex] !== undefined) {
            store[gameName][achievementIndex].completed =
                !store[gameName][achievementIndex].completed;
            localStorage.setItem("customAchievements", JSON.stringify(store));
            loadCustomAchievements(gameName);
        }
    }

    /**
     * Prompts for a JSON string and merges the achievements into the game's list.
     * Expected format: array of { name, description, image, completed } objects.
     * @param {string} gameName
     */
    function importCustomAchievements(gameName) {
        const jsonInput = prompt("Paste JSON achievements array here:");
        if (!jsonInput) { alert("⚠ No JSON provided."); return; }

        try {
            const imported = JSON.parse(jsonInput);
            if (!Array.isArray(imported)) {
                alert("⚠ Invalid format — expected a JSON array.");
                return;
            }

            let store = JSON.parse(localStorage.getItem("customAchievements")) || {};
            if (!store[gameName]) store[gameName] = [];
            store[gameName] = store[gameName].concat(imported);
            localStorage.setItem("customAchievements", JSON.stringify(store));

            alert(`✅ Imported ${imported.length} achievement${imported.length !== 1 ? "s" : ""}.`);
            loadCustomAchievements(gameName);
        } catch {
            alert("⚠ Error parsing JSON. Check the format and try again.");
        }
    }

    /**
     * Creates and returns a styled back button that calls the given callback.
     * The caller appends the returned element to the DOM.
     * @param {Function} callback
     * @returns {HTMLButtonElement}
     */
    function showBackButton(callback) {
        const btn = document.createElement("button");
        btn.textContent = "⬅ Back";
        btn.classList.add("back-btn");
        btn.addEventListener("click", callback);
        return btn;
    }

});
