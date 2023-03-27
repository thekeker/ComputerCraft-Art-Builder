const uploadImageFormContainer = document.getElementById('uploadImageFormContainer');
const uploadJsonFormContainer = document.getElementById('uploadJsonFormContainer');

function changeFormDatatype(radioBtn) {
    if (radioBtn.checked) {
        switch (radioBtn.id) {
            case "uploadImage":
                document.getElementById('uploadImageLabel').style.background = '#555';
                document.getElementById('uploadImageLabel').style.color = 'white';
                document.getElementById('uploadJsonLabel').style.background = 'white';
                document.getElementById('uploadJsonLabel').style.color = 'black';
                uploadJsonFormContainer.style.display = 'none';
                uploadImageFormContainer.style.display = 'block';
            break;

            case "uploadJson":
                document.getElementById('uploadJsonLabel').style.background = '#555';
                document.getElementById('uploadJsonLabel').style.color = 'white';
                document.getElementById('uploadImageLabel').style.background = 'white';
                document.getElementById('uploadImageLabel').style.color = 'black';
                uploadImageFormContainer.style.display = 'none';
                uploadJsonFormContainer.style.display = 'block';
            break;
        }
    } else return;
}