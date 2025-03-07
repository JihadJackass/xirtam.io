async function loadSteamProfile(steamID, apiKey) {
	const url = `https://api.allorigins.win/get?url=` + encodeURIComponent(
		`https://api.steampowered.com/ISteamUser/GetPlayerSummaries/v2/?key=${apiKey}&steamids=${steamID}`
	);

    try {
        const response = await fetch(url);
        const data = await response.json();

        if (data.response.players.length > 0) {
            const player = data.response.players[0];
            document.getElementById("steam-avatar").src = player.avatarfull;
            document.getElementById("steam-name").textContent = player.personaname;
            localStorage.setItem("steamID", steamID);
        } else {
            alert("Steam profile not found!");
        }
    } catch (error) {
        console.error("Error loading Steam profile:", error);
    }
}


async function loadSteamAchievements(steamID, appID, apiKey) {
    const url = `https://api.steampowered.com/ISteamUserStats/GetPlayerAchievements/v1/?key=${apiKey}&steamid=${steamID}&appid=${appID}`;
    try {
        const response = await fetch(url);
        const data = await response.json();

        if (data.playerstats && data.playerstats.achievements) {
            const achievementsList = document.getElementById("steam-achievements");
            achievementsList.innerHTML = ""; // Clear previous achievements

            data.playerstats.achievements.forEach(ach => {
                const achievementItem = document.createElement("li");
                achievementItem.className = ach.achieved ? "completed" : "incomplete";
                achievementItem.innerHTML = `<strong>${ach.apiname}</strong>: ${ach.achieved ? "✔ Completed" : "❌ Not Completed"}`;
                achievementsList.appendChild(achievementItem);
            });
        } else {
            alert("No achievements found for this game.");
        }
    } catch (error) {
        console.error("Error fetching achievements:", error);
    }
}

async function loadAllAchievements(steamID, appID, apiKey, gameName) {
    const achievementsList = document.getElementById("steam-achievements");
    achievementsList.innerHTML = ""; // Clear previous achievements

    // Load Steam Achievements
    const url = `https://api.steampowered.com/ISteamUserStats/GetPlayerAchievements/v1/?key=${apiKey}&steamid=${steamID}&appid=${appID}`;
    try {
        const response = await fetch(url);
        const data = await response.json();

        if (data.playerstats && data.playerstats.achievements) {
            data.playerstats.achievements.forEach(ach => {
                const achievementItem = document.createElement("li");
                achievementItem.className = ach.achieved ? "completed" : "incomplete";
                achievementItem.innerHTML = `<strong>${ach.apiname}</strong>: ${ach.achieved ? "✔ Completed" : "❌ Not Completed"}`;
                achievementsList.appendChild(achievementItem);
            });
        }
    } catch (error) {
        console.error("Error fetching Steam achievements:", error);
    }

    // Load Custom Achievements
    let customAchievements = JSON.parse(localStorage.getItem("achievements")) || {};
    if (customAchievements[gameName]) {
        customAchievements[gameName].forEach(ach => {
            const achievementItem = document.createElement("li");
            achievementItem.className = ach.completed ? "completed" : "incomplete";
            achievementItem.innerHTML = `<strong>${ach.title}</strong>: ${ach.completed ? "✔ Completed" : "❌ Not Completed"}`;
            achievementsList.appendChild(achievementItem);
        });
    }
}

async function loadSteamProfile(steamID, apiKey) {
    const url = `https://api.allorigins.win/get?url=` + encodeURIComponent(
        `https://api.steampowered.com/ISteamUser/GetPlayerSummaries/v2/?key=${apiKey}&steamids=${steamID}`
    );

    try {
        const response = await fetch(url);
        const data = await response.json();

        // The new proxy wraps the response inside a "contents" property
        const parsedData = JSON.parse(data.contents);

        if (parsedData.response.players.length > 0) {
            const player = parsedData.response.players[0];
            document.getElementById("steam-avatar").src = player.avatarfull;
            document.getElementById("steam-name").textContent = player.personaname;
            localStorage.setItem("steamID", steamID);
        } else {
            alert("Steam profile not found!");
        }
    } catch (error) {
        console.error("Error loading Steam profile:", error);
    }
}

async function loadSteamGames(steamID, apiKey) {
    const url = `https://api.allorigins.win/get?url=` + encodeURIComponent(
        `https://api.steampowered.com/IPlayerService/GetOwnedGames/v1/?key=${apiKey}&steamid=${steamID}&include_appinfo=true`
    );

    try {
        const response = await fetch(url);
        const data = await response.json();
        const parsedData = JSON.parse(data.contents);

        if (parsedData.response && parsedData.response.games) {
            localStorage.setItem("steamGames", JSON.stringify(parsedData.response.games)); // 🔹 Cache games

            const gameSelect = document.getElementById("steam-game-select");
            gameSelect.innerHTML = `<option value="">Select a Game</option>`; // Reset dropdown

            parsedData.response.games.forEach(game => {
                const option = document.createElement("option");
                option.value = game.appid;
                option.textContent = game.name;
                gameSelect.appendChild(option);
            });

            console.log("Games loaded and cached!");
        } else {
            alert("No games found for this Steam ID.");
        }
    } catch (error) {
        console.error("Error loading Steam games:", error);
    }
}

async function loadSteamAchievements(steamID, appID, apiKey) {
    const achievementsList = document.getElementById("steam-achievements");
    achievementsList.innerHTML = ""; // Clear previous achievements

    // Fetch player achievements
    const playerAchievementsUrl = `https://api.allorigins.win/get?url=` + encodeURIComponent(
        `https://api.steampowered.com/ISteamUserStats/GetPlayerAchievements/v1/?key=${apiKey}&steamid=${steamID}&appid=${appID}`
    );

    // Fetch full achievement details (schema)
    const schemaUrl = `https://api.allorigins.win/get?url=` + encodeURIComponent(
        `https://api.steampowered.com/ISteamUserStats/GetSchemaForGame/v2/?key=${apiKey}&appid=${appID}`
    );

    try {
        const [playerResponse, schemaResponse] = await Promise.all([
            fetch(playerAchievementsUrl),
            fetch(schemaUrl)
        ]);

        const playerData = await playerResponse.json();
        const schemaData = await schemaResponse.json();
        const parsedPlayerData = JSON.parse(playerData.contents);
        const parsedSchemaData = JSON.parse(schemaData.contents);

        if (parsedPlayerData.playerstats && parsedPlayerData.playerstats.achievements) {
            const playerAchievements = parsedPlayerData.playerstats.achievements;
            const schemaAchievements = parsedSchemaData.game.availableGameStats.achievements;

            playerAchievements.forEach(playerAch => {
                // Find matching achievement details from schema
                const schemaAch = schemaAchievements.find(ach => ach.name === playerAch.apiname);

                if (schemaAch) {
                    const achievementItem = document.createElement("li");
                    achievementItem.className = playerAch.achieved ? "completed" : "incomplete";
                    achievementItem.innerHTML = `
                        <img src="${schemaAch.icon}" class="achievement-icon">
                        <div class="achievement-details">
                            <h4>${schemaAch.displayName}</h4>
                            <p>${schemaAch.description || "No description available"}</p>
                            <span>${playerAch.achieved ? "✔ Completed" : "❌ Not Completed"}</span>
                        </div>
                    `;
                    achievementsList.appendChild(achievementItem);
                }
            });

            console.log("Achievements with localized names & icons loaded!");
        } else {
            alert("No achievements found for this game.");
        }
    } catch (error) {
        console.error("Error fetching achievements:", error);
    }
}


document.addEventListener("DOMContentLoaded", function () {
    const apiKey = "B221B9B37FB61109794F719AEBA0268F"; // Replace with your actual API Key

    // Search Steam Profile (Enter Steam ID)
    document.getElementById("search-steam-profile").addEventListener("click", function () {
        const steamID = document.getElementById("steam-id-input").value;
        if (steamID) {
            loadSteamProfile(steamID, apiKey);
        } else {
            alert("Please enter a Steam ID.");
        }
    });

    // Load Profile (Steam) - Uses stored Steam ID
    document.getElementById("load-profile-steam").addEventListener("click", function () {
        const steamID = localStorage.getItem("steamID");
        if (steamID) {
            loadSteamProfile(steamID, apiKey);
        } else {
            alert("No saved Steam profile found. Use 'Search Steam ID' first.");
        }
    });

	// Load Steam Games when the button is clicked
	document.getElementById("load-steam-games").addEventListener("click", function () {
		const steamID = localStorage.getItem("steamID");
		if (steamID) {
			loadSteamGames(steamID, apiKey);
		} else {
			alert("Please load your Steam profile first!");
		}
	});

	// Load Achievements when a game is selected
	document.getElementById("load-steam-achievements").addEventListener("click", function () {
		const steamID = localStorage.getItem("steamID");
		const appID = document.getElementById("steam-game-select").value;
		if (steamID && appID) {
			loadSteamAchievements(steamID, appID, apiKey);
		} else {
			alert("Please select a game first!");
		}
	});	
});
