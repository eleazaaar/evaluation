function enableEdit() {
    document.getElementById('studNo').disabled = false;
    document.getElementById('Lname').disabled = false;
    document.getElementById('Fname').disabled = false;
    document.getElementById('Mname').disabled = false;
    document.getElementById('gender').disabled = false;
    document.getElementById('course').disabled = false;
    document.getElementById('years').disabled = false;
    document.getElementById('section').disabled = false;
    document.getElementById('status').disabled = false;

    document.getElementById('submit').disabled = false;
}

function showDeleteForm() {
    document.getElementById('deleteForm').hidden = false;
}

function hideDelete() {
    document.getElementById('deleteForm').hidden = true;
}
