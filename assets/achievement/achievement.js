// Achievement Manager Scripts
// - I suck at scripting
// - I love fallout

// PRE-LOAD SPECIFIC SCRIPTS BEFORE DOMContent

// TODO: Documentation

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

// TODO: Documentation

const leftPanel = document.getElementById("left-panel"); // ✅ Ensure this matches your HTML ID

// Inserts the filter/export UI right below the Achievement List title.
function insertFilterUI(gameName) {
	// Find the Achievement List title in the main achievement container.
	const achievementContainer = document.querySelector('.achievement-container');
	const titleElement = achievementContainer.querySelector('h2');
	if (!titleElement) {
		console.error("Achievement List title element not found.");
		return;
	}
	
	// Create the filter container element.
	let filterContainer = document.createElement("div");
	filterContainer.id = "filter-container";
	filterContainer.innerHTML = `
		<center>		
			<input type="text" id="achievement-filter-input" placeholder="Filter achievements...">
			<button id="apply-achievement-filter">Filter</button>
			<div class="import-export-buttons">
				<button id="import-json">Import JSON</button>
				<button id="export-json">Export JSON</button>
			</div>
		</center>
	`;
	
	// Insert the filter container right after the title element.
	titleElement.insertAdjacentElement('afterend', filterContainer);
	
	// Attach event listener for filtering.
	document.getElementById("apply-achievement-filter").addEventListener("click", function(){
		const filterText = document.getElementById("achievement-filter-input").value.trim().toLowerCase();
		filterAchievements(gameName, filterText);
	});
	
	// Attach event listener for exporting achievements.
	document.getElementById("export-achievements-json").addEventListener("click", function(){
		exportAchievements();
	});
}

// TODO: Documentation

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

// TODO: Documentation

document.addEventListener("DOMContentLoaded", function () {
    const apiKey = "B221B9B37FB61109794F719AEBA0268F"; // Replace with your actual API Key
    const leftPanel = document.getElementById("left-panel");
    const savedProfile = JSON.parse(localStorage.getItem("steamProfile"));
	const signOutButton = document.getElementById("sign-out"); // Handle signing out of steam profile
	loadUserAchievements();
    loadServerAchievements();

	// Sign Out button to handle Steam Profile

    if (signOutButton) {
        signOutButton.addEventListener("click", function () {
            // Remove only the logged-in user session (not custom achievements)
            localStorage.removeItem("steamProfile"); 

            // Log sign-out in user.txt for reference
            fetch("../assets/achievements/userdata/user.txt", {
                method: "POST",
                body: "User signed out",
                headers: { "Content-Type": "text/plain" }
            }).then(response => {
                if (response.ok) {
                    console.log("User sign-out logged.");
                }
            }).catch(error => console.error("Error logging sign-out:", error));

            // Redirect to the home page (achievements.html index)
            window.location.href = "../pages/achievements.html"; 
        });
    }

	// TODO: Documentation

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

	function loadUserAchievements() {
		fetch("../assets/achievements/userdata/user.txt")
			.then(response => response.text())
			.then(data => {
				console.log("User Achievements Loaded:", data);
			})
			.catch(error => console.error("Error loading user achievements:", error));
	}
	
	function loadServerAchievements() {
		fetch("../assets/achievements/serverdata/serverdata.txt")
			.then(response => response.text())
			.then(data => {
				console.log("Server Achievements Loaded:", data);
			})
			.catch(error => console.error("Error loading server achievements:", error));
	}

	// TODO: Documentation

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

			// Call this function when initializing your custom achievements menu,
			// after showing the form for adding/editing achievements.
			function showAchievementFilters(gameName) {
				// Create a container for filter input and export button.
				const filterContainer = document.createElement("div");
				filterContainer.id = "filter-container";
				filterContainer.innerHTML = `
					<input type="text" id="achievement-filter-input" placeholder="Filter achievements...">
					<button id="apply-achievement-filter">Filter</button>
					<button id="export-achievements-json">Export JSON</button>
					<button id="import-achievements-json">Import JSON</button>
				`;
				// Append the filter UI to the left panel (or another suitable container).
				leftPanel.appendChild(filterContainer);

				// Event listener for filtering.
				document.getElementById("apply-achievement-filter").addEventListener("click", function(){
					const filterText = document.getElementById("achievement-filter-input").value.trim().toLowerCase();
					filterAchievements(gameName, filterText);
				});

				// Event listener for exporting achievements.
				document.getElementById("export-achievements-json").addEventListener("click", function(){
					exportAchievements();
				});
			}

			// This function filters the custom achievements based on the filter text.
			function filterAchievements(gameName, filterText) {
				const achievementsList = document.getElementById("custom-achievements-list");
				if (!achievementsList) {
					console.error("Custom achievements list element not found.");
					return;
				}
				achievementsList.innerHTML = ""; // Clear the list.

				let customAchievements = JSON.parse(localStorage.getItem("customAchievements")) || {};
				const gameAchievements = customAchievements[gameName] || [];

				// Filter achievements by checking if the name or description includes the filter text.
				const filtered = gameAchievements.filter(ach => {
					return ach.name.toLowerCase().includes(filterText) || ach.description.toLowerCase().includes(filterText);
				});

				if (filtered.length > 0) {
					filtered.forEach((ach, index) => {
						const li = document.createElement("li");
						li.className = "achievement-item"; // Use your CSS styling.
						li.innerHTML = `
							<img src="${ach.image}" class="achievement-icon">
							<div class="achievement-details">
								<h4>${ach.name}</h4>
								<p>${ach.description}</p>
								<span>${ach.completed ? "✔ Completed" : "❌ Not Completed"}</span>
							</div>
							<div class="achievement-actions">
								<button class="edit-achievement">Edit</button>
								<button class="remove-achievement">Remove</button>
								<button class="toggle-completion-achievement">${ach.completed ? "Mark Incomplete" : "Mark Completed"}</button>
							</div>
						`;
						achievementsList.appendChild(li);

						// Attach action listeners (these helper functions should already be defined).
						li.querySelector(".edit-achievement").addEventListener("click", function() {
							// Populate the form with the achievement data for editing.
							document.getElementById("custom-achievement-name").value = ach.name;
							document.getElementById("custom-achievement-description").value = ach.description;
							document.getElementById("custom-achievement-image").value = "";
							// Optionally, clear file input here.
							removeAchievement(gameName, index);
						});
						li.querySelector(".remove-achievement").addEventListener("click", function() {
							removeAchievement(gameName, index);
						});
						li.querySelector(".toggle-completion-achievement").addEventListener("click", function() {
							toggleAchievementCompletion(gameName, index);
						});
					});
				} else {
					achievementsList.innerHTML = "<li>No achievements match your filter.</li>";
				}
			}

			// Export the custom achievements JSON to a downloadable file.
			function exportAchievements() {
				const customAchievements = localStorage.getItem("customAchievements") || "{}";
				const dataStr = "data:text/json;charset=utf-8," + encodeURIComponent(customAchievements);
				const downloadAnchorNode = document.createElement("a");
				downloadAnchorNode.setAttribute("href", dataStr);
				downloadAnchorNode.setAttribute("download", "achievements_export_" + Date.now() + ".json");
				document.body.appendChild(downloadAnchorNode);
				downloadAnchorNode.click();
				downloadAnchorNode.remove();
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
	
	// TODO: Documentation
	
	function showGameSelectionMenu() {
		leftPanel.innerHTML = `
			<h3>Select Game Type</h3>
			<button id="load-steam-games">🎮 Load Steam Games</button>
			<button id="load-non-steam-games">📂 Load Non-Steam Games</button>
		`;
	
		// ✅ Ensure the right panel (achievements list) is cleared when switching between games
		const achievementsList = document.getElementById("steam-achievements");
		const customAchievementsList = document.getElementById("custom-achievements-list");
		if (achievementsList) achievementsList.innerHTML = "";
		if (customAchievementsList) customAchievementsList.innerHTML = "";
	
		// ✅ Event listeners for loading games
		document.getElementById("load-steam-games").addEventListener("click", function () {
			displaySteamGames();
		});
	
		document.getElementById("load-non-steam-games").addEventListener("click", function () {
			displayNonSteamGames();
		});
	}
	
	// TODO: Documentation

	function displaySteamGames() {
		leftPanel.innerHTML = "<h3>Select a Steam Game</h3>";
	
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
	
	// TODO: Documentation

	function displayNonSteamGames() {
		leftPanel.innerHTML = "<h3>Select a Non-Steam Game</h3>";
	
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

	// TODO: Documentation
	
	function removeNonSteamGame(index) {
		let nonSteamGames = JSON.parse(localStorage.getItem("nonSteamGames")) || [];
		if (index >= 0 && index < nonSteamGames.length) {
			nonSteamGames.splice(index, 1); // ✅ Remove the game
			localStorage.setItem("nonSteamGames", JSON.stringify(nonSteamGames));
			displayNonSteamGames(); // ✅ Refresh the list
		}
	}

	// Show the custom achievement form with image upload support

	function showCustomAchievementsMenu(gameName) {
		leftPanel.innerHTML = `
			<h3 class="custom-achievements-title">Custom Achievements for ${gameName}</h3>
			<h4>Add a Custom Achievement</h4>
			<input type="text" id="custom-achievement-name" placeholder="Achievement Name">
			<textarea id="custom-achievement-description" placeholder="Description"></textarea>
			<input type="text" id="custom-achievement-image" placeholder="Image URL (optional)">
			<br>
			<label for="custom-achievement-image-upload">Or upload an image:</label>
			<input type="file" id="custom-achievement-image-upload" accept="image/*">
			<button id="save-custom-achievement">💾 Save Achievement</button>
			<button id="import-achievements">📂 Import from JSON</button>
			`;
		
		document.getElementById("save-custom-achievement").addEventListener("click", function () {
			console.log("Save achievement button clicked.");
			saveCustomAchievement(gameName);
		});
	
		document.getElementById("import-achievements").addEventListener("click", function () {
			importCustomAchievements(gameName);
		});
	
		loadCustomAchievements(gameName);
		insertFilterUI(gameName);
	}

	// TODO: Documentation

	function setupCustomAchievements(gameName) {
		let customAchievements = JSON.parse(localStorage.getItem("customAchievements")) || {};
	
		// ✅ If the game does not already have custom achievements, initialize it
		if (!customAchievements[gameName]) {
			customAchievements[gameName] = [];
			localStorage.setItem("customAchievements", JSON.stringify(customAchievements));
		}
	
		console.log(`✅ Custom Achievements Initialized for: ${gameName}`);
	
		// ✅ Update UI immediately to show the achievement options
		showCustomAchievementsMenu(gameName);
	}

	// TODO: Documentation

	function saveCustomAchievement(gameName) {
		const name = document.getElementById("custom-achievement-name").value.trim();
		const description = document.getElementById("custom-achievement-description").value.trim();
		const imageURL = document.getElementById("custom-achievement-image").value.trim();
		const fileInput = document.getElementById("custom-achievement-image-upload");
		
		if (!name || !description) {
			alert("Achievement name and description are required.");
			return;
		}
		
		// Debug: Log file input details.
		console.log("File input element:", fileInput);
		console.log("File input files:", fileInput.files);
		
		function saveAchievementWithImage(imageSrc) {
			let customAchievements = JSON.parse(localStorage.getItem("customAchievements")) || {};
			if (Array.isArray(customAchievements)) { // Convert if outdated structure exists.
				customAchievements = {};
			}
			if (!customAchievements[gameName]) {
				customAchievements[gameName] = [];
			}
			customAchievements[gameName].push({
				name: name,
				description: description,
				image: imageSrc,
				completed: false
			});
			localStorage.setItem("customAchievements", JSON.stringify(customAchievements));
			console.log("Custom achievements after saving:", JSON.parse(localStorage.getItem("customAchievements")));
			
			// Clear input fields.
			document.getElementById("custom-achievement-name").value = "";
			document.getElementById("custom-achievement-description").value = "";
			document.getElementById("custom-achievement-image").value = "";
			fileInput.value = "";
			
			loadCustomAchievements(gameName);
		}
		
		// Check if a file was selected.
		if (fileInput.files && fileInput.files[0]) {
			console.log("File selected:", fileInput.files[0]);
			const file = fileInput.files[0];
			const reader = new FileReader();
			reader.onload = function(e) {
				const imageData = e.target.result;
				saveAchievementWithImage(imageData);
			};
			reader.readAsDataURL(file);
		} else if (imageURL) {
			console.log("No file selected; using image URL:", imageURL);
			saveAchievementWithImage(imageURL);
		} else {
			console.log("No file or URL provided; using default image.");
			saveAchievementWithImage("default-achievement.png");
		}
	}

	// TODO: Documentation
	
	function loadCustomAchievements(gameName) {
		const achievementsList = document.getElementById("custom-achievements-list");
		if (!achievementsList) {
			console.error("Custom achievements list element not found.");
			return;
		}
		achievementsList.innerHTML = "";
		
		let customAchievements = JSON.parse(localStorage.getItem("customAchievements")) || {};
		console.log("Loading custom achievements for game:", gameName, customAchievements[gameName]);
		
		if (customAchievements[gameName] && customAchievements[gameName].length > 0) {
			customAchievements[gameName].forEach((ach, index) => {
				const li = document.createElement("li");
				li.className = "achievement-item"; // Apply same styling as Steam achievements.
				li.innerHTML = `
					<img src="${ach.image}" class="achievement-icon">
					<div class="achievement-details">
						<h4>${ach.name}</h4>
						<p>${ach.description}</p>
						<span>${ach.completed ? "✔ Completed" : "❌ Not Completed"}</span>
					</div>
					<div class="achievement-actions">
						<button class="edit-achievement">Edit</button>
						<button class="remove-achievement">Remove</button>
						<button class="toggle-completion-achievement">${ach.completed ? "Mark Incomplete" : "Mark Completed"}</button>
					</div>
				`;
				achievementsList.appendChild(li);
				
				// Edit: populate form with current data and remove the achievement for re‑saving.
				li.querySelector(".edit-achievement").addEventListener("click", function() {
					document.getElementById("custom-achievement-name").value = ach.name;
					document.getElementById("custom-achievement-description").value = ach.description;
					document.getElementById("custom-achievement-image").value = "";
					// For simplicity, image upload is not preloaded.
					removeAchievement(gameName, index);
				});
				
				// Remove the achievement.
				li.querySelector(".remove-achievement").addEventListener("click", function() {
					removeAchievement(gameName, index);
				});
				
				// Toggle completion status.
				li.querySelector(".toggle-completion-achievement").addEventListener("click", function() {
					toggleAchievementCompletion(gameName, index);
				});
			});
		} else {
			achievementsList.innerHTML = "<li>No custom achievements added yet.</li>";
		}
	}
	
	// Helper function to remove an achievement.

	function removeAchievement(gameName, achievementIndex) {
		let customAchievements = JSON.parse(localStorage.getItem("customAchievements")) || {};
		if (customAchievements[gameName]) {
			customAchievements[gameName].splice(achievementIndex, 1);
			localStorage.setItem("customAchievements", JSON.stringify(customAchievements));
			loadCustomAchievements(gameName);
		}
	}

	// Helper function to toggle an achievement's completion status.

	function toggleAchievementCompletion(gameName, achievementIndex) {
		let customAchievements = JSON.parse(localStorage.getItem("customAchievements")) || {};
		if (customAchievements[gameName] && customAchievements[gameName][achievementIndex]) {
			customAchievements[gameName][achievementIndex].completed = !customAchievements[gameName][achievementIndex].completed;
			localStorage.setItem("customAchievements", JSON.stringify(customAchievements));
			loadCustomAchievements(gameName);
		}
	}

	// TODO: Documentation

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
			loadCustomAchievements(gameName);
		} catch (error) {
			alert("⚠ Error parsing JSON. Please check the format.");
			console.error("❌ JSON Import Error:", error);
		}
	}
	
	// TODO: Documentation

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
