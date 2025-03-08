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

const leftPanel = document.getElementById("left-panel"); // ✅ Ensure this matches your HTML ID

function showOptionsPage() {
    if (!leftPanel) {
        console.error("❌ 'leftPanel' is not found in the DOM.");
        return;
    }

    leftPanel.innerHTML = `
        <div id="profile-info">
            <img id="steam-avatar" src="" alt="Steam Avatar" width="100">
            <p id="steam-name"></p>
        </div>

        <h3>Options</h3>
        <button id="open-steam-settings">Search Steam ID</button>
        <button id="open-json-settings">JSON Management</button>
        <button id="open-game-selection">Game Selection</button>
    `;

    // ✅ Restore profile info if already loaded
    const savedProfile = JSON.parse(localStorage.getItem("steamProfile"));
    if (savedProfile) {
        document.getElementById("steam-avatar").src = savedProfile.avatar;
        document.getElementById("steam-name").textContent = savedProfile.name;
    }

    // ✅ Attach event listeners to buttons
    document.getElementById("open-steam-settings").addEventListener("click", showSteamSettings);
    document.getElementById("open-game-selection").addEventListener("click", showGameSelectionMenu);
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

	async function loadSteamAchievements(steamID, appID, previousPage) {
		const achievementsList = document.getElementById("steam-achievements");
	
		if (!achievementsList) {
			console.error("❌ 'steam-achievements' element not found!");
			return;
		}
	
		achievementsList.innerHTML = ""; // Clear previous achievements
	
		const apiKey = "B221B9B37FB61109794F719AEBA0268F"; // Your Steam API Key
		const proxyUrl = "https://corsproxy.io/?";
	
		if (!steamID || !appID || !apiKey) {
			console.error("❌ Missing required Steam API parameters!");
			return;
		}
	
		// Fetch game achievement schema
		const schemaUrl = proxyUrl + encodeURIComponent(
			`https://api.steampowered.com/ISteamUserStats/GetSchemaForGame/v2/?key=${apiKey}&appid=${appID}`
		);
	
		try {
			console.log(`🔹 Checking if game supports achievements: ${schemaUrl}`);
			const schemaResponse = await fetch(schemaUrl);
			if (!schemaResponse.ok) {
				throw new Error(`Steam API Schema Request Failed: ${schemaResponse.status}`);
			}
	
			const schemaData = await schemaResponse.json();
			if (!schemaData.game || !schemaData.game.availableGameStats || !schemaData.game.availableGameStats.achievements) {
				console.warn("⚠ This game does not have achievements.");
				alert("⚠ This game does not have achievements. Would you like to add custom achievements instead?");
				showCustomAchievementsMenu(appID);
				return;
			}
	
			// Fetch player's achievements
			const playerAchievementsUrl = proxyUrl + encodeURIComponent(
				`https://api.steampowered.com/ISteamUserStats/GetPlayerAchievements/v1/?key=${apiKey}&steamid=${steamID}&appid=${appID}`
			);
	
			console.log(`🔹 Fetching player achievements: ${playerAchievementsUrl}`);
			const playerResponse = await fetch(playerAchievementsUrl);
			if (!playerResponse.ok) {
				throw new Error(`Steam API Request Failed: ${playerResponse.status}`);
			}
	
			const playerData = await playerResponse.json();
			if (!playerData.playerstats || !playerData.playerstats.achievements) {
				alert("⚠ No achievements found for this game.");
				return;
			}
	
			const playerAchievements = playerData.playerstats.achievements;
			const schemaAchievements = schemaData.game.availableGameStats.achievements;
	
			playerAchievements.forEach(playerAch => {
				const schemaAch = schemaAchievements.find(ach => ach.name === playerAch.apiname);
				if (schemaAch) {
					const achievementItem = document.createElement("li");
					achievementItem.className = "achievement-item"; // ✅ Apply box styling
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
	
			console.log("✅ Steam achievements loaded successfully!");
		} catch (error) {
			console.error("❌ Error fetching achievements:", error);
			alert("⚠ Error fetching achievements. Please try again later.");
			if (previousPage) previousPage();
		}
	}
	
	
	function showGameSelectionMenu() {
		leftPanel.innerHTML = "<h3>Game Selection</h3>";
	
		// ✅ Add Back Button (Goes to Options Page)
		const backButton = showBackButton(showOptionsPage);
		leftPanel.appendChild(backButton);
	
		// ✅ Load Steam & Non-Steam Buttons
		const steamGamesBtn = document.createElement("button");
		steamGamesBtn.textContent = "Load Steam Games";
		steamGamesBtn.addEventListener("click", displaySteamGames);
	
		const nonSteamGamesBtn = document.createElement("button");
		nonSteamGamesBtn.textContent = "Load Non-Steam Games";
		nonSteamGamesBtn.addEventListener("click", displayNonSteamGames);
	
		leftPanel.appendChild(steamGamesBtn);
		leftPanel.appendChild(nonSteamGamesBtn);
	}
	

	function displaySteamGames() {
		leftPanel.innerHTML = "<h3>Select a Steam Game</h3>";
	
		// ✅ Add Back Button (Goes to Game Selection)
		const backButton = showBackButton(showGameSelectionMenu);
		leftPanel.appendChild(backButton);
	
		let steamGames = JSON.parse(localStorage.getItem("steamGames")) || [];
	
		if (steamGames.length === 0) {
			leftPanel.innerHTML += "<p>No Steam games found. Load your Steam profile first.</p>";
			return;
		}
	
		steamGames.forEach((game) => {
			const gameItem = document.createElement("li");
			gameItem.classList.add("steam-game-item");
	
			// ✅ Game Button
			const gameButton = document.createElement("button");
			gameButton.textContent = game.name;
			gameButton.classList.add("game-btn");
			gameButton.addEventListener("click", function () {
				const steamID = localStorage.getItem("steamID");
				if (steamID && game.appid) {
					loadSteamAchievements(steamID, game.appid, displaySteamGames);
					leftPanel.innerHTML = `<h3>Achievements for ${game.name}</h3>`;
				} else {
					console.error("❌ Error: Steam ID or AppID missing");
				}
			});
	
			gameItem.appendChild(gameButton);
			leftPanel.appendChild(gameItem);
		});
	}
	

	function displayNonSteamGames() {
		leftPanel.innerHTML = "<h3>Select a Non-Steam Game</h3>";
	
		// ✅ Add Back Button (Goes to Game Selection)
		const backButton = showBackButton(showGameSelectionMenu);
		leftPanel.appendChild(backButton);
	
		let nonSteamGames = JSON.parse(localStorage.getItem("nonSteamGames")) || [];
	
		if (nonSteamGames.length === 0) {
			leftPanel.innerHTML += "<p>No non-Steam games found. Add one first.</p>";
			return;
		}
	
		const gameList = document.createElement("ul");
		gameList.classList.add("non-steam-game-list");
	
		nonSteamGames.forEach((game, index) => {
			const gameItem = document.createElement("li");
			gameItem.classList.add("non-steam-game-item");
	
			// ✅ Simple Clickable `❌`
			const removeButton = document.createElement("span");
			removeButton.innerHTML = "❌";
			removeButton.classList.add("remove-game-icon");
			removeButton.addEventListener("click", function (event) {
				event.stopPropagation();
				removeNonSteamGame(index);
			});
	
			// ✅ Game Button
			const gameButton = document.createElement("button");
			gameButton.textContent = game;
			gameButton.classList.add("game-btn");
			gameButton.addEventListener("click", function () {
				setupCustomAchievements(game);
			});
	
			// ✅ Append in correct order
			const gameContainer = document.createElement("div");
			gameContainer.classList.add("game-container");
			gameContainer.appendChild(gameButton);
			gameContainer.appendChild(removeButton);
	
			gameItem.appendChild(gameContainer);
			gameList.appendChild(gameItem);
		});
	
		leftPanel.appendChild(gameList);
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
		leftPanel.innerHTML = `<h3>Custom Achievements for ${gameName}</h3>`;
	
		let customAchievements = JSON.parse(localStorage.getItem("customAchievements")) || {};
	
		// ✅ If no custom achievements exist, show the creation option
		if (!customAchievements[gameName]) {
			leftPanel.innerHTML += `
				<p>No custom achievements found for this game.</p>
				<button id="create-custom-achievements">Create Custom Achievements</button>
				<button id="back-to-games">⬅ Back</button>
			`;
	
			document.getElementById("create-custom-achievements").addEventListener("click", function () {
				setupCustomAchievements(gameName);
			});
	
			document.getElementById("back-to-games").addEventListener("click", function () {
				displayNonSteamGames();
			});
	
			return;
		}
	
		// ✅ Once created, show options to manage achievements
		leftPanel.innerHTML += `
			<button id="add-custom-achievement">➕ Add Custom Achievement</button>
			<button id="import-achievements">📂 Import from JSON</button>
		`;
	
		// ✅ Ensure the JSON import button works
		document.getElementById("import-achievements").addEventListener("click", function () {
			importCustomAchievements(gameName);
		});
	
		// ✅ Ensure the add custom achievement button works
		document.getElementById("add-custom-achievement").addEventListener("click", function () {
			showCustomAchievementForm(gameName);
		});
	
		// ✅ Load and display existing achievements
		loadCustomAchievements(gameName);
	}

	function setupCustomAchievements(gameName) {
		let customAchievements = JSON.parse(localStorage.getItem("customAchievements")) || {};
	
		// ✅ If game doesn't have custom achievements, create storage for it
		if (!customAchievements[gameName]) {
			customAchievements[gameName] = [];
			localStorage.setItem("customAchievements", JSON.stringify(customAchievements));
		}
	
		console.log(`✅ Custom Achievements Initialized for: ${gameName}`);
	
		// ✅ Immediately update UI
		showCustomAchievementsMenu(gameName);
	}
	
	function loadCustomAchievements(gameName) {
		let customAchievements = JSON.parse(localStorage.getItem("customAchievements")) || {};
		const achievementsList = document.getElementById("custom-achievements-list");
	
		if (!achievementsList) {
			console.error("❌ 'custom-achievements-list' not found in the DOM.");
			return;
		}
	
		achievementsList.innerHTML = ""; // Clear previous list
	
		if (customAchievements[gameName]) {
			customAchievements[gameName].forEach((ach, index) => {
				const achievementItem = document.createElement("li");
				achievementItem.className = ach.completed ? "completed" : "incomplete";
				achievementItem.innerHTML = `
					<img src="${ach.image}" class="achievement-icon">
					<div class="achievement-details">
						<h4>${ach.name}</h4>
						<p>${ach.description}</p>
						<button onclick="markCustomAchievementComplete('${gameName}', ${index})">
							${ach.completed ? "✔ Completed" : "Mark as Complete"}
						</button>
					</div>
				`;
				achievementsList.appendChild(achievementItem);
			});
		}
	}

	function importCustomAchievements(gameName) {
		const jsonInput = prompt("Paste JSON Achievements Here:");
		
		if (!jsonInput) {
			alert("⚠ No JSON provided.");
			return;
		}
	
		try {
			const importedAchievements = JSON.parse(jsonInput);
	
			if (!Array.isArray(importedAchievements)) {
				alert("⚠ Invalid JSON format. Expected an array.");
				return;
			}
	
			let customAchievements = JSON.parse(localStorage.getItem("customAchievements")) || {};
			if (!customAchievements[gameName]) {
				customAchievements[gameName] = [];
			}
	
			customAchievements[gameName] = customAchievements[gameName].concat(importedAchievements);
			localStorage.setItem("customAchievements", JSON.stringify(customAchievements));
	
			alert(`✅ Successfully imported ${importedAchievements.length} achievements.`);
			showCustomAchievementsMenu(gameName);
		} catch (error) {
			alert("⚠ Error parsing JSON. Please check the format.");
			console.error("❌ JSON Import Error:", error);
		}
	}

	function showBackButton(callback) {
		if (!leftPanel) {
			console.error("❌ 'leftPanel' is not found in the DOM.");
			return;
		}
	
		const backButton = document.createElement("button");
		backButton.textContent = "⬅ Back";
		backButton.classList.add("back-btn");
		backButton.addEventListener("click", callback);
	
		return backButton;
	}
	
});
