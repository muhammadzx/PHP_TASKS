const loadButton = document.getElementById("loadUsers");
const usersTable = document.getElementById("usersTable");
const message = document.getElementById("message");
const editSection = document.getElementById("editSection");
const editUserForm = document.getElementById("editUserForm");

const editId = document.getElementById("editId");
const editName = document.getElementById("editName");
const editEmail = document.getElementById("editEmail");

const editMessage = document.getElementById("editMessage");
const cancelEdit = document.getElementById("cancelEdit");
async function getData() {
    message.textContent = "Loading users...";

    try {
        const response = await fetch("read.php");

        if (!response.ok) {
            throw new Error("Request failed");
        }

        const users = await response.json();

        usersTable.textContent = "";

        for (const user of users) {
            const row = document.createElement("tr");

            const idCell = document.createElement("td");
            const nameCell = document.createElement("td");
            const emailCell = document.createElement("td");

            idCell.textContent = user.id;
            nameCell.textContent = user.name;
            emailCell.textContent = user.email;

            row.appendChild(idCell);
            row.appendChild(nameCell);
            row.appendChild(emailCell);

            const deleteCell = document.createElement("td");
            const deleteButton = document.createElement("button");

            deleteButton.type = "button";
            deleteButton.textContent = "Delete";

            deleteButton.addEventListener("click", function () {
                deleteUser(user.id);
            });

            deleteCell.appendChild(deleteButton);

            row.appendChild(deleteCell);

            const editCell = document.createElement("td");
            const editButton = document.createElement("button");

            editButton.type = "button";
            editButton.textContent = "Edit";

            editButton.addEventListener("click", function () {
                showEditForm(user);
            });

            editCell.appendChild(editButton);

            row.appendChild(editCell);
            usersTable.appendChild(row);
        }

        if (users.length === 0) {
            message.textContent = "No users found.";
        } else {
            message.textContent = "";
        }
    } catch (error) {
        message.textContent = "Could not load users.";

        console.log(error);
    }
}

loadButton.addEventListener("click", getData);


// add user
const addUserForm = document.getElementById("addUserForm");
const formMessage = document.getElementById("formMessage");

async function addUser(event) {
    event.preventDefault();

    formMessage.textContent = "Adding user...";

    const formData = new FormData(addUserForm);

    try {
        const response = await fetch("create.php", {
            method: "POST",
            body: formData
        });

        const result = await response.json();

        if (!response.ok || !result.success) {
            formMessage.textContent = result.message;
            return;
        }

        formMessage.textContent = result.message;

        addUserForm.reset();

        await getData();
    } catch (error) {
        formMessage.textContent = "Could not send the request.";

        console.log(error);
    }
}

addUserForm.addEventListener("submit", addUser);

async function deleteUser(id) {
    const confirmed = confirm("Are you sure you want to delete this user?");

    if (!confirmed) {
        return;
    }

    const formData = new FormData();

    formData.append("id", id);

    try {
        const response = await fetch("delete.php", {
            method: "POST",
            body: formData
        });

        const result = await response.json();

        if (!response.ok || !result.success) {
            message.textContent = result.message;
            return;
        }

        await getData();

        message.textContent = result.message;
    } catch (error) {
        message.textContent = "Could not send the delete request.";

        console.log(error);
    }
}

function showEditForm(user) {
    editId.value = user.id;
    editName.value = user.name;
    editEmail.value = user.email;

    editMessage.textContent = "";

    editSection.hidden = false;
}

async function updateUser(event) {
    event.preventDefault();

    editMessage.textContent = "Saving changes...";

    const formData = new FormData(editUserForm);

    try {
        const response = await fetch("update.php", {
            method: "POST",
            body: formData
        });

        const result = await response.json();

        if (!response.ok || !result.success) {
            editMessage.textContent = result.message;
            return;
        }

        editUserForm.reset();
        editSection.hidden = true;

        await getData();

        message.textContent = result.message;
    } catch (error) {
        editMessage.textContent = "Could not send the update request.";

        console.log(error);
    }
}

editUserForm.addEventListener("submit", updateUser);