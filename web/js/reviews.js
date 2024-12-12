function addReview() {
    const reviewText = document.getElementById("userReview").value;

    if (reviewText.trim() === "") {
        alert("Proszę wpisać swoją opinię.");
        return;
    }

    const headerMessage = document.getElementById("confirmationMessage");
    headerMessage.textContent = "Dziękujemy za dodanie opinii!";

    const th = document.getElementById("reviewsTable").querySelector("thead th");
    if (!th.hasAttribute("colspan")) {
        th.setAttribute("colspan", "2");
    }

    const newRow = document.createElement("tr");
    const newCell = document.createElement("td");
    newCell.innerText = reviewText;
    newRow.appendChild(newCell);

    const deleteButton = document.createElement("button");
    deleteButton.textContent = "Usuń";
    deleteButton.onclick = function() {
        newRow.remove();

        if (document.getElementById("reviewsTable").querySelector("tbody").childElementCount === 0) {
            headerMessage.textContent = "Wyraź swoją opinię o naszej stronie";
        }
    };
    
    const newButtonCell = document.createElement("td");
    newButtonCell.appendChild(deleteButton);
    newRow.appendChild(newButtonCell);

    document.getElementById("reviewsTable").querySelector("tbody").appendChild(newRow);
    document.getElementById("reviewsTable").style.border = "2px solid #6e4a2d";

    document.getElementById("userReview").value = "";
}
