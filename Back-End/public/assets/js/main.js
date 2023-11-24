const selectEle = document.querySelector('select[id="selectSpecialValidity"]');
const nameValidity = document.querySelector(".valid_until");
window.onload = handleValidity;
function handleValidity() {
    const value = selectEle.value;
    const input = nameValidity.nextElementSibling;
    const parentEle = nameValidity.parentElement;
    if (value == "amount") {
        parentEle.classList.remove("d-none");
        nameValidity.innerText = "Số lượng vé tối đa được bán";
        input.placeholder = "";
        input.type = "number";
        input.value = "";
    } else if (value == "date") {
        parentEle.classList.remove("d-none");
        nameValidity.innerText = "Vé có thể được bán đến";
        input.placeholder = "yyyy-mm-dd HH:MM";
        input.type = "datetime-local";
        input.value = "";
    } else {
        parentEle.classList.add("d-none");
        input.value = 0;
    }
}

selectEle.onchange = handleValidity;
