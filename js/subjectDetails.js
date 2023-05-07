function enableEdit() {
    for (let i=0; i<9; i++) {
        // document.getElementsByClassName('col'+i).disabled = false;
        document.getElementById('col'+i).disabled = false;
    }
    document.getElementById('submit').disabled = false;
}

function showDeleteForm() {
    document.getElementById('deleteForm').hidden = false;
}

function hideDelete() {
    document.getElementById('deleteForm').hidden = true;
}