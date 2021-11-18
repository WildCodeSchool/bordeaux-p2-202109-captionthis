const popup = document.getElementById('popup');
const form = document.getElementById('formUrl');
if (form.dataset.success) {
    popup.style.display = "block"
    setTimeout(() => {
        popup.style.display = "none"
    }, 6000)
}

