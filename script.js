let items = [];

function showPage(id) {
  document.querySelectorAll(".page").forEach(p => p.style.display = "none");
  document.getElementById(id).style.display = "block";

  if (id === "search") {
    displayAllItems(); // 検索ページに来たときに常時表示する
  }

  if (id === "searchComplete") {
    const keyword = localStorage.getItem("lastKeyword") || "";
    const location = localStorage.getItem("lastLocation") || "";
    document.getElementById("searchResultText").innerText =
      `検索完了です。\n「${keyword}」は「${location}」にあります。`;
  }
}

function registerItem() {
  const photo = document.getElementById("photo").files[0];
  const keyword = document.getElementById("keyword").value;
  const currentLocation = document.getElementById("currentLocation").value;
  const foundPlace = document.getElementById("foundPlace").value;
  const comment = document.getElementById("comment").value;

  if (!photo || !keyword || !currentLocation || !foundPlace) {
    alert("入力してください");
    return;
  }

  const reader = new FileReader();
  reader.onload = function (e) {
    const photoUrl = e.target.result;
    items.push({ photoUrl, keyword, currentLocation, foundPlace, comment });
    document.getElementById("photo").value = "";
    document.getElementById("keyword").value = "";
    document.getElementById("currentLocation").value = "";
    document.getElementById("foundPlace").value = "";
    document.getElementById("comment").value = "";
    showPage("registerComplete");
  };
  reader.readAsDataURL(photo);
}

function displayAllItems() {
  const resultsDiv = document.getElementById("results");
  resultsDiv.innerHTML = "";
  items.forEach((item, index) => {
    const div = document.createElement("div");
    div.innerHTML = `
      <img src="${item.photoUrl}" width="100"><br>
      キーワード: ${item.keyword}<br>
      現在の場所: ${item.currentLocation}<br>
      <button onclick="showDetail(${index})">詳細</button>
      <hr>
    `;
    resultsDiv.appendChild(div);
  });

  if (items.length === 0) {
    resultsDiv.innerHTML = "登録されたアイテムはありません";
  }
}

function searchItems() {
  const keyword = document.getElementById("searchKeyword").value;
  const resultsDiv = document.getElementById("results");
  resultsDiv.innerHTML = "";

  const filtered = keyword ? items.filter(i => i.keyword === keyword) : items;

  filtered.forEach((item, index) => {
    const div = document.createElement("div");
    div.innerHTML = `
      <img src="${item.photoUrl}" width="100"><br>
      キーワード: ${item.keyword}<br>
      現在の場所: ${item.currentLocation}<br>
      <button onclick="showDetail(${index})">詳細</button>
      <hr>
    `;
    resultsDiv.appendChild(div);
  });

  if (filtered.length === 0) {
    resultsDiv.innerHTML = "該当するアイテムは見つかりませんでした";
  }
}

function showDetail(index) {
  const item = items[index];
  const detail = `
    <img src="${item.photoUrl}" width="150"><br>
    キーワード: ${item.keyword}<br>
    見つけた場所: ${item.foundPlace}<br>
    現在の場所: ${item.currentLocation}<br>
    コメント: ${item.comment || "（なし）"}
  `;
  document.getElementById("detailContent").innerHTML = detail;
  localStorage.setItem("lastKeyword", item.keyword);
  localStorage.setItem("lastLocation", item.currentLocation);
  showPage("searchDetail");
}

// 最初にホームを表示
showPage("home");