async function loadSteamProfile(steamID, apiKey) {
    const url = `https://api.steampowered.com/ISteamUser/GetPlayerSummaries/v2/?key=${apiKey}&steamids=${steamID}`;

    // ✅ Use a proxy to bypass CORS
    const proxyUrl = `https://corsproxy.io/?` + encodeURIComponent(url);

    try {
        const response = await fetch(proxyUrl);
        const data = await response.json();

        if (data.response.players.length > 0) {
            const player = data.response.players[0];

            // ✅ Save profile data in localStorage
            const profileData = {
                steamID: steamID,
                avatar: player.avatarfull,
                name: player.personaname
            };
            localStorage.setItem("steamProfile", JSON.stringify(profileData));

            // ✅ Update UI
            document.getElementById("steam-avatar").src = player.avatarfull;
            document.getElementById("steam-name").textContent = player.personaname;

            alert("✅ Steam Profile Loaded Successfully!");
        } else {
            alert("⚠ Steam profile not found.");
        }
    } catch (error) {
        console.error("❌ Error loading Steam profile:", error);
        alert("Failed to load Steam profile.");
    }
}

document.addEventListener("DOMContentLoaded", function () {
    const apiKey = "B221B9B37FB61109794F719AEBA0268F"; // Replace with your actual API Key
    const leftPanel = document.getElementById("left-panel");
    const savedProfile = JSON.parse(localStorage.getItem("steamProfile"));

	if (savedProfile) {
        console.log("✅ Loading saved Steam profile...");
        document.getElementById("steam-avatar").src = savedProfile.avatar;
        document.getElementById("steam-name").textContent = savedProfile.name;
    }
	
    // 🔹 Load Steam ID Search
    document.getElementById("open-steam-settings").addEventListener("click", function () {
        leftPanel.innerHTML = `
            <h3>Steam Profile</h3>
            <input type="text" id="steam-id-input" placeholder="Enter Steam ID" />
            <button id="search-steam-profile">Search</button>
            <div id="profile-info">
                <img id="steam-avatar" src="" alt="Steam Avatar" width="100">
                <p id="steam-name"></p>
            </div>
        `;

		document.getElementById("search-steam-profile").addEventListener("click", function () {
			const steamID = document.getElementById("steam-id-input").value;
			if (steamID) {
				loadSteamProfile(steamID, apiKey);
			} else {
				alert("Please enter a Steam ID.");
			}
		});
    });

    // 🔹 Load Steam Games
	document.getElementById("open-game-selection").addEventListener("click", function () {
		leftPanel.innerHTML = `
			<h3>Game Selection</h3>
			<button id="load-steam-games">Load Steam Games</button>
			<button id="load-non-steam-games">Load Non-Steam Games</button>
			<button id="add-non-steam-game">Add Non-Steam Game</button>
		`;
	
		// 🔹 Load Steam Games
		document.getElementById("load-steam-games").addEventListener("click", function () {
			displaySteamGames();
		});
	
		// 🔹 Load Non-Steam Games
		document.getElementById("load-non-steam-games").addEventListener("click", function () {
			displayNonSteamGames();
		});
	
		// 🔹 Add a Non-Steam Game
		document.getElementById("add-non-steam-game").addEventListener("click", function () {
			const gameName = prompt("Enter Non-Steam Game Name:");
			if (gameName) {
				let nonSteamGames = JSON.parse(localStorage.getItem("nonSteamGames")) || [];
				if (!nonSteamGames.includes(gameName)) {
					nonSteamGames.push(gameName);
					localStorage.setItem("nonSteamGames", JSON.stringify(nonSteamGames));
					displayNonSteamGames(); // Reload non-Steam games after adding
				}
			}
		});
	});

	async function loadSteamAchievements(steamID, appID, apiKey) {
		const achievementsList = document.getElementById("steam-achievements");
		if (!achievementsList) {
			console.error("❌ 'steam-achievements' element not found!");
			return;
		}
		achievementsList.innerHTML = ""; // Clear previous achievements
	
		// ✅ Use proxy to bypass CORS
		const proxyUrl = `https://corsproxy.io/?`;
		const playerAchievementsUrl = proxyUrl + encodeURIComponent(
			`https://api.steampowered.com/ISteamUserStats/GetPlayerAchievements/v1/?key=${apiKey}&steamid=${steamID}&appid=${appID}`
		);
		const schemaUrl = proxyUrl + encodeURIComponent(
			`https://api.steampowered.com/ISteamUserStats/GetSchemaForGame/v2/?key=${apiKey}&appid=${appID}`
		);
	
		try {
			const [playerResponse, schemaResponse] = await Promise.all([
				fetch(playerAchievementsUrl),
				fetch(schemaUrl)
			]);
	
			const playerData = await playerResponse.json();
			const schemaData = await schemaResponse.json();
	
			// ✅ Fix JSON parsing to handle different response structures
			const parsedPlayerData = playerData.playerstats ? playerData : JSON.parse(playerData.contents);
			const parsedSchemaData = schemaData.game ? schemaData : JSON.parse(schemaData.contents);
	
			if (parsedPlayerData.playerstats && parsedPlayerData.playerstats.achievements) {
				const playerAchievements = parsedPlayerData.playerstats.achievements;
				const schemaAchievements = parsedSchemaData.game.availableGameStats.achievements;
	
				playerAchievements.forEach(playerAch => {
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
	
				console.log("✅ Achievements with localized names & icons loaded!");
			} else {
				alert("⚠ No achievements found for this game.");
			}
		} catch (error) {
			console.error("❌ Error fetching achievements:", error);
		}
	}
	

	function displaySteamGames() {
		const steamGames = JSON.parse(localStorage.getItem("steamGames")) || [];
		leftPanel.innerHTML = "<h3>Select a Steam Game</h3>";
	
		if (steamGames.length === 0) {
			leftPanel.innerHTML += "<p>No Steam games found. Load Steam Profile first.</p>";
			return;
		}
	
		steamGames.forEach(game => {
			const button = document.createElement("button");
			button.textContent = game.name;
			button.dataset.appid = game.appid;
			button.classList.add("steam-game-button"); // Mark as Steam Game
			button.addEventListener("click", function () {
				const steamID = localStorage.getItem("steamID");
				if (steamID && game.appid) {
					loadSteamAchievements(steamID, game.appid, apiKey);
					// 🚀 DO NOT call loadCustomAchievements() for Steam games
					leftPanel.innerHTML = `<h3>Achievements for ${game.name}</h3>`;
				} else {
					console.error("❌ Error: Steam ID or AppID missing");
				}
			});
			leftPanel.appendChild(button);
		});
	}

	function displayNonSteamGames() {
		let nonSteamGames = JSON.parse(localStorage.getItem("nonSteamGames")) || [];
		leftPanel.innerHTML = `
			<h3>Select a Non-Steam Game</h3>
			<button id="back-to-selection">⬅ Back</button>
		`;
	
		if (nonSteamGames.length === 0) {
			leftPanel.innerHTML += "<p>No non-Steam games found. Add one first.</p>";
			return;
		}
	
		const gameList = document.createElement("ul");
		gameList.classList.add("non-steam-game-list");
	
		nonSteamGames.forEach((game, index) => {
			const gameItem = document.createElement("li");
			gameItem.classList.add("non-steam-game-item");
	
			// ✅ Game Button
			const gameButton = document.createElement("button");
			gameButton.textContent = game;
			gameButton.classList.add("game-btn");
			gameButton.addEventListener("click", function () {
				loadCustomAchievements(game);
				showCustomAchievementsMenu(game);
				leftPanel.innerHTML = `<h3>Custom Achievements for ${game}</h3>`;
			});
	
			// ✅ Remove Button (❌)
			const removeButton = document.createElement("button");
			removeButton.innerHTML = "❌";
			removeButton.classList.add("remove-game-btn");
			removeButton.addEventListener("click", function (event) {
				event.stopPropagation(); // Prevent clicking the game itself
				removeNonSteamGame(index);
			});
	
			// ✅ Game and Remove Button are properly formatted inside a div
			const gameContainer = document.createElement("div");
			gameContainer.classList.add("game-container");
			gameContainer.appendChild(gameButton);
			gameContainer.appendChild(removeButton);
	
			gameItem.appendChild(gameContainer);
			gameList.appendChild(gameItem);
		});
	
		leftPanel.appendChild(gameList);
	
		// ✅ Add "Back" button functionality
		document.getElementById("back-to-selection").addEventListener("click", function () {
			showGameSelectionMenu();
		});
	}

	function removeNonSteamGame(index) {
		let nonSteamGames = JSON.parse(localStorage.getItem("nonSteamGames")) || [];
		if (index >= 0 && index < nonSteamGames.length) {
			nonSteamGames.splice(index, 1); // ✅ Remove the game
			localStorage.setItem("nonSteamGames", JSON.stringify(nonSteamGames));
			displayNonSteamGames(); // ✅ Refresh the list
		}
	}

	function showCustomAchievementsMenu(gameName) {
		leftPanel.innerHTML += `
			<h3>Manage Custom Achievements for ${gameName}</h3>
			<button id="add-custom-achievement">Add Achievement</button>
			<button id="remove-custom-achievement">Remove Achievement</button>
			<ul id="custom-achievements-list"></ul>
		`;
	
		document.getElementById("add-custom-achievement").addEventListener("click", function () {
			const achievementName = prompt("Enter achievement name:");
			if (achievementName) {
				let customAchievements = JSON.parse(localStorage.getItem("customAchievements")) || {};
				if (!customAchievements[gameName]) {
					customAchievements[gameName] = [];
				}
				customAchievements[gameName].push({ name: achievementName, completed: false });
				localStorage.setItem("customAchievements", JSON.stringify(customAchievements));
				loadCustomAchievements(gameName);
			}
		});
	
		document.getElementById("remove-custom-achievement").addEventListener("click", function () {
			const achievementName = prompt("Enter achievement name to remove:");
			let customAchievements = JSON.parse(localStorage.getItem("customAchievements")) || {};
			if (customAchievements[gameName]) {
				customAchievements[gameName] = customAchievements[gameName].filter(ach => ach.name !== achievementName);
				localStorage.setItem("customAchievements", JSON.stringify(customAchievements));
				loadCustomAchievements(gameName);
			}
		});
	
		loadCustomAchievements(gameName);
	}
});
